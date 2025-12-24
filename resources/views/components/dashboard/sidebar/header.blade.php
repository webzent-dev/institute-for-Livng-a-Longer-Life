
<header class="sticky top-0 z-10 bg-white/80 backdrop-blur-sm border-b border-slate-200 px-4 py-3 md:px-2">
    <div class="flex items-center justify-between">

        {{-- Left --}}
        <div class="flex items-center ">
            <button @click="sidebarOpen = !sidebarOpen" class="hidden md:flex items-center justify-center p-2 rounded-lg hover:bg-primary hover:text-white transition" >
                    <i data-lucide="panel-left" class="w-5 h-5 "></i>
                </button>

            {{-- <button @click="open = true" class="md:hidden p-2 rounded-lg hover:bg-slate-100">
                <i data-lucide="menu" class="w-5 h-5"></i>
            </button> --}}

            <div class="ml-6 ">
                <h1 class=" text-left text-xl font-semibold self-center ">Admin Portal</h1>
                {{-- <p class="text-sm text-slate-500 hidden md:block"> --}}
                    {{-- Welcome back, {{ $user->name }}. Here's what's happening today. --}}
                    {{-- Welcome back, Dr. Zeines Here's what's happening today. --}}
                {{-- </p> --}}
            </div>
        </div>

        {{-- Right --}}
        <div class="flex items-center space-x-3">
            <div class="hidden md:flex bg-slate-100 rounded-xl px-4 py-2">
                <i data-lucide="search" class="w-4 h-4 text-slate-400 mr-2"></i>
                <input class="bg-transparent text-sm outline-none" placeholder="Search...">
            </div>

            <button class="relative p-2 rounded-lg hover:bg-slate-100">
                <i data-lucide="bell" class="w-5 h-5"></i>
                <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
            </button>
        </div>
    </div>
</header>






{{-- <div class="flex items-center justify-between">
    <div class="flex items-center space-x-4">
        <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden p-2 rounded-lg hover:bg-slate-100">
            <i data-lucide="menu" class="w-5 h-5"></i>
        </button>
        <div>
            <h1 class="text-xl font-semibold text-slate-800">{{ ucfirst(request()->route()->getName()) ?: 'Dashboard' }}</h1>
            <p class="text-sm text-slate-500 hidden md:block">Welcome back, {{ $user->name }}. Here's what's happening today.</p>
        </div>
    </div>

    <div class="flex items-center space-x-3">
        <!-- Search (hidden on mobile) -->
        <div class="hidden md:flex items-center bg-slate-100 rounded-xl px-4 py-2">
            <i data-lucide="search" class="w-4 h-4 text-slate-400 mr-2"></i>
            <input type="text" placeholder="Search..." class="bg-transparent border-none focus:outline-none text-sm w-48">
        </div>

        <!-- Notifications -->
        <button class="relative p-2 rounded-lg hover:bg-slate-100">
            <i data-lucide="bell" class="w-5 h-5"></i>
            <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
        </button>

        <!-- Profile Dropdown (responsive) -->
        <div class="hidden md:flex items-center space-x-2 p-2 rounded-xl hover:bg-slate-100 cursor-pointer">
            <div class="w-9 h-9 rounded-full bg-gradient-to-r from-primary-500 to-primary-700 flex items-center justify-center text-white font-semibold">
                {{ substr($user->name, 0, 2) }}
            </div>
            <div class="hidden lg:block">
                <p class="font-medium text-sm text-slate-800">{{ $user->name }}</p>
                <p class="text-xs text-slate-500">{{ ucfirst($user->role) }}</p>
            </div>
            <i data-lucide="chevron-down" class="w-4 h-4 text-slate-500 hidden lg:block"></i>
        </div>
        <!-- Mobile Profile -->
        <div class="md:hidden">
            <div class="w-9 h-9 rounded-full bg-gradient-to-r from-primary-500 to-primary-700 flex items-center justify-center text-white font-semibold text-sm">
                {{ substr($user->name, 0, 2) }}
            </div>
        </div>
    </div>
</div> --}}