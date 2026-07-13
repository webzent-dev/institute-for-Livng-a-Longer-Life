<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="base-url" content="{{ url('/collaborator') }}">
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'Sub-Order Details | Institute for Living Longer - Your Journey to Wellness')</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://unpkg.com/alpinejs" defer></script>
        <script src="https://unpkg.com/lucide@latest"></script>
        <link rel="stylesheet" href="{{asset('css/toastr.min.css')}}" />
        <script src="{{asset('js/toastr.min.js')}}"></script>
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
        @php
            $order = $subOrder->order;
            $originAddress = $subOrder->origin_address ?? [];
            $destinationAddress = $subOrder->destination_address ?? [];
        @endphp
        <div class="flex min-h-screen">
            <x-dashboard.sidebar.sidebar />
            <div class="flex-1 flex flex-col">
                <x-dashboard.sidebar.header />
                <main class="flex-1 p-8  ">
                    <div class="space-y-6">
                        <!-- Header -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <x-button-use href="{{ route('collaborator.orders') }}" variant="outline" icon="arrow-left" class=" bg-white h-10 w-10 pl-1 pr-0"/>
                                <div>
                                    <h1 class="text-3xl font-bold text-left mb-0">Sub-Order Details</h1>
                                    <p class="text-muted-foreground text-lg">View and manage sub-order shipping</p>
                                </div>
                            </div>
                            <button type="button" onclick="document.getElementById('editSubOrderForm').submit()" class="rounded-md flex items-center justify-center font-semibold gap-2 transition-all duration-150 select-none px-5 py-2 text-base h-10 gradient-primary text-primary-foreground hover:opacity-90 shadow-medium font-semibold h-10 px-4 py-2  font-semibold  text-[14px]">
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
                                <!-- Sub-Order Info -->
                                <div class="bg-white rounded-xl shadow p-6 border">
                                    <h3 class="text-xl font-semibold mb-4">Sub-Order Information</h3>
                                    <form method="POST" id="editSubOrderForm" name="editSubOrderForm" action="{{ route('collaborator.sub-orders.update', $subOrder->id) }}" class="space-y-3 px-5">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="sub_order_id" value="{{ $subOrder->id }}">
                                        <div class="grid grid-cols-2 gap-4 text-sm">
                                            <div>
                                                <p class="text-gray-500">Sub-Order Number</p>
                                                <p class="font-semibold">{{ $subOrder->sub_order_number }}</p>
                                            </div>
                                            <div>
                                                <p class="text-gray-500">Created</p>
                                                <p class="font-semibold">{{ $subOrder->created_at }}</p>
                                            </div>
                                            <div class="col-span-2">
                                                <x-form.select label="Status" name="status" placeholder="Status"
                                                :options="[
                                                ['value' => 'pending', 'label' => 'Pending'],
                                                ['value' => 'confirmed', 'label' => 'Confirmed'],
                                                ['value' => 'processing', 'label' => 'Processing'],
                                                ['value' => 'shipped', 'label' => 'Shipped'],
                                                ['value' => 'delivered', 'label' => 'Delivered'],
                                                ['value' => 'cancelled', 'label' => 'Cancelled'],
                                                ]"
                                                :selected="[$subOrder->status]"
                                                />
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Carrier</label>
                                                <input type="text" name="carrier" value="{{ $subOrder->carrier }}" placeholder="e.g. USPS"
                                                    class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-[14px] ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Tracking Number</label>
                                                <input type="text" name="tracking_number" value="{{ $subOrder->tracking_number }}" placeholder="Tracking number"
                                                    class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-[14px] ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2">
                                            </div>
                                            <div class="col-span-2">
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                                                <textarea name="notes" rows="2" placeholder="Internal notes"
                                                    class="flex w-full rounded-md border border-input bg-background px-3 py-2 text-[14px] ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2">{{ $subOrder->notes }}</textarea>
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
                                            <p class="font-semibold">{{ $order->first_name ?? '' }} {{ $order->last_name ?? '' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-500">Email</p>
                                            <p class="font-semibold">{{ $order->email ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Address Section -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Origin (collaborator business address) -->
                                    <div class="bg-white rounded-xl shadow p-6 border">
                                        <h3 class="text-lg font-semibold mb-3">Origin Address</h3>
                                        @if(!empty($originAddress))
                                        <p class="text-sm text-gray-600">
                                            @if(!empty($originAddress['name'])){{ $originAddress['name'] }}<br>@endif
                                            {{ data_get($originAddress, 'address_line_1') }}<br>
                                            {{ data_get($originAddress, 'city') }}, {{ data_get($originAddress, 'state') }} {{ data_get($originAddress, 'zip_code') }}<br>
                                            {{ data_get($originAddress, 'country') }}
                                        </p>
                                        @else
                                        <p class="text-sm text-gray-400">No origin address on record.</p>
                                        @endif
                                    </div>

                                    <!-- Destination (customer shipping address) -->
                                    <div class="bg-white rounded-xl shadow p-6 border">
                                        <h3 class="text-lg font-semibold mb-3">Destination Address</h3>
                                        @if(!empty($destinationAddress))
                                        <p class="text-sm text-gray-600">
                                            @if(!empty($destinationAddress['name'])){{ $destinationAddress['name'] }}<br>@endif
                                            {{ data_get($destinationAddress, 'address_line_1') }}<br>
                                            {{ data_get($destinationAddress, 'city') }}, {{ data_get($destinationAddress, 'state') }} {{ data_get($destinationAddress, 'zip_code') }}<br>
                                            {{ data_get($destinationAddress, 'country') }}
                                        </p>
                                        @else
                                        <p class="text-sm text-gray-400">No destination address on record.</p>
                                        @endif
                                    </div>
                                </div>

                                <!-- Items Table -->
                                <div class="bg-white rounded-xl shadow border">
                                    <div class="p-6 border-b">
                                        <h3 class="text-xl font-semibold">Items</h3>
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
                                                @forelse($subOrder->items as $item)
                                                    <tr class="border-t">
                                                        <td class="p-4">{{ $item->product_name ?? optional($item->product)->name }}</td>
                                                        <td class="p-4">${{ number_format($item->price, 2) }}</td>
                                                        <td class="p-4">{{ $item->quantity }}</td>
                                                        <td class="p-4 font-semibold">${{ number_format($item->total ?? ($item->price * $item->quantity), 2) }}</td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="4" class="p-4 text-center text-gray-500">No items found for this sub-order.</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- RIGHT SECTION -->
                            <div class="space-y-6">
                                <!-- Order Summary -->
                                <div class="bg-white rounded-xl shadow p-6 border">
                                    <h3 class="text-xl font-semibold mb-4">Order Summary</h3>
                                    <div class="space-y-3 text-sm">
                                        <div class="flex justify-between">
                                            <span>Subtotal</span>
                                            <span>${{ number_format($subOrder->subtotal ?? 0, 2) }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span>Shipping</span>
                                            <span>${{ number_format($subOrder->shipping_cost ?? 0, 2) }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span>Handling Fee</span>
                                            <span>${{ number_format($subOrder->handling_fee ?? 0, 2) }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span>Tax</span>
                                            <span>${{ number_format($subOrder->tax ?? 0, 2) }}</span>
                                        </div>
                                        <hr>
                                        <div class="flex justify-between font-bold text-lg">
                                            <span>Total</span>
                                            <span>${{ number_format($subOrder->total ?? 0, 2) }}</span>
                                        </div>
                                        <hr>
                                        <div class="flex justify-between">
                                            <span>Shipping Method</span>
                                            <span class="font-medium">
                                                @if($subOrder->carrier)
                                                    {{ $subOrder->carrier }} &ndash;
                                                @endif
                                                {{ ucfirst($subOrder->shipping_method ?? 'Standard') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Shipping Label -->
                                <div class="bg-white rounded-xl shadow p-6 border">
                                    <h3 class="text-xl font-semibold mb-4">Shipping Label</h3>
                                    @if($subOrder->label_url)
                                        <div class="space-y-3 text-sm">
                                            <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold border-transparent bg-green-500 text-white">
                                                Label Ready
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-gray-500">Tracking Number</span>
                                                <span class="font-medium">{{ $subOrder->tracking_number ?? 'N/A' }}</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-gray-500">Carrier</span>
                                                <span class="font-medium">{{ $subOrder->carrier ?? 'N/A' }}</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-gray-500">Created</span>
                                                <span class="font-medium">{{ optional($subOrder->label_created_at)->format('M d, Y H:i') }}</span>
                                            </div>
                                            <div class="flex flex-col gap-2 pt-2">
                                                <a href="{{ route('collaborator.download-label', $subOrder->id) }}" target="_blank"
                                                    class="inline-flex items-center justify-center rounded-md gradient-primary text-primary-foreground hover:opacity-90 font-semibold px-4 py-2 text-[14px]">
                                                    Download Label (PDF)
                                                </a>
                                                <button type="button" onclick="window.open('{{ $subOrder->label_url }}', '_blank')"
                                                    class="inline-flex items-center justify-center rounded-md border border-input bg-white hover:bg-gray-50 font-semibold px-4 py-2 text-[14px]">
                                                    Print Label
                                                </button>
                                            </div>
                                        </div>
                                    @else
                                        <div class="space-y-3 text-sm">
                                            <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold border-transparent bg-orange-500 text-white">
                                                No Label
                                            </div>
                                            @if(!$subOrder->shippo_rate_id)
                                                <p class="text-red-600">No shipping rate — label cannot be generated.</p>
                                            @else
                                                <p class="text-gray-500">Generate a shipping label for this sub-order.</p>
                                                <form method="POST" action="{{ route('collaborator.generate-label', $subOrder->id) }}">
                                                    @csrf
                                                    <button type="submit"
                                                        class="w-full inline-flex items-center justify-center rounded-md bg-green-600 text-white hover:bg-green-700 font-semibold px-4 py-2 text-[14px]">
                                                        Generate Shipping Label
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    @endif
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
    </body>
</html>
