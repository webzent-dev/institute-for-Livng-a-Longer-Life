@extends('front.layouts.app')
@section('content')

@php
    $shipping_address = json_decode($order->shipping_address);
    $billing_address  = json_decode($order->billing_address);

    // Mirrors the confirmation email: show the discounts that actually applied,
    // falling back to the generic one when neither is set.
    $membershipDiscount   = $order->membership_discount ?? 0;
    $subscriptionDiscount = $order->subscription_discount ?? 0;
    $genericDiscount      = $order->discount ?? 0;
    $planName             = $order->membership_plan_name ?? ($order->user->plan_name ?? null);

    $statusTone = match(strtolower($order->status)) {
        'delivered' => 'bg-green-100 text-green-800',
        'shipped'   => 'bg-blue-100 text-blue-800',
        'cancelled' => 'bg-red-100 text-red-800',
        default     => 'bg-amber-100 text-amber-800',
    };
    $paid = strtolower($order->payment_status) === 'completed';
@endphp

<div class="min-h-screen bg-muted/30 py-10 sm:py-14">
  <div class="max-w-5xl mx-auto px-4 sm:px-6">

    {{-- Confirmation --}}
    <div class="text-center mb-10">
      <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-100 mb-5">
        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
          <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
        </svg>
      </div>

      <h1 class="text-3xl sm:text-4xl font-bold text-foreground tracking-tight">
        Thank you{{ $order->first_name ? ', ' . ucfirst($order->first_name) : '' }}
      </h1>
      <p class="mt-3 text-lg text-muted-foreground">
        Your order is confirmed and we have started getting it ready.
      </p>

      <div class="mt-5 inline-flex flex-wrap items-center justify-center gap-x-3 gap-y-2 rounded-full border bg-card px-5 py-2.5 text-sm shadow-sm">
        <span class="text-muted-foreground">Order</span>
        <span class="font-semibold text-foreground">{{ $order->order_number }}</span>
        <span class="text-border" aria-hidden="true">|</span>
        <span class="text-muted-foreground">{{ $order->created_at->format('M j, Y') }}</span>
      </div>

      @if(!empty($order->email))
      <p class="mt-4 text-sm text-muted-foreground">
        A confirmation has been emailed to <span class="font-medium text-foreground">{{ $order->email }}</span>
      </p>
      @endif
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

      {{-- Items, next steps, addresses --}}
      <div class="lg:col-span-2 space-y-6">

        {{-- What happens next --}}
        <div class="rounded-xl border bg-card shadow-sm p-6">
          <h2 class="text-lg font-semibold text-foreground mb-5">What happens next</h2>
          <ol class="space-y-5">
            <li class="flex gap-4">
              <span class="flex-shrink-0 flex items-center justify-center w-8 h-8 rounded-full bg-green-100 text-green-700 text-sm font-semibold">1</span>
              <div>
                <p class="font-medium text-foreground">Order confirmed</p>
                <p class="text-sm text-muted-foreground mt-0.5">We have received your payment and your order details.</p>
              </div>
            </li>
            <li class="flex gap-4">
              <span class="flex-shrink-0 flex items-center justify-center w-8 h-8 rounded-full bg-muted text-muted-foreground text-sm font-semibold">2</span>
              <div>
                <p class="font-medium text-foreground">Being prepared</p>
                <p class="text-sm text-muted-foreground mt-0.5">Our team is packing your items ready for despatch.</p>
              </div>
            </li>
            <li class="flex gap-4">
              <span class="flex-shrink-0 flex items-center justify-center w-8 h-8 rounded-full bg-muted text-muted-foreground text-sm font-semibold">3</span>
              <div>
                <p class="font-medium text-foreground">On its way</p>
                <p class="text-sm text-muted-foreground mt-0.5">We will email you tracking details as soon as it ships.</p>
              </div>
            </li>
          </ol>
        </div>

        {{-- Items --}}
        <div class="rounded-xl border bg-card shadow-sm overflow-hidden">
          <div class="px-6 py-4 border-b">
            <h2 class="text-lg font-semibold text-foreground">
              Your items
              <span class="text-muted-foreground font-normal">({{ $orderItems->count() }})</span>
            </h2>
          </div>
          <ul class="divide-y">
            @foreach($orderItems as $item)
            @php $purchaseLabel = \App\Support\CartLine::label($item->purchase_type, $item->subscription_plan); @endphp
            <li class="flex items-start justify-between gap-4 px-6 py-4">
              <div class="min-w-0">
                <p class="font-medium text-foreground">{{ $item->product_name }}</p>
                <p class="text-sm mt-1 {{ $item->purchase_type === 'subscription' ? 'text-teal-700' : 'text-muted-foreground' }}">
                  {{ $purchaseLabel }}
                </p>
                <p class="text-sm text-muted-foreground mt-1">
                  {{ $item->quantity }} &times; ${{ number_format($item->price, 2) }}
                </p>
              </div>
              <p class="font-semibold text-foreground whitespace-nowrap">
                ${{ number_format($item->total ?? ($item->price * $item->quantity), 2) }}
              </p>
            </li>
            @endforeach
          </ul>
        </div>

        {{-- Addresses --}}
        @if(!empty($shipping_address) || !empty($billing_address))
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
          @if(!empty($shipping_address))
          <div class="rounded-xl border bg-card shadow-sm p-6">
            <h3 class="text-sm font-semibold text-foreground mb-2">Shipping address</h3>
            <p class="text-sm text-muted-foreground leading-relaxed">
              {{ $shipping_address->address_line_1 }}<br>
              {{ $shipping_address->city }}, {{ $shipping_address->state }} {{ $shipping_address->zip_code }}<br>
              {{ $shipping_address->country }}
            </p>
          </div>
          @endif
          @if(!empty($billing_address))
          <div class="rounded-xl border bg-card shadow-sm p-6">
            <h3 class="text-sm font-semibold text-foreground mb-2">Billing address</h3>
            <p class="text-sm text-muted-foreground leading-relaxed">
              {{ $billing_address->address_line_1 }}<br>
              {{ $billing_address->city }}, {{ $billing_address->state }} {{ $billing_address->zip_code }}<br>
              {{ $billing_address->country }}
            </p>
          </div>
          @endif
        </div>
        @endif
      </div>

      {{-- Summary --}}
      <div class="lg:sticky lg:top-6 space-y-6">
        <div class="rounded-xl border bg-card shadow-sm p-6">
          <h2 class="text-lg font-semibold text-foreground mb-4">Order summary</h2>

          <dl class="space-y-3 text-sm">
            <div class="flex justify-between">
              <dt class="text-muted-foreground">Subtotal</dt>
              <dd class="font-medium text-foreground">${{ number_format($order->subtotal ?? 0, 2) }}</dd>
            </div>

            <div class="flex justify-between">
              <dt class="text-muted-foreground">Shipping{{ $order->shipping_method ? ' (' . ucfirst($order->shipping_method) . ')' : '' }}</dt>
              <dd class="font-medium text-foreground">${{ number_format($order->shipping_cost ?? 0, 2) }}</dd>
            </div>

            @if(($order->tax ?? 0) > 0)
            <div class="flex justify-between">
              <dt class="text-muted-foreground">Tax</dt>
              <dd class="font-medium text-foreground">${{ number_format($order->tax, 2) }}</dd>
            </div>
            @endif

            @if($membershipDiscount > 0)
            <div class="flex justify-between">
              <dt class="text-muted-foreground">Membership discount{{ $planName ? ' (' . $planName . ')' : '' }}</dt>
              <dd class="font-medium text-green-600">- ${{ number_format($membershipDiscount, 2) }}</dd>
            </div>
            @endif

            @if($subscriptionDiscount > 0)
            <div class="flex justify-between">
              <dt class="text-muted-foreground">Subscription discount</dt>
              <dd class="font-medium text-green-600">- ${{ number_format($subscriptionDiscount, 2) }}</dd>
            </div>
            @endif

            @if($membershipDiscount <= 0 && $subscriptionDiscount <= 0 && $genericDiscount > 0)
            <div class="flex justify-between">
              <dt class="text-muted-foreground">Discount</dt>
              <dd class="font-medium text-green-600">- ${{ number_format($genericDiscount, 2) }}</dd>
            </div>
            @endif
          </dl>

          <div class="flex justify-between items-baseline border-t mt-4 pt-4">
            <span class="font-semibold text-foreground">Total paid</span>
            <span class="text-2xl font-bold text-foreground">${{ number_format($order->total, 2) }}</span>
          </div>

          <div class="border-t mt-4 pt-4 space-y-2 text-sm">
            <div class="flex justify-between items-center">
              <span class="text-muted-foreground">Payment</span>
              <span class="inline-flex items-center gap-1.5 font-medium {{ $paid ? 'text-green-700' : 'text-amber-700' }}">
                @if($paid)
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                </svg>
                @endif
                {{ $paid ? 'Paid' : ucfirst($order->payment_status) }}
                @if($order->payment_method)
                  <span class="text-muted-foreground font-normal">&middot; {{ ucfirst($order->payment_method) }}</span>
                @endif
              </span>
            </div>
            <div class="flex justify-between items-center">
              <span class="text-muted-foreground">Order status</span>
              <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $statusTone }}">
                {{ ucfirst($order->status) }}
              </span>
            </div>
          </div>
        </div>

        {{-- Actions. Guests have no dashboard to send them to. --}}
        <div class="space-y-3">
          @if($order->belongsToMember())
          <a href="{{ route('member.orders') }}"
             class="w-full inline-flex items-center justify-center px-6 py-3 rounded-md bg-primary text-primary-foreground font-semibold hover:opacity-90 transition">
            View your orders
          </a>
          @endif
          <a href="{{ route('shop') }}"
             class="w-full inline-flex items-center justify-center px-6 py-3 rounded-md border-2 border-primary text-primary font-semibold hover:bg-primary hover:text-primary-foreground transition">
            Continue shopping
          </a>
        </div>

        <p class="text-center text-sm text-muted-foreground">
          Questions about this order?<br>
          <a href="{{ url('/contact') }}" class="font-medium text-primary hover:underline">Contact our support team</a>
        </p>
      </div>
    </div>
  </div>
</div>

@endsection
