<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="base-url" content="{{ url('/admin') }}">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Order Management | Institute for Living Longer - Your Journey to Wellness')</title>
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
                <div class="">
                    <h1 class="text-3xl font-bold text-left">Order Management</h1>
                    <p class="text-muted-foreground text-lg">View and manage all orders with analytics</p>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
                    <!-- Institute Revenue -->
                    <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
                        <div class="p-6">
                            <div class="flex items-center gap-4">
                                <div class="rounded-full bg-primary/10 p-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <line x1="12" y1="2" x2="12" y2="22" />
                                        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm text-muted-foreground">Institute Revenue</p>
                                    <p class="text-2xl font-bold text-black">${{number_format($instituteRevenue, 2)}}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Collaborator Revenue -->
                    <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
                        <div class="p-6">
                            <div class="flex items-center gap-4">
                                <div class="rounded-full bg-green-500/10 p-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="22 7 13.5 15.5 8.5 10.5 2 17" />
                                        <polyline points="16 7 22 7 22 13" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm text-muted-foreground">Collaborator Revenue</p>
                                    <p class="text-2xl font-bold text-black">${{number_format($collaboratorRevenue, 2)}}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Orders -->
                    <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
                        <div class="p-6">
                            <div class="flex items-center gap-4">
                                <div class="rounded-full bg-blue-500/10 p-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="8" cy="21" r="1" />
                                        <circle cx="19" cy="21" r="1" />
                                        <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm text-muted-foreground">Total Orders</p>
                                    <p class="text-2xl font-bold text-black">{{$orderCount}}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Active Collaborators -->
                    <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
                        <div class="p-6">
                            <div class="flex items-center gap-4">
                                <div class="rounded-full bg-purple-500/10 p-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                        <circle cx="9" cy="7" r="4" />
                                        <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm text-muted-foreground">Active Collaborators</p>
                                    <p class="text-2xl font-bold text-black">{{$activeCollaboratorsCount}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabs -->
                <div dir="ltr" data-orientation="horizontal">
                    <div role="tablist" aria-orientation="horizontal" class="grid h-10 w-full grid-cols-3 items-center justify-center rounded-md bg-muted p-1 text-muted-foreground" tabindex="0">
                        <button role="tab" aria-selected="true" data-state="active" data-tab="institute_orders" aria-controls="members" type="button" class="inline-flex items-center justify-center rounded-sm px-3 py-1.5 text-sm font-medium transition-all data-[state=active]:bg-background data-[state=active]:text-foreground data-[state=active]:shadow-sm">
                            Institute Orders ({{count($instituteOrders)}})
                        </button>
                        <button role="tab" aria-selected="false" data-state="inactive" data-tab="collaborator_orders" aria-controls="collaborators" type="button" class="inline-flex items-center justify-center rounded-sm px-3 py-1.5 text-sm font-medium transition-all">
                            Collaborator Orders ({{count($collaboratorOrders)}})
                        </button>
                        <button role="tab" aria-selected="false" data-state="inactive" data-tab="collaborator_analytics" aria-controls="admins" type="button" class="inline-flex items-center justify-center rounded-sm px-3 py-1.5 text-sm font-medium transition-all">
                            Collaborator Analytics
                        </button>
                    </div>
                </div>

                <!----- Institute Orders Start Here ----->
                <div id="institute_orders" class="tab-content mt-2">
                    <div class="rounded-lg border bg-card shadow-sm">
                        <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
                            <div class="flex flex-col space-y-1.5 p-6">
                                <h3 class="text-2xl font-semibold leading-none tracking-tight">Institute Orders</h3>
                                <p class="text-sm text-muted-foreground">Orders from Institute for Living Longer products</p>
                            </div>
                            <div class="p-6 pt-0">
                                <div class="relative w-full overflow-auto">
                                    <table class="w-full caption-bottom text-sm">
                                        <thead class="[&_tr]:border-b">
                                            <tr class="border-b transition-colors data-[state=selected]:bg-muted hover:bg-muted/50">
                                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Order Number</th>
                                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Customer</th>
                                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Total</th>
                                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Status</th>
                                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Payment Status</th>
                                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Order Date</th>
                                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="[&_tr:last-child]:border-0">
                                            @forelse($instituteOrders as $order)
                                            <tr class="border-b transition-colors data-[state=selected]:bg-muted hover:bg-muted/50">
                                                <td class="p-4 align-middle">{{$order->order_number}}</td>
                                                <td class="p-4 align-middle">
                                                    <div>
                                                        <p class="font-medium">{{$order->first_name}} {{$order->last_name}}</p>
                                                        <p class="text-sm text-muted-foreground">{{$order->email}}</p>
                                                    </div>
                                                </td>
                                                <td class="p-4 align-middle">${{number_format($order->total, 2)}}</td>
                                                <td class="p-4 align-middle">
                                                    <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-transparent text-primary-foreground hover:bg-primary/80 bg-green-500">
                                                        {{ucfirst($order->status)}}
                                                    </div>
                                                </td>
                                                <td class="p-4 align-middle">
                                                    <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-transparent text-primary-foreground hover:bg-primary/80 bg-green-500">
                                                        {{ucfirst($order->payment_status)}}
                                                    </div>
                                                </td>
                                                <td class="p-4 align-middle">{{$order->created_at}}</td>
                                                <td class="p-4 justify-items-center ">
                                                    <x-button-use href="{{ route('orders.show', $order->o_id) }}" label="View" variant="outline" icon="eye" class="pl-0 pr-0 w-24 h-10"/>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr class="border-b transition-colors data-[state=selected]:bg-muted hover:bg-muted/50">
                                                <td class="p-4 align-middle">
                                                    <div>
                                                        <p class="font-medium">No Orders Found</p>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!----- Institute Orders End Here ----->

                <!----- Collaborator Orders Start Here ----->
                <div id="collaborator_orders" class="tab-content mt-2 hidden">
                    <div class="rounded-lg border bg-card shadow-sm">
                        <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
                            <div class="flex flex-col space-y-1.5 p-6">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <h3 class="text-2xl font-semibold leading-none tracking-tight">Collaborator Orders</h3>
                                        <p class="text-sm text-muted-foreground">Orders from collaborator products in the wellness store</p>
                                    </div>
                                    <!-- <div class="w-[220px]">
                                        <x-form.select
                                            name="collaborator"
                                            :options="[
                                                ['value' => 'all', 'label' => 'All Collaborators'],
                                                ['value' => 'Dr. Sarah Martinez', 'label' => 'Dr. Sarah Martinez'],
                                                ['value' => 'Dr. Michael Chen', 'label' => 'Dr. Michael Chen'],
                                                ['value' => 'Dr. Emily Thompson', 'label' => 'Dr. Emily Thompson'],
                                            ]"
                                            :selected="['all']"
                                        />
                                    </div> -->
                                </div>
                            </div>

                            <div class="p-6 pt-0">
                                <div class="relative w-full overflow-auto">
                                    <table class="w-full caption-bottom text-sm">
                                        <thead class="[&_tr]:border-b">
                                            <tr class="border-b transition-colors data-[state=selected]:bg-muted hover:bg-muted/50">
                                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Order Number</th>
                                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Customer</th>
                                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Total</th>
                                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Status</th>
                                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Payment Status</th>
                                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Order Date</th>
                                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="[&_tr:last-child]:border-0">
                                            @forelse($collaboratorOrders as $order)
                                            <tr class="border-b transition-colors data-[state=selected]:bg-muted hover:bg-muted/50">
                                                <td class="p-4 align-middle">{{$order->order_number}}</td>
                                                <td class="p-4 align-middle">
                                                    <div>
                                                        <p class="font-medium">{{$order->first_name}} {{$order->last_name}}</p>
                                                        <p class="text-sm text-muted-foreground">{{$order->email}}</p>
                                                    </div>
                                                </td>
                                                <td class="p-4 align-middle">${{number_format($order->total, 2)}}</td>
                                                <td class="p-4 align-middle">
                                                    <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-transparent text-primary-foreground hover:bg-primary/80 bg-green-500">
                                                        {{ucfirst($order->status)}}
                                                    </div>
                                                </td>
                                                <td class="p-4 align-middle">
                                                    <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-transparent text-primary-foreground hover:bg-primary/80 bg-green-500">
                                                        {{ucfirst($order->payment_status)}}
                                                    </div>
                                                </td>
                                                <td class="p-4 align-middle">{{$order->created_at}}</td>
                                                <td class="p-4 justify-items-center ">
                                                    <x-button-use href="{{ route('orders.show', $order->o_id) }}" label="View" variant="outline" icon="eye" class="pl-0 pr-0 w-24 h-10"/>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr class="border-b transition-colors data-[state=selected]:bg-muted hover:bg-muted/50">
                                                <td class="p-4 align-middle">
                                                    <div>
                                                        <p class="font-medium">No Orders Found</p>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!----- Collaborator Orders End Here ----->

                <!----- Collaborator Analytics Start Here ----->
                <div id="collaborator_analytics" class="tab-content mt-2 hidden">
                    <div class="rounded-lg border bg-card shadow-sm">
                        <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
                            <div class="flex flex-col space-y-1.5 p-6">
                                <h3 class="text-2xl font-semibold leading-none tracking-tight">Collaborator Performance Analytics</h3>
                                <p class="text-sm text-muted-foreground">Revenue and order statistics by collaborator</p>
                            </div>
                            <div class="p-6 pt-0">
                                <div class="relative w-full overflow-auto">
                                    <table class="w-full caption-bottom text-sm">
                                        <thead class="[&_tr]:border-b">
                                            <tr class="border-b transition-colors data-[state=selected]:bg-muted hover:bg-muted/50">
                                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Collaborator</th>
                                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Total Orders</th>
                                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Products Sold</th>
                                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Total Revenue</th>
                                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Avg. Order Value</th>
                                            </tr>
                                        </thead>
                                        <tbody class="[&_tr:last-child]:border-0">
                                            @forelse($collaborators as $collaborator)
                                                @php
                                                //total products sold by collaborator
                                                $collaborator->totalProducts = DB::table('order_items')->where('user_id', $collaborator->id)->count();
                                                $collaborator->totalOrders = DB::table('orders')->where('user_id', $collaborator->id)->count();
                                                $collaborator->totalRevenue = DB::table('orders')->where('user_id', $collaborator->id)->sum('total');
                                                
                                                if($collaborator->totalOrders > 0)
                                                    $collaborator->avgOrderValue = $collaborator->totalRevenue / $collaborator->totalOrders;
                                                else
                                                    $collaborator->avgOrderValue = 0;
                                                @endphp
                                                <tr class="border-b transition-colors data-[state=selected]:bg-muted hover:bg-muted/50">
                                                    <td class="p-4 align-middle font-medium">{{$collaborator->first_name}} {{$collaborator->last_name}}</td>
                                                    <td class="p-4 align-middle">{{$collaborator->totalOrders}}</td>
                                                    <td class="p-4 align-middle">{{$collaborator->totalProducts}}</td>
                                                    <td class="p-4 align-middle font-semibold text-green-600">${{number_format($collaborator->totalRevenue, 2)}}</td>
                                                    <td class="p-4 align-middle">${{number_format($collaborator->avgOrderValue, 2)}}</td>
                                                </tr>
                                            @empty
                                                <tr class="border-b transition-colors data-[state=selected]:bg-muted hover:bg-muted/50">
                                                    <td class="p-4 align-middle">
                                                        <div>
                                                            <p class="font-medium">No Collaborators Found</p>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!----- Collaborator Analytics End Here ----->
            </div>
        </main>
        @yield('content')
    </div>
</div>
<x-dashboard.sidebar.mobile-sidebar />
<script>lucide.createIcons()</script>
<script>
const tabs = document.querySelectorAll('[role="tab"]');
const contents = document.querySelectorAll('.tab-content');
tabs.forEach(tab => {
    tab.addEventListener('click', () => {
        tabs.forEach(t => {
            t.setAttribute('aria-selected', 'false');
            t.setAttribute('data-state', 'inactive');
            t.classList.remove('bg-background', 'shadow-sm');
        });

        contents.forEach(c => c.classList.add('hidden'));

        tab.setAttribute('aria-selected', 'true');
        tab.setAttribute('data-state', 'active');
        tab.classList.add('bg-background', 'shadow-sm');

        const activeContent = document.getElementById(tab.dataset.tab);
        if (activeContent) {
            activeContent.classList.remove('hidden');
        }
    });
});
</script>
</body>
</html>
