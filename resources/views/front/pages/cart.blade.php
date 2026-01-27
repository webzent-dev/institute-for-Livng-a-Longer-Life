@extends('front.layouts.app')
@section('content')

<div x-data="cartState()" class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="mb-8 ">

            <a href="/shop"
                class="inline-flex items-center justify-center gap-2 rounded-md text-sm font-medium h-10 px-4 py-2 mb-4
                        hover:bg-accent hover:text-accent-foreground"
                >
                <i data-lucide="arrow-left" class="w-5 h-5"></i>
                Continue Shopping
                </a>


            {{-- <a href="/shop" class="inline-flex items-center text-gray-600 hover:text-gray-900 transition mb-4">
                <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Continue Shopping
            </a> --}}

            <h1 class="text-4xl font-bold text-foreground text-left ">Shopping Cart</h1>
            <p class="text-gray-600 mt-2">
                <span x-text="items.length"></span>
                <span x-text="items.length === 1 ? 'item' : 'items'"></span>
                in your cart
            </p>
        </div>

        <div class="grid lg:grid-cols-3 gap-6">

            {{-- Cart Items --}}
            <div class="lg:col-span-2">
                <template x-if="items.length === 0">
                    <div class="bg-white rounded-lg shadow p-12 text-left">
                        <p class="text-gray-500 text-lg">Your cart is empty</p>
                        <a href="/shop" class="inline-block mt-4 text-green-600 hover:text-green-700 font-medium">Continue Shopping</a>
                    </div>
                </template>

                <template x-if="items.length > 0">
                    <div class="space-y-4">
                        <template x-for="item in items" :key="item.id">
                            <div class="bg-white rounded-lg border bg-card text-card-foreground shadow-sm p-6  transition">
                                <div class="flex gap-6">

                                    {{-- Image Slot class="rounded-lg border bg-card text-card-foreground shadow-sm shadow-soft" --}}
                                    <div class="w-24 h-24 rounded-lg bg-gradient-to-br from-primary/10 to-accent/10 flex items-center justify-center flex-shrink-0">
                                        <template x-if="item.image">
                                            <img :src="item.image" :alt="item.name" class="w-full h-full object-cover rounded-lg">
                                        </template>
                                        <template x-if="!item.image">
                                            {{-- <svg class="h-12 w-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14a2 2 0 012 2v7a2 2 0 01-2 2H5a2 2 0 01-2-2v-7a2 2 0 012-2z"/>
                                            </svg> --}}
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shopping-bag h-10 w-10 text-primary"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"></path><path d="M3 6h18"></path><path d="M16 10a4 4 0 0 1-8 0"></path>
                                            </svg>


                                        </template>
                                    </div>

                                    {{-- Item Info --}}
                                    <div class="flex-1 min-w-0">
                                        <div class="flex justify-between items-start mb-3">
                                            <div>
                                                <h3 class="font-semibold text-lg text-gray-900" x-text="item.name"></h3>
                                                <p class="text-sm text-green-600 mt-1">by <span x-text="item.vendor || 'Institute'"></span></p>
                                            </div>

                                            <button
                                                @click="removeFromCart(item.id)"
                                                class="text-red-500 hover:text-red-700 transition p-2 rounded-md hover:shadow-sm hover:bg-accent hover:text-accent-foreground"
                                                title="Remove from cart"
                                            >
                                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                                </svg>
                                            </button>

                                            {{-- <button  @click="removeFromCart(item.id)" class=" inline-flex items-center justify-center gap-2 rounded-md text-sm font-medium h-10 px-4 py-2 mb-4 hover:bg-accent hover:text-accent-foreground" >
                                                <!-- svg -->
                                                <i data-lucide="trash-2" class="w-5 h-5 text-red-500 hover:text-red-700 transition"></i>
                                            </button> --}}


                                        </div>

                                        {{-- Quantity + Pricing --}}
                                        <div class="flex items-center justify-between mt-4">
                                            <div class="flex items-center gap-3 bg-gray-100 rounded-lg p-1">
                                                <button
                                                    @click="updateQuantity(item.id, item.quantity - 1)"
                                                    :disabled="item.quantity <= 1"
                                                    class="btn-outline h-8 w-8 "
                                                >
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-minus h-4 w-4"><path d="M5 12h14"></path>
                                                    </svg>
                                                </button>

                                                <span class="font-medium w-8 text-center" x-text="item.quantity"></span>

                                                <button
                                                    @click="updateQuantity(item.id, item.quantity + 1)"
                                                    class="btn-outline h-8 w-8"
                                                >
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus h-4 w-4"><path d="M5 12h14"></path><path d="M12 5v14"></path>
                                                    </svg>
                                                </button>





                                            </div>

                                            <div class="text-right">
                                                <div class="text-2xl font-bold text-gray-900"
                                                    x-text="currency(item.price * item.quantity)">
                                                </div>
                                                <template x-if="item.originalPrice && item.originalPrice > item.price">
                                                    <div class="text-sm text-gray-400 line-through"
                                                        x-text="currency(item.originalPrice * item.quantity)">
                                                    </div>
                                                </template>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </template>
                    </div>
                </template>
            </div>

            {{-- Order Summary --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow p-6 sticky top-24">
                    <h3 class="text-xl font-semibold text-gray-900 mb-6">Order Summary</h3>

                    <template x-if="items.length > 0">
                        <div>
                            <div class="space-y-3 mb-6">
                                <template x-for="item in items" :key="item.id">
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600" x-text="item.name + ' × ' + item.quantity"></span>
                                        <span class="text-gray-900 font-medium" x-text="currency(item.price * item.quantity)"></span>
                                    </div>
                                </template>
                            </div>

                            <div class="border-t border-gray-200 pt-4 mb-4">
                                <div class="flex justify-between text-sm mb-2">
                                    <span class="text-gray-600">Subtotal</span>
                                    <span class="text-gray-900" x-text="currency(subtotal())"></span>
                                </div>
                                <div class="flex justify-between text-sm mb-2">
                                    <span class="text-gray-600">Shipping</span>
                                    <span class="text-gray-900">FREE</span>
                                </div>
                                <template x-if="memberDiscount() > 0">
                                    <div class="flex justify-between text-sm text-green-600">
                                        <span>Member Discount</span>
                                        <span x-text="'-' + currency(memberDiscount())"></span>
                                    </div>
                                </template>
                            </div>

                            <div class="border-t border-gray-200 pt-4">
                                <div class="flex justify-between items-center mb-6">
                                    <span class="text-lg font-semibold text-gray-900">Total</span>
                                    <span class="text-2xl font-bold text-green-600" x-text="currency(total())"></span>
                                </div>

                                <button
                                    @click="proceedToCheckout()"
                                    class="w-full btn-primary py-3 h-11"
                                >
                                    Proceed to Checkout
                                </button>

                                <p class="text-xs text-gray-400 text-center mt-3">
                                    Secure checkout powered by Stripe
                                </p>
                            </div>
                        </div>
                    </template>

                    <template x-if="items.length === 0">
                        <div class="text-center py-8">
                            <p class="text-gray-500 mb-4">Your cart is empty</p>
                            <a href="/shop" class="inline-block px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                                Start Shopping
                            </a>
                        </div>
                    </template>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- Alpine Component --}}
<script>
function cartState() {
    return {
        items: [
            { id: 1, name: "Adaptogen Blend", vendor: "Dr. Jennifer Park", quantity: 2, price: 39.99, originalPrice: 49.99, image: null },
            { id: 2, name: "Recovery Protein", vendor: "Dr. Michael Rodriguez", quantity: 2, price: 54.99, originalPrice: 74.99, image: null },
            { id: 3, name: "Sleep Optimizer", vendor: "Dr. Emily Thompson", quantity: 2, price: 34.99, originalPrice: 49.99, image: null },
            { id: 4, name: "Heart Health Formula", vendor: "Dr. James Wilson", quantity: 1, price: 59.99, originalPrice: 74.99, image: null },
            { id: 5, name: "Vitality Multivitamin", vendor: "Dr. David Kim", quantity: 1, price: 44.99, originalPrice: 54.99, image: null },
            { id: 6, name: "Green Superfood Powder", vendor: "Dr. Sarah Chen", quantity: 1, price: 49.99, originalPrice: 64.99, image: null },
            { id: 7, name: "Resistance Bands Set", vendor: "Dr. Michael Rodriguez", quantity: 1, price: 29.99, originalPrice: 39.99, image: null },
            { id: 8, name: "Omega-3 Supreme", vendor: "Dr. Sarah Chen", quantity: 1, price: 49.99, originalPrice: 59.99, image: null },
        ],

        updateQuantity(id, qty) {
            if (qty < 1) return;
            this.items = this.items.map(item => {
                if (item.id === id) item.quantity = qty;
                return item;
            });
        },

        removeFromCart(id) {
            this.items = this.items.filter(item => item.id !== id);
        },

        subtotal() {
            return this.items.reduce((sum, item) => sum + item.price * item.quantity, 0);
        },

        memberDiscount() {
            return this.subtotal() * 0.2;
        },

        total() {
            return this.subtotal() - this.memberDiscount();
        },

        proceedToCheckout() {
            alert('Proceeding to checkout...');
            // Add checkout logic here
        },

        currency(value) {
            return "$" + parseFloat(value).toFixed(2);
        }
    }
}
</script>
@endsection
