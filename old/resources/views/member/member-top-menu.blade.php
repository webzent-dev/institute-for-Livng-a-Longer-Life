 
@php
    $menuItems = [
        ['title' => 'Dashboard', 'url' => route('member.dashboard'), 'icon' => 'dashboard', 'active' => request()->routeIs('member.dashboard')],
        ['title' => 'Videos', 'url' => route('member.video-library'), 'icon' => 'video', 'active' => request()->routeIs('member.video-library')],
        ['title' => 'Store', 'url' => route('member.store'), 'icon' => 'store', 'active' => request()->routeIs('member.store')],
        ['title' => 'Profile', 'url' => route('member.profile'), 'icon' => 'user', 'active' => request()->routeIs('member.profile')],
        ['title' => 'Security', 'url' => route('member.security'), 'icon' => 'shield', 'active' => request()->routeIs('member.security')],
        ['title' => 'Subscription', 'url' => route('member.subscription'), 'icon' => 'credit-card', 'active' => request()->routeIs('member.subscription')],
        ['title' => 'Orders', 'url' => route('member.orders'), 'icon' => 'package', 'active' => request()->routeIs('member.orders')],
        ['title' => 'Plans', 'url' => route('member.plans'), 'icon' => 'arrow-up-down', 'active' => request()->routeIs('member.plans')],
        ['title' => 'Payments', 'url' => route('member.payments'), 'icon' => 'receipt', 'active' => request()->routeIs('member.payments')],
    ];
    
    $icons = [
        'dashboard' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
        'video' => 'M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z',
        'store' => 'M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z',
        'user' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z',
        'shield' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z',
        'credit-card' => 'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z',
        'package' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4',
        'arrow-up-down' => 'M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4',
        'receipt' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
    ];
@endphp

<div class="flex justify-center px-4 sm:px-6 lg:px-8 py-4">
    <nav class="bg-white border border-gray-200 rounded-2xl shadow-lg px-2 py-2 flex flex-wrap gap-1">
        @foreach($menuItems as $item)
            <a href="{{ $item['url'] }}"
               class="flex items-center gap-2 px-3 py-2 rounded-xl text-sm font-medium transition-all duration-200
                      {{ $item['active'] 
                         ? 'bg-primary text-white shadow-sm' 
                         : 'text-gray-500 hover:text-gray-900 hover:bg-gray-100' }}">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icons[$item['icon']] }}"/>
                </svg>
                <span class="hidden sm:inline">{{ $item['title'] }}</span>
            </a>
        @endforeach
    </nav>
</div>