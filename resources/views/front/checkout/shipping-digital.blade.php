@extends('front.layouts.app')
@section('content')
<div x-data="cartState()" class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-6xl mx-auto px-4">
        <!-- Progress Bar (downloadable order: no shipping/delivery steps) -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center">
                    <div class="flex items-center justify-center w-10 h-10 bg-primary text-white rounded-full font-bold">1</div>
                    <span class="ml-3 text-sm font-medium text-primary">Details</span>
                </div>
                <div class="h-1 flex-1 mx-4 bg-gray-300">
                    <div class="h-1 bg-primary" style="width: 33%"></div>
                </div>
                <div class="flex items-center">
                    <div class="flex items-center justify-center w-10 h-10 bg-gray-300 text-gray-600 rounded-full font-bold">2</div>
                    <span class="ml-3 text-sm font-medium text-gray-600">Payment</span>
                </div>
                <div class="h-1 flex-1 mx-4 bg-gray-300"></div>
                <div class="flex items-center">
                    <div class="flex items-center justify-center w-10 h-10 bg-gray-300 text-gray-600 rounded-full font-bold">3</div>
                    <span class="ml-3 text-sm font-medium text-gray-600">Review</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <form action="{{ route('checkout.shipping.store') }}" method="POST" class="space-y-8">
                    @csrf
                    @if(!auth()->check())
                        <input type="hidden" name="checkout_type" value="guest">
                    @endif

                    <!-- Digital delivery notice -->
                    <div class="bg-primary/5 border border-primary/20 rounded-lg p-4 flex items-start gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-primary mt-0.5 flex-shrink-0">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                        </svg>
                        <div class="text-sm text-gray-700">
                            <div class="font-medium text-gray-900">Digital delivery — no shipping required</div>
                            Your download will be emailed to you as soon as your payment is complete.
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
                        <div class="border-b border-gray-200 px-6 py-4">
                            <h2 class="text-xl font-bold text-gray-900">Your Details</h2>
                            <p class="text-sm text-gray-500 mt-1">We'll email your download and receipt here</p>
                        </div>
                        <div class="p-6 space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">First Name <span class="text-red-500">*</span></label>
                                    <input type="text" name="first_name" value="{{ old('first_name', auth()->user()->first_name ?? '') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Enter First Name*" autocomplete="off" required>
                                    @error('first_name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Last Name <span class="text-red-500">*</span></label>
                                    <input type="text" name="last_name" value="{{ old('last_name', auth()->user()->last_name ?? '') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Enter Last Name*" autocomplete="off" required>
                                    @error('last_name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Email Address <span class="text-red-500">*</span></label>
                                    <input type="email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Enter Email*" autocomplete="off" required>
                                    @error('email')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number <span class="text-red-500">*</span></label>
                                    <input type="tel" name="phone" value="{{ old('phone', session('checkout.shipping.phone', auth()->user()->phone ?? '')) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent phone_number" placeholder="Enter Phone*" autocomplete="off" required>
                                    @error('phone')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation -->
                    <div class="flex justify-between">
                        <a href="{{ route('cart') }}" class="btn btn-secondary"><i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i> Back to Cart</a>
                        <button type="submit" class="btn btn-primary">Continue to Payment <i data-lucide="arrow-right" class="w-4 h-4 ml-2"></i></button>
                    </div>
                </form>
            </div>

            <!-- Order Summary Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6 sticky top-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Order Summary</h3>
                    <div class="space-y-3 mb-4">
                        @php $cart = session('cart', []); @endphp
                        @foreach($cart as $lineKey => $quantity)
                            @php
                                $product = App\Models\Product::find(App\Support\CartLine::productId($lineKey));
                                if (!$product) { continue; }
                                $meta = App\Support\CartLine::meta($lineKey);
                            @endphp
                            <div class="flex justify-between items-center">
                                <div class="flex-1">
                                    <div class="font-medium text-gray-900">{{ $product->name }}</div>
                                    <div class="text-sm text-gray-500">{{ App\Support\CartLine::label($meta['purchase_type'], $meta['plan']) }} · Qty: {{ $quantity }}</div>
                                </div>
                                <div class="font-medium text-gray-900">${{ number_format($product->price * $quantity, 2) }}</div>
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
                            <span class="font-medium">Free (digital)</span>
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
function cartState() {
    let cartItems = @json($cartItems);
    return {
        items: cartItems.map(item => ({ ...item, quantity: Number(item.quantity), price: item.price })),
        subtotal() {
            return this.items.reduce((sum, item) => sum + item.price * item.quantity, 0);
        },
        total() {
            return this.subtotal();
        },
        currency(value) {
            return "$" + parseFloat(value).toFixed(2);
        }
    }
}

// Digits-only, max 10 chars for the phone field.
$('.phone_number').on('input', function() {
    let value = $(this).val().replace(/[^0-9]/g, '').substring(0, 10);
    $(this).val(value);
});
</script>
@endsection
