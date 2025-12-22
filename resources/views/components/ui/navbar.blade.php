<header class="h-16 bg-white dark:bg-gray-800 shadow flex items-center justify-between px-6">

    {{-- Sidebar toggle --}}
    <button @click="sidebar.toggle()" class="p-2">
        <i data-lucide="menu"></i>
    </button>

    {{-- Search --}}
    <div class="relative w-96">
        <input 
            type="text" 
            placeholder="Search…" 
            class="w-full border rounded-lg px-4 py-2 dark:bg-gray-700 dark:border-gray-600"
            x-model="search.query"
        >
    </div>

    <div class="flex items-center space-x-4">

        {{-- Theme Switch --}}
        {{-- <x-ui.theme-switch /> --}}

        {{-- Notifications Icon --}}
        <button @click="notifications.toggle()" class="relative">
            <i data-lucide="bell"></i>
            <span 
                x-show="notifications.items.length"
                class="absolute -top-1 -right-1 w-3 h-3 bg-red-500 rounded-full"
            ></span>
        </button>

        {{-- Profile menu --}}
        <div class="relative" x-data="{ open: false }">

            <button @click="open = !open" class="flex items-center space-x-2">
                <img src="https://i.pravatar.cc/40" class="rounded-full w-8 h-8">
                <span>John Doe</span>
            </button>

            <div 
                class="absolute right-0 mt-2 bg-white shadow-lg rounded-lg w-48 p-2 dark:bg-gray-700"
                x-show="open"
            >
                <a class="block p-2 hover:bg-gray-100 dark:hover:bg-gray-600">Profile</a>
                <a class="block p-2 hover:bg-gray-100 dark:hover:bg-gray-600">Settings</a>
                <a class="block p-2 hover:bg-gray-100 dark:hover:bg-gray-600">Logout</a>
            </div>

        </div>

    </div>

</header>
{{-- how to use --}}

{{-- <x-ui.navbar /> --}}