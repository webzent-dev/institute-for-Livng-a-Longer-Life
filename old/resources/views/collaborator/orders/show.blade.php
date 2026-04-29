<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="base-url" content="{{ url('/admin') }}">
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'Order Detail | Institute for Living Longer - Your Journey to Wellness')</title>
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

                        <!-- Order Information -->
                        <form method="POST" id="editOrderForm" name="editOrderForm" action="{{ route('collaborator.orders.update', $orderDetail->id) }}" class="space-y-3 overflow-y-auto scrollbar-custom scroll-smooth px-5">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="order_id" value="{{ $orderDetail->id }}">
                            <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
                                <div class="flex flex-col space-y-1.5 p-6">
                                    <h3 class="text-2xl font-semibold leading-none tracking-tight">Order Information</h3>
                                </div>
                                <div class="p-6 pt-0 space-y-4 text-black">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="text-md font-medium text-muted-foreground">Order Number</label>
                                            <p class="font-mono text-md text-black">{{$orderDetail->order_number}}</p>
                                        </div>
                                    <div>
                                        <label class="text-md font-medium text-muted-foreground">Order Date</label>
                                        <p class="text-md text-black">{{$orderDetail->created_at}}</p>
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
                            </div>
                        </form>

                        <!-- Customer Information -->
                        <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
                            <div class="flex flex-col space-y-1.5 p-6">
                                <h3 class="text-2xl font-semibold leading-none tracking-tight">Customer Information</h3>
                            </div>
                            <div class="p-6 pt-0">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="text-md font-medium text-muted-foreground">Customer Name</label>
                                        <p class="text-lg">{{$orderDetail->user->first_name}} {{$orderDetail->user->last_name}}</p>
                                    </div>
                                    <div>
                                        <label class="text-md font-medium text-muted-foreground">Email</label>
                                        <p class="text-lg">{{$orderDetail->user->email}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Product Details -->
                        <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
                            <div class="flex flex-col space-y-1.5 p-6">
                                <h3 class="text-2xl font-semibold leading-none tracking-tight">Product Details</h3>
                            </div>
                            @forelse($orderItems as $item)
                            <div class="p-6 pt-0">
                                <div class="space-y-4">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="text-md font-medium text-muted-foreground">Product Name</label>
                                            <p class="text-lg">{{$item->product->name}}</p>
                                        </div>
                                        <div>
                                            <label class="text-md font-medium text-muted-foreground">Customer Name</label>
                                            <p class="text-lg">{{$orderDetail->user->first_name}} {{$orderDetail->user->last_name}}</p>
                                        </div>
                                        <div>
                                            <label class="text-md font-medium text-muted-foreground">Quantity</label>
                                            <p class="text-lg">{{$item->quantity}}</p>
                                        </div>
                                        <div>
                                            <label class="text-md font-medium text-muted-foreground">Total Amount</label>
                                            <p class="text-lg font-bold text-black">${{number_format($orderDetail->total, 2)}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="p-6 pt-0">
                                <div class="space-y-4">
                                    <div class="grid grid-cols-2 gap-4">
                                        No products found
                                    </div> 
                                </div>
                            </div>
                            @endforelse
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