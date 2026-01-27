@extends('front.layouts.app')

@section('content')
<div class=" min-h-screen flex flex-col">
    <main class="  ">
        {{-- Hero Section  --}}

        <section class="gradient-subtle py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div class="space-y-6">
                    <div
                    class="inline-flex items-center space-x-2 bg-primary/10 px-4 py-2 rounded-full"
                    >
                   <i data-lucide="zap" class="w-5 h-5 text-primary"></i>
                    <span class="text-sm font-semibold text-primary">
                        Premium Wellness Formula
                    </span>
                    </div>

                    <h1 class="text-4xl lg:text-6xl font-bold text-foreground text-left">
                    Vital Boost
                    </h1>

                    <p class="text-2xl text-muted-foreground">
                    Your Daily Foundation for Longevity and Vitality
                    </p>

                    <p class="text-lg text-muted-foreground">
                    Inspired by years of lecturing and thirty years of research treating
                    thousands of patients, Dr. Zeines developed this excellent and
                    complete vitamin, mineral, and nutrient-rich supplement. When used
                    daily, it gives you renewed Energy, Vitality, and Health to help you
                    live a better, more satisfying life!
                    </p>

                    <div class="p-4 bg-secondary/50 rounded-lg border-l-4 border-primary">
                    <p class="text-sm text-muted-foreground italic">
                        Originally formulated to protect patients from harmful effects of
                        dental radiation, now protects you from everyday electromagnetic
                        radiation from computers, cell phones, and other hi-tech devices.
                    </p>
                    </div>
                      <div class="flex flex-col sm:flex-row gap-4">
                                <x-button-use href="{{ route('shop') }}" label="Order Now" variant="primary"  icon="zap" />
                                <x-button-use href="{{ route('intro-videos') }}" label="Learn More" variant="outline"   />
                        </div>

                </div>

                <div class="relative">
                    <div
                    class="rounded-lg bg-card text-card-foreground shadow-sm shadow-strong border-2 border-primary/20"
                    >
                    <div class="p-8">
                        <div class="aspect-square rounded-2xl overflow-hidden">
                        <img
                            src="{{ asset('product_images/'.$product->image) }}"
                            alt="Vital Boost - Premium Longevity Formula"
                            class="w-full h-full object-cover"
                        />
                        </div>
                    </div>
                    </div>
                </div>
                </div>
            </div>
        </section>


        {{-- <section class="section-base gradient-subtle py-20">
            <div class="container-base max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid lg:grid-cols-2 gap-12 items-center">

                    <div class="space-y-6">
                        <div class="inline-flex items-center space-x-2 bg-primary/10 px-4 py-2 rounded-full">

                           <i data-lucide="zap" class="w-5 h-5 text-primary"></i>
                            <span class="text-sm font-semibold text-primary">Premium Wellness Formula</span>
                        </div>

                        <h1 class="heading-1">{{ $product->name }}</h1>

                        <p class="text-2xl text-muted-foreground">
                            {{ $product->category }}
                        </p>

                        <p class="text-lg text-muted-foreground">
                            {{ $product->description }}
                        </p>

                        <div class="p-6 bg-secondary rounded-lg border-l-8 border-primary  ">
                            <p class="text-sm text-muted-foreground italic">
                                Originally formulated to protect patients from harmful effects of dental radiation,
                                now protects you from everyday electromagnetic radiation from computers, cell phones,
                                and other hi-tech devices.
                            </p>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-4">

                            <x-button-use href="{{ route('shop') }}" label="Order Now" variant="outline" class="w-full sm:w-auto" icon="zap" />
                            <x-button-use href="#" label="Learn More" variant="outline" class="w-full sm:w-auto"   />

                        </div>
                    </div>

                    <div class="relative">
                        <div class="shadow-soft   rounded-xl">
                            <div class="p-8">
                                <div class="aspect-square rounded-2xl overflow-hidden">
                                    <img
                                        src="{{ asset('product_images/'.$product->image) }}"
                                        alt="Vital Boost - Premium Longevity Formula"
                                        class="w-full h-full object-cover"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section> --}}


        {{-- Benefits Section --}}
        <section class="container-base py-20 bg-background">
            @php

                $benefits = [
                    [
                        'icon' => 'heart',
                        'title' => 'Cardiovascular Support',
                        'description' => 'Promotes healthy heart function and optimal blood circulation'
                    ],
                    [
                        'icon' => 'brain',
                        'title' => 'Cognitive Enhancement',
                        'description' => 'Supports mental clarity, focus, and memory retention'
                    ],
                    [
                        'icon' => 'shield',
                        'title' => 'Immune Strength',
                        'description' => 'Bolsters your body\'s natural defense mechanisms'
                    ],
                    [
                        'icon' => 'trending-up',
                        'title' => 'Energy & Vitality',
                        'description' => 'Sustained energy throughout the day without crashes'
                    ],
                    [
                        'icon' => 'zap',
                        'title' => 'Cellular Renewal',
                        'description' => 'Supports healthy cellular function and regeneration'
                    ],
                    [
                        'icon' => 'users',
                        'title' => 'Holistic Wellness',
                        'description' => 'Comprehensive support for your entire body'
                    ]
                ];

                $ingredients = [
                                                "Vitamin C - 1000mg",
                                                "Vitamin B Complex (B1, B2, B3, B5, B6, B12) - Complete energy support",
                                                "Biotin - 315mcg",
                                                "Folic Acid - 800mcg",
                                                "Vitamin A (Carotene Complex) - 3,334 IU",
                                                "Vitamin E (d-alpha tocopherol) - 100 IU",
                                                "CoQ10 - 50mg for cellular energy",
                                                "Lipoic Acid - 2mg antioxidant",
                                                "Selenium - 9.8mcg immune support",
                                                "Zinc - 36mg for immune function",
                                                "Magnesium Complex - 192mg",
                                                "Amino Acid Complex - L-Lysine, L-Cysteine, L-Methionine, Taurine",
                                                "Organic Spirulina, Barley Grass, Wheat Grass, Spinach",
                                                "Digestive Enzymes & Probiotics",
                                                "Herbal Extracts & Antioxidants"
                                            ];

            @endphp

            <div class="container-base max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <div class="text-center mb-16">
                    <h2 class="text-3xl lg:text-5xl font-bold text-foreground mb-4">
                        Comprehensive Health Benefits
                    </h2>
                    <p class="text-xl text-muted-foreground max-w-3xl mx-auto">
                        Experience synergistic nutrients working together
                        to support your<br> body's natural vitality
                    </p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($benefits as $b)
                    <div class="border-2 hover:border-primary transition-all shadow-soft hover:shadow-medium rounded-xl">
                        <div class="p-6 space-y-4">
                            <div class="iconbg w-14 h-14">

                                <i data-lucide="{{$b['icon']}}" class="h-7 w-7 text-primary-foreground" ></i>
                            </div>
                            <h3 class="heading-3   ">{{ $b['title'] }}</h3>
                            <p class="text-muted-foreground text-[16px]">{{ $b['description'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>

            </div>
        </section>


        {{-- Ingredients Section --}}


        <section class="section-base py-20 gradient-subtle">
            <div class="container-base max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-4xl mx-auto">
                    <div class="shadow-strong rounded-xl bg-white">

                        <div class="text-center pb-8 p-8">
                            <h2 class="text-3xl lg:text-5xl mb-4">Premium Ingredients</h2>
                            <p class="text-xl text-muted-foreground">
                                Each ingredient selected for proven efficacy
                                and optimal bioavailability
                            </p>
                        </div>

                        <div class="grid md:grid-cols-2 gap-4 p-8">
                            @foreach($ingredients as $item)

                            <div class="flex items-start gap-3 p-4 bg-secondary rounded-lg">
                                <div class="w-3 h-3 rounded-full bg-primary flex-shrink-0 self-start mt-1"></div>

                                <span class="text-foreground">
                                    {{ $item }}
                                </span>
                            </div>

                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
        </section>


        {{-- Dosage & Usage --}}

        <section class="py-20 bg-background">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="rounded-lg border bg-card text-card-foreground shadow-sm shadow-medium">
                <div class="flex flex-col space-y-1.5 p-6">
                    <h3 class="font-semibold tracking-tight text-3xl text-center">
                    How to Use Vital Boost
                    </h3>
                </div>

                <div class="p-6 pt-0 space-y-6">
                    <div class="grid md:grid-cols-3 gap-6">
                    <div class="text-center p-6 bg-secondary rounded-xl">
                        <div
                        class="text-4xl font-bold gradient-primary text-transparent bg-clip-text mb-2"
                        >
                        1
                        </div>
                        <p class="text-muted-foreground">Packet</p>
                        <p class="text-sm text-muted-foreground mt-2">per day</p>
                    </div>

                    <div class="text-center p-6 bg-secondary rounded-xl">
                        <div
                        class="text-4xl font-bold gradient-primary text-transparent bg-clip-text mb-2"
                        >
                        Mix
                        </div>
                        <p class="text-muted-foreground">In Liquid</p>
                        <p class="text-sm text-muted-foreground mt-2">
                        smoothie or juice
                        </p>
                    </div>

                    <div class="text-center p-6 bg-secondary rounded-xl">
                        <div
                        class="text-4xl font-bold gradient-primary text-transparent bg-clip-text mb-2"
                        >
                        30
                        </div>
                        <p class="text-muted-foreground">Day Supply</p>
                        <p class="text-sm text-muted-foreground mt-2">per box</p>
                    </div>
                    </div>

                    <div class="p-6 bg-primary/5 rounded-xl border-2 border-primary/20">
                    <h4 class="font-semibold text-foreground mb-3">
                        Recommended Use:
                    </h4>

                    <ul class="space-y-2 text-muted-foreground">
                        <li class="flex items-start">
                        <span class="text-primary mr-2">•</span>
                        Mix one packet of Vital Boost powder into your morning smoothie
                        or juice
                        </li>
                        <li class="flex items-start">
                        <span class="text-primary mr-2">•</span>
                        Powder form allows better absorption than pills or capsules
                        </li>
                        <li class="flex items-start">
                        <span class="text-primary mr-2">•</span>
                        No fillers or binders — just pure, concentrated nutrients
                        </li>
                        <li class="flex items-start">
                        <span class="text-primary mr-2">•</span>
                        For best results, use consistently daily for optimal health
                        benefits
                        </li>
                    </ul>
                    </div>

                    <div class="p-6 bg-secondary rounded-xl">
                    <h4 class="font-semibold text-foreground mb-3">
                        Why Powder Form?
                    </h4>

                    <p class="text-muted-foreground mb-3">
                        Vital Boost is not a pill, capsule, or liquid. It's a powdered
                        drink mix precisely formulated for each day's needs.
                    </p>

                    <ul class="space-y-2 text-muted-foreground text-sm">
                        <li class="flex items-start">
                        <span class="text-primary mr-2">✓</span>
                        Better absorption than pills
                        </li>
                        <li class="flex items-start">
                        <span class="text-primary mr-2">✓</span>
                        More concentrated nutrients
                        </li>
                        <li class="flex items-start">
                        <span class="text-primary mr-2">✓</span>
                        Saves hundreds compared to multiple pill supplements
                        </li>
                        <li class="flex items-start">
                        <span class="text-primary mr-2">✓</span>
                        Quick renewal and recovery from stress and daily life
                        </li>
                    </ul>
                    </div>
                </div>
                </div>
            </div>
        </section>


        {{-- <section class="section-base py-20 bg-background">
            <div class="container-base max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

                <div class="shadow-medium rounded-xl bg-white">

                    <div class="p-6">
                        <h2 class="text-3xl text-center font-bold mb-6">
                            How to Use Vital Boost
                        </h2>

                        <div class="space-y-6">


                            <div class="grid md:grid-cols-3 gap-6">
                                <div class="text-center p-6 bg-secondary rounded-xl">
                                    <div class="heading-1 text-primary  bg-clip-text mb-2">1</div>
                                    <p class="heading-4 text-muted-foreground">Packet</p>
                                    <p class="text-sm text-muted-foreground mt-2">per day</p>
                                </div>

                                <div class="text-center p-6 bg-secondary rounded-xl">
                                    <div class="heading-2 text-primary  bg-clip-text mb-2">Mix</div>
                                    <p class="heading-4 text-muted-foreground">In Liquid</p>
                                    <p class="text-sm text-muted-foreground mt-2">smoothie or juice</p>
                                </div>

                                <div class="text-center p-6 bg-secondary rounded-xl">
                                    <div class="heading-1 text-primary  bg-clip-text mb-2">30</div>
                                    <p class="heading-4 text-muted-foreground">Day Supply</p>
                                    <p class="text-sm text-muted-foreground mt-2">per box</p>
                                </div>
                            </div>
                            <div class="grid md:grid-cols-2 gap-6">

                            <div class="p-6 bg-primary/5 rounded-xl border-2 border-primary/20">
                                <h4 class="heading-4 font-semibold text-foreground mb-3">Recommended Use:</h4>
                                <ul class=" text-lg space-y-2 text-muted-foreground">
                                    <li class="flex items-start"><span class="text-primary mr-2">•</span> Mix one packet into your morning smoothie or juice</li>
                                    <li class="flex items-start"><span class="text-primary mr-2">•</span> Better absorption than pills or capsules</li>
                                    <li class="flex items-start"><span class="text-primary mr-2">•</span> No fillers or binders</li>
                                    <li class="flex items-start"><span class="text-primary mr-2">•</span> Use daily for best results</li>
                                </ul>
                            </div>


                            <div class="p-6 bg-secondary rounded-xl">
                                <h4 class="heading-4 font-semibold text-foreground mb-3">Why Powder Form?</h4>
                                <p class="text-muted-foreground mb-3 ">
                                    Vital Boost is a precisely formulated powdered drink mix.
                                </p>
                                <ul class="text-lg space-y-2 text-muted-foreground  ">
                                    <li class="flex items-start"><span class="text-primary mr-2">✓</span> Better absorption</li>
                                    <li class="flex items-start"><span class="text-primary mr-2">✓</span> More concentrated nutrients</li>
                                    <li class="flex items-start"><span class="text-primary mr-2">✓</span> Saves money vs. multiple supplements</li>
                                    <li class="flex items-start"><span class="text-primary mr-2">✓</span> Faster recovery and renewal</li>
                                </ul>
                            </div>
                            </div>


                        </div>
                    </div>

                </div>

            </div>
        </section> --}}

        <section class="py-20 gradient-subtle">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <div class="rounded-lg border bg-card text-card-foreground shadow-sm shadow-strong">
                <div class="p-8 lg:p-12">
                    <h2 class="text-3xl lg:text-5xl font-bold text-foreground mb-6">
                    Start Your Journey to Vitality
                    </h2>

                    <p class="text-xl text-muted-foreground mb-4">
                    Join thousands who have made Vital Boost part of their daily wellness
                    routine
                    </p>

                    <div
                    class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-6"
                    >
                    <div class="text-center">
                        <div
                        class="text-4xl font-bold gradient-primary text-transparent bg-clip-text"
                        >
                        $79.99
                        </div>
                        <p class="text-sm text-muted-foreground">One-time purchase</p>
                    </div>

                    <div class="text-muted-foreground hidden sm:block">or</div>

                    <div class="text-center p-4 bg-secondary rounded-lg">
                        <div
                        class="text-4xl font-bold gradient-primary text-transparent bg-clip-text"
                        >
                        $67.99
                        </div>
                        <p class="text-sm text-muted-foreground">
                        Subscribe &amp; Save 15%
                        </p>
                    </div>
                    </div>
                    <x-button-use href="{{ route('shop') }}" label="Order Vital Boost Now" variant="primary"  icon="zap" class="w-1/3 justify-self-center" />


                    <p class="text-sm text-muted-foreground mt-4">
                    Members receive additional discounts. Free shipping on orders over
                    $50.
                    </p>
                </div>
                </div>
            </div>
        </section>


        {{-- <x-ui.cta-section
                    icon="bookmark-check"
                    align="center"
                    title="Start Your Journey to Vitality"
                    subtitle="Join thousands who use Vital Boost daily"
                       class="py-0 my-0"
                    :buttons="[
                        ['route' => 'membership', 'label' => 'Get Started Today', 'variant' => 'outline', 'icon' => 'send'],
                        ['route' => 'intro-videos', 'label' => 'Watch Intro Videos', 'variant' => 'outline', 'icon' => 'tv-minimal'],
                    ]"
                >


                    <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-6">

                        <div class="text-center">
                            <div class="text-4xl font-bold   text-primary bg-clip-text">$79.99</div>
                            <p class="text-sm text-black font-bold ">One-time purchase</p>
                        </div>

                        <div class="text-muted-foreground hidden sm:block">or</div>

                        <div class="text-center p-4 bg-secondary rounded-lg">
                            <div class="text-4xl font-bold   text-primary bg-clip-text">$67.99</div>
                            <p class="text-sm  text-amber-500 font-bold  ">Subscribe & Save 15%</p>
                        </div>

                    </div>
                                    <p class="text-sm text-muted-foreground mt-4">
                                        Members receive additional discounts. <strong >Free shipping</strong> on orders over <span class="text-primary heading-4">$50</span>.
                                    </p>
        </x-ui.cta-section> --}}


    </main>

</div>
@endsection
