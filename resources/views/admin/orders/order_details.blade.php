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
        <style>
            [x-cloak] { display: none !important; }
            /* Custom scrollbar styles */
            .scrollbar-thin {
                scrollbar-width: thin;
                scrollbar-color: #d1d5db #f3f4f6;
            }
            .scrollbar-thin::-webkit-scrollbar {
                width: 6px;
            }
            .scrollbar-thin::-webkit-scrollbar-track {
                background: #f3f4f6;
                border-radius: 3px;
            }
            .scrollbar-thin::-webkit-scrollbar-thumb {
                background: #d1d5db;
                border-radius: 3px;
            }
            .scrollbar-thin::-webkit-scrollbar-thumb:hover {
                background: #9ca3af;
            }
        </style>
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
    <body  x-data="{  sidebarOpen: true,  mobileSidebar: false  }"  class="bg-slate-50 antialiased h-screen overflow-hidden">
        <div class="flex h-full">
            <x-dashboard.sidebar.sidebar />
            <div class="flex-1 flex flex-col h-full overflow-hidden">
                <x-dashboard.sidebar.header />
                <main class="flex-1 p-8 overflow-y-auto scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
                    <div class="space-y-6 pb-8">
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
                        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
                            <!-- LEFT SECTION -->
                            <div class="xl:col-span-2 space-y-6">
                                <!-- Order Info -->
                                <div class="bg-white rounded-xl shadow p-6 border">
                                    <h3 class="text-xl font-semibold mb-4">Order Information</h3>
                                    <form method="POST" id="editOrderForm" name="editOrderForm" action="{{ route('admin.orders.update', $orderDetail->id) }}" class="space-y-3">
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
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
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

                            </div>

                            <!-- RIGHT SECTION (ORDER SUMMARY) -->
                            <div class="space-y-6">
                                <div class="bg-white rounded-xl shadow p-4 sm:p-6 border">
                                    <h3 class="text-xl font-semibold mb-4">Order Summary</h3>
                                    <div class="space-y-3 text-sm">
                                        <div class="flex justify-between items-center">
                                            <span class="text-gray-600">Subtotal</span>
                                            <span class="font-medium">${{number_format($orderDetail->subtotal ?? 0,2)}}</span>
                                        </div>
                                        <div class="flex justify-between items-center">
                                            <span class="text-gray-600">Tax</span>
                                            <span class="font-medium">${{number_format($orderDetail->tax ?? 0,2)}}</span>
                                        </div>
                                        <div class="flex justify-between items-center">
                                            <span class="text-gray-600">Shipping</span>
                                            <span class="font-medium">${{number_format($orderDetail->shipping_cost ?? 0,2)}}</span>
                                        </div>
                                        <div class="flex justify-between items-center">
                                            <span class="text-gray-600">Discount</span>
                                            <span class="font-medium text-red-600">- ${{number_format($orderDetail->discount ?? 0,2)}}</span>
                                        </div>
                                        <hr class="border-gray-200">
                                        <div class="flex justify-between items-center font-bold text-lg">
                                            <span>Total</span>
                                            <span class="text-blue-600">${{number_format($orderDetail->total,2)}}</span>
                                        </div>
                                        <hr class="border-gray-200">
                                        <div class="space-y-2">
                                            <div class="flex justify-between items-center">
                                                <span class="text-gray-600 text-xs">Payment Method</span>
                                                <span class="font-medium text-xs">{{ucfirst($orderDetail->payment_method) ?? 'N/A'}}</span>
                                            </div>
                                            <div class="flex justify-between items-center">
                                                <span class="text-gray-600 text-xs">Shipping Method</span>
                                                <span class="font-medium text-xs">{{ucfirst($orderDetail->shipping_method) ?? 'Standard'}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Product Table -->
                        <div class="bg-white rounded-xl shadow border">
                            <div class="p-4 sm:p-6 border-b">
                                <h3 class="text-xl font-semibold">Order Items</h3>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm min-w-[500px]">
                                    <thead class="bg-gray-100 text-left">
                                        <tr>
                                            <th class="p-3 sm:p-4 text-left">Product</th>
                                            <th class="p-3 sm:p-4 text-left">Seller</th>
                                            <th class="p-3 sm:p-4 text-right sm:text-left">Price</th>
                                            <th class="p-3 sm:p-4 text-center sm:text-left">Qty</th>
                                            <th class="p-3 sm:p-4 text-right">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($orderItems as $item)
                                            @php
                                                $isCollaboratorItem = in_array($item->product_id, $collaboratorProductIds);
                                                $sellerName = $isCollaboratorItem && $item->product && $item->product->user
                                                    ? trim($item->product->user->first_name . ' ' . $item->product->user->last_name)
                                                    : 'Institute';
                                            @endphp
                                            <tr class="border-t hover:bg-gray-50">
                                                <td class="p-3 sm:p-4">
                                                    <div class="font-medium text-gray-900">{{ $item->product->name ?? $item->product_name }}</div>
                                                </td>
                                                <td class="p-3 sm:p-4">
                                                    <span class="sm:hidden font-medium">Seller: </span>
                                                    <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold border-transparent text-white {{ $isCollaboratorItem ? 'bg-purple-500' : 'bg-slate-500' }}">
                                                        {{ $sellerName }}
                                                    </span>
                                                </td>
                                                <td class="p-3 sm:p-4 text-right sm:text-left">
                                                    <span class="sm:hidden font-medium">Price: </span>${{number_format($item->price,2)}}
                                                </td>
                                                <td class="p-3 sm:p-4 text-center sm:text-left">
                                                    <span class="sm:hidden font-medium">Qty: </span>{{$item->quantity}}
                                                </td>
                                                <td class="p-3 sm:p-4 text-right font-semibold">
                                                    <span class="sm:hidden font-medium">Total: </span>${{number_format($item->price * $item->quantity,2)}}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="p-4 text-center text-gray-500">No items found for this order.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Shipping & Labels (one block per seller) -->
                        @if(isset($subOrders) && $subOrders->count() > 0)
                        <div class="bg-white rounded-xl shadow border">
                            <div class="p-4 sm:p-6 border-b">
                                <h3 class="text-xl font-semibold">Shipping &amp; Labels</h3>
                                <p class="text-sm text-gray-500">
                                    Every seller ships from their own address, so each one's label is generated separately.
                                </p>
                            </div>
                            <div class="divide-y">
                                @foreach($subOrders as $subOrder)
                                    @php
                                        $seller = $subOrder->seller;
                                        $isCollaboratorSubOrder = $seller && $seller->role === 'collaborator';
                                        $subOrderSellerName = $isCollaboratorSubOrder
                                            ? trim($seller->first_name . ' ' . $seller->last_name)
                                            : 'Institute';
                                    @endphp
                                    <div class="p-4 sm:p-6 space-y-4" x-data="{ confirmOpen: false }">
                                        <!-- Seller header -->
                                        <div class="flex flex-wrap items-start justify-between gap-3">
                                            <div>
                                                <div class="flex items-center gap-2">
                                                    <span class="font-semibold text-gray-900">{{ $subOrderSellerName }}</span>
                                                    <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold border-transparent text-white {{ $isCollaboratorSubOrder ? 'bg-purple-500' : 'bg-slate-500' }}">
                                                        {{ $isCollaboratorSubOrder ? 'Collaborator' : 'Institute' }}
                                                    </span>
                                                </div>
                                                <p class="text-xs text-gray-500 mt-1">{{ $subOrder->sub_order_number }}</p>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold border-transparent text-white @if($subOrder->status == 'delivered') bg-green-500 @elseif($subOrder->status == 'cancelled') bg-red-500 @elseif($subOrder->status == 'shipped') bg-blue-500 @else bg-orange-500 @endif">
                                                    {{ ucfirst($subOrder->status) }}
                                                </span>
                                                @if($subOrder->label_url)
                                                    <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold border-transparent bg-green-500 text-white">Label Ready</span>
                                                @else
                                                    <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold border-transparent bg-yellow-500 text-white">No Label</span>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Items in this seller's parcel -->
                                        <ul class="text-sm text-gray-600 list-disc list-inside">
                                            @foreach($subOrder->items as $subItem)
                                                <li>{{ $subItem->product_name }} &times; {{ $subItem->quantity }}</li>
                                            @endforeach
                                        </ul>

                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                            <!-- Status -->
                                            <form method="POST" action="{{ route('admin.sub-orders.update', $subOrder->id) }}"
                                                x-ref="statusForm"
                                                @if($isCollaboratorSubOrder) @submit.prevent="confirmOpen = true" @endif>
                                                @csrf
                                                @method('PUT')
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                                <div class="flex gap-2">
                                                    <select name="status" class="border rounded-xl px-4 py-2 bg-white text-gray-700 w-full">
                                                        @foreach(['pending','confirmed','processing','shipped','delivered','cancelled'] as $statusOption)
                                                            <option value="{{ $statusOption }}" @selected($subOrder->status === $statusOption)>{{ ucfirst($statusOption) }}</option>
                                                        @endforeach
                                                    </select>
                                                    <button type="submit" class="shrink-0 inline-flex items-center justify-center rounded-md gradient-primary text-primary-foreground hover:opacity-90 font-semibold px-4 py-2 text-[14px]">
                                                        Update
                                                    </button>
                                                </div>
                                            </form>

                                            <!-- Label -->
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Shipping Label</label>
                                                @if($subOrder->label_url)
                                                    <div class="text-sm text-gray-600 mb-2">
                                                        Tracking: <span class="font-medium">{{ $subOrder->tracking_number ?? 'N/A' }}</span>
                                                        ({{ $subOrder->carrier ?? 'N/A' }})
                                                    </div>
                                                    <div class="flex gap-2">
                                                        <a href="{{ route('admin.download-label', $subOrder->id) }}" target="_blank"
                                                            class="inline-flex items-center justify-center rounded-md gradient-primary text-primary-foreground hover:opacity-90 font-semibold px-4 py-2 text-[14px]">
                                                            Download (PDF)
                                                        </a>
                                                        <button type="button" onclick="window.open('{{ $subOrder->label_url }}', '_blank')"
                                                            class="inline-flex items-center justify-center rounded-md border border-input bg-white hover:bg-gray-50 font-semibold px-4 py-2 text-[14px]">
                                                            Print
                                                        </button>
                                                    </div>
                                                @elseif(!$subOrder->shippo_rate_id)
                                                    <p class="text-sm text-red-600">No shipping rate — label cannot be generated.</p>
                                                @else
                                                    <form method="POST" action="{{ route('admin.generate-label', $subOrder->id) }}">
                                                        @csrf
                                                        <button type="submit"
                                                            class="inline-flex items-center justify-center rounded-md bg-green-600 text-white hover:bg-green-700 font-semibold px-4 py-2 text-[14px]">
                                                            Generate Label
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>

                                        @if($isCollaboratorSubOrder)
                                        <!-- Confirm before touching a collaborator's sub-order -->
                                        <div x-show="confirmOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center">
                                            <div class="absolute inset-0 bg-black/50" @click="confirmOpen = false"></div>
                                            <div class="relative bg-white rounded-xl shadow-lg p-6 w-full max-w-md mx-4">
                                                <h4 class="text-lg font-semibold text-gray-900">Update this collaborator's order?</h4>
                                                <p class="text-sm text-gray-600 mt-2">
                                                    This part of the order belongs to <span class="font-semibold">{{ $subOrderSellerName }}</span>.
                                                    Changing its status updates their record, and the customer is emailed once every seller
                                                    on this order reaches the same status.
                                                </p>
                                                <div class="flex justify-end gap-3 mt-6">
                                                    <button type="button" @click="confirmOpen = false"
                                                        class="inline-flex items-center justify-center rounded-md border border-input bg-white hover:bg-gray-50 font-semibold px-4 py-2 text-[14px]">
                                                        Cancel
                                                    </button>
                                                    <button type="button" @click="$refs.statusForm.submit()"
                                                        class="inline-flex items-center justify-center rounded-md gradient-primary text-primary-foreground hover:opacity-90 font-semibold px-4 py-2 text-[14px]">
                                                        Yes, update status
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
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