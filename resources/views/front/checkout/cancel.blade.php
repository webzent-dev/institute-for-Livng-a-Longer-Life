@extends('front.layouts.app')
@section('content')

@php
    // Mirrors the success page and the confirmation email: show the discounts that
    // actually applied, falling back to the generic one when neither is set.
    $membershipDiscount   = $order->membership_discount ?? 0;
    $subscriptionDiscount = $order->subscription_discount ?? 0;
    $genericDiscount      = $order->discount ?? 0;
    $planName             = $order->membership_plan_name ?? ($order->user->plan_name ?? null);
@endphp

<div class="min-h-screen bg-muted/30 py-10 sm:py-14">
  <div class="max-w-5xl mx-auto px-4 sm:px-6">

    {{-- Cancelling is a deliberate, harmless action — not an error — so this reads
         amber and reassuring rather than red and alarming. --}}
    <div class="text-center mb-10">
      <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-amber-100 mb-5">
        <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
      </div>

      <h1 class="text-3xl sm:text-4xl font-bold text-foreground tracking-tight">
        Your payment was cancelled
      </h1>
      <p class="mt-3 text-lg text-muted-foreground">
        Nothing has been charged, and your basket is exactly as you left it.
      </p>

      <div class="mt-5 inline-flex flex-wrap items-center justify-center gap-x-3 gap-y-2 rounded-full border bg-card px-5 py-2.5 text-sm shadow-sm">
        <span class="text-muted-foreground">Order</span>
        <span class="font-semibold text-foreground">{{ $order->order_number }}</span>
        <span class="text-border" aria-hidden="true">|</span>
        <span class="text-muted-foreground">Not completed</span>
      </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

      {{-- Reassurance + the items still waiting --}}
      <div class="lg:col-span-2 space-y-6">

        <div class="rounded-xl border bg-card shadow-sm p-6">
          <h2 class="text-lg font-semibold text-foreground mb-5">What this means</h2>
          <ul class="space-y-4">
            <li class="flex gap-3">
              <svg class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
              </svg>
              <div>
                <p class="font-medium text-foreground">You have not been charged</p>
                <p class="text-sm text-muted-foreground mt-0.5">The payment never went through, so no money has left your account.</p>
              </div>
            </li>
            <li class="flex gap-3">
              <svg class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
              </svg>
              <div>
                <p class="font-medium text-foreground">Your basket is saved</p>
                <p class="text-sm text-muted-foreground mt-0.5">Your items and delivery details are still here — pick up where you left off.</p>
              </div>
            </li>
            <li class="flex gap-3">
              <svg class="w-5 h-5 text-muted-foreground flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
              </svg>
              <div>
                <p class="font-medium text-foreground">This order was not placed</p>
                <p class="text-sm text-muted-foreground mt-0.5">Nothing will be sent to you. Complete the payment whenever you are ready.</p>
              </div>
            </li>
          </ul>
        </div>

        {{-- Items --}}
        <div class="rounded-xl border bg-card shadow-sm overflow-hidden">
          <div class="px-6 py-4 border-b">
            <h2 class="text-lg font-semibold text-foreground">
              Still in your basket
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
            <span class="font-semibold text-foreground">Total due</span>
            <span class="text-2xl font-bold text-foreground">${{ number_format($order->total, 2) }}</span>
          </div>

          <p class="text-xs text-muted-foreground mt-2">Nothing has been charged yet.</p>
        </div>

        {{-- The cart and delivery details survive a cancel, so the review step can
             take them straight back to paying. It redirects to the shop by itself
             if the basket has since emptied. --}}
        <div class="space-y-3">
          <a href="{{ route('checkout.review') }}"
             class="w-full inline-flex items-center justify-center px-6 py-3 rounded-md bg-primary text-primary-foreground font-semibold hover:opacity-90 transition">
            Complete your payment
          </a>
          <a href="{{ route('shop') }}"
             class="w-full inline-flex items-center justify-center px-6 py-3 rounded-md border-2 border-primary text-primary font-semibold hover:bg-primary hover:text-primary-foreground transition">
            Continue shopping
          </a>
        </div>

        <p class="text-center text-sm text-muted-foreground">
          Trouble paying?<br>
          <a href="{{ url('/contact') }}" class="font-medium text-primary hover:underline">Contact our support team</a>
        </p>
      </div>
    </div>
  </div>
</div>

@endsection
