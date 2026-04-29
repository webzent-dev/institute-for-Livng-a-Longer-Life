<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'Order Detail | Institute for Living Longer - Your Journey to Wellness')</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://unpkg.com/alpinejs" defer></script>
        <script src="https://unpkg.com/lucide@latest"></script>
    </head>
    @if (session('success'))
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition class="fixed top-5 right-5 bg-green-600 text-white px-5 py-3 rounded-lg shadow-lg z-50">
        {{ session('success') }}
    </div>
    @endif

    @if (session('error'))
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition class="fixed top-5 right-5 bg-red-600 text-white px-5 py-3 rounded-lg shadow-lg z-50">
        {{ session('error') }}
    </div>
    @endif
    
    <div id="toast" class="hidden fixed top-5 right-5 px-5 py-3 rounded-lg shadow-lg text-white z-50"></div>
    <body  x-data="{  sidebarOpen: true,  mobileSidebar: false  }"  class="bg-slate-50 antialiased">
        <div class="flex min-h-screen">
            <x-dashboard.sidebar.sidebar />
            <div class="flex-1 flex flex-col">
                <x-dashboard.sidebar.header />
                <main class="flex-1 p-8  ">
                    <div class="space-y-6">
                        <!-- Header -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <x-button-use href="{{ route('admin.orders') }}" variant="outline" icon="arrow-left" class=" bg-white h-10 w-10 pl-1 pr-0"/>
                                <div>
                                    <h1 class="text-3xl font-bold text-left mb-0">Order Details</h1>
                                    <p class="text-muted-foreground text-lg">View and manage order information</p>
                                </div>
                            </div>
                            <button type="button" onclick="updateOrder()" class="rounded-md flex items-center justify-center font-semibold gap-2 transition-all duration-150 select-none px-5 py-2 text-base h-10 gradient-primary text-primary-foreground hover:opacity-90 shadow-medium font-semibold h-10 px-4 py-2  font-semibold  text-[14px]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="save" aria-hidden="true" class="lucide lucide-save w-5 h-5 mr-2">
                                    <path d="M15.2 3a2 2 0 0 1 1.4.6l3.8 3.8a2 2 0 0 1 .6 1.4V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2z"></path>
                                    <path d="M17 21v-7a1 1 0 0 0-1-1H8a1 1 0 0 0-1 1v7"></path>
                                    <path d="M7 3v4a1 1 0 0 0 1 1h7"></path>
                                </svg>
                                Save Changes
                            </button>
                        </div>

                        <!-- GRID LAYOUT -->
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                            <!-- LEFT SECTION -->
                            <div class="lg:col-span-2 space-y-6">
                                <!-- Order Info -->
                                <div class="bg-white rounded-xl shadow p-6 border">
                                    <h3 class="text-xl font-semibold mb-4">Order Information</h3>
                                    <form method="POST" id="editOrderForm" name="editOrderForm" action="{{ route('admin.orders.update', $orderDetail->id) }}" class="space-y-3 overflow-y-auto scrollbar-custom scroll-smooth px-5">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="order_id" value="{{ $orderDetail->id }}">
                                        <div class="grid grid-cols-2 gap-4 text-sm">
                                            <div>
                                                <p class="text-gray-500">Order Number</p>
                                                <p class="font-semibold">{{$orderDetail->order_number}}</p>
                                            </div>
                                            <div>
                                                <p class="text-gray-500">Order Date</p>
                                                <p class="font-semibold">{{$orderDetail->created_at}}</p>
                                            </div>
                                            <div class="col-span-2">
                                                <x-form.select label="Order Status" name="status" placeholder="Order Status"
                                                :options="[
                                                ['value' => 'pending', 'label' => 'Pending'],
                                                ['value' => 'confirmed', 'label' => 'Confirmed'],
                                                ['value' => 'processing', 'label' => 'Processing'],
                                                ['value' => 'shipped', 'label' => 'Shipped'],
                                                ['value' => 'delivered', 'label' => 'Delivered'],
                                                ['value' => 'cancelled', 'label' => 'Cancelled'],
                                                ]"
                                                :selected="[$orderDetail->status]"
                                                />
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <!-- Customer Info -->
                                <div class="bg-white rounded-xl shadow p-6 border">
                                    <h3 class="text-xl font-semibold mb-4">Customer Information</h3>
                                    <div class="grid grid-cols-2 gap-4 text-sm">
                                        <div>
                                            <p class="text-gray-500">Name</p>
                                            <p class="font-semibold">{{$orderDetail->first_name}} {{$orderDetail->last_name}}</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-500">Email</p>
                                            <p class="font-semibold">{{$orderDetail->email}}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Address Section -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    @php 
                                        $billing_address = json_decode($orderDetail->billing_address);
                                    @endphp

                                    @if(!empty($billing_address))
                                    <!-- Billing -->
                                    <div class="bg-white rounded-xl shadow p-6 border">
                                        <h3 class="text-lg font-semibold mb-3">Billing Address</h3>
                                        <p class="text-sm text-gray-600">
                                            {{ $billing_address->address_line_1 }}<br>
                                            {{ $billing_address->city }}, {{ $billing_address->state }} {{ $billing_address->zip_code }}<br>
                                            {{ $billing_address->country }}
                                        </p>
                                    </div>
                                    @endif

                                    <!-- Shipping -->
                                    @php 
                                        $shipping_address = json_decode($orderDetail->shipping_address);
                                    @endphp
                                    @if(!empty($shipping_address))
                                    <div class="bg-white rounded-xl shadow p-6 border">
                                        <h3 class="text-lg font-semibold mb-3">Shipping Address</h3>
                                        <p class="text-sm text-gray-600">
                                            {{ $shipping_address->address_line_1 }}<br>
                                            {{ $shipping_address->city }}, {{ $shipping_address->state }} {{ $shipping_address->zip_code }}<br>
                                            {{ $shipping_address->country }}
                                        </p>
                                    </div>
                                    @endif
                                </div>

                                <!-- Product Table -->
                                <div class="bg-white rounded-xl shadow border">
                                    <div class="p-6 border-b">
                                        <h3 class="text-xl font-semibold">Order Items</h3>
                                    </div>
                                    <div class="overflow-x-auto">
                                        <table class="w-full text-sm">
                                            <thead class="bg-gray-100 text-left">
                                                <tr>
                                                    <th class="p-4">Product</th>
                                                    <th class="p-4">Price</th>
                                                    <th class="p-4">Qty</th>
                                                    <th class="p-4">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($orderItems as $item)
                                                <tr class="border-t">
                                                    <td class="p-4">{{$item->product->name}}</td>
                                                    <td class="p-4">${{number_format($item->price,2)}}</td>
                                                    <td class="p-4">{{$item->quantity}}</td>
                                                    <td class="p-4 font-semibold">
                                                        ${{number_format($item->price * $item->quantity,2)}}
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- RIGHT SECTION (ORDER SUMMARY) -->
                            <div class="space-y-6">
                                <div class="bg-white rounded-xl shadow p-6 border">
                                    <h3 class="text-xl font-semibold mb-4">Order Summary</h3>
                                    <div class="space-y-3 text-sm">
                                        <div class="flex justify-between">
                                            <span>Subtotal</span>
                                            <span>${{number_format($orderDetail->subtotal ?? 0,2)}}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span>Tax</span>
                                            <span>${{number_format($orderDetail->tax ?? 0,2)}}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span>Shipping</span>
                                            <span>${{number_format($orderDetail->shipping_cost ?? 0,2)}}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span>Discount</span>
                                            <span>- ${{number_format($orderDetail->discount ?? 0,2)}}</span>
                                        </div>
                                        <hr>
                                        <div class="flex justify-between font-bold text-lg">
                                            <span>Total</span>
                                            <span>${{number_format($orderDetail->total,2)}}</span>
                                        </div>
                                        <hr>
                                        <div class="flex justify-between">
                                            <span>Payment Method</span>
                                            <span class="font-medium">{{ucfirst($orderDetail->payment_method) ?? 'N/A'}}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span>Shipping Method</span>
                                            <span class="font-medium">{{ucfirst($orderDetail->shipping_method) ?? 'Standard'}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            @yield('content')
        </div>
        <x-dashboard.sidebar.mobile-sidebar />
        <script>lucide.createIcons()</script>
        <script>
        function updateOrder() {
            document.getElementById('editOrderForm').submit();
        }
        </script>
    </body>
</html>