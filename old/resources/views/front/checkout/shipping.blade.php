@extends('front.layouts.app')
@section('content')
<div x-data="cartState()" class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-6xl mx-auto px-4">
        <!-- Progress Bar -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center">
                    <div class="flex items-center justify-center w-10 h-10 bg-primary text-white rounded-full font-bold">1</div>
                    <span class="ml-3 text-sm font-medium text-primary">Shipping</span>
                </div>
                <div class="h-1 flex-1 mx-4 bg-gray-300">
                    <div class="h-1 bg-primary" style="width: 25%"></div>
                </div>
                <div class="flex items-center">
                    <div class="flex items-center justify-center w-10 h-10 bg-gray-300 text-gray-600 rounded-full font-bold">2</div>
                    <span class="ml-3 text-sm font-medium text-gray-600">Delivery</span>
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
                <form action="{{ route('checkout.shipping.store') }}" method="POST" class="space-y-8">
                    @csrf
                    <!-- Guest/Registered User Selection -->
                    @if(!auth()->check())
                    <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
                        <div class="border-b border-gray-200 px-6 py-4">
                            <h2 class="text-xl font-bold text-gray-900">Checkout Options</h2>
                            <p class="text-sm text-gray-500 mt-1">Choose how you'd like to checkout</p>
                        </div>
                        <div class="p-6 space-y-4">
                            <div class="space-y-3">
                                <label class="flex items-center p-4 border-2 rounded-lg cursor-pointer transition border-primary bg-primary/5 hover:border-primary active:bg-primary/5">
                                    <input type="radio" name="checkout_type" value="guest" checked class="mr-3">
                                    <div>
                                        <div class="font-medium text-gray-900">Continue as Guest</div>
                                        <div class="text-sm text-gray-500">Checkout without creating an account</div>
                                    </div>
                                </label>
                                <label class="flex items-center p-4 border-2 rounded-lg cursor-pointer transition border-gray-300 hover:border-primary active:bg-primary/5">
                                    <input type="radio" name="checkout_type" value="register" class="mr-3">
                                    <div>
                                        <div class="font-medium text-gray-900">Create Account</div>
                                        <div class="text-sm text-gray-500">Create an account to track orders and get better service</div>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                    @endif
                    <!-- Contact Information -->
                    <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
                        <div class="border-b border-gray-200 px-6 py-4">
                            <h2 class="text-xl font-bold text-gray-900">Contact Information</h2>
                            <p class="text-sm text-gray-500 mt-1">We'll use this to send you order updates</p>
                        </div>
                        <div class="p-6 space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Email Address <span class="text-red-500">*</span></label>
                                    <input type="email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Enter Email*" autocomplete="off" required>
                                    @error('email') 
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number <span class="text-red-500">*</span></label>
                                    @if(session('checkout.shipping'))
                                        <input type="tel" name="phone" value="{{ old('phone', session('checkout.shipping.phone') ?? '') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Enter Phone*" autocomplete="off" required>
                                    @else
                                        <input type="tel" name="phone" value="{{ old('phone', auth()->user()->phone ?? '') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Enter Phone*" autocomplete="off" required>
                                    @endif
                                    
                                    @error('phone') 
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Shipping Address -->
                    <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
                        <div class="border-b border-gray-200 px-6 py-4">
                            <h2 class="text-xl font-bold text-gray-900">Shipping Address</h2>
                            <p class="text-sm text-gray-500 mt-1">Where should we deliver your order?</p>
                        </div>
                        <div class="p-6 space-y-4">
                            @if(auth()->check() && $addresses && $addresses->count() > 0)
                            <div class="space-y-3 mb-6">
                                <h3 class="font-medium text-gray-900">Saved Addresses</h3>
                                @foreach($addresses as $address)
                                <label class="flex items-start p-4 border-2 rounded-lg cursor-pointer transition {{ $loop->first ? 'border-primary bg-primary/5' : 'border-gray-300 hover:border-primary active:bg-primary/5' }}">
                                    <input type="radio" name="address_id" value="{{ $address->id }}" {{ $loop->first ? 'checked' : '' }} class="mt-1 mr-3">
                                    <div class="flex-1">
                                        <div class="font-medium">{{ $address->first_name }} {{ $address->last_name }}</div>
                                        <div class="text-sm text-gray-600">{{ $address->address_line_1 }}</div>
                                        @if($address->address_line_2)
                                        <div class="text-sm text-gray-600">{{ $address->address_line_2 }}</div>
                                        @endif
                                        <div class="text-sm text-gray-600">{{ $address->city }}, {{ $address->state }} {{ $address->zip_code }}</div>
                                        <div class="text-sm text-gray-600">{{ $address->country }}</div>
                                    </div>
                                </label>
                                @endforeach
                                <label class="flex items-center p-4 border-2 rounded-lg cursor-pointer transition border-gray-300 hover:border-primary active:bg-primary/5">
                                    <input type="radio" name="address_id" value="new" class="mr-3">
                                    <span class="font-medium text-gray-900">Use a new address</span>
                                </label>
                            </div>
                            @endif
                            <div id="new-address-fields" class="{{ auth()->check() && $addresses && $addresses->count() > 0 ? 'hidden' : '' }}">
                                @if(auth()->check() && $addresses && $addresses->count() > 0)
                                @else
                                    <input type="hidden" name="address_id" value="new">
                                @endif
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">First Name <span class="text-red-500">*</span></label>
                                        <input type="text" name="first_name" value="{{ old('first_name') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Enter First Name*" autocomplete="off" required>
                                        @error('first_name') 
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Last Name <span class="text-red-500">*</span></label>
                                        <input type="text" name="last_name" value="{{ old('last_name') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Enter Last Name*" autocomplete="off" required>
                                        @error('last_name') 
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Address Line 1 <span class="text-red-500">*</span></label>
                                    <input type="text" name="address_line_1" value="{{ old('address_line_1') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Enter Address Line 1*" autocomplete="off" required>
                                    @error('address_line_1') 
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Address Line 2 (Optional)</label>
                                    <input type="text" name="address_line_2" value="{{ old('address_line_2') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Enter Address Line 2" autocomplete="off">
                                    @error('address_line_2') 
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">City <span class="text-red-500">*</span></label>
                                    <input type="text" name="city" value="{{ old('city') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Enter City*" autocomplete="off" required>
                                    @error('city') 
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">State/Province <span class="text-red-500">*</span></label>
                                    <input type="text" name="state" value="{{ old('state') }}"  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Enter State/Province*" autocomplete="off" required>
                                    @error('state') 
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Postal Code <span class="text-red-500">*</span></label>
                                    <input type="text" name="postal_code" value="{{ old('postal_code') }}"  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Enter Postal Code" autocomplete="off" required>
                                    @error('postal_code') 
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                </div>
                                <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Country <span class="text-red-500">*</span></label>
                                <select name="country" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" required>
                                    <option value="">Select Country</option>
                                    <option value="US" {{ old('country') == 'US' ? 'selected' : '' }}>United States</option>
                                    <option value="CA" {{ old('country') == 'CA' ? 'selected' : '' }}>Canada</option>
                                    <!-- Add more countries as needed -->
                                </select>
                                @error('country') 
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Navigation -->
                    <div class="flex justify-between">
                        <a href="{{ route('cart') }}" class="btn btn-secondary "><i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i> Back to Cart</a>
                        <button type="submit" class="btn btn-primary">Continue to Delivery <i data-lucide="arrow-right" class="w-4 h-4 ml-2"></i></button>
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
                            <span class="font-medium">Calculated at next step</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tax</span>
                            <span class="font-medium">Calculated at next step</span>
                        </div>
                        <!-- <template x-if="memberDiscount() > 0">
                            <div class="flex justify-between text-sm text-green-600">
                                <span>Member Discount</span>
                                <span x-text="'-' + currency(memberDiscount())"></span>
                            </div>
                        </template> -->
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
// Handle checkout type selection visual feedback
@if(!auth()->check())
    document.querySelectorAll('input[name="checkout_type"]').forEach(radio => {
        radio.addEventListener('change', function() {
        // Remove active styles from all labels
        document.querySelectorAll('input[name="checkout_type"]').forEach(r => {
            r.closest('label').classList.remove('border-primary', 'bg-primary/5');
            r.closest('label').classList.add('border-gray-300');
        });
        // Add active styles to selected label
        this.closest('label').classList.remove('border-gray-300');
        this.closest('label').classList.add('border-primary', 'bg-primary/5');
        });
    });

    // Set initial state for checked checkout type radio
    document.querySelector('input[name="checkout_type"]:checked')?.dispatchEvent(new Event('change'));
@endif

// Handle address selection visual feedback
@if(auth()->check() && $addresses && $addresses->count() > 0)
document.querySelectorAll('input[name="address_id"]').forEach(radio => {
    radio.addEventListener('change', function() {
        // style handling
        document.querySelectorAll('input[name="address_id"]').forEach(r => {
            r.closest('label').classList.remove('border-primary', 'bg-primary/5');
            r.closest('label').classList.add('border-gray-300');
        });

        this.closest('label').classList.remove('border-gray-300');
        this.closest('label').classList.add('border-primary', 'bg-primary/5');
        const newAddressFields = document.getElementById('new-address-fields');
        const inputs = newAddressFields.querySelectorAll('input, select');
        if (this.value === 'new') {
            newAddressFields.classList.remove('hidden');
            // add required validation
            inputs.forEach(input => {
                if(input.name !== 'address_line_2'){
                    input.setAttribute('required', true);
                }
            });
        } else {
            newAddressFields.classList.add('hidden');
            // remove required validation
            inputs.forEach(input => {
                input.removeAttribute('required');
            });
        }
    });
});

// trigger initial state
document.querySelector('input[name="address_id"]:checked')?.dispatchEvent(new Event('change'));
@endif
</script>
<script>
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
            //return this.subtotal() - this.memberDiscount();
            return this.subtotal();
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