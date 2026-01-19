
@php
    $logo = DB::table('web_settings')->where('id', 1)->first();
@endphp
<nav class="sticky top-0 z-50 bg-white/80 backdrop-blur-lg border-b border-gray-200 shadow">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center h-20">
      <!-- Logo -->
      <a href="{{ url('/') }}" class="flex items-center group">
        <img
          src="{{ asset('storage/'.$logo->logo) }}"
          alt="Institute for Living Longer"
          class="h-16 w-auto group-hover:scale-105 transition-transform"
        />
      </a>

      <!-- Desktop Navigation -->

      <div class="sm:hidden lg:flex items-center gap-2">
        <a href="{{ url('/') }}" class="px-4 py-2 text-md font-medium rounded-md {{ request()->is('/') ? 'text-primary' : 'hover:bg-accent' }}">Home</a>

        {{-- About dropdown --}}
        <div class="relative group">
                <button
                    type="button"
                    class="flex items-center px-4 py-2 text-sm font-medium rounded-md
                    {{ request()->is('about*') || request()->is('collaborators') ? 'text-primary' : 'hover:bg-accent' }}">

                    About
                    <i data-lucide="chevron-down" class="ml-1 h-4 w-4"></i>
                </button>

                <div class="absolute hidden group-hover:block bg-white border border-gray-200 rounded-md shadow-lg w-56">

                    <a href="{{ url('/about-dr-zeines') }}"
                    class="block px-4 py-2 text-sm
                    {{ request()->is('about-dr-zeines') ? 'text-primary' : 'hover:bg-gray-100' }}">
                    About Dr. Zeines
                    </a>

                    <a href="/collaborators"
                    class="block px-4 py-2 text-sm
                    {{ request()->is('collaborators') ? 'text-primary' : 'hover:bg-gray-100' }}">
                    Our Collaborators
                    </a>

                </div>
        </div>


        <a href="{{ url('/intro-videos') }}" class="px-4 py-2 text-sm font-medium rounded-md {{ request()->is('intro-videos') ? 'text-primary' : 'hover:bg-accent' }}">Intro Videos</a>
        <a href="{{ url('/vital-boost') }}" class="px-4 py-2 text-sm font-medium rounded-md {{ request()->is('vital-boost') ? 'text-primary' : 'hover:bg-accent' }}">Vital Boost</a>
        <a href="{{ url('/shop') }}" class="px-4 py-2 text-sm font-medium rounded-md {{ request()->is('shop') ? 'text-primary' : 'hover:bg-accent' }}">Store</a>
        {{-- <a href="{{ url('/shop') }}" class="px-4 py-2 text-sm font-medium rounded-md  hover:bg-accent active:bg-lime-600">Store</a> --}}
        <a href="{{ url('/contact') }}" class="px-4 py-2 text-sm font-medium rounded-md {{ request()->is('contact') ? 'text-primary' : 'hover:bg-accent' }}">Contact Us</a>
        <a href="{{ url('/testimonials') }}" class="px-4 py-2 text-sm font-medium rounded-md  {{ request()->is('testimonials') ? 'text-primary' : 'hover:bg-accent' }}">Testimonials</a>

        <a href="{{ url('/cart') }}" class="relative px-3 py-2 bg-primary {{ request()->is('cart') ? 'text-primary' : 'hover:bg-accent' }} rounded-md">
          <i data-lucide="shopping-cart" class="h-5 w-5"></i>
          <span class="absolute -top-1 -right-1 bg-gradient-to-r from-green-500 to-orange-400 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">0</span>
        </a>

          @guest
              {{-- LOGIN BUTTON FOR GUEST --}}
              <a href="{{ url('/auth') }}"
                class="ml-4 px-4 py-2 border border-gray-300 rounded-md hover:bg-primary flex items-center {{ request()->is('auth') ? 'text-primary' : 'hover:bg-accent' }}">
                  <i data-lucide="log-in" class="mr-2 h-5 w-5"></i>
                  Login
              </a>
          @endguest

            @auth
                {{-- SHOW USER DROPDOWN ONLY IF ROLE = user --}}
                @if(auth()->user()->role === 'user')
                    <div x-data="{ open: false }" class="relative ml-4">

                        <!-- USER BUTTON -->
                        <button
                            @click="open = !open"
                            class="px-4 py-2 border border-gray-300 rounded-md hover:bg-emerald-500 flex items-center"
                        >
                            <i data-lucide="user" class="mr-2 h-5 w-5"></i>
                            {{ auth()->user()->first_name }}
                            <i data-lucide="chevron-down" class="ml-2 h-4 w-4"></i>
                        </button>

                        <!-- DROPDOWN -->
                        <div
                            x-show="open"
                            @click.outside="open = false"
                            x-transition
                            class="absolute right-0 mt-2 w-44 bg-white border rounded-md shadow-md z-50"
                        >

                            {{-- USER MENU --}}
                            <a href="#"
                              class="block px-4 py-2 hover:bg-gray-100">
                                User Dashboard
                            </a>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button
                                    type="submit"
                                    class="w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100"
                                >
                                    Logout
                                </button>
                            </form>

                        </div>
                    </div>
                @endif

                {{-- SHOW LOGIN BUTTON FOR ADMIN --}}
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}"
                      class="ml-4 px-4 py-2 border border-gray-300 rounded-md hover:bg-primary flex items-center">
                        <i data-lucide="grid" class="mr-2 h-5 w-5"></i>
                        Admin Dashboard
                    </a>
                @endif
            @endauth




            <a href="{{ url('/membership') }}" class="ml-4 px-5 py-2 rounded-md bg-primary text-white font-semibold hover:opacity-90">
              Get Membership
            </a>
          </div>

          <!-- Mobile Menu Button -->
          <button id="menu-toggle" class="lg:hidden p-2 rounded-lg hover:bg-gray-100 transition-colors" aria-expanded="false" aria-controls="mobile-menu">
            <i data-lucide="menu" class="h-6 w-6"></i>
          </button>
    </div>

    <!-- Mobile Navigation -->
    <div id="mobile-menu" class="hidden lg:hidden py-4 border-t border-gray-200" aria-hidden="true">
      <div class="flex flex-col space-y-2">
        <a href="{{ url('/') }}" class="px-4 py-2 rounded-md hover:bg-gray-100 {{ request()->is('/') ? 'text-primary' : 'hover:bg-accent' }}">Home</a>
        <a href="{{ url('/about-dr-zeines') }}" class="px-4 py-2 rounded-md hover:bg-gray-100 {{ request()->is('about-dr-zeines') ? 'text-primary' : 'hover:bg-accent' }}">About Dr. Zeines</a>
        <a href="{{ url('/collaborators') }}" class="px-4 py-2 rounded-md hover:bg-gray-100 {{ request()->is('collaborators') ? 'text-primary' : 'hover:bg-accent' }}">Our Collaborators</a>
        <a href="{{ url('/intro-videos') }}" class="px-4 py-2 rounded-md hover:bg-gray-100 {{ request()->is('intro-videos') ? 'text-primary' : 'hover:bg-accent' }}">Intro Videos</a>
        <a href="{{ url('/vital-boost') }}" class="px-4 py-2 rounded-md hover:bg-gray-100 {{ request()->is('vital-boost') ? 'text-primary' : 'hover:bg-accent' }}">Vital Boost</a>
        <a href="{{ url('/shop') }}" class="px-4 py-2 rounded-md hover:bg-gray-100 {{ request()->is('shop') ? 'text-primary' : 'hover:bg-accent' }}">Store</a>
        <a href="{{ url('/contact') }}" class="px-4 py-2 rounded-md hover:bg-gray-100 {{ request()->is('contact') ? 'text-primary' : 'hover:bg-accent' }}">Contact Us</a>
        <a href="{{ url('/testimonials') }}" class="px-4 py-2 rounded-md hover:bg-gray-100 {{ request()->is('testimonials') ? 'text-primary' : 'hover:bg-accent' }}">Testimonials</a>
        <a href="{{ url('/cart') }}" class="px-4 py-2 rounded-md hover:bg-gray-100 flex items-center {{ request()->is('cart') ? 'text-white' : 'hover:bg-accent' }}">
          <i data-lucide="shopping-cart" class="mr-2 h-5 w-5"></i> Cart
          <span class="ml-auto bg-gradient-to-r from-green-500 to-orange-400 text-white text-xs rounded-full px-2 py-0.5">2</span>
        </a>
        <a href="{{ url('/auth') }}" class="w-full mt-4 border border-gray-300 px-4 py-2 rounded-md flex items-center justify-center hover:bg-gray-100 {{ request()->is('auth') ? 'text-primary' : 'hover:bg-accent' }}">
          <i data-lucide="log-in" class="mr-2 h-5 w-5"></i> Login
        </a>
        <a href="{{ url('/membership') }}" class="w-full mt-2 bg-gradient-to-r from-orange-500 to-green-500 text-white font-semibold px-4 py-2 rounded-md text-center hover:opacity-90 {{ request()->is('membership') ? 'text-primary' : 'hover:bg-accent' }}">
          Get Membership
        </a>
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




