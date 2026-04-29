<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\UserAddress;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\MemberSignupMail;
use Stripe\Stripe;
use Stripe\Charge;
use Stripe\PaymentIntent;
use App\Models\PaymentHistory;
use Carbon\Carbon;
use App\Models\User;

class CheckoutController extends Controller
{
    
    public function shipping()
    {
        $addresses = [];
        if(Auth::check()){
            $addresses = auth()->user()->addresses()->get();
            session('addresses', $addresses);
        }
        $cartItems = $this->getCartTotal();
        return view('front.checkout.shipping', compact('addresses', 'cartItems'));
    }

    public function shippingStore(Request $request)
    {
        if(!Auth::check()){
            if($request->checkout_type == 'guest'){
                $data = [
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'address_line_1' => $request->address_line_1,
                    'address_line_2' => $request->address_line_2,
                    'city' => $request->city,
                    'state' => $request->state,
                    'zip_code' => $request->postal_code,
                    'country' => $request->country
                ];
                session(['checkout.shipping'=>$data]);
            }else{
                /*********Register Account Process Start***************/
                //Get user detail 
                $userDetail = User::where('email', $request->email)->first();
                if(!empty($userDetail)){
                    return redirect()->route('checkout.shipping')->with('error', 'Email already exists. Please use a different email address.');
                }else{
                    /******Add user start*********/
                    $userData = [
                        'first_name' => $request->first_name,
                        'last_name' => $request->last_name,
                        'email' => $request->email,
                        'phone' => $request->phone,
                        'password' => bcrypt('12345678'),
                        'role' => 'user'
                    ];
                    $user = User::create($userData);

                    Mail::to($request->email)->send(
                        new MemberSignupMail($user, '12345678')
                    );
                    /******Add user end*********/

                    /******Add user address start*********/
                    $userAddressData = [
                        'user_id' => $user->id,
                        'first_name' => $request->first_name,
                        'last_name' => $request->last_name,
                        'email' => $request->email,
                        'phone' => $request->phone,
                        'address_line_1' => $request->address_line_1,
                        'address_line_2' => $request->address_line_2,
                        'city' => $request->city,
                        'state' => $request->state,
                        'zip_code' => $request->postal_code,
                        'country' => $request->country
                    ];
                    $userAddress = UserAddress::create($userAddressData);
                    session(['checkout.shipping'=>$userAddressData]);
                    /******Add user address end**********/
                }
                /*********Register Account Process End***************/
            }
        }else{
            if($request->address_id == 'new'){
                $firstName = $request->first_name;
                $lastName = $request->last_name;
                $email = $request->email;
                $phone = $request->phone;
                $addressLine1 = $request->address_line_1;
                $addressLine2 = $request->address_line_2;
                $city = $request->city;
                $state = $request->state;
                $postalCode = $request->postal_code;
                $country = $request->country;

                $user = auth()->user(); 
                $data = [
                    'user_id' => $user->id,
                    'first_name' => $firstName, 
                    'last_name' => $lastName,
                    'email' => $email,
                    'phone' => $phone,
                    'address_line_1' => $addressLine1,
                    'address_line_2' => $addressLine2,
                    'city' => $city,
                    'state' => $state,
                    'zip_code' => $postalCode,
                    'country' => $country
                ];
                $address = UserAddress::create($data);
                session(['checkout.shipping'=>$data]);
                //session('address_id', $address->id);
            }else{
                //session('address_id', $request->address_id);
                $userAddressDetail = UserAddress::findOrFail($request->address_id);
                $data = [
                    'first_name' => $userAddressDetail->first_name,
                    'last_name' => $userAddressDetail->last_name,
                    'email' => $userAddressDetail->email,
                    'phone' => $userAddressDetail->phone,
                    'address_line_1' => $userAddressDetail->address_line_1,
                    'address_line_2' => $userAddressDetail->address_line_2,
                    'city' => $userAddressDetail->city,
                    'state' => $userAddressDetail->state,
                    'zip_code' => $userAddressDetail->zip_code,
                    'country' => $userAddressDetail->country
                ];
                session(['checkout.shipping'=>$data]);
            }
        }
        return redirect()->route('checkout.delivery');
    }

    public function deliveryStore(Request $request){
        $method = $request->delivery_method;
        $charges = [
            'standard' => 5.99,
            'express' => 12.99,
            'overnight' => 24.99
        ];
        $shippingCharge = $charges[$method] ?? 0;
        Session::put('checkout.delivery', [
            'method' => $method,
            'charge' => $shippingCharge,
            'delivery_instructions' => $request->delivery_instructions ?? null
        ]);
        return redirect()->route('checkout.payment');
    }

    public function payment()
    {
        $cartItems = $this->getCartTotal();
        return view('front.checkout.payment', compact('cartItems'));
    }

    public function paymentStore(Request $request){
        $data = $request->validate([
            'payment_method'=>'required'
        ]);

        session(['checkout.payment'=>[
            'method'=>$data['payment_method']
        ]]);

        $billingAddress = [];
        if(!$request->same_as_shipping){
            $billingAddress = [
                'first_name' => $request->billing_first_name,
                'last_name' => $request->billing_last_name,
                'address_line_1' => $request->billing_address_line_1,
                'address_line_2' => $request->billing_address_line_2,
                'city' => $request->billing_city,
                'state' => $request->billing_state,
                'zip_code' => $request->billing_postal_code,
                'country' => $request->billing_country
            ];
        }

        session(['checkout.billing'=> $billingAddress]);

        return redirect()->route('checkout.review');
    }

    public function delivery()
    {
        $cartItems = $this->getCartTotal();
        return view('front.checkout.delivery', compact('cartItems'));
    }

    public function review()
    {
        $cartItems = $this->getCartTotal();
        return view('front.checkout.review', compact('cartItems'));
    }

    public function thankyou()
    {
        return view('front.checkout.thankyou');
    }

    public function success(Request $request)
    {
        //get order detail
        $order = Order::limit(1)->orderBy('id','desc')->first();
        $orderItems = OrderItem::where('order_id', $order->id)->get();

        /**********Get transaction detail start*****************/
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
            //Update order table
            $order->update([
                'payment_status'=>'completed'
            ]);
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
                'user_id' => $order->user_id,
                'transaction_id' => $data['transaction_id'],
                'description' => $data['description'],
                'payment_method' => $data['payment_method'],
                'amount' => $data['amount'],
                'card_details' => json_encode($cardDetails),
                'invoice_detail' => json_encode($invoiceDetails),
                'receipt_detail' => json_encode($receiptDetails),
                'payment_for' => 'order',
                'status' => $data['status'],
                'created_at' => Carbon::now()
            ]);
        }
        /**********Get transaction detail end*****************/


        session()->forget('cart');
        session()->forget('checkout.shipping');
        session()->forget('checkout.delivery');
        session()->forget('checkout.payment');
        session()->forget('checkout.billing');

        return view('front.checkout.success',compact('orderItems','order'));
    }

    public function cancel()
    {
        //get order detail
        $order = Order::limit(1)->orderBy('id','desc')->first();
        $orderItems = OrderItem::where('order_id', $order->id)->get();

        //Update order table
        $order->update([
            'payment_status'=>'failed'
        ]);
        return view('front.checkout.cancel',compact('order','orderItems'));
    }

    public function getCartTotal()
    {
        $cart = Session::get('cart', []);
        $total = 0;
        $cartItems = [];

        foreach ($cart as $productId => $quantity) {
            //Get product detail with user detail
            $product = Product::with('user')->find($productId);
            if ($product) {
                $itemTotal = $product->price * $quantity;
                $total += $itemTotal;
                $cartItems[] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'vendor' => $product->user->name,
                    'quantity' => $quantity,
                    'itemTotal' => $itemTotal,
                    'price' => $product->price,
                    'originalPrice' => $product->originalPrice,
                    'image' =>  $product->image ? asset('product_images/' . $product->image) : null
                ];
            }
        }

        return $cartItems;
    }

    public function placeOrder(Request $request)
    {

        $cart = session('cart', []);
        if(!$cart){
            return redirect()->route('cart');
        }

        $shipping = session('checkout.shipping');
        $delivery = session('checkout.delivery');
        $payment = session('checkout.payment');
        $billing = session('checkout.biling');
        //dd($shipping);
        $subtotal = 0;
        foreach($cart as $productId => $qty){
            $product = Product::findOrFail($productId);
            $subtotal += $product->price * $qty;
        }

        $total = $subtotal + $delivery['charge'];
        $order = Order::create([
            'order_number' => 'ORD_'.time(),
            'user_id'=>auth()->id(),
            'first_name'=>$shipping['first_name'],
            'last_name'=>$shipping['last_name'],
            'email'=>$shipping['email'],
            'phone'=>$shipping['phone'],
            'address_line_1'=>$shipping['address_line_1'],
            'address_line_2'=>$shipping['address_line_2'] ?? null,
            'city'=>$shipping['city'],
            'state'=>$shipping['state'],
            'zip_code'=>$shipping['zip_code'],
            'country'=>$shipping['country'],
            'payment_method'=>$payment['method'],
            'subtotal'=>$subtotal,
            'shipping_method' => $delivery['method'],
            'shipping_cost'=>$delivery['charge'],
            'tax' => 0,
            'discount' => 0,
            'total'=>$total,
            'status' => 'pending',
            'payment_status'=>'pending',
            'shipping_address' => json_encode($shipping),
            'billing_address' => json_encode($billing),
            'notes' => $delivery['delivery_instructions'] ?? null
        ]);


        foreach($cart as $productId => $qty){
            $product = Product::findOrFail($productId);
            OrderItem::create([
                'user_id'=>auth()->id(),
                'order_id'=>$order->id,
                'product_id'=>$productId,
                'product_name' => $product->name,
                'quantity'=>$qty,
                'price'=>$product->price,
                'total' => $product->price * $qty
            ]);
        }

        /************Stripe payment start here****************/
        Stripe::setApiKey(config('services.stripe.secret'));
        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'Order #' . $order->order_number,
                        'description' => 'Order #' . $order->order_number
                    ],
                    'unit_amount' => (int)($total * 100), // Dynamic total in cents
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'invoice_creation' => [
                'enabled' => true
            ],
            'success_url' => route('checkout.payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout.payment.cancel'),
            'metadata' => [
                'order_id' => $order->id // Useful for webhooks later
            ]
        ]);
        return redirect($session->url, 303);
        /************Stripe payment end here*****************/
    }

}