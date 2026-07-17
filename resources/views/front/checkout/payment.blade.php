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
                    <div class="flex items-center justify-center w-10 h-10 bg-primary text-white rounded-full font-bold">3</div>
                    <span class="ml-3 text-sm font-medium text-primary">Payment</span>
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
                <form action="{{ route('checkout.payment.store') }}" method="POST" class="space-y-8">
                @csrf
                <!-- Payment Method Selection -->
                <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
                    <div class="border-b border-gray-200 px-6 py-4">
                        <h2 class="text-xl font-bold text-gray-900">Payment Method</h2>
                        <p class="text-sm text-gray-500 mt-1">Choose how you'd like to pay</p>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="space-y-3">
                            <label class="flex items-center p-4 border-2 rounded-lg cursor-pointer transition border-primary bg-primary/5 hover:border-primary active:bg-primary/5">
                                <input type="radio" name="payment_method" value="stripe" checked class="mr-3">
                                <div class="flex items-center flex-1">
                                    <div class="flex-1">
                                        <div class="font-medium text-gray-900">Credit/Debit Card</div>
                                        <div class="text-sm text-gray-600">Pay securely with Stripe</div>
                                    </div>
                                    <div class="ml-4">
                                        <img src="https://js.stripe.com/v3/fingerprinted/img/visa-729c05c240c4bdb47b03ac81d9945bfe.svg" alt="Visa" class="h-6 inline-block mr-2">
                                        <img src="https://js.stripe.com/v3/fingerprinted/img/mastercard-4d8844094130711885b5e41b28c9848f.svg" alt="Mastercard" class="h-6 inline-block mr-2">
                                        <img src="https://cdn-icons-png.freepik.com/512/179/179431.png" alt="Amex" class="h-8 inline-block">
                                    </div>
                                </div>
                            </label>
                            {{-- PayPal --}}
                            <!-- <label class="flex items-center p-4 border-2 rounded-lg cursor-pointer transition border-gray-300 hover:border-primary active:bg-primary/5">
                                <input type="radio" name="payment_method" value="paypal" class="mr-3">
                                <div class="flex items-center flex-1">
                                    <div class="flex-1">
                                        <div class="font-medium text-gray-900">PayPal</div>
                                        <div class="text-sm text-gray-600">Pay with your PayPal account</div>
                                    </div>
                                    <div class="ml-4">
                                        <img src="https://www.paypalobjects.com/webstatic/en_US/i/buttons/PP_logo_h_100x26.png" alt="PayPal" class="h-6">
                                    </div>
                                </div>
                            </label> -->
                        </div>
                    </div>
                </div>
                <!-- Billing Address -->
                <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
                    <div class="border-b border-gray-200 px-6 py-4">
                        <h2 class="text-xl font-bold text-gray-900">Billing Address</h2>
                        <p class="text-sm text-gray-500 mt-1">Where should we send the receipt?</p>
                    </div>
                    <div class="p-6">
                        <div class="space-y-3">
                            <label class="flex items-center">
                                <input type="checkbox" name="same_as_shipping" class="mr-3" value="1" checked>
                                <span class="text-sm text-gray-700">Same as shipping address</span>
                            </label>
                        </div>
                        <div id="billing-address-fields" class="hidden mt-4 space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">First Name <span class="text-red-500">*</span></label>
                                    <input type="text" name="billing_first_name" value="{{ session('checkout.shipping.first_name') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Enter First Name*" autocomplete="off" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Last Name <span class="text-red-500">*</span></label>
                                    <input type="text" name="billing_last_name" value="{{ session('checkout.shipping.last_name') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Enter Last Name*" autocomplete="off" required>
                                </div>
                            </div>
                            <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Address Line 1 <span class="text-red-500">*</span></label>
                                <input type="text" name="billing_address_line_1" value="{{ session('checkout.shipping.address_line_1') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Enter Address Line 1*" autocomplete="off" required>
                            </div>
                            <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Address Line 2 (Optional)</label>
                                <input type="text" name="billing_address_line_2" value="{{ session('checkout.shipping.address_line_2') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Enter Address Line 2" autocomplete="off">
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">City <span class="text-red-500">*</span></label>
                                    <input type="text" name="billing_city" value="{{ session('checkout.shipping.city') }}"class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Enter City*" autocomplete="off" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">State/Province <span class="text-red-500">*</span></label>
                                    <input type="text" name="billing_state" value="{{ session('checkout.shipping.state') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Enter State/Province*" autocomplete="off" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Postal Code <span class="text-red-500">*</span></label>
                                    <input type="text" name="billing_postal_code" value="{{ session('checkout.shipping.zip_code') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Enter Postal Code*" autocomplete="off" required>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Country <span class="text-red-500">*</span></label>
                                <select name="billing_country" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                    <option value="">Select Country</option>
                                    <!-- <option value="US" @if(session('checkout.shipping.country') == 'US') selected @endif>United States</option>
                                    <option value="CA" @if(session('checkout.shipping.country') == 'CA') selected @endif>Canada</option> -->
                                    @foreach($countries as $country)
                                        <option value="{{ $country->iso }}" {{ old('country') == $country->iso ? 'selected' : '' }}>{{ $country->nicename }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Navigation -->
                <div class="flex justify-between">
                    <a href="{{ route('checkout.delivery') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i> Back to Delivery
                    </a>
                    <button type="submit" class="btn btn-primary">
                        Continue to Review <i data-lucide="arrow-right" class="w-4 h-4 ml-2"></i>
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
                        @endif
                    </div>
                </div>
                <!-- Delivery Method -->
                <div class="mb-4 p-3 bg-gray-50 rounded-lg">
                    <h4 class="font-medium text-gray-900 mb-2">Delivery:</h4>
                    <div class="text-sm text-gray-600">
                        @if(session('checkout.delivery'))
                            @if(session('checkout.delivery.methods') !== null)
                                Multi-seller shipping
                            @else
                                {{ ucfirst(session('checkout.delivery.method')) }}
                            @endif
                            - ${{ number_format(session('checkout.delivery.total_charge') ?? session('checkout.delivery.charge', 0), 2) }}
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
                        <span x-text="currency(total())"></span>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
// Handle billing address toggle
document.querySelector('input[name="same_as_shipping"]').addEventListener('change', function() {
    const billingFields = document.getElementById('billing-address-fields');
    if (this.checked) {
        billingFields.classList.add('hidden');
    } else {
        billingFields.classList.remove('hidden');
    }
});

document.addEventListener("DOMContentLoaded", function () {
    const checkbox = document.querySelector('input[name="same_as_shipping"]');
    const billingFields = document.getElementById('billing-address-fields');
    const billingInputs = billingFields.querySelectorAll('input, select');

    function toggleBillingFields() {
        if (checkbox.checked) {
            billingFields.classList.add('hidden');

            // Remove required validation
            billingInputs.forEach(input => {
                input.removeAttribute('required');
            });

        } else {
            billingFields.classList.remove('hidden');

            // Add required validation back
            billingInputs.forEach(input => {
                if (!input.name.includes('address_line_2')) { // optional field
                    input.setAttribute('required', true);
                }
            });
        }
    }
    checkbox.addEventListener('change', toggleBillingFields);

    // Run once on page load
    toggleBillingFields();
});

// Handle payment method selection visual feedback
document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
    radio.addEventListener('change', function() {
    // Remove active state from all labels
    document.querySelectorAll('input[name="payment_method"]').forEach(r => {
        r.closest('label').classList.remove('border-primary', 'bg-primary/5');
        r.closest('label').classList.add('border-gray-300');
    });

    // Add active state to selected label
    if (this.checked) {
        this.closest('label').classList.remove('border-gray-300');
        this.closest('label').classList.add('border-primary', 'bg-primary/5');
    }
    });
});

// Set initial state for checked radio
document.querySelector('input[name="payment_method"]:checked').dispatchEvent(new Event('change'));

function cartState() {
    let cartItems = @json($cartItems);
    return {
        items: cartItems.map(item => ({
            ...item,
            id: item.id,
            line_key: item.line_key,
            name: item.name,
            vendor: item.vendor,
            quantity: Number(item.quantity),
            price: item.price,
            originalPrice: item.originalPrice,
            image: item.image
        })),
        updateQuantity(lineKey, qty) {
            if (qty < 1) return;
            this.items = this.items.map(item => {
                if (item.line_key === lineKey) item.quantity = qty;
                return item;
            });

            if(qty>0){
                $.ajax({
                    url: baseurl+'/cart/update',
                    type: 'POST',
                    data: {line_key: lineKey, quantity: qty},
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
        removeFromCart(lineKey) {
            this.items = this.items.filter(item => item.line_key !== lineKey);
            var r = confirm('Are you sure want to remove this product from cart?');
            if(lineKey != '' && r){
                $.ajax({
                    url: baseurl+"/cart/remove",
                    type: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    cache: false,
                    async: false,
                    data: { line_key: lineKey },
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
        // Server-computed discounts (fixed for the cart; independent of payment method).
        memberDiscount() {
            return {{ $memberDiscount ?? 0 }};
        },
        subscriptionDiscount() {
            return {{ $subscriptionDiscount ?? 0 }};
        },
        total() {
            let shipping = parseFloat($('#shipping_cost').val()) || 0;
            let total = this.subtotal() + shipping - this.memberDiscount() - this.subscriptionDiscount();
            return total < 0 ? 0 : total;
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