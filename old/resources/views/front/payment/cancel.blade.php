@extends('front.layouts.app')
@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <!-- FULL WIDTH CONTAINER -->
    <div class="max-w-4xl mx-auto px-4">
        
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-red-100 rounded-full mb-4">
                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Payment Cancelled</h1>
            <p class="text-gray-500 mt-2">
                No payment has been processed. You can try again anytime.
            </p>
        </div>

        <!-- CENTERED BOX -->
        <div class="flex justify-center">
            <div class="w-full max-w-xl bg-white rounded-lg border border-gray-200 shadow-sm p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">What Happened?</h2>
                <p class="text-gray-600 mb-4">
                    The payment process was cancelled before completion. Your order was not confirmed.
                </p>
                <p class="text-gray-600 mb-4">
                    If this was a mistake, you can go back to the shop and place the order again.
                </p>
                <a href="{{ url('/')}}" class="w-full inline-flex items-center justify-center px-4 py-2 bg-primary text-white font-medium rounded-md hover:bg-primary-dark">
                    Return to Home
                </a>
            </div>
        </div>

    </div>
</div>
@endsection