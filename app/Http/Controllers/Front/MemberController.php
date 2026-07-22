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
use App\Services\MembershipService;
use App\Services\PaymentMethodService;
use App\Services\StripeService;

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
        return view('member.subscription', [
            'hasSavedCard' => $this->memberHasSavedCard(auth()->user()),
        ]);
    }

    /**
     * Cancel the membership.
     *
     * Benefits carry on until plan_expiry — the member already paid for that
     * period. Cancelling only stops the next automatic charge.
     */
    public function cancelSubscription()
    {
        $result = app(MembershipService::class)->cancel(auth()->user());
        $expiry = $result['expiry'] ?? null;

        return $this->flashMembershipResult($result, [
            'no_plan'           => 'You do not have a membership to cancel.',
            'already_cancelled' => 'Your membership is already cancelled.',
            'cancelled'         => $expiry
                ? "Your membership has been cancelled. You keep your benefits until {$expiry}, and you will not be charged again."
                : 'Your membership has been cancelled, and you will not be charged again.',
        ]);
    }

    /**
     * Undo a cancellation and put automatic renewal back on.
     */
    public function resumeSubscription()
    {
        $result = app(MembershipService::class)->resume(auth()->user());

        return $this->flashMembershipResult($result, [
            'not_cancelled'   => 'Your membership is not cancelled.',
            'resumed_no_card' => 'Your membership has been resumed. Add a card by renewing once manually, otherwise automatic renewal cannot charge you.',
            'resumed'         => 'Your membership has been resumed and will renew automatically.',
        ]);
    }

    /**
     * Switch automatic renewal on or off without cancelling.
     */
    public function updateAutoRenew(Request $request)
    {
        $validated = $request->validate([
            'auto_renew' => 'required|boolean',
        ]);

        $result = app(MembershipService::class)
            ->setAutoRenew(auth()->user(), (bool) $validated['auto_renew']);

        return $this->flashMembershipResult($result, [
            'no_plan'               => 'You do not have a membership to change.',
            'lifetime'              => 'Lifetime memberships never need renewing.',
            'auto_renew_off'        => 'Automatic renewal is off. Your membership will simply end on its expiry date unless you renew.',
            'auto_renew_on_no_card' => 'Automatic renewal is on. Renew once manually to save a card, otherwise there is nothing for us to charge.',
            'auto_renew_on'         => 'Automatic renewal is on. We will charge your saved card before your membership expires.',
        ]);
    }

    /**
     * Flash a MembershipService result using the member-facing wording.
     *
     * The service phrases its messages for the admin panel, so the dashboard
     * maps each result code back to the second-person copy members already know.
     *
     * @param array{ok: bool, code: string, message: string} $result
     * @param array<string, string> $messages Result code => member-facing copy.
     */
    private function flashMembershipResult(array $result, array $messages)
    {
        $message = $messages[$result['code']] ?? $result['message'];

        return back()->with($result['ok'] ? 'success' : 'error', $message);
    }

    /**
     * Whether Stripe holds a card we could charge off-session.
     */
    private function memberHasSavedCard(User $user): bool
    {
        return app(PaymentMethodService::class)->hasSavedCard($user);
    }

    public function member_vitalBoostSubscriptions()
    {
        $subscriptions = \App\Models\VitalBoostSubscription::where('user_id', auth()->id())
            ->orderByDesc('created_at')
            ->get();

        return view('member.vital-boost-subscriptions', compact('subscriptions'));
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

        // The plan they hold today, so each card can say Upgrade / Downgrade / Current
        // rather than calling everything an upgrade.
        $currentPlan = Membership::find(auth()->user()->plan_id);

        return view('member.plans', compact('memberships', 'currentPlan'));
    }

    public function member_payments()
    {
        $paymentHistory = PaymentHistory::where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->paginate(10);
        
        // Get saved cards from Stripe API
        $savedCards = $this->getSavedPaymentMethods();
        
        return view('member.payments', compact('paymentHistory', 'savedCards'));
    }

    /**
     * The member's saved cards, brand and last four only.
     */
    private function getSavedPaymentMethods()
    {
        return app(PaymentMethodService::class)->listCards(auth()->user());
    }

    private function getOrCreateStripeCustomer($user)
    {
        return app(PaymentMethodService::class)->getOrCreateCustomer($user);
    }

    public function deletePaymentMethod(Request $request)
    {
        $request->validate([
            'payment_method_id' => 'required|string'
        ]);

        $result = app(PaymentMethodService::class)
            ->detach(auth()->user(), $request->payment_method_id);

        return response()->json($result);
    }

    public function setDefaultPaymentMethod(Request $request)
    {
        $request->validate([
            'payment_method_id' => 'required|string'
        ]);

        $result = app(PaymentMethodService::class)
            ->setDefault(auth()->user(), $request->payment_method_id);

        return response()->json($result);
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
        // Only collaborators who are still active — a deactivated collaborator
        // must not be listed, nor their videos reachable.
        $collaborators = User::where('role', 'collaborator')
            ->where('status', 'active')
            ->get();

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

        // Grouped here rather than queried from the Blade template, so the
        // active-owner rule is applied once instead of per category.
        $coursesByCategory = Course::with('user')
            ->fromActiveOwner()
            ->whereIn('category', array_keys($courseCategories))
            ->get()
            ->groupBy('category');

        return view('member.member-video-library', compact('collaborators', 'courseCategories', 'coursesByCategory', 'activeTab'));
    }

    public function collaboratorVideos($id)
    {
        // Deep links must not expose a deactivated collaborator either.
        $collaborator = User::where('id', $id)
            ->where('role', 'collaborator')
            ->where('status', 'active')
            ->firstOrFail();

        $courses = Course::where('user_id', $collaborator->id)->get();

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

        // Prefer the admin-uploaded PDF when one exists; the on-the-fly generated
        // document below stays as a fallback for older products without a file.
        if ($product->pdfPath()) {
            return $this->streamProductPdf($product);
        }

        // Build the product image as a base64 data URI (if it exists on disk)
        $imageSrc = null;
        if ($product->image) {
            $imagePath = public_path('product_images/' . $product->image);
            if (file_exists($imagePath)) {
                $imageData = base64_encode(file_get_contents($imagePath));
                $imageSrc = 'data:image/' . pathinfo($imagePath, PATHINFO_EXTENSION) . ';base64,' . $imageData;
            }
        }

        // Render the PDF HTML from a dedicated Blade view
        $html = view('front.pdf.member-download', [
            'product'     => $product,
            'user'        => $user,
            'imageSrc'    => $imageSrc,
            'generatedAt' => date('Y-m-d H:i:s'),
        ])->render();

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

    /**
     * Stream the admin-uploaded guide PDF as a download. The file lives outside the
     * public folder, so this is the only way to reach it — callers are responsible
     * for the access check (active membership, or ownership of a paid order).
     */
    private function streamProductPdf(Product $product)
    {
        $path = $product->pdfPath();
        abort_if(!$path, 404, 'The download for this product is not available.');

        $filename = \Illuminate\Support\Str::slug($product->name) . '.pdf';

        return response()->download($path, $filename, [
            'Content-Type' => 'application/pdf',
        ]);
    }

    /**
     * Download a guide the member has actually purchased. Gated on the order item
     * belonging to an order owned by the signed-in user, so members can retrieve
     * their bought guides from the dashboard without needing an active membership.
     */
    public function downloadPurchasedGuide($orderItemId)
    {
        $orderItem = \App\Models\OrderItem::findOrFail($orderItemId);

        $order = Order::where('id', $orderItem->order_id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        // Only released once the order is paid for.
        if ($order->payment_status !== 'completed') {
            abort(403, 'This download becomes available once your payment is confirmed.');
        }

        $product = Product::findOrFail($orderItem->product_id);
        abort_if($product->product_type !== 'guide' || !$product->pdfPath(), 404, 'This product does not have a downloadable file.');

        return $this->streamProductPdf($product);
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
            return $this->createPdfReceipt($payment);

        } catch (\Exception $e) {
            // Log error and return error message
            \Log::error('Receipt download error: ' . $e->getMessage());
            return back()->with('error', 'Unable to download receipt. Please try again later.');
        }
    }

    private function createPdfReceipt($payment)
    {
        $cardDetails = json_decode($payment->card_details);
        $user = auth()->user();

        // Render the receipt HTML from a dedicated Blade view
        $html = view('front.pdf.receipt', [
            'payment'     => $payment,
            'user'        => $user,
            'cardDetails' => $cardDetails,
            'receiptDate' => \Carbon\Carbon::parse($payment->created_at)->format('M j, Y \a\t g:i A'),
            'generatedAt' => date('Y-m-d H:i:s'),
        ])->render();

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
                // off_session (not on_session) so the card is saved with a mandate to
                // charge it later without the member present — what membership:auto-renew needs.
                'setup_future_usage' => 'off_session',
            ],
            'success_url' => route('payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('payment.cancel')
        ]);
        return redirect($session->url, 303);
        /************Stripe payment end here*****************/
    }

    public function renewMembership(Request $request){
        $user_id = auth()->user()->id;
        $userDetail = User::find($user_id);

        // Renewal re-purchases the member's CURRENT plan. The expiry-extension logic
        // in IndexController::getTransactionDetail() stacks the new period on top of
        // any remaining time, so renewing early never loses days.
        $planDetail = Membership::find($userDetail->plan_id);
        if (empty($planDetail)) {
            return back()->with('error', 'You do not have a plan to renew. Please choose a plan first.');
        }

        /************Stripe payment start here****************/
        session(['planDetail' => $planDetail]);

        // Get or create Stripe customer for the user
        $customer = $this->getOrCreateStripeCustomer($userDetail);

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
                // off_session (not on_session) so the card is saved with a mandate to
                // charge it later without the member present — what membership:auto-renew needs.
                'setup_future_usage' => 'off_session',
            ],
            'success_url' => route('payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('payment.cancel')
        ]);
        return redirect($session->url, 303);
        /************Stripe payment end here*****************/
    }

    public function getStripeSecret()
    {
        StripeService::configure();
    }

}