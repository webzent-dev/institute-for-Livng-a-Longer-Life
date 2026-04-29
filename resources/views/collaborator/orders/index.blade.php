<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="base-url" content="{{ url('/collaborator') }}">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Orders | Institute for Living Longer - Your Journey to Wellness')</title>
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
                <div class="">
                    <h1 class="text-3xl font-bold text-left">Orders</h1>
                    <p class="text-muted-foreground text-lg">View and manage your product orders</p>
                </div>

                <!----- Orders Start Here ----->
                <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
                    @if($orders->count() > 0)
                        <div class="flex flex-col space-y-1.5 p-6">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h3 class="text-2xl font-semibold leading-none tracking-tight">Orders</h3>
                                </div>
                                <div class="w-[220px]">
                                    <input id="collaborator_search" type="text" name="collaborator_search" placeholder="Search orders..." onkeyup="searchCollaboratorOrders()" class="flex h-10 w-full rounded-md
                                    border border-input
                                    bg-background
                                    px-3 py-2
                                    text-[14px]
                                    placeholder:text-[14px]
                                    ring-offset-background
                                    focus-visible:outline-none
                                    focus-visible:ring-2
                                    focus-visible:ring-ring
                                    focus-visible:ring-offset-2
                                    disabled:cursor-not-allowed
                                    disabled:opacity-50">
                                </div>
                            </div>
                        </div>
                        <div id="collaborator_orders" class="p-6 pt-0">
                            <div class="relative w-full overflow-auto">
                                <table class="w-full caption-bottom text-sm">
                                    <thead class="[&_tr]:border-b">
                                        <tr class="border-b transition-colors data-[state=selected]:bg-muted hover:bg-muted/50">
                                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Order Number</th>
                                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Customer</th>
                                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Total</th>
                                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Order Status</th>
                                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Payment Status</th>
                                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Order Date</th>
                                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="[&_tr:last-child]:border-0">
                                        @forelse($orders as $order)
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
                                                <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-transparent text-primary-foreground hover:bg-primary/80 @if($order->status == 'confirmed') bg-orange-500 @elseif($order->status == 'delivered') bg-green-500 @elseif($order->status == 'cancelled') bg-red-500 @else bg-orange-500 @endif">
                                                    {{ucfirst($order->status)}}
                                                </div>
                                            </td>
                                            <td class="p-4 align-middle">
                                                <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-transparent text-primary-foreground hover:bg-primary/80 @if($order->payment_status == 'pending') bg-orange-500 @elseif($order->payment_status == 'completed') bg-green-500 @elseif($order->payment_status == 'failed') bg-red-500 @elseif($order->payment_status == 'refunded') bg-purple-500 @else bg-orange-500 @endif">
                                                    {{ucfirst($order->payment_status)}}
                                                </div>
                                            </td>
                                            <td class="p-4 align-middle">{{$order->created_at}}</td>
                                            <td class="p-4 justify-items-center ">
                                                <x-button-use href="{{ route('collaborator.order-details', $order->id) }}" label="View" variant="outline" icon="eye" class="pl-0 pr-0 w-24 h-10"/>
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
                            <!-- PAGINATION UI -->
                            @if($orders->hasPages())
                                <div class="px-6 py-4 border-t border-gray-100">
                                    <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                                        <div class="text-sm text-gray-500">
                                            Showing <span class="font-semibold text-gray-700">{{ $orders->firstItem() }}</span> 
                                            to <span class="font-semibold text-gray-700">{{ $orders->lastItem() }}</span> 
                                            of <span class="font-semibold text-gray-700">{{ $orders->total() }}</span> orders
                                        </div>
                                        <div class="custom-pagination">
                                            {{ $orders->links('pagination::tailwind') }}
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="p-6 flex flex-col items-center justify-center py-12">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shopping-bag h-12 w-12 text-muted-foreground mb-4">
                                <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"></path>
                                <path d="M3 6h18"></path><path d="M16 10a4 4 0 0 1-8 0"></path>
                            </svg>
                            <h3 class="text-lg font-semibold mb-2">No orders yet</h3>
                            <p class="text-muted-foreground">Your orders will appear here once customers make purchases</p>
                        </div>
                    @endif
                </div>
                <!----- Orders End Here ----->
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

function searchCollaboratorOrders() {
    const searchInput = document.getElementById('collaborator_search');
    const filter = searchInput.value.toLowerCase();
    const table = document.querySelector('#collaborator_orders table');
    const rows = table.getElementsByTagName('tr');

    for (let i = 1; i < rows.length; i++) {
        const cells = rows[i].getElementsByTagName('td');
        let match = false;
        for (let j = 0; j < cells.length; j++) {
            if (cells[j]) {
                const cellText = cells[j].textContent || cells[j].innerText;
                if (cellText.toLowerCase().indexOf(filter) > -1) {
                    match = true;
                    break;
                }
            }
        }
        rows[i].style.display = match ? '' : 'none';
    }
}
</script>
</body>
</html>
