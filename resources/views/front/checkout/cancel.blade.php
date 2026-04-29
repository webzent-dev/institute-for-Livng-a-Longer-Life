@extends('front.layouts.app')
@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-4xl mx-auto px-4">
        <!-- Cancel Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-red-100 rounded-full mb-4">
                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Payment Cancelled</h1>
            <p class="text-lg text-gray-600">
                Your payment for order <strong>#{{ $order->order_number }}</strong> was cancelled.
            </p>
            <p class="text-gray-500 mt-2">
                No payment has been processed. You can try placing the order again anytime.
            </p>
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
                        <span class="text-gray-600">Order Status:</span>
                        <span class="font-medium text-red-600 capitalize">{{ ucfirst($order->status) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Payment Status:</span>
                        <span class="font-medium text-red-600 capitalize">{{ ucfirst($order->payment_status) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Total:</span>
                        <span class="font-medium">${{ number_format($order->total, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Information Box -->
            <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">
                What Happened?
                </h2>

                <p class="text-gray-600 mb-4">
                The payment process was cancelled before completion.
                Your order was not confirmed.
                </p>

                <p class="text-gray-600 mb-4">
                If this was a mistake, you can go back to the shop and place
                the order again.
                </p>

                <a href="{{ route('shop') }}"
                class="w-full inline-flex items-center justify-center px-4 py-2 bg-primary text-white font-medium rounded-md hover:bg-primary-dark">
                Return to Shop
                </a>

            </div>
        </div>

        <!-- Order Items -->
        <div class="mt-8 bg-white rounded-lg border border-gray-200 shadow-sm p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Order Items</h2>
            <div class="space-y-4">

                @foreach($order->items as $item)

                <div class="flex justify-between items-center p-4 bg-gray-50 rounded">

                <div class="flex-1">
                    <div class="font-medium text-gray-900">
                    {{ $item->product_name }}
                    </div>

                    <div class="text-sm text-gray-500">
                    Qty: {{ $item->quantity }}
                    </div>
                </div>

                <div class="font-medium text-gray-900">
                    ${{ number_format($item->total, 2) }}
                </div>

                </div>

                @endforeach

            </div>
        </div>

        <!-- Actions -->
        <div class="mt-8 text-center">
            <a href="{{ route('shop') }}" class="inline-flex items-center px-6 py-3 bg-primary text-white font-semibold rounded-md hover:bg-primary-dark">Continue Shopping</a>
        </div>
    </div>
</div>
@endsection