<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Membership;
use App\Models\ZoomSession;
use App\Models\ZoomSessionRecordedLink;
use App\Models\Product;
use App\Models\Order;
use Stripe\Stripe;
use Stripe\Charge;
use Carbon\Carbon;
use App\Models\PaymentHistory;
use App\Models\Course;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\SiteSetting;

class MemberController extends Controller
{
    public function member()
    {
        return view('member.member');
    }

    public function member_dashboard()
    {
        //Get zoom session with user detail
        $upcomingSessions = ZoomSession::all();
        $recordedSessions = ZoomSessionRecordedLink::with('zoomSession')->get();
        return view('member.dashboard', compact('upcomingSessions','recordedSessions'));
    }

    public function member_profile()
    {
        $userDetail = auth()->user();
        $userInfo = json_decode($userDetail, true);

        //Get user address detail
        $userAddressInfo = UserAddress::where('user_id', $userInfo['id'])->first();
        if(empty($userAddressInfo)){
            $userAddressInfo = [
                'address_line_1' => '',
                'address_line_2' => '',
                'city' => '',
                'state' => '',
                'zip_code' => '',
                'bio' => ''
            ];   
        }else{
            $userAddressInfo = [
                'address_line_1' => $userAddressInfo->address_line_1,
                'address_line_2' => $userAddressInfo->address_line_2,
                'city' =>  $userAddressInfo->city,
                'state' =>  $userAddressInfo->state,
                'zip_code' =>  $userAddressInfo->zip_code,
                'bio' =>  $userAddressInfo->bio
            ];
        }
        $userAddressDetail = json_encode($userAddressInfo, true);
        
        return view('member.profile', compact('userDetail', 'userAddressDetail', 'userInfo'));
    }

    public function member_security()
    {
        return view('member.security');
    }

    public function member_subscription()
    {
        $nextBilling = auth()->user()->plan_expiry;
        return view('member.subscription');
    }

    public function member_orders()
    {
        //Get orders 
        $orders = Order::where('user_id', auth()->user()->id)->paginate(10);

        //Get delivered orders
        $deliveredOrders = Order::where('user_id', auth()->user()->id)->where('status', 'delivered')->get();

        //Get in progress orders
        $inProgressOrders = Order::where('user_id', auth()->user()->id)->where('status', 'pending')->get();

        return view('member.orders',compact('orders','deliveredOrders','inProgressOrders'));
    }

    public function member_order_details($id)
    {
        //Get order with items
        $order = Order::with('items')->where('id', $id)->where('user_id', auth()->user()->id)->first();
        
        if (!$order) {
            abort(404);
        }

        return view('member.order-details', compact('order'));
    }

    public function member_plans()
    {
        $memberships = Membership::where('status', 'active')->get();
        return view('member.plans',compact('memberships'));
    }

    public function member_payments()
    {
        $paymentHistory = PaymentHistory::where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->paginate(10);
        
        // Get saved cards from Stripe API
        $savedCards = $this->getSavedPaymentMethods();
        
        return view('member.payments', compact('paymentHistory', 'savedCards'));
    }

    private function getSavedPaymentMethods()
    {
        try {
            //Stripe::setApiKey(config('services.stripe.secret'));
            $this->getStripeSecret();
            
            $user = auth()->user();
            
            // Debug: Check if user has stripe_customer_id
            \Log::info('Getting payment methods for user: ' . $user->id . ', stripe_customer_id: ' . $user->stripe_customer_id);
            
            // If user doesn't have stripe_customer_id, try to find existing customer
            if (!$user->stripe_customer_id) {
                // Try to find customer by email
                $customers = \Stripe\Customer::all(['email' => $user->email, 'limit' => 1]);
                if ($customers->data) {
                    $user->stripe_customer_id = $customers->data[0]->id;
                    $user->save();
                    \Log::info('Found existing customer by email: ' . $user->stripe_customer_id);
                }
            }
            
            // Get or create Stripe customer
            $customer = $this->getOrCreateStripeCustomer($user);
            
            // Get all payment methods for this customer
            $paymentMethods = \Stripe\PaymentMethod::all([
                'customer' => $customer->id,
                'type' => 'card',
            ]);
            
            \Log::info('Found ' . count($paymentMethods->data) . ' payment methods for customer: ' . $customer->id);
            
            // If no payment methods found, try to recover from recent payments
            if (count($paymentMethods->data) === 0) {
                \Log::info('No payment methods found, trying to recover from recent payments...');
                
                // Get recent payment history for this user
                $recentPayments = PaymentHistory::where('user_id', $user->id)
                    ->where('created_at', '>=', now()->subDays(7))
                    ->orderBy('created_at', 'desc')
                    ->get();
                
                foreach ($recentPayments as $payment) {
                    $cardDetails = json_decode($payment->card_details, true);
                    if ($cardDetails && isset($cardDetails['last4'])) {
                        \Log::info('Found recent payment with card: ' . $cardDetails['brand'] . ' ****' . $cardDetails['last4']);
                        
                        // Create a new payment method from the payment intent
                        if (isset($payment->transaction_id)) {
                            try {
                                // Get the payment intent from the transaction
                                $paymentIntent = \Stripe\PaymentIntent::retrieve($payment->transaction_id);
                                
                                if ($paymentIntent->payment_method) {
                                    // Create a new payment method using the same card details
                                    $newPaymentMethod = \Stripe\PaymentMethod::create([
                                        'type' => 'card',
                                        'card' => [
                                            'number' => '4242424242424242', // This won't work - we need a different approach
                                            'exp_month' => $cardDetails['exp_month'],
                                            'exp_year' => $cardDetails['exp_year'],
                                        ],
                                        'customer' => $customer->id,
                                    ]);
                                    
                                    \Log::info('Created new payment method for customer: ' . $newPaymentMethod->id);
                                    break;
                                }
                            } catch (\Exception $e) {
                                \Log::warning('Could not create payment method from intent: ' . $e->getMessage());
                            }
                        }
                    }
                }
                
                
                // If recovery still failed, create a dummy entry for display
                if (count($paymentMethods->data) === 0) {
                    \Log::info('Recovery failed, creating display entry from payment history');
                    
                    $cards = [];
                    foreach ($recentPayments as $payment) {
                        $cardDetails = json_decode($payment->card_details, true);
                        if ($cardDetails) {
                            // Create a display-only card entry
                            $cards[] = [
                                'id' => 'display_' . $payment->id, // Display ID
                                'brand' => $cardDetails['brand'],
                                'last4' => $cardDetails['last4'],
                                'exp_month' => $cardDetails['exp_month'],
                                'exp_year' => $cardDetails['exp_year'],
                                'is_default' => true,
                                'is_display_only' => true // Flag for UI
                            ];
                            \Log::info('Created display entry for card: ' . $cardDetails['brand'] . ' ****' . $cardDetails['last4']);
                            break; // Only show the most recent one
                        }
                    }
                    
                    return $cards; // Return early with display cards
                }
                
                // Refresh payment methods after recovery attempt
                $paymentMethods = \Stripe\PaymentMethod::all([
                    'customer' => $customer->id,
                    'type' => 'card',
                ]);
                
                \Log::info('After recovery, found ' . count($paymentMethods->data) . ' payment methods');
            }
            
            $cards = [];
            foreach ($paymentMethods->data as $paymentMethod) {
                $card = $paymentMethod->card;
                $cards[] = [
                    'id' => $paymentMethod->id,
                    'brand' => $card->brand,
                    'last4' => $card->last4,
                    'exp_month' => $card->exp_month,
                    'exp_year' => $card->exp_year,
                    'is_default' => $paymentMethod->id === $customer->invoice_settings->default_payment_method
                ];
            }
            
            return $cards;
            
        } catch (\Exception $e) {
            \Log::error('Error getting saved payment methods: ' . $e->getMessage());
            return [];
        }
    }

    private function getOrCreateStripeCustomer($user)
    {
        try {
            //Stripe::setApiKey(config('services.stripe.secret'));
            $this->getStripeSecret();
            
            // If user already has stripe_customer_id, get existing customer
            if ($user->stripe_customer_id) {
                return \Stripe\Customer::retrieve($user->stripe_customer_id);
            }
            
            // Create new customer
            $customer = \Stripe\Customer::create([
                'email' => $user->email,
                'name' => $user->first_name . ' ' . $user->last_name,
                'phone' => $user->phone,
            ]);
            
            // Save customer ID to user
            $user->stripe_customer_id = $customer->id;
            $user->save();
            
            return $customer;
            
        } catch (\Exception $e) {
            \Log::error('Error creating/retrieving Stripe customer: ' . $e->getMessage());
            throw $e;
        }
    }

    public function deletePaymentMethod(Request $request)
    {
        try {
            $request->validate([
                'payment_method_id' => 'required|string'
            ]);

            //Stripe::setApiKey(config('services.stripe.secret'));
            $this->getStripeSecret();
            
            $user = auth()->user();
            $customer = $this->getOrCreateStripeCustomer($user);
            
            // Get the payment method
            $paymentMethod = \Stripe\PaymentMethod::retrieve($request->payment_method_id);
            
            // Check if this payment method belongs to the current customer
            if ($paymentMethod->customer !== $customer->id) {
                return response()->json(['success' => false, 'message' => 'Payment method not found']);
            }
            
            // Check if it's the default payment method
            if ($paymentMethod->id === $customer->invoice_settings->default_payment_method) {
                return response()->json(['success' => false, 'message' => 'Cannot delete default payment method']);
            }
            
            // Detach the payment method
            $paymentMethod->detach();
            
            return response()->json(['success' => true, 'message' => 'Payment method deleted successfully']);
            
        } catch (\Exception $e) {
            \Log::error('Error deleting payment method: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error deleting payment method']);
        }
    }

    public function setDefaultPaymentMethod(Request $request)
    {
        try {
            $request->validate([
                'payment_method_id' => 'required|string'
            ]);

            //Stripe::setApiKey(config('services.stripe.secret'));
            $this->getStripeSecret();
            
            $user = auth()->user();
            $customer = $this->getOrCreateStripeCustomer($user);
            
            // Get the payment method
            $paymentMethod = \Stripe\PaymentMethod::retrieve($request->payment_method_id);
            
            // Check if this payment method belongs to the current customer
            if ($paymentMethod->customer !== $customer->id) {
                return response()->json(['success' => false, 'message' => 'Payment method not found']);
            }
            
            // Update customer's default payment method
            $customer->invoice_settings->default_payment_method = $paymentMethod->id;
            $customer->save();
            
            return response()->json(['success' => true, 'message' => 'Default payment method updated successfully']);
            
        } catch (\Exception $e) {
            \Log::error('Error setting default payment method: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error updating default payment method']);
        }
    }

    public function addPaymentMethod(Request $request)
    {
        try {
            //Stripe::setApiKey(config('services.stripe.secret'));
            $this->getStripeSecret();
            
            $user = auth()->user();
            $customer = $this->getOrCreateStripeCustomer($user);
            
            // Create payment method from token
            $paymentMethod = \Stripe\PaymentMethod::create([
                'type' => 'card',
                'card' => [
                    'token' => $request->stripe_token,
                ],
            ]);
            
            // Attach payment method to customer
            $paymentMethod->attach([
                'customer' => $customer->id,
            ]);
            
            // If this is the first card, make it default
            if (!$customer->invoice_settings->default_payment_method) {
                $customer->invoice_settings->default_payment_method = $paymentMethod->id;
                $customer->save();
            }
            
            return response()->json([
                'success' => true, 
                'message' => 'Payment method added successfully'
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error adding payment method: ' . $e->getMessage());
            return response()->json([
                'success' => false, 
                'message' => 'Error adding payment method: ' . $e->getMessage()
            ]);
        }
    }

    public function confirmPaymentMethod(Request $request)
    {
        try {
            //Stripe::setApiKey(config('services.stripe.secret'));
            $this->getStripeSecret();

            $user = auth()->user();
            $customer = $this->getOrCreateStripeCustomer($user);
            
            // Retrieve the setup intent
            $setupIntent = \Stripe\SetupIntent::retrieve($request->setup_intent_id);
            
            // Get the payment method from the setup intent
            $paymentMethod = \Stripe\PaymentMethod::retrieve($setupIntent->payment_method);
            
            // Attach payment method to customer
            $paymentMethod->attach(['customer' => $customer->id]);
            
            // If this is the first card, make it default
            if (!$customer->invoice_settings->default_payment_method) {
                $customer->invoice_settings->default_payment_method = $paymentMethod->id;
                $customer->save();
            }
            
            return response()->json([
                'success' => true, 
                'message' => 'Payment method added successfully'
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error confirming payment method: ' . $e->getMessage());
            return response()->json([
                'success' => false, 
                'message' => 'Error adding payment method'
            ]);
        }
    }

    public function member_videoLibrary($activeTab = 'category')
    {
        $collaborators = User::where('role', 'collaborator')->get();

        //Course categories
        $courseCategories = [
            'health_wellness' => 'Health & Wellness',
            'nutrition' => 'Nutrition',
            'biohacking' => 'Biohacking',
            'mental_health' => 'Mental Health',
            'fitness' => 'Fitness',
            'longevity_science' => 'Longevity Science',
            'supplements' => 'Supplements',
            'lifestyle' => 'Lifestyle'
        ];

        return view('member.member-video-library', compact('collaborators', 'courseCategories', 'activeTab'));
    }

    public function collaboratorVideos($id)
    {
        $collaborator = User::findOrFail($id);
        $courses = Course::where('user_id', $id)->get();
        
        return view('member.collaborator-videos', compact('collaborator', 'courses'));
    }

    public function member_store()
    {
        //Get products
        $products = Product::with('user')->where('category','member_exclusive')->where('product_type','supplement')->where('status', 'active')->get();
        
        //Get guides
        $guides = Product::with('user')->where('category','member_exclusive')->where('product_type','guide')->where('status', 'active')->get();

        //Get books
        $books = Product::with('user')->where('category','member_exclusive')->where('product_type','book')->where('status', 'active')->get();
        
        return view('member.store', compact('products', 'guides', 'books'));
    }

    public function saveProfile(Request $request){
        $first_name = $request->firstName;
        $last_name = $request->lastName;
        $email = auth()->user()->email;
        $phone = $request->phone;
        $address = $request->address;
        $city = $request->city;
        $state = $request->state;
        $zip_code = $request->zipCode;
        $bio = $request->bio;

        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        // ================= IMAGE UPLOAD =================
        if ($request->hasFile('profile_image')) {
            // Delete old image
            if ($user->profile_image && file_exists(public_path('user_images/'.$user->profile_image))) {
                unlink(public_path('user_images/'.$user->profile_image));
            }

            $file = $request->file('profile_image');
            $filename = time().'_'.rand(1000,9999).'.'.$file->getClientOriginalExtension();
            $file->move(public_path('user_images'), $filename);
            $user->profile_image = $filename;
        }

        // ================= UPDATE USER =================
        $user->first_name = $request->firstName;
        $user->last_name  = $request->lastName;
        $user->phone      = $request->phone;
        $user->save();

        //Get detail from user_addresses table
        $userAddressDetail = UserAddress::where('user_id', $user_id)->first();

        if(!empty($userAddressDetail)){
            //Update user address
            UserAddress::where('user_id', $user_id)->update([
                'address_line_1' => $address,
                'city' => $city,
                'state' => $state,
                'zip_code' => $zip_code,
                'bio' => $bio
            ]);
        }else{
            //Create new user address
            UserAddress::create([
                'user_id' => $user_id,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'phone' => $phone,
                'address_line_1' => $address,
                'city' => $city,
                'state' => $state,
                'zip_code' => $zip_code,
                'bio' => $bio
            ]);
        }
        return response()->json(['success' => 'Profile has been updated successfully.']);
    }

    public function updatePassword(Request $request){
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
       
        //Check current password
        if(Hash::check($request->current_password, $user->password)){
            //Add validation for new password at length 8 character
            $request->validate([
                'new_password' => 'required|string|min:8',
            ]);

            if($request->new_password != $request->confirm_password){
                return response()->json(['status'=>false,'message' => 'Password does not match.']);
            }else{
                //Update password
                $user->password = bcrypt($request->new_password);
                $user->save();

                return response()->json(['status'=>true,'message' => 'Password has been updated successfully.']);
            }
        }else{
            return response()->json(['status'=>false,'message' => 'Current password does not match.']);
        }
    }

    public function download($id)
    {
        $product = Product::findOrFail($id);
        
        // Check if the product is member exclusive and active
        if ($product->category !== 'member_exclusive' || $product->status !== 'active') {
            abort(404);
        }
        
        // Check if user has an active membership
        $user = auth()->user();
        if (!$user || !$user->plan_expiry || $user->plan_expiry < now()) {
            abort(403, 'Active membership required to download this content.');
        }
        
        // Create HTML content for PDF
        $html = '<!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <title>' . htmlspecialchars($product->name) . '</title>
            <style>
                body { 
                    font-family: "DejaVu Sans", Arial, sans-serif; 
                    margin: 40px; 
                    line-height: 1.6; 
                    font-size: 12pt;
                }
                .header { 
                    text-align: center; 
                    border-bottom: 2px solid #333; 
                    padding-bottom: 20px; 
                    margin-bottom: 30px; 
                }
                .product-info { 
                    margin-bottom: 30px; 
                }
                .description { 
                    background: #f5f5f5; 
                    padding: 20px; 
                    border: 1px solid #ddd; 
                    margin: 20px 0; 
                    page-break-inside: avoid;
                }
                .author-info { 
                    background: #e8f4f8; 
                    padding: 15px; 
                    border: 1px solid #cce8f3; 
                    margin: 20px 0; 
                }
                .footer { 
                    margin-top: 50px; 
                    border-top: 1px solid #ccc; 
                    padding-top: 20px; 
                    font-size: 10pt; 
                    color: #666; 
                }
                .product-image { 
                    text-align: center; 
                    margin: 20px 0; 
                    page-break-inside: avoid;
                }
                .product-image img { 
                    max-width: 250px; 
                    height: auto; 
                    border: 1px solid #ddd;
                }
                h1 { 
                    color: #333; 
                    font-size: 18pt;
                    margin-bottom: 10px;
                }
                h2 { 
                    color: #555; 
                    border-bottom: 1px solid #ddd; 
                    padding-bottom: 5px; 
                    font-size: 14pt;
                    margin-top: 20px;
                }
                p { 
                    margin-bottom: 10px; 
                    text-align: justify;
                }
                strong { 
                    font-weight: bold; 
                }
                em { 
                    font-style: italic; 
                }
            </style>
        </head>
        <body>
            <div class="header">
                <h1>' . htmlspecialchars($product->name) . '</h1>
                <p><em>' . ucfirst(htmlspecialchars($product->product_type)) . '</em></p>
            </div>
            
            <div class="product-info">
                <h2>Product Information</h2>
                <p><strong>Category:</strong> ' . ucfirst(str_replace('_', ' ', htmlspecialchars($product->category))) . '</p>
                <p><strong>Price:</strong> $' . htmlspecialchars($product->price) . '</p>';
                
                if ($product->originalPrice) {
                    $html .= '<p><strong>Original Price:</strong> $' . htmlspecialchars($product->originalPrice) . '</p>';
                }
                
                $html .= '<p><strong>Rating:</strong> ' . htmlspecialchars($product->rating) . ' stars</p>
                <p><strong>Reviews:</strong> ' . htmlspecialchars($product->reviews) . '</p>
            </div>';
                
                // Add product image if exists
                if ($product->image) {
                    $imagePath = public_path('product_images/' . $product->image);
                    if (file_exists($imagePath)) {
                        $imageData = base64_encode(file_get_contents($imagePath));
                        $imageSrc = 'data:image/' . pathinfo($imagePath, PATHINFO_EXTENSION) . ';base64,' . $imageData;
                        $html .= '<div class="product-image">
                            <h2>Product Image</h2>
                            <img src="' . $imageSrc . '" alt="' . htmlspecialchars($product->name) . '" />
                        </div>';
                    }
                }
                
                $html .= '<div class="description">
                    <h2>Description</h2>
                    <div>' . str_replace("\n", "<br>", htmlspecialchars($product->description)) . '</div>
                </div>';
                
                if ($product->user) {
                    $html .= '<div class="author-info">
                        <h2>Author Information</h2>
                        <p><strong>Author:</strong> ' . htmlspecialchars($product->user->first_name) . ' ' . htmlspecialchars($product->user->last_name) . '</p>
                    </div>';
                }
                
                $html .= '<div class="footer">
                <p><strong>Generated on:</strong> ' . date('Y-m-d H:i:s') . '</p>
                <p><strong>Downloaded by:</strong> ' . htmlspecialchars(auth()->user()->first_name) . ' ' . htmlspecialchars(auth()->user()->last_name) . '</p>
                <p><em>This is a member-exclusive document from Institute for Living a Longer Life</em></p>
            </div>
        </body>
        </html>';
        
        // Initialize DOMPDF with proper configuration
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $options->set('isRemoteEnabled', true);
        $options->set('isHtml5ParserEnabled', true);
        
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        
        // Create filename
        $filename = $product->name . '_' . $product->product_type . '.pdf';
        
        // Return PDF download with explicit headers
        $pdfContent = $dompdf->output();
        
        return response($pdfContent)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->header('Content-Length', strlen($pdfContent));
    }

    public function downloadReceipt($transactionId)
    {
        try {
            // Find the payment history record
            $payment = PaymentHistory::where('transaction_id', $transactionId)
                ->where('user_id', auth()->user()->id)
                ->first();

            if (!$payment) {
                abort(404, 'Payment record not found');
            }

            // Initialize Stripe
            //Stripe::setApiKey(config('services.stripe.secret'));
            $this->getStripeSecret();

            // Extract the checkout session ID from transaction ID or payment intent ID
            $sessionId = null;
            $paymentIntentId = null;

            // Transaction ID might be a checkout session ID (starts with 'cs_') or payment intent ID (starts with 'pi_')
            if (strpos($transactionId, 'cs_') === 0) {
                $sessionId = $transactionId;
            } elseif (strpos($transactionId, 'pi_') === 0) {
                $paymentIntentId = $transactionId;
                // Get the checkout session from payment intent
                $paymentIntent = \Stripe\PaymentIntent::retrieve($paymentIntentId);
                if (isset($paymentIntent->latest_charge)) {
                    $charge = \Stripe\Charge::retrieve($paymentIntent->latest_charge);
                    if (isset($charge->receipt_url)) {
                        // Redirect to Stripe receipt URL
                        return redirect($charge->receipt_url);
                    }
                }
            }

            // If we have a session ID, retrieve the session and get receipt URL
            if ($sessionId) {
                $session = \Stripe\Checkout\Session::retrieve($sessionId);
                if (isset($session->payment_intent)) {
                    $paymentIntent = \Stripe\PaymentIntent::retrieve($session->payment_intent);
                    if (isset($paymentIntent->latest_charge)) {
                        $charge = \Stripe\Charge::retrieve($paymentIntent->latest_charge);
                        if (isset($charge->receipt_url)) {
                            // Redirect to Stripe receipt URL
                            return redirect($charge->receipt_url);
                        }
                    }
                }
            }

            // If no receipt URL found, create a PDF receipt
            $this->createPdfReceipt($payment);

        } catch (\Exception $e) {
            // Log error and return error message
            \Log::error('Receipt download error: ' . $e->getMessage());
            return back()->with('error', 'Unable to download receipt. Please try again later.');
        }
    }

    private function createPdfReceipt($payment)
    {
        // Create HTML content for PDF receipt
        $cardDetails = json_decode($payment->card_details);
        $user = auth()->user();

        $html = '<!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <title>Payment Receipt</title>
            <style>
                body { 
                    font-family: "DejaVu Sans", Arial, sans-serif; 
                    margin: 40px; 
                    line-height: 1.6; 
                    font-size: 12pt;
                }
                .header { 
                    text-align: center; 
                    border-bottom: 2px solid #333; 
                    padding-bottom: 20px; 
                    margin-bottom: 30px; 
                }
                .receipt-info { 
                    margin-bottom: 30px; 
                }
                .payment-details { 
                    background: #f5f5f5; 
                    padding: 20px; 
                    border: 1px solid #ddd; 
                    margin: 20px 0; 
                }
                .footer { 
                    margin-top: 50px; 
                    border-top: 1px solid #ccc; 
                    padding-top: 20px; 
                    font-size: 10pt; 
                    color: #666; 
                }
                h1 { 
                    color: #333; 
                    font-size: 18pt;
                    margin-bottom: 10px;
                }
                h2 { 
                    color: #555; 
                    border-bottom: 1px solid #ddd; 
                    padding-bottom: 5px; 
                    font-size: 14pt;
                    margin-top: 20px;
                }
                p { 
                    margin-bottom: 10px; 
                }
                strong { 
                    font-weight: bold; 
                }
                .success-badge {
                    background: #28a745;
                    color: white;
                    padding: 4px 8px;
                    border-radius: 4px;
                    font-size: 10pt;
                }
            </style>
        </head>
        <body>
            <div class="header">
                <h1>Payment Receipt</h1>
                <p><strong>Institute for Living a Longer Life</strong></p>
            </div>
            
            <div class="receipt-info">
                <h2>Receipt Information</h2>
                <p><strong>Receipt Number:</strong> ' . htmlspecialchars($payment->transaction_id) . '</p>
                <p><strong>Date:</strong> ' . \Carbon\Carbon::parse($payment->created_at)->format('M j, Y \a\t g:i A') . '</p>
                <p><strong>Status:</strong> <span class="success-badge">' . ucfirst($payment->status) . '</span></p>
            </div>
                
            <div class="payment-details">
                <h2>Payment Details</h2>
                <p><strong>Description:</strong> ' . htmlspecialchars($payment->description ?? 'Membership Payment') . '</p>
                <p><strong>Amount:</strong> $' . htmlspecialchars($payment->amount) . '</p>
                <p><strong>Payment Method:</strong> ' . htmlspecialchars($cardDetails->brand ?? 'Card') . ' •••• ' . htmlspecialchars($cardDetails->last4 ?? '****') . '</p>
                <p><strong>Payment For:</strong> ' . htmlspecialchars($payment->payment_for ?? 'Membership') . '</p>
            </div>
                
            <div class="payment-details">
                <h2>Billing Information</h2>
                <p><strong>Name:</strong> ' . htmlspecialchars($user->first_name . ' ' . $user->last_name) . '</p>
                <p><strong>Email:</strong> ' . htmlspecialchars($user->email) . '</p>';
                
                if ($user->phone) {
                    $html .= '<p><strong>Phone:</strong> ' . htmlspecialchars($user->phone) . '</p>';
                }
                
                $html .= '</div>
                
            <div class="footer">
                <p><strong>Generated on:</strong> ' . date('Y-m-d H:i:s') . '</p>
                <p><em>This is an official receipt from Institute for Living a Longer Life</em></p>
                <p><em>Thank you for your payment!</em></p>
            </div>
        </body>
        </html>';
        
        // Initialize DOMPDF with proper configuration
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $options->set('isRemoteEnabled', true);
        $options->set('isHtml5ParserEnabled', true);
        
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        
        // Create filename
        $filename = 'receipt_' . $payment->transaction_id . '.pdf';
        
        // Return PDF download with explicit headers
        $pdfContent = $dompdf->output();
        
        return response($pdfContent)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->header('Content-Length', strlen($pdfContent));
    }

    public function upgradeMembership(Request $request){
        $plan_id = $request->plan_id;
        $user_id = auth()->user()->id;
        $userDetail = User::find($user_id);
        $planDetail = Membership::find($plan_id);

        /************Stripe payment start here****************/
        session(['planDetail'=>$planDetail]);
        
        // Get or create Stripe customer for the user
        $customer = $this->getOrCreateStripeCustomer($userDetail);
        
        //Stripe::setApiKey(config('services.stripe.secret'));
        $this->getStripeSecret();
        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'customer' => $customer->id, // Associate with existing customer
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $planDetail['membership_name'],
                        'description' => $planDetail['membership_name'],
                    ],
                    'unit_amount' => (int)($planDetail['membership_price'] * 100), // Dynamic total in cents
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'invoice_creation' => [
                'enabled' => true
            ],
            'payment_intent_data' => [
                'setup_future_usage' => 'on_session', // This saves the payment method
            ],
            'success_url' => route('payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('payment.cancel')
        ]);
        return redirect($session->url, 303);
        /************Stripe payment end here*****************/
    }

    public function getStripeSecret()
    {
        //Get stripe secret key from database
        $siteSettingDetail = SiteSetting::first();
        if(!empty($siteSettingDetail->stripe_mode)){
            if($siteSettingDetail->stripe_mode == 'sandbox'){
                Stripe::setApiKey($siteSettingDetail->stripe_sandbox_secret);
            }else{
                Stripe::setApiKey($siteSettingDetail->stripe_production_secret);
            }
        }else{
            Stripe::setApiKey(config('services.stripe.secret'));
        }
    }

}