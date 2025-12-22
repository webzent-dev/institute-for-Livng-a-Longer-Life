{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Member Area' }}</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="bg-slate-50 min-h-screen"> --}}

@extends('front.layouts.app')
 
@section('content')
    {{-- Member Tabs --}}
    <x-dashboard.sidebar.member_tabs/>

    {{-- Page Content --}}
    <main class="max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')
    </main>

@endsection    
{{-- </body>
</html> --}}
