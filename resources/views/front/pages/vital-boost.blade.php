@extends('front.layouts.app')
@section('content')
@php
    // CMS sections (App\Models\VitalBoostContent), keyed by section_key. Every value below
    // falls back to the original hard-coded copy, so the page still renders if a section
    // has not been seeded or an admin deactivates one.
    $sections = $sections ?? collect();
    $hero     = $sections['hero']     ?? null;
    $benefits = $sections['benefits'] ?? null;
    $booster  = $sections['booster']  ?? null;
    $usage    = $sections['usage']    ?? null;
    $cta      = $sections['cta']      ?? null;

    $heroMeta    = $hero->meta    ?? [];
    $boosterMeta = $booster->meta ?? [];
    $usageMeta   = $usage->meta   ?? [];
    $ctaMeta     = $cta->meta     ?? [];

    $benefitCards = $benefits->items ?? [];
    if (empty($benefitCards)) {
        $benefitCards = [
            ['icon' => 'heart',       'title' => 'Rich in Vitamins and Minerals',    'description' => 'Boosts healthy functioning of the heart and helps in maintaining optimum blood flow in your body.'],
            ['icon' => 'brain',       'title' => 'Health All Around',                'description' => 'Experience an increase in your energy levels daily. Metabolism, digestion, and immunity will work well for you.'],
            ['icon' => 'shield',      'title' => 'Science Behind It',                'description' => 'Developed by experts to cater to the hectic lifestyles of today\'s generation and provide complete nutrition to your body.'],
            ['icon' => 'trending-up', 'title' => 'Economical and Efficient Wellness','description' => 'Get one solution that saves you money as well as provides you with all the essential nutrients in one single capsule.'],
            ['icon' => 'zap',         'title' => 'Tailored to Your Lifestyles',      'description' => 'Developed specifically to help your body combat all the stressors of today\'s technological world.'],
            ['icon' => 'users',       'title' => 'Experience Life to the Fullest',   'description' => 'Experience a boost in your energy levels, as well as experience wellness throughout your life.'],
        ];
    }

    $facts = $booster->items['facts'] ?? [];
    if (empty($facts)) {
        $facts = [
            'The number of sperm cells is going down, and cancer cases are going up.',
            'Our lifespan is getting longer, and the quality of our lives has greatly diminished.',
            'There are more individuals suffering from chronic pain, exhaustion, and compromised immune systems than ever before.',
        ];
    }
    // Card accents cycle so the FACT list stays styled however many an admin adds.
    $factStyles = [
        ['from-red-50 to-red-100 border-red-500', 'bg-red-500'],
        ['from-orange-50 to-orange-100 border-orange-500', 'bg-orange-500'],
        ['from-yellow-50 to-yellow-100 border-yellow-500', 'bg-yellow-500'],
    ];

    $ingredients = $booster->items['ingredients'] ?? [];
    if (empty($ingredients)) {
        $ingredients = [
            'Vitamin C 1000 mg', 'Vit B1 (Thymine) 3.15mg', 'Vit B2 (riboflavin) 3.06mg',
            'Vit B3 (niacinamide) 20mg', 'Vit B5 (Calcium pantothenate) 10mg', 'Vit B6 (pyridoxine 10mg)',
            'Vit B12 (hydroxyl cobalamin 5 mcg)', 'Biotin 315mcg', 'Folic acid 800mcg',
            'Vit A (entire carotene complex) 3,334 IU', 'Vit E (d-alpha tocopherol succinate) 100iu',
            'Lipoic Acid 2mg', 'Coenzyme Q10 50mg', 'Selenium (Se-Methyselenocysteine) 9.8mcg',
            'Zinc (methionate and succinate) 36 mg', 'Iodine (potassium iodide) 100mcg', 'Copper 1mg',
            'Chromium (picolinate) 96mcg', 'Potassium (bicarbonate) 250mg', 'Molybdenum 80mcg',
            'Manganese (gluconate) 4mg', 'Magnesium (citrate, Aspartate, glycinate, ascorbate) 192mg',
            'L-Lysine 250mg', 'L-cysteine 250mg', 'L-methionine 250mg', 'Taurine 250mg', 'Choline complex',
        ];
    }

    $usageStats = $usage->items['stats'] ?? [];
    if (empty($usageStats)) {
        $usageStats = [
            ['value' => '1',   'label' => 'Packet',       'sub' => 'daily'],
            ['value' => 'Mix', 'label' => 'Into a Drink', 'sub' => 'smoothie or juice'],
            ['value' => '30',  'label' => 'Day Supply',   'sub' => 'per box'],
        ];
    }

    $usageSteps = $usage->items['steps'] ?? [];
    if (empty($usageSteps)) {
        $usageSteps = [
            'Add one package to your morning smoothie or juice and stir.',
            'In the powdered form, absorption is much easier compared to tablets or capsules.',
            'It is made from pure and concentrated nutrients without any fillers or binders.',
            'Consistent daily intake gives maximum benefits.',
        ];
    }

    $powderPoints = $usage->items['powder_points'] ?? [];
    if (empty($powderPoints)) {
        $powderPoints = [
            'Better absorbed by your body than pills.',
            'Higher concentration of nutrients per serving.',
            'More cost-effective than juggling multiple pill supplements.',
            'Supports faster recovery from stress and daily demands.',
        ];
    }
@endphp
<div class="min-h-screen flex flex-col">
    <main>
        {{-- Hero Section — product purchase moved to the shop (/shop). This page is
             informational only; the Vital Boost product is bought from the store. --}}
        <section class="gradient-subtle py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div class="space-y-6">
                        <div class="inline-flex items-center space-x-2 bg-primary/10 px-4 py-2 rounded-full">
                            <i data-lucide="zap" class="w-5 h-5 text-primary"></i>
                            <span class="text-sm font-semibold text-primary">{{ $heroMeta['badge_text'] ?? 'Premium Wellness Formula' }}</span>
                        </div>
                        <h1 class="text-4xl lg:text-6xl font-bold text-foreground text-left">{{ $hero->heading ?? 'Vital Boost' }}</h1>
                        <p class="text-2xl text-muted-foreground">{{ $hero->subheading ?? 'The finest supplement for the way we live today' }}</p>
                        <p class="text-lg text-muted-foreground">{{ $hero->body ?? 'Premium wellness formula designed to support your daily health and longevity needs.' }}</p>
                        @if(!empty($heroMeta['note']) || !$hero)
                        <div class="p-4 bg-secondary/50 rounded-lg border-l-4 border-primary">
                            <p class="text-sm text-muted-foreground italic">
                                {{ $heroMeta['note'] ?? 'Originally formulated to protect patients from harmful effects of dental radiation, now protects you from everyday electromagnetic radiation from computers, cell phones, and other hi-tech devices.' }}
                            </p>
                        </div>
                        @endif
                        <div class="flex flex-col sm:flex-row gap-4">
                            <x-button-use href="{{ url('/shop') }}" :label="$heroMeta['cta_label'] ?? 'Shop Now'" variant="primary" icon="shopping-cart" />
                        </div>
                    </div>
                    <div class="relative">
                        <div class="rounded-lg bg-card text-card-foreground shadow-sm shadow-strong border-2 border-primary/20">
                            <div class="p-8">
                                <div class="aspect-square rounded-2xl overflow-hidden">
                                    <img src="{{asset('/assets/vitalboost.webp')}}" alt="Vital Boost - Premium Longevity Formula" class="w-full h-full object-cover"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Benefits Section --}}
        <section class="container-base py-20 bg-background">
            <div class="container-base max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl lg:text-5xl font-bold text-foreground mb-4">{{ $benefits->heading ?? 'What Makes Vital Boost Different' }}</h2>
                    <p class="text-xl text-muted-foreground max-w-3xl mx-auto">
                        {{ $benefits->body ?? 'Both stress and emotions may prevent you from living happily, too. There is one more thing that we usually ignore: malnutrition. The reality is that we don\'t provide ourselves with enough nutrition that can help us cope with all our everyday tasks. You can\'t lead a happy life if you don\'t feel good. And you can\'t feel good without proper nutrition. That\'s exactly where Vital Boost comes in and helps you.' }}
                    </p>
                </div>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($benefitCards as $b)
                    <div class="border-2 hover:border-primary transition-all shadow-soft hover:shadow-medium rounded-xl">
                        <div class="p-6 space-y-4">
                            <div class="iconbg w-14 h-14">
                                <i data-lucide="{{ $b['icon'] ?? 'heart' }}" class="h-7 w-7 text-primary-foreground"></i>
                            </div>
                            <h3 class="heading-3">{{ $b['title'] ?? '' }}</h3>
                            <p class="text-muted-foreground text-[16px]">{{ $b['description'] ?? '' }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- Immune System Booster / Ingredients Section --}}
        <section class="section-base py-20 gradient-subtle vital-boost-section">
            <div class="container-base max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-6xl mx-auto">
                    <div class="shadow-strong rounded-xl bg-white overflow-hidden">
                        <!-- Header Section -->
                        <div class="bg-gradient-to-r from-primary/10 to-primary/5 p-8 lg:p-12">
                            <div class="text-center">
                                <h2 class="text-3xl lg:text-5xl font-bold text-foreground mb-6">{{ $booster->heading ?? 'Vital Boost — Immune System Booster' }}</h2>
                                <div class="max-w-4xl mx-auto">
                                    <p class="text-lg lg:text-xl text-muted-foreground leading-relaxed mb-8">
                                        {{ $booster->subheading ?? 'Life is full of options in the modern world. Some are beneficial to our well-being, while some others are actually working against it. Everybody wants to live an energetic and happy life, but we may not be doing everything right.' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Content Section -->
                        <div class="p-8 lg:p-12">
                            <div class="prose prose-lg max-w-none mb-12">
                                @php
                                    $boosterBody = $booster->body
                                        ?? "Several external factors prevent us from being healthy. Such as stress, pollution, nutrition, and constant exposure to technologies. Cell phones, computer systems, microwaves, and any other appliances also belong to this category. They have an effect on our bodies slowly and unnoticeably to us.\n\nVital Boost was created by Dr. Zeines, DDS. He designed it to protect his patients from the effects of dental X-rays. Over time, he expanded the formula. Today, it is designed to help support your body against everyday electromagnetic exposure, from wireless devices to daily tech use.\n\nSome research proves now that even minimal magnetic fields might affect our DNA and cell work.";
                                    $boosterParagraphs = preg_split('/\R{2,}/', trim($boosterBody));
                                @endphp
                                @foreach($boosterParagraphs as $paragraph)
                                    <p class="text-muted-foreground leading-relaxed mb-6">{{ $paragraph }}</p>
                                @endforeach

                                <!-- FACT Cards -->
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8 mt-8">
                                    @foreach($facts as $i => $fact)
                                        @php $style = $factStyles[$i % count($factStyles)]; @endphp
                                        <div class="bg-gradient-to-br {{ $style[0] }} border-l-4 p-4 md:p-6 rounded-lg shadow-sm">
                                            <div class="inline-block {{ $style[1] }} text-white px-3 py-1 rounded-full text-sm font-bold mb-3">FACT</div>
                                            <p class="text-gray-800 font-medium">{{ $fact }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Ingredients Grid -->
                            <div class="mt-12">
                                <h3 class="text-2xl font-bold text-foreground mb-6 text-center">{{ $boosterMeta['ingredients_heading'] ?? 'Premium Ingredients' }}</h3>
                                <div class="grid grid-cols-2 lg:grid-cols-3 gap-4">
                                    @foreach($ingredients as $item)
                                    <div class="flex items-start gap-3 p-4 bg-gradient-to-r from-secondary/50 to-secondary/30 rounded-lg border border-secondary/200 hover:shadow-md transition-shadow">
                                        <div class="w-3 h-3 rounded-full bg-primary flex-shrink-0 self-start mt-1"></div>
                                        <span class="text-foreground font-medium text-sm">{{ $item }}</span>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Dosage & Usage --}}
        <section class="py-20 bg-background">
            <div class="container-base max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="rounded-lg border bg-card text-card-foreground shadow-sm shadow-medium">
                    <div class="flex flex-col space-y-1.5 p-6">
                        <h3 class="font-semibold tracking-tight text-3xl text-center">{{ $usage->heading ?? 'Your Daily Vital Boost Routine' }}</h3>
                    </div>
                    <div class="p-6 pt-0 space-y-6">
                        <div class="grid md:grid-cols-3 gap-6">
                            @foreach($usageStats as $stat)
                            <div class="text-center p-6 bg-secondary rounded-xl">
                                <div class="text-4xl font-bold gradient-primary text-transparent bg-clip-text mb-2">{{ $stat['value'] ?? '' }}</div>
                                <p class="text-muted-foreground">{{ $stat['label'] ?? '' }}</p>
                                <p class="text-sm text-muted-foreground mt-2">{{ $stat['sub'] ?? '' }}</p>
                            </div>
                            @endforeach
                        </div>
                        <div class="p-6 bg-primary/5 rounded-xl border-2 border-primary/20">
                            <h4 class="font-semibold text-foreground mb-3">{{ $usageMeta['steps_heading'] ?? 'Simple Steps to Follow:' }}</h4>
                            <ul class="space-y-2 text-muted-foreground">
                                @foreach($usageSteps as $step)
                                <li class="flex items-start">
                                    <span class="text-primary mr-2">•</span>
                                    {{ $step }}
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="p-6 bg-secondary rounded-xl">
                            <h4 class="font-semibold text-foreground mb-3">{{ $usageMeta['powder_heading'] ?? 'Why Powder Beats Pills?' }}</h4>
                            <p class="text-muted-foreground mb-3">
                                {{ $usageMeta['powder_intro'] ?? 'Vital Boost skips the pill and the capsule entirely. It\'s a daily powdered drink mix, built fresh for your body\'s needs.' }}
                            </p>
                            <ul class="space-y-2 text-muted-foreground text-sm">
                                @foreach($powderPoints as $point)
                                <li class="flex items-start">
                                    <span class="text-primary mr-2">✓</span>
                                    {{ $point }}
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Call To Action --}}
        <section class="py-20 gradient-subtle">
            <div class="container-base max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <div class="rounded-lg border bg-card text-card-foreground shadow-sm shadow-strong">
                    <div class="p-8 lg:p-12">
                        <h2 class="text-3xl lg:text-5xl font-bold text-foreground mb-6">{{ $cta->heading ?? 'Begin Your Path to Vitality' }}</h2>
                        <p class="text-xl text-muted-foreground mb-4">
                            {{ $cta->subheading ?? 'Join the many members who\'ve made Vital Boost part of their daily routine.' }}
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-6">
                            <div class="text-center">
                                <div class="text-4xl font-bold gradient-primary text-transparent bg-clip-text">{{ $ctaMeta['price_one_time'] ?? '$79.99' }}</div>
                                <p class="text-sm text-muted-foreground">{{ $ctaMeta['price_one_time_label'] ?? 'One-time purchase' }}</p>
                            </div>
                            <div class="text-muted-foreground hidden sm:block">or</div>
                            <div class="text-center p-4 bg-secondary rounded-lg">
                                <div class="text-4xl font-bold gradient-primary text-transparent bg-clip-text">{{ $ctaMeta['price_subscription'] ?? '$67.99' }}</div>
                                <p class="text-sm text-muted-foreground">{{ $ctaMeta['price_subscription_label'] ?? 'Subscribe & Save 15%' }}</p>
                            </div>
                        </div>
                        <x-button-use href="{{ url('/membership') }}" :label="$ctaMeta['cta_label'] ?? 'Explore Membership'" variant="primary" class="w-2/3 justify-self-center" />
                        <p class="text-sm text-muted-foreground mt-4">
                            {{ $ctaMeta['footer_note'] ?? 'Members enjoy additional discounts. Free shipping on orders over $50.' }}
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </main>
</div>
@endsection
