<div class="flex flex-col h-full">
    <!-- Logo -->
    <div class="p-6 border-b border-slate-100">
        <div class="flex items-center space-x-3">
            <div class="w-8 h-8 rounded-lg bg-primary-600 flex items-center justify-center">
                <span class="text-white font-bold">N</span>
            </div>
            <span class="text-xl font-semibold text-slate-800">Nexus</span>
        </div>
    </div>

    <!-- Dynamic Navigation -->
    <nav class="flex-1 p-4 space-y-1">
        @php $links = $user->canAccess('dashboard') ? [['icon' => 'layout-dashboard', 'text' => 'Dashboard', 'route' => 'dashboard', 'active' => request()->routeIs('dashboard')] : []; @endphp
        @if($user->canAccess('users')) $links[] = ['icon' => 'users', 'text' => 'Users', 'route' => 'users', 'active' => request()->routeIs('users')]; @endif
        @if($user->canAccess('analytics')) $links[] = ['icon' => 'bar-chart-3', 'text' => 'Analytics', 'route' => 'analytics', 'active' => request()->routeIs('analytics')]; @endif
        @if($user->canAccess('reports')) $links[] = ['icon' => 'file-text', 'text' => 'Reports', 'route' => 'reports', 'active' => request()->routeIs('reports')]; @endif
        @if($user->canAccess('settings')) $links[] = ['icon' => 'settings', 'text' => 'Settings', 'route' => 'settings', 'active' => request()->routeIs('settings')]; @endif

        @foreach($links as $link)
            <x-nav-link :href="route($link['route'])" :active="$link['active']" :icon="$link['icon']" :text="$link['text']" />
        @endforeach
    </nav>

    <!-- User Profile -->
    <div class="p-4 border-t border-slate-100">
        <div class="flex items-center space-x-3 p-3 rounded-xl hover:bg-slate-50">
            <div class="w-10 h-10 rounded-full bg-gradient-to-r from-primary-500 to-primary-700 flex items-center justify-center text-white font-semibold">
                {{ substr($user->name, 0, 2) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="font-medium text-slate-800 truncate">{{ $user->name }}</p>
                <p class="text-sm text-slate-500 truncate">{{ $user->email }}</p>
            </div>
        </div>
    </div>
</div>





// {{-- @props([
//     'side' => 'left',
//     'variant' => 'sidebar',
//     'collapsible' => 'offcanvas'
// ])

<!-- Desktop -->
<aside
    x-show="!$store.sidebar.isMobile"
    :data-state="$store.sidebar.open ? 'expanded' : 'collapsed'"
    data-variant="{{ $variant }}"
    data-side="{{ $side }}"
    data-collapsible="{{ $collapsible }}"
    class="
        fixed inset-y-0 z-30 hidden md:flex
        transition-all duration-200 ease-linear
        bg-sidebar text-sidebar-foreground
        {{ $side === 'left' ? 'left-0' : 'right-0' }}
        group-data-[state=collapsed]:w-[3rem]
        w-[16rem]
    "
>



    <div class="flex h-full w-full flex-col">
        {{ $slot }}
    </div>
</aside>

<!-- Mobile -->
<div
    x-show="$store.sidebar.isMobile && $store.sidebar.mobileOpen"
    class="fixed inset-0 z-40 bg-black/50"
    @click="$store.sidebar.mobileOpen = false"
></div>

<aside
    x-show="$store.sidebar.isMobile && $store.sidebar.mobileOpen"
    class="fixed inset-y-0 left-0 z-50 w-[18rem] bg-sidebar text-sidebar-foreground"
>
    {{ $slot }}
</aside>
