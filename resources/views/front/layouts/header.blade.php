<nav class="sticky top-0 z-50 bg-white/80 backdrop-blur-lg border-b border-gray-200 shadow">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            <!-- Logo -->
            <a href="{{ url('/') }}" class="flex items-center group">
                @if(!empty($webSettingData->logo) && file_exists(public_path('uploads/'.$webSettingData->logo)))
                    <img src="{{ asset('uploads/'.$webSettingData->logo) }}" alt="{{$webSettingData->tagline}}" class="h-16 w-auto group-hover:scale-105 transition-transform"/>
                @else
                    <img src="{{ asset('assets/logo.png') }}" alt="Institute for Living Longer" class="h-16 w-auto group-hover:scale-105 transition-transform"/>
                @endif
            </a>

            <!-- Desktop Navigation -->
            <div class="hidden lg:flex items-center gap-2 desktop">
                <a href="{{ url('/') }}" class="px-4 py-2 text-md font-medium rounded-md {{ request()->is('/') ? 'bg-secondary hover:bg-secondary/80 text-secondary-foreground' : 'hover:bg-accent hover:text-accent-foreground' }}">Home</a>
                {{-- About dropdown --}}
                <div class="relative group">
                    <button type="button" class="flex items-center px-4 py-2 text-sm font-medium rounded-md {{ request()->is('about*') || request()->is('collaborators') ? 'bg-secondary hover:bg-secondary/80 text-secondary-foreground' : 'hover:bg-accent hover:text-accent-foreground'}}">
                        About
                        <i data-lucide="chevron-down" class="ml-1 h-4 w-4"></i>
                    </button>

                    <div class="absolute hidden group-hover:block bg-white border border-gray-200 rounded-md shadow-lg w-56">
                        <a href="{{ url('/about-dr-zeines') }}" class="block px-4 py-2 text-sm m-1 rounded-sm{{ request()->is('about-dr-zeines') ? 'bg-secondary hover:bg-secondary/80 text-secondary-foreground' : 'hover:bg-accent hover:text-accent-foreground' }}">
                            About Dr. Zeines
                        </a>
                        <a href="{{ url('/collaborators') }}" class="block px-4 py-2 text-sm m-1 rounded-sm
                            {{ request()->is('collaborators') ? 'bg-secondary hover:bg-secondary/80 text-secondary-foreground' : 'hover:bg-accent hover:text-accent-foreground' }}">
                            Our Collaborators
                        </a>
                    </div>
                </div>
                <a href="{{ url('/intro-videos') }}" class="px-4 py-2 text-sm font-medium rounded-md {{ request()->is('intro-videos') ? 'bg-secondary hover:bg-secondary/80 text-secondary-foreground' : 'hover:bg-accent hover:text-accent-foreground' }}">Intro Videos</a>
                <a href="{{ url('/vital-boost') }}" class="px-4 py-2 text-sm font-medium rounded-md {{ request()->is('vital-boost') ? 'bg-secondary hover:bg-secondary/80 text-secondary-foreground' : 'hover:bg-accent hover:text-accent-foreground' }}">Vital Boost</a>
                <a href="{{ url('/shop') }}" class="px-4 py-2 text-sm font-medium rounded-md {{ request()->is('shop') ? 'bg-secondary hover:bg-secondary/80 text-secondary-foreground' : 'hover:bg-accent hover:text-accent-foreground' }}">Store</a>
                <a href="{{ url('/contact') }}" class="px-4 py-2 text-sm font-medium rounded-md {{ request()->is('contact') ? 'bg-secondary hover:bg-secondary/80 text-secondary-foreground' : 'hover:bg-accent hover:text-accent-foreground' }}">Contact Us</a>
                <a href="{{ url('/testimonials') }}" class="px-4 py-2 text-sm font-medium rounded-md  {{ request()->is('testimonials') ? 'bg-secondary hover:bg-secondary/80 text-secondary-foreground' : 'hover:bg-accent hover:text-accent-foreground' }}">Testimonials</a>
                @php ($cartVal = Session::get('cart', []))
                @php ($cartCount = !empty($cartVal)?array_sum($cartVal):0)
                <a href="{{ url('/cart') }}" class="relative px-3 py-2 text-[14px] {{ request()->is('cart') ? 'bg-secondary hover:bg-secondary/80 text-secondary-foreground' : 'hover:bg-accent hover:text-accent-foreground' }} rounded-md">
                    <i data-lucide="shopping-cart" class="h-5 w-5"></i>
                    {{-- <span class="absolute -top-1 -right-1 bg-gradient-to-r from-green-500 to-orange-400 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center" id="cart_count">{{ $cartCount }}</span> --}}
                    <span class="absolute -top-2 -right-1 bg-accent to-orange-400 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center" id="cart_count">{{ $cartCount }}</span>
                </a>

                @guest {{-- LOGIN BUTTON FOR GUEST --}}
                    <x-button-use href="{{ url('/auth') }}" type="button"  label="Login" variant="outline" class="w-1/7 {{ request()->is('auth') ? 'bg-secondary hover:bg-secondary/80 text-foreground' : 'hover:bg-accent hover:text-accent-foreground' }}"  icon="log-in"/>
                @endguest

                @auth
                    {{-- SHOW USER DROPDOWN ONLY IF ROLE = user --}}
                    @if(auth()->user()->role === 'user')
                    <div x-data="{ open: false }" class="relative ml-4">
                        <!-- USER BUTTON -->
                        <button @click="open = !open" class="px-4 py-2 border border-gray-300 rounded-md hover:bg-emerald-500 flex items-center">
                            <i data-lucide="user" class="mr-2 h-5 w-5"></i>
                            {{ auth()->user()->first_name }}
                            <i data-lucide="chevron-down" class="ml-2 h-4 w-4"></i>
                        </button>
                        <!-- DROPDOWN -->

                        <div x-show="open" @click.outside="open = false" x-transition class="absolute right-0 mt-2 w-44 bg-white border rounded-md shadow-md z-50">
                            {{-- USER MENU --}}
                            <a href="{{ route('member.dashboard') }}" class="block px-4 py-2 hover:bg-gray-100">
                                Dashboard
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                    @endif

                    {{-- SHOW LOGIN BUTTON FOR ADMIN --}}
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="ml-4 px-4 py-2 border border-gray-300 rounded-md hover:bg-primary flex items-center">
                            <i data-lucide="grid" class="mr-2 h-5 w-5"></i>Admin
                        </a>
                    @endif

                    @if(auth()->user()->role === 'collaborator')
                        <a href="{{ route('collaborator.dashboard') }}" class="ml-4 px-4 py-2 border border-gray-300 rounded-md hover:bg-primary flex items-center">
                            <i data-lucide="grid" class="mr-2 h-5 w-5"></i>Collaborator
                        </a>
                    @endif
                @endauth
                {{-- Nothing to sell a member whose plan is still running. A cancelled
                     member keeps their benefits until expiry, so they don't see it either. --}}
                @unless(auth()->check() && auth()->user()->membershipIsActive())
                <a href="{{ url('/membership') }}" class="ml-4 px-5 py-2 rounded-md bg-primary text-white font-semibold hover:opacity-90">
                    Get Membership
                </a>
                @endunless
            </div>

            <!-- Mobile Menu Button -->
            <button id="menu-toggle" class="lg:hidden p-2 rounded-lg hover:bg-gray-100 transition-colors" aria-expanded="false" aria-controls="mobile-menu">
                <i data-lucide="menu" class="h-6 w-6"></i>
            </button>
        </div>

        <!-- Mobile Navigation -->
        <div id="mobile-menu" class="hidden lg:hidden py-4 border-t border-gray-200" aria-hidden="true">
            <div class="flex flex-col space-y-2 px-8">
                <a href="{{ url('/') }}" class="px-4 py-2 text-md font-medium rounded-md {{ request()->is('/') ? 'bg-secondary hover:bg-secondary/80 text-secondary-foreground' : 'hover:bg-accent hover:text-accent-foreground' }}">Home</a>
                {{-- About dropdown --}}
                <div class="relative group">
                    <button type="button" class="flex items-center px-4 py-2 text-sm font-medium rounded-md {{ request()->is('about*') || request()->is('collaborators') ? 'bg-secondary hover:bg-secondary/80 text-secondary-foreground' : 'hover:bg-accent hover:text-accent-foreground'}}">
                        About
                        <i data-lucide="chevron-down" class="ml-1 h-4 w-4"></i>
                    </button>
                    <div class="absolute hidden group-hover:block bg-white border border-gray-200 rounded-md shadow-lg w-56">
                        <a href="{{ url('/about-dr-zeines') }}" class="block px-4 py-2 text-sm m-1 rounded-sm {{ request()->is('about-dr-zeines') ? 'bg-secondary hover:bg-secondary/80 text-secondary-foreground' : 'hover:bg-accent hover:text-accent-foreground' }}">
                            About Dr. Zeines
                        </a>
                        <a href="/collaborators" class="block px-4 py-2 text-sm m-1 rounded-sm {{ request()->is('collaborators') ? 'bg-secondary hover:bg-secondary/80 text-secondary-foreground' : 'hover:bg-accent hover:text-accent-foreground' }}">
                            Our Collaborators
                        </a>
                    </div>
                </div>
                <a href="{{ url('/intro-videos') }}" class="px-4 py-2 text-sm font-medium rounded-md {{ request()->is('intro-videos') ? 'bg-secondary hover:bg-secondary/80 text-secondary-foreground' : 'hover:bg-accent hover:text-accent-foreground' }}">Intro Videos</a>
                <a href="{{ url('/vital-boost') }}" class="px-4 py-2 text-sm font-medium rounded-md {{ request()->is('vital-boost') ? 'bg-secondary hover:bg-secondary/80 text-secondary-foreground' : 'hover:bg-accent hover:text-accent-foreground' }}">Vital Boost</a>
                <a href="{{ url('/shop') }}" class="px-4 py-2 text-sm font-medium rounded-md {{ request()->is('shop') ? 'bg-secondary hover:bg-secondary/80 text-secondary-foreground' : 'hover:bg-accent hover:text-accent-foreground' }}">Store</a>
                <a href="{{ url('/contact') }}" class="px-4 py-2 text-sm font-medium rounded-md {{ request()->is('contact') ? 'bg-secondary hover:bg-secondary/80 text-secondary-foreground' : 'hover:bg-accent hover:text-accent-foreground' }}">Contact Us</a>
                <a href="{{ url('/testimonials') }}" class="px-4 py-2 text-sm font-medium rounded-md  {{ request()->is('testimonials') ? 'bg-secondary hover:bg-secondary/80 text-secondary-foreground' : 'hover:bg-accent hover:text-accent-foreground' }}">Testimonials</a>
                

                @guest {{-- LOGIN BUTTON FOR GUEST --}}
                    <x-button-use href="{{ url('/auth') }}" type="button"  label="Login" variant="outline" class="w-1/7 {{ request()->is('auth') ? 'bg-secondary hover:bg-secondary/80 text-foreground' : 'hover:bg-accent hover:text-accent-foreground' }}"  icon="log-in"/>
                @endguest

                @auth
                    {{-- SHOW USER DROPDOWN ONLY IF ROLE = user --}}
                    @if(auth()->user()->role === 'user')
                        <div x-data="{ open: false }" class="relative ml-4">
                            <!-- USER BUTTON -->
                            <button @click="open = !open" class="px-4 py-2 border border-gray-300 rounded-md hover:bg-emerald-500 flex items-center">
                                <i data-lucide="user" class="mr-2 h-5 w-5"></i>
                                {{ auth()->user()->first_name }}
                                <i data-lucide="chevron-down" class="ml-2 h-4 w-4"></i>
                            </button>

                        <!-- DROPDOWN -->
                        <div x-show="open" @click.outside="open = false" x-transition class="absolute right-0 mt-2 w-44 bg-white border rounded-md shadow-md z-50">
                            {{-- USER MENU --}}
                            <a href="#" class="block px-4 py-2 hover:bg-gray-100">User Dashboard</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                    @endif

                    {{-- SHOW LOGIN BUTTON FOR ADMIN --}}
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="ml-4 px-4 py-2 border border-gray-300 rounded-md hover:bg-primary flex items-center">
                            <i data-lucide="grid" class="mr-2 h-5 w-5"></i>Admin Dashboard
                        </a>
                    @endif
                @endauth

                @unless(auth()->check() && auth()->user()->membershipIsActive())
                <a href="{{ url('/membership') }}" class=" px-5 py-2 rounded-md bg-primary text-white font-semibold hover:opacity-90">Get Membership</a>
                @endunless
            </div>
        </div>
   </div>
</nav>
<script>
if (window.lucide) lucide.createIcons();
    // Mobile menu toggle
    (function () {
        const toggleBtn = document.querySelector('#menu-toggle');
        const mobileMenu = document.querySelector('#mobile-menu');
        if (!toggleBtn || !mobileMenu) return;

        let open = false;
        toggleBtn.addEventListener('click', () => {
            open = !open;
            mobileMenu.classList.toggle('hidden', !open);
            toggleBtn.setAttribute('aria-expanded', String(open));
            toggleBtn.querySelector('i').setAttribute('data-lucide', open ? 'x' : 'menu');
            if (window.lucide) lucide.createIcons();
        });

        const aboutBtn = document.querySelector('.group > button');
        const aboutMenu = document.querySelector('.group > div');

        aboutBtn.addEventListener('click', () => {
        aboutMenu.classList.toggle('hidden');
    });
})();
</script>
