@extends('member.member')
@section('member-content')
<div class="min-h-screen py-8 px-4 sm:px-6 lg:px-8">
    <div class="space-y-6 max-w-5xl mx-auto">
        <div>
            <h1 class="text-2xl font-bold text-foreground text-left">My Vital Boost Subscriptions</h1>
            <p class="text-muted-foreground">Manage your recurring Vital Boost deliveries</p>
        </div>

        @if($subscriptions->isEmpty())
        <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
            <div class="p-6">
                <h3 class="text-xl font-semibold leading-none tracking-tight">No active subscriptions</h3>
                <p class="text-sm text-muted-foreground mt-2">You don't have a Vital Boost subscription yet. Subscribe and save on every delivery.</p>
                <a href="{{ url('/vital-boost') }}">
                    <button class="inline-flex items-center justify-center gap-2 rounded-md border-2 border-primary bg-background text-primary hover:bg-primary hover:text-primary-foreground h-10 px-4 py-2 mt-4">
                        Explore Vital Boost
                    </button>
                </a>
            </div>
        </div>
        @else
        <div class="grid gap-4">
            @foreach($subscriptions as $sub)
            @php
                $isYearly = strtolower($sub->plan) === 'yearly';
                $nextBilling = $sub->next_billing_at;
                $daysLeft = $nextBilling ? floor(\Carbon\Carbon::now()->diffInDays($nextBilling, false)) : null;
                $statusStyles = [
                    'active'    => 'bg-green-100 text-green-800',
                    'cancelled' => 'bg-gray-200 text-gray-700',
                    'expired'   => 'bg-red-100 text-red-800',
                ];
                $badge = $statusStyles[$sub->status] ?? 'bg-gray-100 text-gray-800';
            @endphp
            <div class="rounded-lg border bg-card text-card-foreground shadow-sm border-primary/20">
                <div class="p-6">
                    <div class="flex items-start justify-between gap-4 flex-wrap">
                        <div>
                            <h3 class="text-lg font-semibold flex items-center gap-2">
                                {{ $sub->product_name ?? 'Vital Boost' }}
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $badge }}">{{ ucfirst($sub->status) }}</span>
                            </h3>
                            <p class="text-muted-foreground text-sm mt-1">{{ ucfirst($sub->plan) }} subscription &middot; Qty {{ $sub->quantity }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-bold text-foreground">${{ number_format($sub->item_total, 2) }}</p>
                            <p class="text-xs text-muted-foreground">per {{ $isYearly ? 'year' : 'month' }}{{ $isYearly ? ' · free shipping' : '' }}</p>
                        </div>
                    </div>

                    <div class="grid md:grid-cols-3 gap-4 mt-6 text-sm">
                        <div>
                            <p class="text-muted-foreground">Started</p>
                            <p class="font-medium">{{ $sub->started_at ? $sub->started_at->format('M j, Y') : '—' }}</p>
                        </div>
                        <div>
                            <p class="text-muted-foreground">Next renewal</p>
                            <p class="font-medium">
                                {{ $nextBilling ? $nextBilling->format('M j, Y') : '—' }}
                                @if($daysLeft !== null && $sub->status === 'active')
                                    <span class="text-muted-foreground">({{ $daysLeft > 0 ? $daysLeft . ' days' : 'due' }})</span>
                                @endif
                            </p>
                        </div>
                        <div>
                            <p class="text-muted-foreground">Discount applied</p>
                            <p class="font-medium text-primary">
                                @if($sub->membership_percent > 0){{ rtrim(rtrim(number_format($sub->membership_percent,2),'0'),'.') }}% member @endif
                                @if($sub->subscription_percent > 0)+ {{ rtrim(rtrim(number_format($sub->subscription_percent,2),'0'),'.') }}% subscribe @endif
                                @if($sub->membership_percent == 0 && $sub->subscription_percent == 0)—@endif
                            </p>
                        </div>
                    </div>

                    @if($sub->status === 'active')
                    <div class="mt-6">
                        <a href="{{ url('/vital-boost') }}">
                            <button class="inline-flex items-center justify-center gap-2 rounded-md gradient-primary text-primary-foreground font-semibold h-10 px-4 py-2 hover:opacity-90">
                                Renew / Reorder
                            </button>
                        </a>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>
@endsection
