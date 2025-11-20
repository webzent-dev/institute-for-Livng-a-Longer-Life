<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Living Longer Institute')</title>

    {{-- Fonts --}}
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700&display=swap" rel="stylesheet" />
 

    {{-- Load Vite compiled CSS & JS --}}
     @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased">

    @include('front.layouts.header')

    @yield('content')

    @include('front.layouts.footer')
 

    <script src="https://unpkg.com/lucide@latest"></script>
    <script> lucide.createIcons(); </script>

</body>
</html>
