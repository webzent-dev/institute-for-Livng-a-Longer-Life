@php
$tabs = [
    'dashboard' => ['icon' => 'grid'],
    'videos' => ['icon' => 'video'],
    'store' => ['icon' => 'shopping-bag'],
    'profile' => ['icon' => 'user'],
    'security' => ['icon' => 'lock'],
    'subscription' => ['icon' => 'credit-card'],
    'orders' => ['icon' => 'package'],
    'payments' => ['icon' => 'dollar-sign'],
];
$tabs1 = [
    'dashboard' => ['icon' => 'grid', 'route' => 'das'],
    'videos' => ['icon' => 'video', 'route' => 'intro-videos'],
    'store' => ['icon' => 'shopping-bag', 'route' => 'member'],
    // 'profile' => ['icon' => 'user', 'route' => '#'],
    'security' => ['icon' => 'lock', 'route' => 'security'],
    'subscription' => ['icon' => 'credit-card', 'route' => 'subscription'],
    'orders' => ['icon' => 'package', 'route' => 'orders'],
    'payments' => ['icon' => 'dollar-sign', 'route' => 'payments'],
];
@endphp

<div class=" sticky top-[72px] bg-gray-50 z-40   shadow-sm">
    <div class="max-w-[1600px] mx-auto px-4 py-3 overflow-x-auto justify-items-center">
        <div class="flex gap-2 min-w-max ">
            @foreach($tabs1 as $key => $tab)
            {{-- @if($tab['route'] == '#') --}}
                <a 
                href="{{ route($tab['route']) }}"
                   class="px-4 py-2 rounded-lg text-sm font-medium
                   {{ request()->routeIs($tab['route']) ? 'bg-emerald-500 text-white' : 'hover:bg-slate-100' }}">
                    {{ ucfirst($key) }}
                </a>
            
                
            {{-- @else
                
          
                <a 
                   href="#"
                   class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium shadow-sm
                   {{ request()->is('member/' . $key) ? 'bg-emerald-500 text-white' : 'hover:bg-slate-100' }}">
                    <i data-lucide="{{ $tab['icon'] }}" class="w-4 h-4"></i>
                    <span>{{ ucfirst($key) }}</span>
                </a>   
            @endif --}}

            @endforeach
        </div>
    </div>
</div>
