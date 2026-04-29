
@extends('member.member')
@section('member-content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pb-8">
    <div class="space-y-6">
        <div class=" mb-10">
            <h4 class="text-2xl font-bold text-foreground">Manage Your Plan</h4>
            <p class="text-gray-600 text-base">Upgrade or downgrade your membership</p>
        </div>
        <div class="flex flex-col lg:flex-row gap-8 justify-center items-stretch">
            @foreach($memberships as $plan)
                @php
                    $isPopular = ($plan->popular == 'yes') ? true : false;
                    $isCurrentPlan = (auth()->user()->plan_id == $plan->id) ? true : false;

                    $membership_features = explode(",", $plan->membership_features);
                    $membership_benefits = explode(",", $plan->membership_benefits);
                @endphp
            <div class="relative"  x-data="{ selectedPlan: { name: '', price: '', period: '' } }">
                <div class="flex flex-col {{ $isPopular ? 'border-primary border-4 shadow-strong md:scale-105 bg-card' : 'border-2 shadow-medium bg-card' }} rounded-2xl  ">
                    @if($isPopular)
                    <div class="relative">
                        <div class="absolute -top-4 left-1/2 -translate-x-1/2 z-10">
                            <span class="inline-flex items-center gap-1 rounded-full bg-primary text-white text-xs font-semibold px-3 py-1 shadow-md">
                            <i data-lucide="star" class="w-4 h-4  flex-shrink-0 mr-2 "></i>
                            Most Popular
                            </span>
                        </div>

                        {{-- @if($isCurrentPlan) --}}
                        <!-- <div class=" w-10 h-10 absolute -top-5 -right-6  -translate-x-1/2 z-10">
                            <span class="w-10 h-10  gradient-accent px-6 py-2 rounded-full text-sm font-semibold text-accent-foreground shadow-medium inline-flex justify-center text-white items-center">
                            <i data-lucide="check-check" class="w-4 h-4 font-extrabold flex-shrink-0  "></i>
                            Current Plan
                            </span>
                        </div> -->

                        <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-transparent bg-secondary text-secondary-foreground hover:bg-secondary/80 absolute -top-3 right-1">Current Plan</div>
                        {{-- @endif --}}
                    </div>
                    @endif

                    <div class="text-center pb-8 pt-12 px-6">
                        <h3 class="font-semibold tracking-tight text-xl">{{$plan->membership_name}}</h3>
                        <p class="text-base mb-6">{{$plan->membership_description}}</p>
                        <div class="flex items-baseline justify-center">
                        <span class="text-4xl font-bold ">${{$plan->membership_price}}</span>
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
                                        <i data-lucide="check" class="w-5 h-5 text-primary flex-shrink-0 mr-2 "></i>
                                        <span class="text-sm ">{{ ltrim($feature) }}</span>
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
                        class="{{ $isPopular ? 'gradient-primary text-primary-foreground hover:opacity-90 shadow-medium font-semibold' : 'border-2 border-primary  text-primary hover:bg-primary hover:text-primary-foreground' }} h-11 rounded-md px-8 w-full mt-8 "
                        data-plan-id="{{ $plan['id'] }}"
                        data-plan-name="{{ $plan['membership_name'] }}"
                        data-plan-price="{{ $plan['membership_price'] }}"
                        data-plan-period="{{ $plan['membership_period'] }}"
                        onclick="openPlanModal(this)">
                            @if($isCurrentPlan)
                                Current Plan
                            @else
                                Upgrade to Lifetime
                            @endif
                        </button>
                        <x-membership-card :plan="$plan" />
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pb-8">
    <div class="space-y-6">
            <div class="map-6 pt-6">
                <div class="rounded-xl border border-gray-200 bg-gray-50 shadow-sm">
                    <div class="p-6 text-center">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Need Help Choosing?</h3>
                        <p class="text-sm text-gray-500 mb-5 max-w-md mx-auto">
                            Our team is here to help you find the perfect plan for your wellness journey.
                        </p>
                        <button class="inline-flex items-center justify-center gap-2 rounded-md border-2 border-green-600 text-green-600 px-5 py-2 text-sm font-medium transition hover:bg-green-600 hover:text-white focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                            <i data-lucide="message-circle" class="w-4 h-4"></i>
                            Contact Support
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
// Simple interactivity for buttons
document.addEventListener(
    'DOMContentLoaded', function() {
        const downgradeBtn = document.querySelector('button:first-of-type');
        const upgradeBtn = document.querySelector('button:last-of-type');
        downgradeBtn.addEventListener(
            'click',
            function() { alert('Downgrade to Standard plan selected'); }
        );
        upgradeBtn.addEventListener(
            'click',
            function() { alert('Upgrade to Lifetime plan selected'); }
        );
    }
);
</script>
@endsection