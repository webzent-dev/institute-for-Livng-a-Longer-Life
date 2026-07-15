@extends('front.layouts.app')
@section('content')
<div class="min-h-screen flex flex-col">
    <main class="flex-1">
        <!--<section class="gradient-subtle py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="grid items-center gap-12 lg:grid-cols-2">
                    <div>
                        <h1 class="mb-6 text-4xl font-bold text-foreground lg:text-6xl text-left">Membership Plans</h1>
                        <p class="mb-8 text-xl text-muted-foreground">
                        Choose the membership level that best supports your health and wellness
                        goals. All plans include access to our comprehensive video library and
                        supportive community.
                        </p>
                        <div class="aspect-video overflow-hidden rounded-2xl shadow-strong">
                            <img
                                src="{{asset('assets/expert-guidance.jpg')}}"
                                alt="Professional wellness expert providing personalized guidance"
                                class="h-full w-full object-cover"
                            />
                        </div>
                    </div>
                    <div class="relative">
                        <div class="aspect-video overflow-hidden rounded-2xl shadow-strong">
                            <img
                                src="{{asset('assets/membership-benefits.jpg')}}"
                                alt="Comprehensive membership benefits for holistic wellness"
                                class="h-full w-full object-cover"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </section>-->
        
        <section class="gradient-subtle py-10">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="grid items-center justify-center gap-12">
                    <div class="text-center max-w-3xl mx-auto">
                        <h1 class="mb-6 text-4xl font-bold text-foreground lg:text-6xl">
                            Membership Plans
                        </h1>
                        <p class="text-xl text-muted-foreground">
                            Choose the membership level that best supports your health and wellness
                            goals. All plans include access to our comprehensive video library and
                            supportive community.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        {{-- Membership Card Arrays --}}
        @php
        $plans = [
            [
                'name' => 'Standard Membership',
                'price' => '$183',
                'period' => '/Year',
                'url' => '/membership',
                'description' => 'Access to all video lessons',
                'features' => [
                'Access to 1 pre-recorded lecture a month',
                '$10 Discount on Vital Boost',
                'Monthly Live Zoom Session',
                '3 free guides',
                ],
            ],
            [
                'name' => 'Premium Membership',
                'price' => '$387',
                'period' => '/Year',
                'url' => '/membership',
                'popular' => true,
                'description' => 'Everything in Essential',
                'features' => [
                'Access to all pre-recorded lectures for a year',
                '$15 Discount on Vital Boost',
                'Monthly Live Zoom Session',
                '3 free books',
                '10 free guides',
                ],
            ],
            [
                'name' => 'Lifetime Membership',
                'price' => '$799',
                'period' => 'Lifetime',
                'url' => '/membership',
                'description' => 'Everything in Premium',
                'features' => [
                'Access to all pre-recorded lectures for lifetime',
                '$20 Discount on Vital Boost',
                'Monthly Live Zoom Session',
                '3 free books, 10 free guides',
                '50% off on consultations',
                ],
            ],
        ];
        @endphp

        <!--<section class="py-20 bg-background">-->
        <section class="py-10 bg-background">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 max-w-7xl mx-auto">
                    @foreach($memberships as $plan)
                    @php
                        $isPopular = ($plan->popular == 'yes') ? true : false;
                        $isCurrentPlan = false;
                        if(Auth::check()) {
                            $userPlanId = auth()->user()->plan_id;
                            $currentPlanId = $plan->id;
                            $isCurrentPlan = ($userPlanId == $currentPlanId) ? true : false;
                        }

                        $membership_features = explode(",", $plan->membership_features);
                        $membership_benefits = explode(",", $plan->membership_benefits);
                    @endphp
                    {{-- h-full on both so every card fills its grid cell and all cards end up the same height,
                         whatever the number of features/benefits. --}}
                    <div class="relative h-full" x-data="{ selectedPlan: { name: '', price: '', period: '' } }">
                        {{-- No scale-105 on the popular card: scaling made it overhang the others. It is
                             still highlighted by the thicker border, stronger shadow and the badge. --}}
                        <div class="flex flex-col h-full {{ $isPopular ? 'border-primary border-4 shadow-strong bg-card' : 'border-2 shadow-medium bg-card' }} rounded-2xl  ">
                        @if($isPopular)
                        <div class="relative">
                            <div class="absolute -top-4 left-1/2 -translate-x-1/2 z-10">
                                <span class="gradient-accent px-6 py-2 rounded-full text-sm font-semibold text-accent-foreground shadow-medium inline-flex items-center">
                                <i data-lucide="star" class="w-4 h-4  flex-shrink-0 mr-2 "></i>
                                Most Popular
                                </span>
                            </div>

                            @if($isCurrentPlan)
                            <div class=" w-10 h-10 absolute -top-5 -right-6  -translate-x-1/2 z-10">
                                <span class="w-10 h-10  gradient-accent px-6 py-2 rounded-full text-sm font-semibold text-accent-foreground shadow-medium inline-flex justify-center text-white items-center">
                                <i data-lucide="check-check" class="w-4 h-4 font-extrabold flex-shrink-0  "></i>
                                {{-- Current Plan --}}
                                </span>
                            </div>
                            @endif
                        </div>
                        @endif

                        <div class="text-center pb-8 pt-12 px-6">
                            <h3 class="text-2xl font-bold text-foreground mb-2">{{$plan->membership_name}}</h3>
                            <p class="text-muted-foreground mb-6">{{$plan->membership_description}}</p>
                            <div class="flex items-baseline justify-center">
                                <span class="text-3xl text-primary font-bold ">${{$plan->membership_price}}</span>
                                <span class="text-muted-foreground ml-2">/{{$plan->membership_period}}</span>
                            </div>
                        </div>

                        <div class="border-gray-200 flex-1 flex flex-col px-6 pb-6">
                            <div class="space-y-6 flex-1">
                                <div>
                                    <h4 class="font-semibold text-foreground mb-3 mt-1">Features</h4>
                                    <ul class="space-y-3">
                                        @foreach($membership_features as $feature)
                                        <li class="flex items-start">
                                            <i data-lucide="check-circle" class="w-5 h-5 text-primary flex-shrink-0 mr-2 "></i>
                                            <span class="text-muted-foreground text-sm">{{ ltrim($feature) }}</span>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>

                                {{-- Benefits part --}}
                                @if(isset($membership_benefits) && is_array($membership_benefits))
                                <div>
                                    <h4 class="font-semibold text-foreground mb-3">Benefits</h4>
                                    <ul class="space-y-2">
                                        @foreach($membership_benefits as $benefit)
                                        <li class="flex items-center">
                                            <div class="w-1.5 h-1.5 rounded-full bg-primary mr-2"></div>
                                            <span class="text-muted-foreground text-sm">{{ ltrim($benefit) }}</span>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                            </div>

                            <button type="button" 
                            class="{{ $isPopular ? 'gradient-primary text-primary-foreground shadow-medium font-semibold' : 'border-2 border-primary text-primary' }} {{ $isCurrentPlan ? 'opacity-50 cursor-not-allowed' : 'hover:opacity-90' }} h-11 rounded-md px-8 w-full mt-8" 
                            data-plan-id="{{ $plan['id'] }}"
                            data-plan-name="{{ $plan['membership_name'] }}"
                            data-plan-price="{{ $plan['membership_price'] }}"
                            data-plan-period="{{ $plan['membership_period'] }}"
                            onclick="openPlanModal(this)"
                            @if($isCurrentPlan) disabled @endif>
                                @if($isCurrentPlan)
                                    Current Plan
                                @else
                                    Get Started
                                @endif
                            </button>
                    <x-membership-card :plan="$plan" />
                    @endforeach
                </div>
                <div class="mt-16 text-center">
                    <div class="max-w-4xl mx-auto rounded-lg border bg-card text-card-foreground shadow-sm shadow-medium">
                        <div class="p-8">
                            <h3 class="mb-4 text-2xl font-bold text-foreground">All Memberships Include</h3>
                            <div class="grid gap-4 text-left md:grid-cols-2">
                                @php
                                    $items = [
                                        ['Secure online member portal'],
                                        ['Mobile and desktop access'],
                                        ['Downloadable resources and guides'],
                                        ['Community forum and support']
                                    ];
                                @endphp

                                @foreach($items as [$text])
                                    <div class="flex items-start">
                                    <i data-lucide="circle-check" class="w-5 h-5 text-primary flex-shrink-0 mr-2 "></i>
                                    <span class="text-muted-foreground">{{ $text }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <p class="mt-6 text-sm text-muted-foreground">
                            Each plan is a one-time payment for its period (monthly, yearly or lifetime). You can renew, upgrade or change your plan any time from your member dashboard.
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </main>
</div>
@endsection