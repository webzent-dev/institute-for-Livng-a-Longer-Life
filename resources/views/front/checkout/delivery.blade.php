@extends('front.layouts.app')
@section('content')
<div x-data="cartState()" class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-6xl mx-auto px-4">
        <!-- Progress Bar -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center">
                    <div class="flex items-center justify-center w-10 h-10 bg-green-500 text-white rounded-full font-bold">✓</div>
                    <span class="ml-3 text-sm font-medium text-green-600">Shipping</span>
                </div>
                <div class="h-1 flex-1 mx-4 bg-gray-300">
                    <div class="h-1 bg-green-500" style="width: 100%"></div>
                </div>
                <div class="flex items-center">
                    <div class="flex items-center justify-center w-10 h-10 bg-primary text-white rounded-full font-bold">2</div>
                    <span class="ml-3 text-sm font-medium text-primary">Delivery</span>
                </div>
                <div class="h-1 flex-1 mx-4 bg-gray-300"></div>
                <div class="flex items-center">
                    <div class="flex items-center justify-center w-10 h-10 bg-gray-300 text-gray-600 rounded-full font-bold">3</div>
                    <span class="ml-3 text-sm font-medium text-gray-600">Payment</span>
                </div>
                <div class="h-1 flex-1 mx-4 bg-gray-300"></div>
                <div class="flex items-center">
                    <div class="flex items-center justify-center w-10 h-10 bg-gray-300 text-gray-600 rounded-full font-bold">4</div>
                    <span class="ml-3 text-sm font-medium text-gray-600">Review</span>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <form action="{{ route('checkout.delivery.store') }}" method="POST" class="space-y-8">
                @csrf
                <!-- Display validation errors -->
                @if($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-md p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i data-lucide="alert-circle" class="h-5 w-5 text-red-400"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">There were some errors with your submission:</h3>
                            <div class="mt-2 text-sm text-red-700">
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                <!-- Delivery Options -->
                <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
                    <div class="border-b border-gray-200 px-6 py-4">
                        <h2 class="text-xl font-bold text-gray-900">Delivery Options</h2>
                        <p class="text-sm text-gray-500 mt-1">Choose how you want to receive your order</p>
                    </div>
                    <div class="p-6 space-y-4">
                        @if(isset($shippingRates) && !empty($shippingRates))
                            @foreach($shippingRates as $sellerId => $sellerRates)
                                <div class="mb-6">
                                    <h3 class="font-medium text-gray-900 mb-3">
                                        @if(isset($sellerRates['seller_name']))
                                            {{ $sellerRates['seller_name'] }}
                                        @else
                                            Seller {{ $loop->iteration }}
                                        @endif
                                    </h3>
                                    <div class="space-y-3">
                                        @if(!empty($sellerRates['free_shipping']))
                                            <label class="flex items-start p-4 border-2 rounded-lg border-primary bg-primary/5">
                                                <input type="radio" name="delivery_method_{{ $sellerId }}" value="free_{{ $sellerId }}" checked class="mt-1 mr-3 delivery-method-radio" data-seller-id="{{ $sellerId }}" data-rate-key="free" data-amount="0" data-handling-fee="0">
                                                <div class="flex-1">
                                                    <div class="flex justify-between items-start">
                                                        <div>
                                                            <div class="font-medium text-gray-900">Free shipping</div>
                                                            <div class="text-sm text-gray-600">Included with your yearly Vital Boost subscription</div>
                                                        </div>
                                                        <div class="text-right"><div class="font-medium text-green-600">$0.00</div></div>
                                                    </div>
                                                </div>
                                            </label>
                                        @elseif(!empty($sellerRates['rates']))
                                            @php
                                                // Pre-select the same rate the backend defaults this seller to, so the
                                                // summary and the order total agree before the buyer touches anything.
                                                $defaultRateKey = $sellerRates['default_rate_key'] ?? array_key_first($sellerRates['rates']);
                                                $handlingFee = $sellerRates['handling_fee'] ?? 0;
                                            @endphp
                                            @foreach($sellerRates['rates'] as $rateKey => $rate)
                                                <label class="flex items-start p-4 border-2 rounded-lg cursor-pointer transition @if($rateKey === $defaultRateKey) border-primary bg-primary/5 @else border-gray-300 @endif hover:border-primary active:bg-primary/5">
                                                    <input type="radio" name="delivery_method_{{ $sellerId }}" value="{{ $rateKey }}_{{ $sellerId }}" @if($rateKey === $defaultRateKey) checked @endif class="mt-1 mr-3 delivery-method-radio" data-seller-id="{{ $sellerId }}" data-rate-key="{{ $rateKey }}" data-amount="{{ $rate['amount'] }}" data-handling-fee="{{ $handlingFee }}">
                                                    <div class="flex-1">
                                                        <div class="flex justify-between items-start">
                                                            <div>
                                                                <div class="font-medium text-gray-900">{{ $rate['provider'] }} - {{ $rate['service'] }}</div>
                                                                <div class="text-sm text-gray-600">
                                                                    @if(isset($rate['estimated_days']))
                                                                        Estimated delivery: {{ $rate['estimated_days'] }} days
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="text-right">
                                                                <div class="font-medium text-gray-900">${{ number_format($rate['amount'], 2) }}</div>
                                                                <div class="text-sm text-primary">{{ $rate['currency'] ?? 'USD' }}</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </label>
                                            @endforeach
                                        @else
                                            <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                                                <div class="text-sm text-yellow-800">
                                                    @if(isset($sellerRates['no_shipping_message']))
                                                        {{ $sellerRates['no_shipping_message'] }}
                                                    @else
                                                        Shipping rates not available for this seller. Please contact support.
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <!-- Multi-seller shipping rates handled above -->
                            <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                                <div class="text-sm text-yellow-800">
                                    No shipping rates available. Please contact support.
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <!-- Delivery Instructions -->
                <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
                    <div class="border-b border-gray-200 px-6 py-4">
                        <h2 class="text-xl font-bold text-gray-900">Delivery Instructions</h2>
                        <p class="text-sm text-gray-500 mt-1">Optional instructions for the delivery</p>
                    </div>
                    <div class="p-6">
                        <textarea name="delivery_instructions" rows="3" placeholder="e.g., Leave at front door, Ring doorbell twice, etc."
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"></textarea>
                    </div>
                </div>
                <!-- Navigation -->
                <div class="flex justify-between">
                    <a href="{{ route('checkout.shipping') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
                        Back to Shipping
                    </a>
                    <button type="submit" class="btn btn-primary">
                        Proceed to Payment
                        <i data-lucide="arrow-right" class="w-4 h-4 ml-2"></i>
                    </button>
                </div>
                </form>
            </div>
            <!-- Order Summary Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6 sticky top-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Order Summary</h3>
                <!-- Shipping Address -->
                <div class="mb-4 p-3 bg-gray-50 rounded-lg">
                    <h4 class="font-medium text-gray-900 mb-2">Shipping to:</h4>
                    <div class="text-sm text-gray-600">
                        @if(session('checkout.shipping'))
                        {{ session('checkout.shipping.first_name') }} {{ session('checkout.shipping.last_name') }}<br>
                        {{ session('checkout.shipping.address_line_1') }}<br>
                        @if(session('checkout.shipping.address_line_2')){{ session('checkout.shipping.address_line_2') }}<br>@endif
                        {{ session('checkout.shipping.city') }}, {{ session('checkout.shipping.state') }} {{ session('checkout.shipping.zip_code') }}<br>
                        {{ session('checkout.shipping.country') }}
                        @else
                        Address will be displayed after shipping step
                        @endif
                    </div>
                </div>
                <div class="space-y-3 mb-4">
                    @php $cart = session('cart', []); @endphp
                    @foreach($cart as $lineKey => $quantity)
                    @php
                    $product = App\Models\Product::find(App\Support\CartLine::productId($lineKey));
                    if (!$product) { continue; }
                    $meta = App\Support\CartLine::meta($lineKey);
                    $item = [
                        'name' => $product->name,
                        'price' => $product->price,
                        'quantity' => $quantity,
                        'label' => App\Support\CartLine::label($meta['purchase_type'], $meta['plan']),
                    ];
                    @endphp
                    <div class="flex justify-between items-center">
                        <div class="flex-1">
                            <div class="font-medium text-gray-900">{{ $item['name'] }}</div>
                            <div class="text-sm text-gray-500">{{ $item['label'] }} · Qty: {{ $item['quantity'] }}</div>
                        </div>
                        <div class="font-medium text-gray-900" data-price="{{ $item['price'] * $item['quantity'] }}">${{ number_format($item['price'] * $item['quantity'], 2) }}</div>
                    </div>
                    @endforeach
                </div>
                <div class="border-t border-gray-200 pt-4 space-y-2">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="font-medium" id="subtotal-cost"></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Shipping</span>
                        <span class="font-medium" id="shipping-cost"></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Tax</span>
                        <span class="font-medium">$0.00</span>
                    </div>
                    @if(($memberDiscount ?? 0) > 0)
                    <div class="flex justify-between text-green-600">
                        <span>Member Discount ({{ ucfirst(strtolower(auth()->user()->plan_name ?? '')) }})</span>
                        <span class="font-medium">-${{ number_format($memberDiscount, 2) }}</span>
                    </div>
                    @endif
                    @if(($subscriptionDiscount ?? 0) > 0)
                    <div class="flex justify-between text-green-600">
                        <span>Subscription Discount</span>
                        <span class="font-medium">-${{ number_format($subscriptionDiscount, 2) }}</span>
                    </div>
                    @endif
                </div>
                <div class="border-t border-gray-200 pt-4 mt-4">
                    <div class="flex justify-between text-lg font-bold">
                        <span>Total</span>
                        <span id="total-cost"></span>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
// Real shipping costs from backend
const realShippingCosts = @json(isset($shippingRates) ? $shippingRates : []);
const totalShippingCost = @json(isset($totalShippingCost) ? $totalShippingCost : 0);
// Server-computed discounts (fixed for the cart; independent of the shipping method).
const memberDiscount = {{ $memberDiscount ?? 0 }};
const subscriptionDiscount = {{ $subscriptionDiscount ?? 0 }};

// Fallback costs
const defaultShippingCost = {
    standard: 5.99,
    express: 12.99,
    overnight: 24.99
};

function getSubtotal(){
    let subtotal = 0;
    document.querySelectorAll('[data-price]').forEach(el=>{
        subtotal += parseFloat(el.dataset.price);
    });
    return subtotal;
}

function updateSummary(method){
    let subtotal = getSubtotal();
    document.getElementById('subtotal-cost').textContent = '$' + subtotal.toFixed(2);
    
    // Calculate shipping cost based on multi-seller selection:
    // each selected rate, plus that seller's handling fee once.
    let shipping = 0;
    const chargedSellers = new Set();

    document.querySelectorAll('.delivery-method-radio:checked').forEach(radio => {
        shipping += parseFloat(radio.dataset.amount) || 0;

        const sellerId = radio.dataset.sellerId;
        if (!chargedSellers.has(sellerId)) {
            chargedSellers.add(sellerId);
            shipping += parseFloat(radio.dataset.handlingFee) || 0;
        }
    });

    document.getElementById('shipping-cost').textContent = '$' + shipping.toFixed(2);
    let total = subtotal + shipping - memberDiscount - subscriptionDiscount;
    if (total < 0) total = 0;
    document.getElementById('total-cost').textContent = '$' + total.toFixed(2);
}

// Handle multi-seller radio button changes
document.querySelectorAll('.delivery-method-radio').forEach(radio=>{
    radio.addEventListener('change',function(){
        const sellerId = this.dataset.sellerId;
        
        // Update styling for this seller's options
        document.querySelectorAll(`input[name="delivery_method_${sellerId}"]`).forEach(r=>{
            r.closest('label').classList.remove('border-primary','bg-primary/5');
            r.closest('label').classList.add('border-gray-300');
        });
        
        // Highlight selected option
        this.closest('label').classList.remove('border-gray-300');
        this.closest('label').classList.add('border-primary','bg-primary/5');
        
        // Update summary with all selected options
        updateSummary('multi-seller');
    });
});

// Initialize with first selected options
updateSummary('multi-seller');

function cartState() {
    let cartItems = @json($cartItems ?? []);
    return {
        items: cartItems.map(item => ({
            ...item,
            id: item.id,
            name: item.name || '',
            vendor: item.vendor || '',
            quantity: Number(item.quantity || 0),
            price: Number(item.price || 0),
        })),
        updateQuantity(id, qty) {
            if (qty < 1) return;
            this.items = this.items.map(item => {
                if (item.id === id) item.quantity = qty; 
                return item;
            });

            if(qty>0){
                $.ajax({
                    url: baseurl+'/cart/update',
                    type: 'POST',
                    data: {product_id: id, quantity: qty},
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) { 
                        if (data.status == true) { 
                            toastr.success(data.message); 
                            $('#cart_count').html(data.cartCount); 
                        } else { 
                            toastr.error(data.message); 
                        } 
                    } 
                });
            }
        },
        removeFromCart(id) {
            this.items = this.items.filter(item => item.id !== id);
            var r = confirm('Are you sure want to remove this product from cart?');
            if(id != '' && r){
                $.ajax({
                    url: baseurl+"/cart/remove",
                    type: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    cache: false,
                    async: false,
                    data: { product_id: id},
                    success: function (response) {
                        if (response.status == true) {
                            toastr.success(response.message);
                            setTimeout(function () { location.reload(); }, 2000);
                        } else {
                            toastr.error(response.message);
                        }
                    }
                });
            }
        },
        addToCart(id, qty = 1) {
            this.items = this.items.filter(item => item.id !== id);
            this.items.push({ id, quantity: qty });
            var r = confirm('Are you sure want to add this product to cart?');
            if(id != '' && r){
                $.ajax({
                    url: baseurl+'/cart/update',
                    type: 'POST',
                    data: {product_id: id, quantity: qty},
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) { 
                        if (data.status == true) { 
                            toastr.success(data.message); 
                            $('#cart_count').html(data.cartCount); 
                        } else { 
                            toastr.error(data.message); 
                        } 
                    } 
                });
            }
        },
        subtotal() {
            return this.items.reduce((sum, item) => sum + item.price * item.quantity, 0);
        },
        memberDiscount() {
            return this.subtotal() * 0.2;
        },
        /*total() {
            //return this.subtotal() - this.memberDiscount();
            return this.subtotal();
        },*/
        proceedToCheckout() {
            window.location.href = baseurl+'/checkout/shipping';
        },
        currency(value) {
            return "$" + parseFloat(value).toFixed(2);
        }
    }
};
</script>
@endsection