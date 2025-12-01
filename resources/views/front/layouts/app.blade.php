<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Living Longer Institute')</title>
     
    {{-- Fonts --}}
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700&display=swap" rel="stylesheet" />
 <link href="{{ asset('vendor/bladewind/css/animate.min.css') }}" rel="stylesheet" />
 <link href="{{ asset('vendor/bladewind/css/bladewind-ui.min.css') }}" rel="stylesheet" />
 <script src="{{ asset('vendor/bladewind/js/helpers.js') }}"></script>
 <script src="https://cdn.jsdelivr.net/npm/@tailwindplus/elements@1" type="module"></script> 
    {{-- Load Vite compiled CSS & JS --}}
     @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="{{ asset('js/validators.js') }}"></script>
    <script src="{{ asset('js/formEngine.js') }}"></script>
    <script src="{{ asset('js/membershipForm.js') }}"></script>
    <script src="{{ asset('js/contactForm.js') }}"></script>
    <script src="{{ asset('js/login.js') }}"></script>

{{-- cdn --}}
    <script src="https://unpkg.com/embla-carousel/embla-carousel.umd.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/alpinejs" defer></script>
 <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

 <style>
        /* Remove default Leaflet styles */
        .leaflet-control-attribution,
        .leaflet-control-attribution a {
            display: none !important;
        }
    </style>

</head>
<script src="//unpkg.com/alpinejs" defer></script>
<body class="antialiased">

    @include('front.layouts.header')

    @yield('content')

    @include('front.layouts.footer')
 

    <script src="https://unpkg.com/lucide@latest"></script>
    <script> lucide.createIcons(); </script>
 <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
 
</body>

</html>
