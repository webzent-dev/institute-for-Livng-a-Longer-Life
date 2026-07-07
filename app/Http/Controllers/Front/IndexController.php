<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Membership;
use App\Models\ContentManagement;
use App\Models\IntroVideos;
use Stripe\Stripe;
use Stripe\Charge;
use Stripe\PaymentIntent;
use App\Models\PaymentHistory;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Testimonial;
use App\Models\VideoTestimonial;
use Auth;
use App\Models\SiteSetting;
use App\Services\StripeService;

class IndexController extends Controller
{
     
    public function index()
    {
        $product = Product::where('product_type','vital_boost')->where('status', 'active')->latest()->first();
        $memberships = Membership::where('status', 'active')->get();
        $homePageContent = ContentManagement::where('page_name', 'home_page')->first();
        $videoTestimonials = VideoTestimonial::where('is_active', 1) ->orderBy('sort_order')->get() ->map(function ($item) {
            return [
                'id' => $item->id,
                'videoUrl' => $item->video_url,
                'thumbnail' => rtrim(config('app.url'), '/') . '/testimonial_images/'.$item->thumbnail,
                'quote' => $item->quote,
                'name' => $item->name,
            ];
        });
        return view('front.pages.home', compact('product','memberships', 'homePageContent', 'videoTestimonials'));
    }

    public function introVideos()
    {
        $introVideos = IntroVideos::where('status', 'active')->get();
        return view('front.pages.intro-videos', compact('introVideos'));
    }

    public function membership()
    {
        $memberships = Membership::where('status', 'active')->get();
        return view('front.pages.membership',compact('memberships'));
    }
    
    public function create()
    {
         
    }

     
    public function store(Request $request)
    {
         
    }

     
    public function show(string $id)
    {
        
    }

     
    public function edit(string $id)
    {
         
    }

     
    public function update(Request $request, string $id)
    {
         
    }
 
    public function destroy(string $id)
    {
         
    }

    public function paymentSuccess(Request $request)
    {
        $this->getTransactionDetail($request);
        return view('front.payment.success');
    }

    public function paymentCancel(Request $request)
    {
        $this->getTransactionDetail($request);
        return view('front.payment.cancel');
    }

    /*public function getTransactionDetail($request){
        Stripe::setApiKey(config('services.stripe.secret'));
        $sessionId = $request->get('session_id');
        $session = \Stripe\Checkout\Session::retrieve($sessionId);
        $paymentIntent = PaymentIntent::retrieve($session->payment_intent);
        //Get line items
        $lineItems = \Stripe\Checkout\Session::allLineItems($sessionId);
        $description = $lineItems->data[0]->description;

        $data = [
            'transaction_id' => $paymentIntent->id,
            'description'    => $description,
            'payment_method' => $paymentIntent->payment_method_types[0] ?? null,
            'amount'         => $paymentIntent->amount / 100,
            'currency'       => $paymentIntent->currency,
            'status'         => $paymentIntent->status,
        ];

        if($paymentIntent->status == 'succeeded'){
            $planDetail = session('planDetail');
            if($planDetail->membership_period == 'month'){
                $plan_expiry = Carbon::now()->addDays(30);
            }else if($planDetail->membership_period == 'year'){
                $plan_expiry = Carbon::now()->addDays(365);
            }

            //Update users table
            if(Auth::check()){
                $user_id = auth()->user()->id;
                $user = User::findOrFail($user_id);
                
                // Update stripe_customer_id if not already set
                if (!$user->stripe_customer_id && $session->customer) {
                    $user->stripe_customer_id = $session->customer;
                }
                
                $user->update([
                    'plan_id' => $planDetail->id,
                    'plan_name' => $planDetail->membership_name,
                    'plan_price' => $planDetail->membership_price,
                    'plan_period' => $planDetail->membership_period,
                    'plan_expiry' => $plan_expiry,
                    'stripe_customer_id' => $user->stripe_customer_id ?? $session->customer
                ]);
            }else{
                $user_id = session('user_id');
                $user = User::findOrFail($user_id);
                
                // Update stripe_customer_id if not already set
                if (!$user->stripe_customer_id && $session->customer) {
                    $user->stripe_customer_id = $session->customer;
                }
                
                $user->update([
                    'plan_id' => $planDetail->id,
                    'plan_name' => $planDetail->membership_name,
                    'plan_price' => $planDetail->membership_price,
                    'plan_period' => $planDetail->membership_period,
                    'plan_expiry' => $plan_expiry,
                    'stripe_customer_id' => $user->stripe_customer_id ?? $session->customer
                ]);
            }
        }

        //Get card details
        $paymentMethod = \Stripe\PaymentMethod::retrieve(
            $paymentIntent->payment_method
        );
        $card = $paymentMethod->card;
        $cardDetails = [
            'brand' => $card->brand,
            'last4' => $card->last4,
            'exp_month' => $card->exp_month,
            'exp_year' => $card->exp_year
        ];

        // With setup_future_usage, we need to ensure the payment method is properly attached
        \Log::info('Payment method saved for future use: ' . $paymentIntent->payment_method);
        
        // Ensure the payment method is attached to the customer
        if ($session->customer && $paymentIntent->payment_method) {
            try {
                $paymentMethod = \Stripe\PaymentMethod::retrieve($paymentIntent->payment_method);
                
                // Check if payment method is already attached to this customer
                if ($paymentMethod->customer !== $session->customer) {
                    // Attach the payment method to the customer
                    $paymentMethod->attach(['customer' => $session->customer]);
                    \Log::info('Payment method attached to customer: ' . $paymentIntent->payment_method . ' -> ' . $session->customer);
                } else {
                    \Log::info('Payment method already attached to customer: ' . $paymentIntent->payment_method);
                }
                
            } catch (\Exception $e) {
                \Log::warning('Could not attach payment method: ' . $e->getMessage());
            }
        }

        //Get invoice details
        $invoiceId = $session->invoice;
        $invoice = \Stripe\Invoice::retrieve($invoiceId);
        $invoiceDetails = [
            'invoice_id' => $invoice->id,
            'invoice_number' => $invoice->number,
            'invoice_pdf' => $invoice->invoice_pdf
        ];

        //Get receipt details
        $charge = \Stripe\Charge::retrieve($paymentIntent->latest_charge);
        $receiptDetails = [
            'receipt_url' => $charge->receipt_url
        ];

        //Get transaction detail
        $paymentHistoryDetail = PaymentHistory::where('transaction_id', $data['transaction_id'])->first();
        if(empty($paymentHistoryDetail)){
            PaymentHistory::create([
                'user_id' => $user_id,
                'transaction_id' => $data['transaction_id'],
                'description' => $data['description'],
                'payment_method' => $data['payment_method'],
                'amount' => $data['amount'],
                'card_details' => json_encode($cardDetails),
                'invoice_detail' => json_encode($invoiceDetails),
                'receipt_detail' => json_encode($receiptDetails),
                'payment_for' => 'membership',
                'status' => $data['status'],
                'created_at' => Carbon::now()
            ]);
        }
    }*/

    public function getTransactionDetail($request){
        /**********Get transaction detail start*****************/
        StripeService::configure();
        $sessionId = $request->get('session_id');
        if(!empty($sessionId)){
            $session = \Stripe\Checkout\Session::retrieve($sessionId);
            $paymentIntent = PaymentIntent::retrieve($session->payment_intent);
            //Get line items
            $lineItems = \Stripe\Checkout\Session::allLineItems($sessionId);
            $description = $lineItems->data[0]->description;
            
            $data = [
                'transaction_id' => $paymentIntent->id,
                'description'    => $description,
                'payment_method' => $paymentIntent->payment_method_types[0] ?? null,
                'amount'         => $paymentIntent->amount / 100,
                'currency'       => $paymentIntent->currency,
                'status'         => $paymentIntent->status,
            ];
    
            if($paymentIntent->status == 'succeeded'){
                $planDetail = session('planDetail');
                if(strtolower($planDetail->membership_period) == 'month'){
                    $plan_expiry = Carbon::now()->addDays(30);
                }else if(strtolower($planDetail->membership_period) == 'year'){
                    $plan_expiry = Carbon::now()->addDays(365);
                }else {
                    //set plan expiry for lifetime or other types of plans
                    $plan_expiry = Carbon::now()->addYears(100); // Set a far future date for lifetime plans
                }
    
                //Update users table
                if(Auth::check()){
                    $user_id = auth()->user()->id;
                    $user = User::findOrFail($user_id);
                    
                    // Update stripe_customer_id if not already set
                    if (!$user->stripe_customer_id && $session->customer) {
                        $user->stripe_customer_id = $session->customer;
                    }
                    
                    $user->update([
                        'plan_id' => $planDetail->id,
                        'plan_name' => $planDetail->membership_name,
                        'plan_price' => $planDetail->membership_price,
                        'plan_period' => $planDetail->membership_period,
                        'plan_expiry' => isset($plan_expiry) ? $plan_expiry : null,
                        'stripe_customer_id' => $user->stripe_customer_id ?? $session->customer
                    ]);
                }else{
                    $user_id = session('user_id');
                    $user = User::findOrFail($user_id);
                    
                    // Update stripe_customer_id if not already set
                    if (!$user->stripe_customer_id && $session->customer) {
                        $user->stripe_customer_id = $session->customer;
                    }
                    
                    $user->update([
                        'plan_id' => $planDetail->id,
                        'plan_name' => $planDetail->membership_name,
                        'plan_price' => $planDetail->membership_price,
                        'plan_period' => $planDetail->membership_period,
                        'plan_expiry' => isset($plan_expiry) ? $plan_expiry : null,
                        'stripe_customer_id' => $user->stripe_customer_id ?? $session->customer,
                        'status' => 'active'
                    ]);
                }

                // Assign a unique membership number on first membership purchase
                if (empty($user->membership_number)) {
                    $user->membership_number = User::generateMembershipNumber();
                    $user->save();
                }

                // Sync the member's Shopify discount code (new purchase / renewal / tier change)
                app(\App\Services\ShopifyAppService::class)->syncActiveMember($user);
            }
    
            //Get card details
            $paymentMethod = \Stripe\PaymentMethod::retrieve(
                $paymentIntent->payment_method
            );
            $card = $paymentMethod->card;
            $cardDetails = [
                'brand' => $card->brand,
                'last4' => $card->last4,
                'exp_month' => $card->exp_month,
                'exp_year' => $card->exp_year
            ];
    
            // With setup_future_usage, we need to ensure the payment method is properly attached
            \Log::info('Payment method saved for future use: ' . $paymentIntent->payment_method);
            
            // Ensure the payment method is attached to the customer
            if ($session->customer && $paymentIntent->payment_method) {
                try {
                    $paymentMethod = \Stripe\PaymentMethod::retrieve($paymentIntent->payment_method);
                    
                    // Check if payment method is already attached to this customer
                    if ($paymentMethod->customer !== $session->customer) {
                        // Attach the payment method to the customer
                        $paymentMethod->attach(['customer' => $session->customer]);
                        \Log::info('Payment method attached to customer: ' . $paymentIntent->payment_method . ' -> ' . $session->customer);
                    } else {
                        \Log::info('Payment method already attached to customer: ' . $paymentIntent->payment_method);
                    }
                    
                } catch (\Exception $e) {
                    \Log::warning('Could not attach payment method: ' . $e->getMessage());
                }
            }
    
            //Get invoice details
            $invoiceId = $session->invoice;
            $invoice = \Stripe\Invoice::retrieve($invoiceId);
            $invoiceDetails = [
                'invoice_id' => $invoice->id,
                'invoice_number' => $invoice->number,
                'invoice_pdf' => $invoice->invoice_pdf
            ];
    
            //Get receipt details
            $charge = \Stripe\Charge::retrieve($paymentIntent->latest_charge);
            $receiptDetails = [
                'receipt_url' => $charge->receipt_url
            ];
        }

        //Get transaction detail
        if(isset($data['transaction_id'])){
            $paymentHistoryDetail = PaymentHistory::where('transaction_id', $data['transaction_id'])->first();
            if(empty($paymentHistoryDetail)){
                PaymentHistory::create([
                    'user_id' => $user_id,
                    'transaction_id' => $data['transaction_id'],
                    'description' => $data['description'],
                    'payment_method' => $data['payment_method'],
                    'amount' => $data['amount'],
                    'card_details' => json_encode($cardDetails),
                    'invoice_detail' => json_encode($invoiceDetails),
                    'receipt_detail' => json_encode($receiptDetails),
                    'payment_for' => 'membership',
                    'status' => $data['status'],
                    'created_at' => Carbon::now()
                ]);
            }   
        }
        /**********Get transaction detail end*****************/
    }

    public function terms()
    {
        $content = ContentManagement::where('page_name', 'terms_and_conditions_page')->first();
        return view('front.pages.terms-and-conditions', compact('content'));
    }

    public function privacy()
    {
        $content = ContentManagement::where('page_name', 'privacy_policy_page')->first();
        return view('front.pages.privacy-policy', compact('content'));
    }

}