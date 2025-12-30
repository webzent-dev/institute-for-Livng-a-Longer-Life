{{-- <aside class="hidden md:flex flex-col w-64 bg-white border-r border-slate-200 sticky top-0 h-screen"> --}}
<aside
    x-show="sidebarOpen"
    x-transition
    class="hidden md:flex flex-col w-64 bg-white border-r border-slate-200 sticky top-0 h-screen"
>
    {{-- Logo --}}
    <div class="p-6 border-b border-slate-100 sticky top-0 bg-white z-10">
        <div class="flex items-center space-x-3">
            <div class="w-16 h-16 flex items-center justify-center">
                
                {{-- <a href="{{ route('/') }}"> --}}
                <a href="/">
                    <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="w-full h-full object-contain">
                </a>
                
            </div>
            <span class="ml-2 font-semibold text-slate-800">
            Welcome back <br><span class="text-primary">{{ auth()->user()->first_name . ' ' . auth()->user()->last_name }}</span>
            </span>
        </div>
    </div>

    {{-- Navigation --}}
   <x-dashboard.sidebar.menu />

    {{-- Profile --}}
    <div class="p-1 border-t border-slate-100 sticky bottom-0 bg-white z-10">
        <div class="flex items-center space-x-3 p-3 rounded-xl hover:bg-slate-50">
            {{-- <x-button-use size="sm" :label="strtoupper(substr(auth()->user()->name,0,2))" class="w-10 h-10 rounded-full bg-gradient-to-r from-green-500 to-amber-700 flex items-center justify-center text-white font-semibold"/> --}}
                
                    {{-- Logout Button--}}

                    <x-button-use
                        size="sm"
                        label="Logout"
                        variant="outline"
                        href="{{ route('logout') }}"
                        method="post"
                        icon="log-out"
                        class="confirm px-10"
                        onclick="return confirm('Are you sure you want to logout?')"
                    />



            {{-- <div class="w-10 h-10 rounded-full bg-gradient-to-r from-green-500 to-amber-700
                        flex items-center justify-center text-white font-semibold">
                DRZ
                {{ strtoupper(substr(auth()->user()->name,0,2)) }}
            </div>
            <div class="min-w-0">
                <p class="font-medium truncate text-primary">{{ auth()->user()->name }}</p>
                <p class="text-sm text-slate-500 truncate">{{ auth()->user()->email }}</p>
                <p class="font-medium truncate">{{ auth()->user()->name }}</p>
                <p class="text-sm text-slate-500 truncate">{{ auth()->user()->email }}</p>
            </div> --}}
        </div>
    </div>
</aside>
 