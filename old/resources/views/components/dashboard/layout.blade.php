{{-- <div class="min-h-screen bg-gray-100 flex"> --}}
    
     
    {{-- <x-ui.sidebar />

    <div class="flex-1 flex flex-col"> --}}
        
       
        {{-- <x-ui.navbar /> --}}

        {{-- MAIN CONTENT --}}
        {{-- <main class="p-6">
            {{ $slot }}
        </main>

    </div>

</div> --}}


<div 
    x-data="dashboardLayout()" 
    class="min-h-screen flex bg-gray-100 text-gray-900"
    x-bind:class="{ 'dark bg-gray-900 text-gray-100': theme.dark }"
>

    {{-- Sidebar --}}
    <x-ui.sidebar />

    <div class="flex-1 flex flex-col">

         
        <x-ui.navbar />

        {{-- Toast Notifications --}}
        <x-ui.toast />

        {{-- Notifications Panel --}}
        <x-ui.notifications />

        {{-- Page Content --}}
        <main class="p-6">
            {{ $slot }}
        </main>
    </div>

</div>

{{-- Scripts --}}
<script src="/js/alpine-global.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="/js/chart-setup.js"></script>

{{-- <script>
    function dashboardLayout() {
        return {
            theme: {
                dark: false,
            },
            init() {
                // Initialize theme based on user preference or system settings
                this.theme.dark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
            },
        }
    }
</script>    --}}








{{-- how to use --}}

{{-- <x-dashboard.layout>
    <h1 class="text-2xl font-semibold">Dashboard</h1>
</x-dashboard.layout> --}}


{{-- <x-dashboard.layout>
    <h1 class="text-2xl font-bold mb-4">Dashboard Content Here</h1>
    <p>Welcome to the dashboard!</p>
</x-dashboard.layout> --> -->


