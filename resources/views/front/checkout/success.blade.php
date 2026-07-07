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
      <h1 class="text-3xl font-bold text-gray-900 mb-2">Order Created Successfully!</h1>
      <p class="text-lg text-gray-600">Your order #{{ $order->order_number }} has been created and payment is successful.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
      <!-- Order Details -->
      <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Order Details</h2>
        <div class="space-y-3">
          <div class="flex justify-between">
            <span class="text-gray-600">Order Number:</span>
            <span class="font-medium">{{ $order->order_number }}</span>
          </div>
          <div class="flex justify-between">
            <span class="text-gray-600">Status:</span>
            <span class="font-medium capitalize">{{ ucfirst($order->status) }}</span>
          </div>
          <div class="flex justify-between">
            <span class="text-gray-600">Payment Status:</span>
            <span class="font-medium capitalize">{{ ucfirst($order->payment_status) }}</span>
          </div>
          <div class="flex justify-between">
            <span class="text-gray-600">Subtotal:</span>
            <span class="font-medium">${{ number_format($order->subtotal ?? 0, 2) }}</span>
          </div>
          <div class="flex justify-between">
            <span class="text-gray-600">Shipping:</span>
            <span class="font-medium">${{ number_format($order->shipping_cost ?? 0, 2) }}</span>
          </div>
          @if(($order->discount ?? 0) > 0)
          <div class="flex justify-between">
            <span class="text-gray-600">Member Discount:</span>
            <span class="font-medium text-green-600">-${{ number_format($order->discount, 2) }}</span>
          </div>
          @endif
          <div class="flex justify-between border-t border-gray-200 pt-3">
            <span class="text-gray-600">Total:</span>
            <span class="font-medium">${{ number_format($order->total, 2) }}</span>
          </div>
        </div>
      </div>

      
    </div>

    <!-- Order Items -->
    <div class="mt-8 bg-white rounded-lg border border-gray-200 shadow-sm p-6">
      <h2 class="text-xl font-bold text-gray-900 mb-4">Order Items</h2>
      <div class="space-y-4">
        @foreach($orderItems as $item)
        <div class="flex justify-between items-center p-4 bg-gray-50 rounded">
          <div class="flex-1">
            <div class="font-medium text-gray-900">{{ $item->product_name }}</div>
            <div class="text-sm text-gray-500">Qty: {{ $item->quantity }}</div>
          </div>
          <div class="font-medium text-gray-900">${{ number_format($item->total, 2) }}</div>
        </div>
        @endforeach
      </div>
    </div>

    <!-- Actions -->
    <div class="mt-8 text-center">
      <a href="{{ route('shop') }}" class="inline-flex items-center px-6 py-3 bg-primary text-white font-semibold rounded-md hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
        Continue Shopping
      </a>
    </div>
  </div>
</div>

@endsection
