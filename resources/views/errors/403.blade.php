@extends('front.layouts.app') {{-- ya jo bhi aapka main layout hai --}}

@section('title', 'Unauthorized Access')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-gray-100 text-center px-4">
    <h1 class="text-6xl font-bold text-red-600 mb-4">403</h1>
    <h2 class="text-2xl font-semibold mb-4">Unauthorized Access</h2>
    <p class="mb-6 text-gray-700">
        You do not have permission to access this page.
    </p>
    <a href="{{ url('/') }}" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
        Go to Home
    </a>
</div>
@endsection