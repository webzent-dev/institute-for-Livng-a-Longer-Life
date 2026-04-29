@extends('front.layouts.app')
@section('content')
<div class="antialiased min-h-screen flex flex-col">
    <div class="mt-8 sticky ">
        @include('member.member-top-menu')
    </div>
    <div class="flex-1 bg-white">
        <main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pb-8">
            @yield('member-content')
        </main>
    </div>
</div>
<script>lucide.createIcons();</script>
@endsection