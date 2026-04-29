<div x-show="mobileSidebar" 
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-300"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-50 md:hidden">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" @click="mobileSidebar=false"></div>

    <aside x-transition:enter="transition ease-out duration-300"
           x-transition:enter-start="-translate-x-full"
           x-transition:enter-end="translate-x-0"
           x-transition:leave="transition ease-in duration-300"
           x-transition:leave-start="translate-x-0"
           x-transition:leave-end="-translate-x-full"
           class="relative w-64 bg-white h-full shadow-xl">
        {{-- <x-nav.menu /> --}}
         <x-dashboard.sidebar.menu />
    </aside>
</div>
