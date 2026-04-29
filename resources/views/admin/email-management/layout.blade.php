<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Email Management')</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Make sure jQuery is available and prevent conflicts
        window.jQuery = window.$ = jQuery;
        console.log('jQuery loaded from CDN:', typeof jQuery !== 'undefined');
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/alpinejs" defer></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- TinyMCE CSS -->
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
</head>
@if (session('success'))
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition class="fixed top-5 right-5 bg-green-600 text-white px-5 py-3 rounded-lg shadow-lg z-50">
        {{ session('success') }}
    </div>
@endif
<body x-data="{ sidebarOpen: true, mobileSidebar: false }" class="bg-slate-50 antialiased">
<div class="flex min-h-screen">
    <x-dashboard.sidebar.sidebar />
    <div class="flex-1 flex flex-col">
        <x-dashboard.sidebar.header />
        
        @if(auth()->user()->isAdmin())
            <div class="space-y-6 flex-1 p-8 bg-gradient-subtle">
                @yield('content')
            </div>
        @endif
    </div>
</div>
<script>lucide.createIcons()</script>

<!-- Fallback jQuery loading -->
<script>
if (typeof jQuery === 'undefined') {
    console.log('jQuery not loaded, trying fallback...');
    var script = document.createElement('script');
    script.src = 'https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js';
    script.onload = function() {
        console.log('Fallback jQuery loaded:', typeof jQuery !== 'undefined');
        window.jQuery = window.$ = jQuery;
    };
    document.head.appendChild(script);
}
</script>

<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
@stack('scripts')
</body>
</html>
