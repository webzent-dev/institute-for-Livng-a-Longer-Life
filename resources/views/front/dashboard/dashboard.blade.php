<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/alpinejs" defer></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

@if (session('success'))
<div 
    x-data="{ show: true }"
    x-init="setTimeout(() => show = false, 3000)"
    x-show="show"
    x-transition
    class="fixed top-5 right-5 bg-green-600 text-white px-5 py-3 rounded-lg shadow-lg z-50"
>
    {{ session('success') }}
</div>
@endif

<body  x-data="{  sidebarOpen: true,  mobileSidebar: false  }"  class="bg-slate-50 antialiased">


<div class="flex min-h-screen">

   
    <x-dashboard.sidebar.sidebar />

    <div class="flex-1 flex flex-col">

       
        <x-dashboard.sidebar.header />

        <main class="flex-1 p-4 md:p-6 overflow-y-auto">
            @yield('content')
            
        </main>
    </div>
</div>

 
<x-dashboard.sidebar.mobile-sidebar />

<script>lucide.createIcons()</script>
</body>
</html>
