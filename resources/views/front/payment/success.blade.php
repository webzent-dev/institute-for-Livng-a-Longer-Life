@extends('front.layouts.app')
@section('content')

<div class="min-h-screen bg-gray-50 py-12">
  <div class="max-w-4xl mx-auto px-4">
    <!-- Success Header -->
    <div class="text-center mb-8">
      <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-4">
        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
      </div>
      <!-- <h1 class="text-3xl font-bold text-gray-900 mb-2">Order Created Successfully!</h1> -->
      <p class="text-lg text-gray-600">Your payment has been processed successfully.</p>
    </div>

    <!-- Actions -->
    <div class="mt-8 text-center">
      <a href="{{ url('/') }}" class="inline-flex items-center px-6 py-3 bg-primary text-white font-semibold rounded-md hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
        Go to Home
      </a>
    </div>
  </div>
</div>

@endsection
