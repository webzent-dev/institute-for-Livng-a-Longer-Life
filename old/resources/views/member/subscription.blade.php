@extends('member.member')
@section('member-content')
<!-- Subscription Page -->
<div class="min-h-screen   py-8 px-4 sm:px-6 lg:px-8">
    <div class="space-y-6">
        <!-- Header -->
        <div>
            <h1 class="text-2xl font-bold text-foreground text-left">My Subscription</h1>
            <p class="text-muted-foreground">Manage your membership plan and benefits</p>
        </div>

        <!-- Premium Plan Card -->
        <div class="rounded-lg border bg-card text-card-foreground shadow-sm border-primary/20 bg-gradient-to-br from-primary/5 to-transparent">
            <div class="flex flex-col space-y-1.5 p-6">
                <div class="flex items-center justify-between">
                    <div>
                    <h3 class="font-semibold tracking-tight text-2xl flex items-center gap-2">
                        {{auth()->user()->plan_name}}
                        <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-transparent bg-primary text-primary-foreground hover:bg-primary/80 ml-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-check-big h-3 w-3 mr-1">
                                <path d="M21.801 10A10 10 0 1 1 17 3.335"></path>
                                <path d="m9 11 3 3L22 4"></path>
                            </svg>
                            Active
                        </div>
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
                        <p class="text-sm text-muted-foreground">Next Billing</p>
                        <p class="font-medium">{{ \Carbon\Carbon::parse(auth()->user()->plan_expiry)->addDay()->format('M j, Y') }}</p>
                    </div>
                    </div>
                </div>

                <!-- Subscription Period -->
                <div class="space-y-2">
                    <div class="flex justify-between text-sm">
                    <span class="text-muted-foreground">Subscription Period</span>
                    <span class="font-medium">380 days remaining</span>
                    </div>
                    <div aria-valuemax="100" aria-valuemin="0" role="progressbar" data-state="indeterminate" data-max="100" class="relative h-4 w-full overflow-hidden rounded-full bg-secondary">
                    <div data-state="indeterminate" data-max="100" class="h-full w-full flex-1 bg-primary transition-all"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Benefits Card -->
        @php
            $planDetail = App\Models\Membership::find(auth()->user()->plan_id);
            $membership_benefits = explode(",", $planDetail->membership_benefits);
        @endphp
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

        <!-- Auto-Renewal Notice -->
        <div class="rounded-lg border text-card-foreground shadow-sm border-amber-200 bg-amber-50/50 dark:border-amber-800 dark:bg-amber-950/20">
            <div class="p-6 pt-6">
                <div class="flex items-start gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-alert h-5 w-5 text-amber-600 flex-shrink-0 mt-0.5">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" x2="12" y1="8" y2="12"></line>
                    <line x1="12" x2="12.01" y1="16" y2="16"></line>
                    </svg>
                    <div>
                    <h4 class="font-medium text-foreground">Auto-Renewal Enabled</h4>
                    <p class="text-sm text-muted-foreground mt-1">
                        Your subscription will automatically renew on January 1, 2026. You can cancel or modify this at any time.
                    </p>
                    <button class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 underline-offset-4 hover:underline h-10 py-2 px-0 mt-2 text-amber-700 dark:text-amber-400">
                        Manage Auto-Renewal Settings
                    </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
