<aside x-show="sidebarOpen" x-transition class="hidden md:flex flex-col w-64 bg-white border-r border-slate-200 sticky top-0 h-screen">
    <div class="p-6 border-b border-slate-100 sticky top-0 bg-white z-10">
        <div class="flex items-center space-x-3">
            <div class="w-16 h-16 flex items-center justify-center">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="w-full h-full object-contain">
                </a>
            </div>
            <span class="ml-2 font-semibold text-slate-800">
                Welcome back <br><span class="text-primary">{{ auth()->user()->first_name . ' ' . auth()->user()->last_name }}</span>
            </span>
        </div>
    </div>
    <x-dashboard.sidebar.menu />
    <div class="mt-auto p-1 border-t-2 border-slate-100 bg-zinc-50 z-10">
        <x-button-use label="Logout" variant="outline" href="{{ route('logout') }}" method="post" icon="log-out" class="confirm w-full mt-4" onclick="return confirm('Are you sure you want to logout?')"/>
    </div>
</aside>