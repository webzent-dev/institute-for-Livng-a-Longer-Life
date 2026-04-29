
<header class="sticky top-0 z-10 bg-white/80 backdrop-blur-sm border-b border-slate-200 px-4 py-3 md:px-2">
    <div class="flex items-center justify-between">

        {{-- Left --}}
        <div class="flex items-center ">
            <button @click="sidebarOpen = !sidebarOpen" class="hidden md:flex items-center justify-center p-2 rounded-lg hover:bg-primary hover:text-white transition" >
                    <i data-lucide="panel-left" class="w-5 h-5 "></i>
                </button>


            <div class="ml-4 ">
                <h1 class=" text-left text-xl font-semibold self-center mt-3 ">{{ ucfirst(auth()->user()->role) }} Dashboard</h1>

            </div>
        </div>

    </div>
</header>

