<div x-show="open" class="fixed inset-0 z-50 md:hidden">
    <div class="absolute inset-0 bg-black/40" @click="open=false"></div>

    <aside class="relative w-64 bg-white h-full shadow-xl">
        {{-- <x-nav.menu /> --}}
         <x-dashboard.sidebar.menu />
    </aside>
</div>
