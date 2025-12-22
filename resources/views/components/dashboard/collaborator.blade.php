
<div class="flex min-h-screen">

    {{-- SIDEBAR --}}
    <aside class="w-64 bg-sidebar border-r border-border flex flex-col">
        <div class="h-16 flex items-center gap-2 px-6 border-b">
            <img src="/logo.png" class="h-8" />
            <span class="font-semibold">Collaborator Portal</span>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-2">
            <a class="flex items-center gap-3 px-3 py-2 rounded-lg bg-green-50 text-green-600">
                Dashboard
            </a>
            <a class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100">
                My Products
            </a>
            <a class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100">
                Orders
            </a>
            <a class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100">
                My Courses
            </a>
            <a class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100">
                Profile
            </a>
        </nav>

        <div class="px-6 py-4 border-t text-sm text-muted">
            Logout
        </div>
    </aside>

    {{-- MAIN --}}
    <div class="flex-1 flex flex-col">

        {{-- HEADER --}}
        <header class="h-16 flex items-center px-8 border-b bg-white">
            <h1 class="text-lg font-semibold">Collaborator Portal</h1>
        </header>

        {{-- CONTENT --}}
        <main class="flex-1 p-8">
            @yield('content')
        </main>

    </div>
</div>



{{-- <x-sidebar.provider>
    <div class="flex min-h-screen w-full bg-background">
        <x-collaborator.sidebar />

        <div class="flex-1 flex flex-col">
            <header class="h-16 flex items-center border-b px-6 bg-background">
                <x-sidebar.trigger class="mr-4"/>
                <h2 class="text-xl font-semibold">
                    @yield('title')
                </h2>
            </header>

            <main class="flex-1 p-6 sm:p-8 bg-gradient-subtle">
                @yield('content')
            </main>
        </div>
    </div>
</x-sidebar.provider> --}}
