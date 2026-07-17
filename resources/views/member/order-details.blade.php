@extends('member.member')
@section('member-content')
<!-- Order Details Page -->
<div class="min-h-screen py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('member.orders') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                    <path d="m15 18-6-6 6-6"></path>
                </svg>
                Back to Orders
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Order Details</h1>
            <p class="text-gray-600 mt-2">Order #{{ $order->order_number }}</p>
        </div>

        <!-- Order Status Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">Order Status</h2>
                    <p class="text-sm text-gray-600 mt-1">Placed on {{ \Carbon\Carbon::parse($order->created_at)->format('M j, Y \a\t g:i A') }}</p>
                </div>
                <div class="text-right">
                    <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full 
                        @if($order->status == 'delivered') bg-green-100 text-green-800
                        @elseif($order->status == 'processing') bg-blue-100 text-blue-800
                        @elseif($order->status == 'pending') bg-yellow-100 text-yellow-800
                        @else bg-gray-100 text-gray-800
                        @endif">
                        {{ ucfirst($order->status) }}
                    </span>
                    <p class="text-sm text-gray-600 mt-1">
                        Payment: {{ ucfirst($order->payment_status ?? 'pending') }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Order Items -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Order Items</h2>
            <div class="space-y-4">
                @forelse($order->items as $item)
                    <div class="flex items-center justify-between py-3 border-b border-gray-200 last:border-b-0">
                        <div class="flex-1">
                            <h3 class="text-sm font-medium text-gray-900">{{ $item->product_name }}</h3>
                            @php $purchaseLabel = \App\Support\CartLine::label($item->purchase_type, $item->subscription_plan); @endphp
                            <span class="inline-block mt-1 rounded-full text-[11px] font-semibold px-2 py-0.5 {{ $item->purchase_type === 'subscription' ? 'bg-primary/10 text-primary' : 'bg-gray-100 text-gray-600' }}">{{ $purchaseLabel }}</span>
                            <p class="text-sm text-gray-600 mt-1">Quantity: {{ $item->quantity }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-medium text-gray-900">${{ number_format($item->price, 2) }}</p>
                            <p class="text-sm text-gray-600">each</p>
                        </div>
                        <div class="text-right ml-6">
                            <p class="text-sm font-semibold text-gray-900">${{ number_format($item->total, 2) }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500">No items found for this order.</p>
                @endforelse
            </div>
        </div>

        <!-- Shipping Address -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Shipping Address</h2>
            <div class="text-sm text-gray-600">
                <p class="font-medium text-gray-900">{{ $order->first_name }} {{ $order->last_name }}</p>
                @if($order->address_line_1)
                    <p>{{ $order->address_line_1 }}</p>
                @endif
                @if($order->address_line_2)
                    <p>{{ $order->address_line_2 }}</p>
                @endif
                @if($order->city)
                    <p>{{ $order->city }}, {{ $order->state }} {{ $order->zip_code }}</p>
                @endif
                @if($order->country)
                    <p>{{ $order->country }}</p>
                @endif
                @if($order->phone)
                    <p class="mt-2">Phone: {{ $order->phone }}</p>
                @endif
                <p class="mt-2">Email: {{ $order->email }}</p>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Order Summary</h2>
            <div class="space-y-2">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Subtotal</span>
                    <span class="font-medium">${{ number_format($order->subtotal, 2) }}</span>
                </div>
                @if($order->shipping_cost)
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Shipping</span>
                        <span class="font-medium">${{ number_format($order->shipping_cost, 2) }}</span>
                    </div>
                @endif
                @if($order->tax)
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Tax</span>
                        <span class="font-medium">${{ number_format($order->tax, 2) }}</span>
                    </div>
                @endif
                @if($order->discount)
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Discount</span>
                        <span class="font-medium text-green-600">-${{ number_format($order->discount, 2) }}</span>
                    </div>
                @endif
                <div class="border-t border-gray-200 pt-2 mt-2">
                    <div class="flex justify-between">
                        <span class="text-base font-semibold text-gray-900">Total</span>
                        <span class="text-base font-semibold text-gray-900">${{ number_format($order->total, 2) }}</span>
                    </div>
                </div>
            </div>
            
            @if($order->payment_method)
                <div class="mt-4 pt-4 border-t border-gray-200">
                    <p class="text-sm text-gray-600">
                        <span class="font-medium">Payment Method:</span> {{ ucfirst($order->payment_method) }}
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
