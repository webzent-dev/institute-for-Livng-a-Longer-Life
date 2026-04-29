@php
$webSettingData = DB::table('web_settings')->first();
$siteSettingData = DB::table('site_settings')->first();
$locations = DB::table('locations')->where('status','active')->get();
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="base-url" content="{{ url('/') }}">
    <title>@yield('title', 'Living Longer Institute')</title>
    @if(!empty($webSettingData->favicon) && file_exists(public_path('uploads/'.$webSettingData->favicon)))
        <link rel="icon" type="image/png" href="{{ asset('uploads/'.$webSettingData->favicon) }}">
    @else   
        <link rel="icon" type="image/png" href="{{ asset('assets/logo.png') }}">
    @endif
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindplus/elements@1" type="module"></script>
    {{-- Load Vite compiled CSS & JS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- <link rel="stylesheet" href="{{ asset('build/assets/app-Bz59QJus.css') }}">
    <script src="{{ asset('build/assets/app-ovrmPlgd.js') }}" defer></script> --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/common.js') }}"></script>
    <script src="{{ asset('js/validators.js') }}"></script>
    <script src="{{ asset('js/formEngine.js') }}"></script>
    <script src="{{ asset('js/membershipForm.js') }}"></script>
    <script src="{{ asset('js/contactForm.js') }}"></script>
    <script src="{{ asset('js/login.js') }}"></script>
    {{-- cdn --}}
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/embla-carousel/embla-carousel.umd.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/alpinejs" defer></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
    /* Remove default Leaflet styles for Location map */
    .leaflet-control-attribution,
    .leaflet-control-attribution a {
        display: none !important;
    }
    </style>
    <link rel="stylesheet" href="{{asset('css/toastr.min.css')}}"/>
    <script src="{{asset('js/toastr.min.js')}}"></script>
</head>
<script src="//unpkg.com/alpinejs" defer></script>
<body class="antialiased">
    @include('front.layouts.header')
    @yield('content')
    @include('front.layouts.footer')
    <script src="https://unpkg.com/lucide@latest"></script>
    <script> lucide.createIcons(); </script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    @include('admin.toastr_notification')
</body>
</html>