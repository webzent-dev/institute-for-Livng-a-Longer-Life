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

<body  x-data="{  sidebarOpen: true,  mobileSidebar: false  }"  class="bg-slate-50 antialiased">


<div class="flex min-h-screen">

    {{-- Sidebar (PRIVATE ONLY) --}}
    <x-dashboard.sidebar.sidebar />

    <div class="flex-1 flex flex-col">

        {{-- Header (PRIVATE ONLY) --}}
        <x-dashboard.sidebar.header1 />

        <main class="flex-1 p-4 md:p-6 overflow-y-auto">
            @yield('content')
        </main>
    </div>
</div>

{{-- Mobile Sidebar --}}
<x-dashboard.sidebar.mobile-sidebar />

<script>lucide.createIcons()</script>
</body>
</html>
