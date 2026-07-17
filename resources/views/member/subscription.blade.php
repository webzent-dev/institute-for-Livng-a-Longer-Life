@extends('member.member')
@section('member-content')
<style>[x-cloak] { display: none !important; }</style>
<!-- Subscription Page -->
<div class="min-h-screen   py-8 px-4 sm:px-6 lg:px-8">
    <div class="space-y-6">
        <!-- Header -->
        <div>
            <h1 class="text-2xl font-bold text-foreground text-left">My Subscription</h1>
            <p class="text-muted-foreground">Manage your membership plan and benefits</p>
        </div>

        @php
            $planDetail = App\Models\Membership::find(auth()->user()->plan_id);
            $membership_benefits = !empty($planDetail) ? explode(",", $planDetail->membership_benefits) : [];
        @endphp

        @if(auth()->user()->plan_id > 0)
        <!-- Premium Plan Card -->
        <div class="rounded-lg border bg-card text-card-foreground shadow-sm border-primary/20 bg-gradient-to-br from-primary/5 to-transparent">
            <div class="flex flex-col space-y-1.5 p-6">
                <div class="flex items-center justify-between">
                    <div>
                    <h3 class="font-semibold tracking-tight text-2xl flex items-center gap-2">
                        {{auth()->user()->plan_name}}
                        @if(auth()->user()->membershipIsCancelled())
                        <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold border-transparent bg-amber-500 text-white ml-2">
                            Cancelled
                        </div>
                        @else
                        <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-transparent bg-primary text-primary-foreground hover:bg-primary/80 ml-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-check-big h-3 w-3 mr-1">
                                <path d="M21.801 10A10 10 0 1 1 17 3.335"></path>
                                <path d="m9 11 3 3L22 4"></path>
                            </svg>
                            Active
                        </div>
                        @endif
                    </h3>
                    <p class="text-muted-foreground text-lg mt-1">${{auth()->user()->plan_price}}/{{auth()->user()->plan_period}}</p>
                    </div>
                    <a href="{{route('member.plans')}}">
                        <button class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 border-2 border-primary bg-background text-primary hover:bg-primary hover:text-primary-foreground h-10 px-4 py-2">
                            Change Plan
                        </button>
                    </a>
                </div>
            </div>

            <!-- Plan Details -->
            <div class="p-6 pt-0 space-y-6">
                <div class="grid md:grid-cols-2 gap-4">
                    <div class="flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar h-5 w-5 text-muted-foreground">
                        <path d="M8 2v4"></path>
                        <path d="M16 2v4"></path>
                        <rect width="18" height="18" x="3" y="4" rx="2"></rect>
                        <path d="M3 10h18"></path>
                    </svg>
                    <div>
                        <p class="text-sm text-muted-foreground">Member Since</p>
                        <p class="font-medium">{{ \Carbon\Carbon::parse(auth()->user()->created_at)->format('M j, Y') }}</p>
                    </div>
                    </div>
                    <div class="flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-credit-card h-5 w-5 text-muted-foreground">
                        <rect width="20" height="14" x="2" y="5" rx="2"></rect>
                        <line x1="2" x2="22" y1="10" y2="10"></line>
                    </svg>
                    <div>
                        @php $willAutoRenew = auth()->user()->shouldAutoRenew(); @endphp
                        <p class="text-sm text-muted-foreground">{{ $willAutoRenew ? 'Next Billing' : 'Access Until' }}</p>
                        <p class="font-medium">
                            {{ $willAutoRenew
                                ? \Carbon\Carbon::parse(auth()->user()->plan_expiry)->addDay()->format('M j, Y')
                                : \Carbon\Carbon::parse(auth()->user()->plan_expiry)->format('M j, Y') }}
                        </p>
                    </div>
                    </div>
                </div>

                <!-- Subscription Period -->
                <div class="space-y-2">
                    <div class="flex justify-between text-sm">
                    <span class="text-muted-foreground">Subscription Period</span>
                    @php 
                        $expiry_date = \Carbon\Carbon::parse(auth()->user()->plan_expiry);
                        $current_date = \Carbon\Carbon::now();
                        $remaining_days = $current_date->diffInDays($expiry_date, false);

                        // Ensure remaining days is not negative and not in decimal format
                        $remaining_days = max(0, floor($remaining_days));

                        if($remaining_days <= 0) {
                            $remaining_days = 'Expired';
                        } else {
                            $remaining_days = $remaining_days . ' days remaining';
                        }
                    @endphp
                    <span class="font-medium">{{ $remaining_days }}</span>
                    </div>
                    <div aria-valuemax="100" aria-valuemin="0" role="progressbar" data-state="indeterminate" data-max="100" class="relative h-4 w-full overflow-hidden rounded-full bg-secondary">
                    <div data-state="indeterminate" data-max="100" class="h-full w-full flex-1 bg-primary transition-all"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Benefits Card -->
        <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
            <div class="flex flex-col space-y-1.5 p-6">
                <h3 class="text-2xl font-semibold leading-none tracking-tight">Your Benefits</h3>
                <p class="text-sm text-muted-foreground">Everything included in your Premium plan</p>
            </div>
            <div class="p-6 pt-0">
                <div class="grid md:grid-cols-2 gap-3">
                    @foreach($membership_benefits as $benefit)
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-check-big h-4 w-4 text-primary flex-shrink-0">
                            <path d="M21.801 10A10 10 0 1 1 17 3.335"></path>
                            <path d="m9 11 3 3L22 4"></path>
                        </svg>
                        <span class="text-sm">{{ ltrim($benefit) }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Renewal Notice -->
        @php
            $expiryDate = \Carbon\Carbon::parse(auth()->user()->plan_expiry);
            // Lifetime plans are set 100 years out and never need renewing.
            $isLifetime = auth()->user()->hasLifetimeMembership();
            $daysLeft = floor(\Carbon\Carbon::now()->diffInDays($expiryDate, false));
            $isExpired = $daysLeft <= 0;
            $isExpiringSoon = !$isExpired && $daysLeft <= 7;
            $isCancelled = auth()->user()->membershipIsCancelled();
            $autoRenewOn = (bool) auth()->user()->auto_renew;
        @endphp

        @unless($isLifetime)
        <!-- Renewal & Cancellation -->
        <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
            <div class="flex flex-col space-y-1.5 p-6">
                <h3 class="text-2xl font-semibold leading-none tracking-tight">Renewal</h3>
                <p class="text-sm text-muted-foreground">Choose whether your membership renews on its own, or renew it yourself each time.</p>
            </div>
            <div class="p-6 pt-0 space-y-4">
                @if($isCancelled)
                    <div class="rounded-md border border-amber-200 bg-amber-50/50 p-4">
                        <p class="text-sm text-foreground">
                            <span class="font-medium">Your membership is cancelled.</span>
                            You keep every benefit until <span class="font-medium">{{ $expiryDate->format('M j, Y') }}</span>,
                            and you will not be charged again. Change your mind any time before then.
                        </p>
                        <form method="POST" action="{{ route('member.resume-subscription') }}" class="mt-3">
                            @csrf
                            <button type="submit" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium h-10 px-4 py-2 bg-primary text-primary-foreground hover:bg-primary/90">
                                Resume Membership
                            </button>
                        </form>
                    </div>
                @else
                    <div class="flex items-start justify-between gap-4 rounded-md border p-4">
                        <div>
                            <p class="font-medium text-foreground">Automatic renewal</p>
                            <p class="text-sm text-muted-foreground mt-1">
                                @if($autoRenewOn)
                                    On — we will charge your saved card ${{ auth()->user()->plan_price }} on {{ $expiryDate->format('M j, Y') }} to keep your benefits running.
                                @else
                                    Off — your membership ends on {{ $expiryDate->format('M j, Y') }} unless you renew it yourself.
                                @endif
                            </p>
                            @if($autoRenewOn && !$hasSavedCard)
                                <p class="text-sm text-amber-700 mt-2">
                                    We have no card saved for you, so automatic renewal cannot charge anything yet.
                                    Renew once using the button below and we will save your card for next time.
                                </p>
                            @endif
                        </div>
                        <form method="POST" action="{{ route('member.auto-renew') }}" class="shrink-0">
                            @csrf
                            <input type="hidden" name="auto_renew" value="{{ $autoRenewOn ? 0 : 1 }}">
                            <button type="submit" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium h-10 px-4 py-2 border-2 border-primary bg-background text-primary hover:bg-primary hover:text-primary-foreground">
                                {{ $autoRenewOn ? 'Turn Off' : 'Turn On' }}
                            </button>
                        </form>
                    </div>

                    <div x-data="{ confirmCancel: false }">
                        <button type="button" @click="confirmCancel = true" class="text-sm font-medium text-red-600 hover:text-red-700 underline">
                            Cancel membership
                        </button>

                        <div x-show="confirmCancel" x-cloak class="fixed inset-0 z-50 flex items-center justify-center">
                            <div class="absolute inset-0 bg-black/50" @click="confirmCancel = false"></div>
                            <div class="relative bg-white dark:bg-card rounded-xl shadow-lg p-6 w-full max-w-md mx-4">
                                <h4 class="text-lg font-semibold text-foreground">Cancel your membership?</h4>
                                <p class="text-sm text-muted-foreground mt-2">
                                    You will keep your {{ auth()->user()->plan_name }} benefits until
                                    <span class="font-medium">{{ $expiryDate->format('M j, Y') }}</span> — the period you have already paid for.
                                    After that your membership ends and you will not be charged again.
                                </p>
                                <div class="flex justify-end gap-3 mt-6">
                                    <button type="button" @click="confirmCancel = false" class="inline-flex items-center justify-center rounded-md border h-10 px-4 py-2 text-sm font-medium bg-background hover:bg-muted">
                                        Keep Membership
                                    </button>
                                    <form method="POST" action="{{ route('member.cancel-subscription') }}">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center justify-center rounded-md h-10 px-4 py-2 text-sm font-medium bg-red-600 text-white hover:bg-red-700">
                                            Yes, cancel
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        @endunless

        @unless($isLifetime)
        @php
            // Colour the card by urgency: red when expired, amber when due soon, neutral otherwise.
            $tone = $isExpired
                ? ['border' => 'border-red-200 bg-red-50/50 dark:border-red-800 dark:bg-red-950/20', 'icon' => 'text-red-600', 'btn' => 'bg-red-600 hover:bg-red-700 text-white']
                : ($isExpiringSoon
                    ? ['border' => 'border-amber-200 bg-amber-50/50 dark:border-amber-800 dark:bg-amber-950/20', 'icon' => 'text-amber-600', 'btn' => 'bg-primary hover:bg-primary/90 text-primary-foreground']
                    : ['border' => 'border-primary/20 bg-primary/5', 'icon' => 'text-primary', 'btn' => 'bg-primary hover:bg-primary/90 text-primary-foreground']);
        @endphp
        <div class="rounded-lg border text-card-foreground shadow-sm {{ $tone['border'] }}">
            <div class="p-6 pt-6">
                <div class="flex items-start gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-alert h-5 w-5 {{ $tone['icon'] }} flex-shrink-0 mt-0.5">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" x2="12" y1="8" y2="12"></line>
                    <line x1="12" x2="12.01" y1="16" y2="16"></line>
                    </svg>
                    <div class="flex-1">
                    <h4 class="font-medium text-foreground">
                        @if($isExpired)
                            Your membership has expired
                        @elseif($isExpiringSoon)
                            Your membership expires soon
                        @else
                            Renew your membership
                        @endif
                    </h4>
                    <p class="text-sm text-muted-foreground mt-1">
                        @if($isExpired)
                            Your {{ auth()->user()->plan_name }} membership expired on {{ $expiryDate->format('M j, Y') }}. Renew now to restore access to member benefits.
                        @elseif($isExpiringSoon)
                            Your {{ auth()->user()->plan_name }} membership expires on {{ $expiryDate->format('M j, Y') }} ({{ $daysLeft }} {{ \Illuminate\Support\Str::plural('day', $daysLeft) }} left). Renew now to keep your benefits without interruption.
                        @else
                            Your {{ auth()->user()->plan_name }} membership is active until {{ $expiryDate->format('M j, Y') }}. You can renew any time — the new period is added on top of your remaining days, so you never lose time by renewing early.
                        @endif
                    </p>
                    <form method="POST" action="{{ route('member.renew-membership') }}" class="mt-3">
                        @csrf
                        <button type="submit" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 h-10 px-4 py-2 {{ $tone['btn'] }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
                                <path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"></path>
                                <path d="M21 3v5h-5"></path>
                                <path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"></path>
                                <path d="M8 16H3v5"></path>
                            </svg>
                            {{ $isExpired ? 'Renew Membership' : 'Renew Now' }} &mdash; ${{ auth()->user()->plan_price }}
                        </button>
                    </form>
                    </div>
                </div>
            </div>
        </div>
        @endunless
        @else
        <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
            <div class="flex flex-col space-y-1.5 p-6">
                <h3 class="text-2xl font-semibold leading-none tracking-tight">No Active Subscription</h3>
                <p class="text-sm text-muted-foreground">You currently do not have an active membership plan. Explore our plans to enjoy exclusive benefits.</p>
                <a href="{{route('member.plans')}}">
                    <button class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 border-2 border-primary bg-background text-primary hover:bg-primary hover:text-primary-foreground h-10 px-4 py-2 mt-4">
                        View Plans
                    </button>
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
