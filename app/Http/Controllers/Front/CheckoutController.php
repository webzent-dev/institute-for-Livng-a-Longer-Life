<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\SubOrder;
use App\Models\SubOrderItem;
use App\Models\UserAddress;
use App\Services\AddressValidationService;
use App\Services\OrderFulfilmentService;
use App\Services\ShippingService;
use App\Services\StripeService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use App\Mail\MemberSignupMail;
use Stripe\Stripe;
use Stripe\Charge;
use Stripe\PaymentIntent;
use App\Models\PaymentHistory;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Country;
use App\Mail\OrderConfirmationMail;
use App\Mail\AdminOrderNotification;
use App\Mail\CollaboratorOrderNotification;
use App\Mail\SubOrderNotification;
use App\Models\SiteSetting;

class CheckoutController extends Controller
{
    protected $shippingService;
    protected $addressValidationService;
    protected $fulfilmentService;

    public function __construct(ShippingService $shippingService, AddressValidationService $addressValidationService, OrderFulfilmentService $fulfilmentService)
    {
        $this->shippingService = $shippingService;
        $this->addressValidationService = $addressValidationService;
        $this->fulfilmentService = $fulfilmentService;
    }
    
    public function shipping()
    {
        //Add check if cart is empty then redirect to cart page
        $cart = session('cart', []);
        if(empty($cart)){
            return redirect()->route('shop')->with('error', 'Your cart is empty. Please add products to cart before proceeding to checkout.');
        }

        $addresses = [];
        if(Auth::check()){
            $addresses = auth()->user()->addresses()->get();
            session('addresses', $addresses);
        }
        $cartItems = $this->getCartTotal();

        $countries = Country::all();
        return view('front.checkout.shipping', compact('addresses', 'cartItems', 'countries'));
    }

    public function shippingStore(Request $request)
    {
        //Add check if cart is empty then redirect to cart page
        $cart = session('cart', []);
        if(empty($cart)){
            return redirect()->route('shop')->with('error', 'Your cart is empty. Please add products to cart before proceeding to checkout.');
        }

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

                // Validate address if enabled
                if (config('shipping.validation.address_validation.enabled', true)) {
                    // Check if country is US - if not, block checkout
                    if (!isset($data['country']) || !in_array(strtoupper($data['country']), ['US', 'USA', 'UNITED STATES'])) {
                        return redirect()->route('checkout.shipping')
                            ->with('error', 'Currently we only ship within United States. Please select United States as your country.')
                            ->withInput();
                    }
                    
                    // Use US-specific validation for US addresses
                    $validation = $this->addressValidationService->validateUSAddress($data);
                    
                    if (!$validation['valid']) {
                        return redirect()->route('checkout.shipping')
                            ->with('error', 'Address validation failed. Please check your address.')
                            ->with('validation_results', $validation)
                            ->withInput();
                    }
                    
                    // Store validation results for frontend display
                    session(['address_validation' => $validation]);
                }

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
                        'password' => bcrypt(Str::random(32)),
                        'role' => 'user'
                    ];
                    $user = User::create($userData);

                    if(!empty($request->email)) {
                        $resetToken = Password::createToken($user);
                        $resetUrl = route('password.reset', ['token' => $resetToken, 'email' => $user->email]);
                        Mail::to($request->email)->send(
                            new MemberSignupMail($user, null, $resetUrl)
                        );
                    }
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

                // Validate address if enabled
                if (config('shipping.validation.address_validation.enabled', true)) {
                    // Check if country is US - if not, block checkout
                    if (!isset($data['country']) || !in_array(strtoupper($data['country']), ['US', 'USA', 'UNITED STATES'])) {
                        return redirect()->route('checkout.shipping')
                            ->with('error', 'Currently we only ship within United States. Please select United States as your country.')
                            ->withInput();
                    }
                    
                    // Use US-specific validation for US addresses
                    $validation = $this->addressValidationService->validateUSAddress($data);
                    
                    if (!$validation['valid']) {
                        return redirect()->route('checkout.shipping')
                            ->with('error', 'Address validation failed. Please check your address.')
                            ->with('validation_results', $validation)
                            ->withInput();
                    }
                    
                    // Store validation results for frontend display
                    session(['address_validation' => $validation]);
                }

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

                // Validate address if enabled
                if (config('shipping.validation.address_validation.enabled', true)) {
                    // Check if country is US - if not, block checkout
                    if (!isset($data['country']) || !in_array(strtoupper($data['country']), ['US', 'USA', 'UNITED STATES'])) {
                        return redirect()->route('checkout.shipping')
                            ->with('error', 'Currently we only ship within United States. Please select United States as your country.')
                            ->withInput();
                    }
                    
                    // Use US-specific validation for US addresses
                    $validation = $this->addressValidationService->validateUSAddress($data);
                    
                    if (!$validation['valid']) {
                        return redirect()->route('checkout.shipping')
                            ->with('error', 'Address validation failed. Please check your address.')
                            ->with('validation_results', $validation)
                            ->withInput();
                    }
                    
                    // Store validation results for frontend display
                    session(['address_validation' => $validation]);
                }

                session(['checkout.shipping'=>$data]);
            }
        }
        return redirect()->route('checkout.delivery');
    }

    public function deliveryStore(Request $request){
        //Add check if cart is empty then redirect to cart page
        $cart = session('cart', []);
        if(empty($cart)){
            return redirect()->route('shop')->with('error', 'Your cart is empty. Please add products to cart before proceeding to checkout.');
        }

        // Get the shipping address from session
        $shipping = session('checkout.shipping');
        if (!$shipping) {
            return redirect()->route('checkout.shipping')->with('error', 'Please enter shipping information first.');
        }

        // Calculate shipping rates using ShippingService
        try {
            $destinationAddress = [
                'name' => $shipping['first_name'] . ' ' . $shipping['last_name'],
                'address_line_1' => $shipping['address_line_1'],
                'address_line_2' => $shipping['address_line_2'] ?? '',
                'city' => $shipping['city'],
                'state' => $shipping['state'],
                'zip_code' => $shipping['zip_code'],
                'country' => $shipping['country'],
            ];
            
            \Log::info('DeliveryStore - Calculating shipping for destination: ' . json_encode($destinationAddress));
            \Log::info('DeliveryStore - Cart items: ' . json_encode($cart));
            
            $shippingRates = $this->shippingService->calculateSplitShippingRates($cart, $destinationAddress);
            
            \Log::info('DeliveryStore - Shipping rates calculated: ' . json_encode($shippingRates));
            
            // Process selected delivery methods for each seller
            $totalShippingCost = 0;
            $selectedMethods = [];
            
            \Log::info('DeliveryStore - Processing delivery methods for ' . count($shippingRates) . ' sellers');
            
            foreach ($shippingRates as $sellerId => $quote) {
                $deliveryMethodKey = 'delivery_method_' . $sellerId;
                $selectedMethod = $request->input($deliveryMethodKey);
                
                \Log::info('DeliveryStore - Looking for ' . $deliveryMethodKey . ', found: ' . $selectedMethod);
                
                if ($selectedMethod) {
                    // Parse the selected method (format: "service_sellerId")
                    $parts = explode('_', $selectedMethod);
                    $service = $parts[0];
                    
                    \Log::info('DeliveryStore - Parsed service: ' . $service . ' for seller: ' . $sellerId);
                    
                    // Find the rate for this service
                    if (isset($quote['rates'][$service])) {
                        $rateAmount = $quote['rates'][$service]['amount'];
                        $handlingFee = $quote['handling_fee'] ?? 0;
                        
                        $selectedMethods[$sellerId] = [
                            'service' => $service,
                            'rate' => $quote['rates'][$service],
                            'handling_fee' => $handlingFee
                        ];
                        $totalShippingCost += $rateAmount + $handlingFee;
                        
                        \Log::info('DeliveryStore - Added rate: ' . $rateAmount . ' + handling: ' . $handlingFee . ' = ' . ($rateAmount + $handlingFee));
                    } else {
                        \Log::warning('DeliveryStore - Rate not found for service: ' . $service . ' in seller: ' . $sellerId);
                    }
                } else {
                    \Log::warning('DeliveryStore - No delivery method selected for seller: ' . $sellerId);
                }
            }
            
            \Log::info('DeliveryStore - Final total shipping cost: ' . $totalShippingCost);
            
            Session::put('checkout.delivery', [
                'methods' => $selectedMethods,
                'total_charge' => $totalShippingCost,
                'delivery_instructions' => $request->delivery_instructions ?? null,
                'shipping_rates' => $shippingRates
            ]);
            
        } catch (\Exception $e) {
            // Fallback to default if calculation fails
            Session::put('checkout.delivery', [
                'methods' => [],
                'total_charge' => 0,
                'delivery_instructions' => $request->delivery_instructions ?? null,
                'shipping_rates' => []
            ]);
            \Log::error('Shipping calculation failed in deliveryStore: ' . $e->getMessage());
        }
        
        return redirect()->route('checkout.payment');
    }

    public function payment()
    {
        //Add check if cart is empty then redirect to cart page
        $cart = session('cart', []);
        if(empty($cart)){
            return redirect()->route('shop')->with('error', 'Your cart is empty. Please add products to cart before proceeding to checkout.');
        }

        $cartItems = $this->getCartTotal();
        $countries = Country::all();
        return view('front.checkout.payment', compact('cartItems', 'countries'));
    }

    public function paymentStore(Request $request){
        //Add check if cart is empty then redirect to cart page
        $cart = session('cart', []);
        if(empty($cart)){
            return redirect()->route('shop')->with('error', 'Your cart is empty. Please add products to cart before proceeding to checkout.');
        }

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
            session(['checkout.billing'=> $billingAddress]);
        }else{
            $shipping = session('checkout.shipping');
            session(['checkout.billing'=> $shipping]);
        }

        return redirect()->route('checkout.review');
    }

    public function delivery()
    {
        //Add check if cart is empty then redirect to cart page
        $cart = session('cart', []);
        if(empty($cart)){
            return redirect()->route('shop')->with('error', 'Your cart is empty. Please add products to cart before proceeding to checkout.');
        }

        $shipping = session('checkout.shipping');
        if (!$shipping) {
            return redirect()->route('checkout.shipping')->with('error', 'Please enter shipping information first.');
        }

        $cartItems = $this->getCartTotal();
        
        // Calculate shipping rates using ShippingService
        try {
            // Prepare destination address for shipping service
            $destinationAddress = [
                'name' => $shipping['first_name'] . ' ' . $shipping['last_name'],
                'address_line_1' => $shipping['address_line_1'],
                'address_line_2' => $shipping['address_line_2'] ?? '',
                'city' => $shipping['city'],
                'state' => $shipping['state'],
                'zip_code' => $shipping['zip_code'],
                'country' => $shipping['country'],
            ];
            
            \Log::info('Calculating shipping for destination: ' . json_encode($destinationAddress));
            \Log::info('Cart items: ' . json_encode($cart));
            
            $shippingRates = $this->shippingService->calculateSplitShippingRates($cart, $destinationAddress);
            
            // Calculate total shipping cost properly
            $totalShippingCost = 0;
            foreach ($shippingRates as $sellerId => $quote) {
                $selectedRate = $quote['selected_rate'] ?? null;
                if ($selectedRate) {
                    $totalShippingCost += $selectedRate['amount'] + ($quote['handling_fee'] ?? 0);
                }
            }
            
            \Log::info('Shipping rates calculated: ' . json_encode($shippingRates));
            \Log::info('Total shipping cost: ' . $totalShippingCost);
            
        } catch (\Exception $e) {
            // Fallback to default rates if calculation fails
            $shippingRates = [];
            $totalShippingCost = 0;
            \Log::error('Shipping calculation failed: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
        }

        return view('front.checkout.delivery', compact('cartItems', 'shippingRates', 'totalShippingCost'));
    }

    public function review()
    {
        //Add check if cart is empty then redirect to cart page
        $cart = session('cart', []);
        if(empty($cart)){
            return redirect()->route('shop')->with('error', 'Your cart is empty. Please add products to cart before proceeding to checkout.');
        }

        $cartItems = $this->getCartTotal();
        return view('front.checkout.review', compact('cartItems'));
    }

    public function thankyou()
    {
        return view('front.checkout.thankyou');
    }

    public function success(Request $request)
    {
        $this->getStripeSecret();
        $sessionId = $request->get('session_id');
        $session = \Stripe\Checkout\Session::retrieve($sessionId);

        $order = Order::findOrFail($session->metadata->order_id);

        if ($order->user_id !== null && Auth::check() && Auth::id() !== $order->user_id) {
            abort(403);
        }

        $orderItems = OrderItem::where('order_id', $order->id)->get();

        $this->fulfilmentService->fulfil($order, $session);

        session()->forget('cart');
        session()->forget('checkout.shipping');
        session()->forget('checkout.delivery');
        session()->forget('checkout.payment');
        session()->forget('checkout.billing');

        return view('front.checkout.success',compact('orderItems','order'));
    }

    public function cancel(Request $request)
    {
        $this->getStripeSecret();
        $sessionId = $request->get('session_id');
        $session = \Stripe\Checkout\Session::retrieve($sessionId);

        $order = Order::findOrFail($session->metadata->order_id);

        if ($order->user_id !== null && Auth::check() && Auth::id() !== $order->user_id) {
            abort(403);
        }

        $orderItems = OrderItem::where('order_id', $order->id)->get();

        //Update order table
        $order->update([
            'payment_status'=>'failed'
        ]);
        return view('front.checkout.cancel', compact('orderItems','order'));
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
        //Add check if cart is empty then redirect to cart page
        $cart = session('cart', []);
        if(empty($cart)){
            return redirect()->route('shop')->with('error', 'Your cart is empty. Please add products to cart before proceeding to checkout.');
        }

        $shipping = session('checkout.shipping');
        $delivery = session('checkout.delivery');
        $payment = session('checkout.payment');
        $billing = session('checkout.billing');
        
        // Use already calculated shipping costs from delivery session
        $totalShipping = $delivery['total_charge'] ?? $delivery['charge'] ?? 0;
        $shippingQuotes = $delivery['shipping_rates'] ?? [];
        
        // Calculate order totals
        $subtotal = 0;
        foreach($cart as $productId => $qty){
            $product = Product::findOrFail($productId);
            $subtotal += $product->price * $qty;
        }

        $total = $subtotal + $totalShipping;

        /************Stripe payment start here****************/
        $stripeUrl = DB::transaction(function () use ($cart, $shipping, $delivery, $payment, $billing, $totalShipping, $shippingQuotes, $subtotal, $total) {
            // Create main order
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
                'shipping_method' => 'split_shipping',
                'shipping_cost'=>$totalShipping,
                'tax' => 0,
                'discount' => 0,
                'total'=>$total,
                'status' => 'pending',
                'payment_status'=>'pending',
                'shipping_address' => json_encode($shipping),
                'billing_address' => json_encode($billing),
                'notes' => $delivery['delivery_instructions'] ?? null
            ]);

            // Create order items and sub-orders
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

            // Create sub-orders for each seller
            $this->createSubOrders($order, $cart, $shippingQuotes, $shipping);

            //Stripe::setApiKey(config('services.stripe.secret'));
            $this->getStripeSecret();
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
                'cancel_url' => route('checkout.payment.cancel') . '?session_id={CHECKOUT_SESSION_ID}',
                'metadata' => [
                    'order_id' => $order->id // Useful for webhooks later
                ]
            ]);

            return $session->url;
        });
        return redirect($stripeUrl, 303);
        /************Stripe payment end here*****************/
    }

    /**
     * Create sub-orders for split shipping
     */
    private function createSubOrders(Order $order, array $cart, array $shippingQuotes, array $shippingAddress)
    {
        // Group cart items by seller
        $groupedItems = $this->shippingService->groupCartBySeller($cart);

        foreach ($groupedItems as $sellerId => $items) {
            $quote = $shippingQuotes[$sellerId] ?? null;
            if (!$quote) continue;

            // Calculate sub-order totals
            $subtotal = 0;
            foreach ($items as $item) {
                $subtotal += $item['product']->price * $item['quantity'];
            }

            $shippingCost = ($quote['selected_rate']['amount'] ?? 0) + $quote['handling_fee'];
            $total = $subtotal + $shippingCost;

            // Create sub-order
            $subOrder = SubOrder::create([
                'order_id' => $order->id,
                'seller_id' => $sellerId,
                'sub_order_number' => 'SUB_' . $order->order_number . '_' . $sellerId . '_' . time(),
                'subtotal' => $subtotal,
                'shipping_method' => $quote['selected_rate']['service'] ?? 'standard',
                'shipping_cost' => $quote['selected_rate']['amount'] ?? 0,
                'handling_fee' => $quote['handling_fee'],
                'tax' => 0,
                'total' => $total,
                'status' => 'pending',
                'payment_status' => 'pending',
                'origin_address' => $quote['origin_address'],
                'destination_address' => $shippingAddress,
                'carrier' => $quote['selected_rate']['provider'] ?? 'USPS',
                'service_level' => $quote['selected_rate']['service'] ?? 'Standard',
                'weight' => $quote['package_details']['weight'] ?? 0,
                'package_dimensions' => $quote['package_details'],
            ]);

            // Create sub-order items
            foreach ($items as $item) {
                $product = $item['product'];
                SubOrderItem::create([
                    'sub_order_id' => $subOrder->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                    'total' => $product->price * $item['quantity'],
                    'product_snapshot' => [
                        'name' => $product->name,
                        'price' => $product->price,
                        'originalPrice' => $product->originalPrice,
                        'image' => $product->image,
                        'weight' => $product->weight,
                        'dimensions' => [
                            'length' => $product->length,
                            'width' => $product->width,
                            'height' => $product->height,
                        ]
                    ]
                ]);
            }
        }
    }

    public function getStripeSecret()
    {
        StripeService::configure();
    }

}