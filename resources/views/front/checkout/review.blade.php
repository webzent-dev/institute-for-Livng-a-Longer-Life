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
                    <div class="flex items-center justify-center w-10 h-10 bg-green-500 text-white rounded-full font-bold">✓</div>
                    <span class="ml-3 text-sm font-medium text-green-600">Delivery</span>
                </div>
                <div class="h-1 flex-1 mx-4 bg-gray-300">
                    <div class="h-1 bg-green-500" style="width: 100%"></div>
                </div>
                <div class="flex items-center">
                    <div class="flex items-center justify-center w-10 h-10 bg-green-500 text-white rounded-full font-bold">✓</div>
                    <span class="ml-3 text-sm font-medium text-green-600">Payment</span>
                </div>
                <div class="h-1 flex-1 mx-4 bg-gray-300">
                    <div class="h-1 bg-green-500" style="width: 100%"></div>
                </div>
                <div class="flex items-center">
                    <div class="flex items-center justify-center w-10 h-10 bg-primary text-white rounded-full font-bold">4</div>
                    <span class="ml-3 text-sm font-medium text-primary">Review</span>
                </div>
            </div>
        </div>
        <!-- Display validation errors -->
        @if($errors->any())
        <div class="mb-8 bg-red-50 border border-red-200 rounded-lg p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">There were some errors with your order:</h3>
                    <div class="mt-2 text-sm text-red-700">
                        <ul role="list" class="list-disc pl-5 space-y-1">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @endif
        <!-- Display success/error messages -->
        @if(session('success'))
        <div class="mb-8 bg-green-50 border border-green-200 rounded-lg p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        </div>
        @endif
        @if(session('error'))
        <div class="mb-8 bg-red-50 border border-red-200 rounded-lg p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                </div>
            </div>
        </div>
        @endif
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Order Review -->
                <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
                    <div class="border-b border-gray-200 px-6 py-4">
                        <h2 class="text-xl font-bold text-gray-900">Review Your Order</h2>
                        <p class="text-sm text-gray-500 mt-1">Please review all details before placing your order</p>
                    </div>
                    <div class="p-6 space-y-6">
                        <!-- Contact Information -->
                        <div>
                            <h3 class="font-medium text-gray-900 mb-2">Contact Information</h3>
                            <div class="text-sm text-gray-600 bg-gray-50 p-3 rounded">
                                <div>Email: {{ session('checkout.shipping.email') }}</div>
                                <div>Phone: {{ session('checkout.shipping.phone') }}</div>
                            </div>
                        </div>
                        <!-- Shipping Address -->
                        <div>
                            <h3 class="font-medium text-gray-900 mb-2">Shipping Address</h3>
                            <div class="text-sm text-gray-600 bg-gray-50 p-3 rounded">
                                {{ session('checkout.shipping.first_name') }} {{ session('checkout.shipping.last_name') }}<br>
                                {{ session('checkout.shipping.address_line_1') }}<br>
                                @if(session('checkout.shipping.address_line_2')){{ session('checkout.shipping.address_line_2') }}<br>@endif
                                {{ session('checkout.shipping.city') }}, {{ session('checkout.shipping.state') }} {{ session('checkout.shipping.zip_code') }}<br>
                                {{ session('checkout.shipping.country') }}
                            </div>
                        </div>
                        <!-- Delivery Method -->
                        <div>
                            <h3 class="font-medium text-gray-900 mb-2">Delivery Method</h3>
                            <div class="text-sm text-gray-600 bg-gray-50 p-3 rounded">
                                @if(session('checkout.delivery.methods') !== null)
                                    Multi-seller shipping
                                @else
                                    {{ ucfirst(session('checkout.delivery.method') ?? 'standard') }} Delivery
                                @endif
                                - ${{ number_format(session('checkout.delivery.total_charge') ?? session('checkout.delivery.charge', 0), 2) }}<br>
                                <span class="text-xs">Estimated delivery: 5-7 business days</span>
                                @if(session('checkout.delivery.delivery_instructions'))
                                <br><strong>Instructions:</strong> {{ session('checkout.delivery.delivery_instructions') }}
                                @endif
                            </div>
                        </div>
                        <!-- Payment Method -->
                        <div>
                            <h3 class="font-medium text-gray-900 mb-2">Payment Method</h3>
                            <div class="text-sm text-gray-600 bg-gray-50 p-3 rounded">
                                {{ ucfirst(session('checkout.payment.method')) }}
                                @if(session('checkout.payment.method') === 'stripe')
                                <span class="text-xs">(Credit/Debit Card)</span>
                                @endif
                            </div>
                        </div>
                        <!-- Order Items -->
                        <div>
                            <h3 class="font-medium text-gray-900 mb-2">Order Items</h3>
                            <div class="space-y-3">
                            @php $cart = session('cart', []); @endphp
                            @foreach($cart as $productId => $quantity)
                                @php 
                                $product = App\Models\Product::find($productId);
                                $item = [
                                    'id' => $product->id,
                                    'name' => $product->name,
                                    'price' => $product->price,
                                    'quantity' => $quantity
                                ];
                                @endphp
                                <div class="flex justify-between items-center p-3 bg-gray-50 rounded">
                                    <div class="flex-1">
                                        <div class="font-medium text-gray-900">{{ $item['name'] }}</div>
                                        <div class="text-sm text-gray-500">Qty: {{ $item['quantity'] }}</div>
                                    </div>
                                    <div class="font-medium text-gray-900">${{ number_format($item['price'] * $item['quantity'], 2) }}</div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Terms and Conditions -->
                <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
                    <div class="p-6">
                        <div class="flex items-start">
                            <input type="checkbox" id="terms" class="mt-1 mr-3 h-4 w-4 text-primary border-gray-300 rounded focus:ring-primary">
                            <label for="terms" class="text-sm text-gray-700">
                            I agree to the <a href="{{ route('terms-and-conditions') }}" target="_blank" class="text-primary hover:underline">Terms of Service</a> and
                            <a href="{{ route('privacy-policy') }}" target="_blank" class="text-primary hover:underline">Privacy Policy</a>
                            </label>
                        </div>
                        <p class="text-xs text-gray-500 mt-2">You must agree to the terms before placing your order.</p>
                    </div>
                </div>
                <!-- Place Order Button -->
                <form action="{{ route('checkout.place-order') }}" method="POST" id="place-order-form">
                    @csrf
                    <div class="flex justify-between">
                        <a href="{{ route('checkout.payment') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                            <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
                            Back to Payment
                        </a>
                        <button type="submit" id="place-order-btn" class="btn btn-primary" disabled>
                            Place Order
                            <i data-lucide="arrow-right" class="w-4 h-4 ml-2"></i>
                        </button>
                    </div>
                </form>
            </div>
            <!-- Order Summary Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6 sticky top-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Order Summary</h3>
                    <div class="space-y-3 mb-4">
                        @php 
                            $cart = session('cart', []); 
                        @endphp
                        @foreach($cart as $productId => $quantity)
                            @php 
                                $product = App\Models\Product::find($productId);
                                $item = [
                                    'id' => $product->id,
                                    'name' => $product->name,
                                    'price' => $product->price,
                                    'quantity' => $quantity
                                ];
                            @endphp
                        <div class="flex justify-between items-center">
                            <div class="flex-1">
                                <div class="font-medium text-gray-900">{{ $item['name'] }}</div>
                                <div class="text-sm text-gray-500">Qty: {{ $item['quantity'] }}</div>
                            </div>
                            <div class="font-medium text-gray-900">${{ number_format($item['price'] * $item['quantity'], 2) }}</div>
                        </div>
                        @endforeach
                    </div>
                    <div class="border-t border-gray-200 pt-4 space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="font-medium" x-text="currency(subtotal())"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Shipping</span>
                            <span class="font-medium">${{ number_format(session('checkout.delivery.total_charge') ?? session('checkout.delivery.charge', 0), 2) }}</span>
                            <input type="hidden" id="shipping_cost" value="{{ number_format(session('checkout.delivery.total_charge') ?? session('checkout.delivery.charge', 0), 2) }}">
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tax</span>
                            <span class="font-medium">$0.00</span>
                        </div>
                    </div>
                    <div class="border-t border-gray-200 pt-4 mt-4">
                        <div class="flex justify-between text-lg font-bold">
                            <span>Total</span>
                            <span x-text="currency(total())"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
document.getElementById('terms').addEventListener('change', function() {
    const button = document.getElementById('place-order-btn');
    if (this.checked) {
       button.disabled = false;
       //button.classList.remove('bg-gray-400', 'cursor-not-allowed', 'opacity-50', 'focus:ring-gray-500');
       //button.classList.add('bg-gradient-to-r', 'from-emerald-500', 'to-teal-600', 'hover:from-emerald-600', 'hover:to-teal-700', 'focus:ring-emerald-500', 'shadow-md', 'transition-all', 'duration-300');
    } else {
       button.disabled = true;
       //button.classList.remove('bg-gradient-to-r', 'from-emerald-500', 'to-teal-600', 'hover:from-emerald-600', 'hover:to-teal-700', 'focus:ring-emerald-500', 'shadow-md', 'transition-all', 'duration-300');
       //button.classList.add('bg-gray-400', 'cursor-not-allowed', 'opacity-50', 'focus:ring-gray-500');
    }
});

function cartState() {
    let cartItems = @json($cartItems);
    return {
        items: cartItems.map(item => ({
            ...item,
            id: item.id,
            name: item.name,
            vendor: item.vendor,
            quantity: Number(item.quantity),
            price: item.price,
            originalPrice: item.originalPrice,
            image: item.image
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
        subtotal() {
            return this.items.reduce((sum, item) => sum + item.price * item.quantity, 0);
        },
        memberDiscount() {
            return this.subtotal() * 0.2;
        },
        total() {
            let shipping = parseFloat($('#shipping_cost').val()) || 0;
            return this.subtotal() + shipping;
        },
        proceedToCheckout() {
            window.location.href = baseurl+'/checkout/shipping';
        },
        currency(value) {
            return "$" + parseFloat(value).toFixed(2);
        }
    }
}
</script>
@endsection