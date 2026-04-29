@extends('front.layouts.app')
@section('content')
<div class="min-h-screen flex flex-col">
    <main>
        @if(!empty($product))
        <section class="gradient-subtle py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div class="space-y-6">
                        <div class="inline-flex items-center space-x-2 bg-primary/10 px-4 py-2 rounded-full">
                            <i data-lucide="zap" class="w-5 h-5 text-primary"></i>
                            <span class="text-sm font-semibold text-primary">Premium Wellness Formula</span>
                        </div>
                        <h1 class="text-4xl lg:text-6xl font-bold text-foreground text-left">{{ $product->name ?? 'Vital Boost' }}</h1>
                        <p class="text-2xl text-muted-foreground">The finest supplement for the way we live today</p>
                        <p class="text-lg text-muted-foreground">{{ $product->description ?? 'Premium wellness formula designed to support your daily health and longevity needs.' }}</p>
                        <div class="p-4 bg-secondary/50 rounded-lg border-l-4 border-primary">
                            <p class="text-sm text-muted-foreground italic">
                                Originally formulated to protect patients from harmful effects of
                                dental radiation, now protects you from everyday electromagnetic
                                radiation from computers, cell phones, and other hi-tech devices.
                            </p>
                        </div>
                        <div class="flex flex-col sm:flex-row gap-4">
                            @if($product)
                                <x-button-use href="javascript:addToCart({{ $product->id }})" label="Order Now" variant="primary" icon="zap" />
                            @else
                                <x-button-use href="#" label="Coming Soon" variant="outline" icon="clock" disabled />
                            @endif
                            <!-- <x-button-use href="{{ url('/intro-videos') }}" label="Learn More" variant="outline"   /> -->
                        </div>
                    </div>
                    <div class="relative">
                        <div class="rounded-lg bg-card text-card-foreground shadow-sm shadow-strong border-2 border-primary/20">
                            <div class="p-8">
                                <div class="aspect-square rounded-2xl overflow-hidden">
                                    @if($product && !empty($product->image) && file_exists(public_path('product_images/'.$product->image)))
                                        <img src="{{ asset('product_images/'.$product->image) }}" alt="Vital Boost - Premium Longevity Formula" class="w-full h-full object-cover"/>
                                    @else
                                        <img src="{{asset('/assets/placeholder.svg')}}" alt="Vital Boost - Premium Longevity Formula" class="w-full h-full object-cover"/>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @endif

        {{-- Benefits Section --}}
        <section class="container-base py-20 bg-background">
            @php
            $benefits = [
                [
                    'icon' => 'heart',
                    'title' => 'Nutrient-Rich',
                    'description' => 'Promotes healthy heart function and optimal blood circulation'
                ],
                [
                    'icon' => 'brain',
                    'title' => 'Health Benefits Galore',
                    'description' => 'Experience increased energy, improved metabolism, better digestion, and a stronger immune system.'
                ],
                [
                    'icon' => 'shield',
                    'title' => 'Science-Backed',
                    'description' => 'Formulated by experts, it\'s designed to meet the demands of a hectic lifestyle while providing comprehensive nutritional support. Your Daily Dose of Wellness'
                ],
                [
                    'icon' => 'trending-up',
                    'title' => 'Economical Choice',
                    'description' => 'Save on supplements with this all-in-one solution that\'s easy on your wallet.'
                ],
                [
                    'icon' => 'zap',
                    'title' => 'Combat Modern Day Challenges',
                    'description' => 'From stress and pollution to the effects of electromagnetic radiation, Vital Boost is your shield against everyday health hazards'
                ],
                [
                    'icon' => 'users',
                    'title' => 'A Quality Life Awaits',
                    'description' => 'Notice the difference in your energy levels, vitality, and overall well-being as you make Vital Boost a part of your daily routine.'
                ]
            ];

            $ingredients = [
                "Vitamin C 1000 mg",
                "Vit B1 (Thymine) 3.15mg",
                "Vit B2 (riboflavin) 3.06mg",
                "Vit B3 (niacinamide) 20mg",
                "Vit B5 (Calcium pantothenate) 10mg",
                "Vit B6 (pyridoxine 10mg)",
                "Vit B12 ( hydroxyl cobalamin 5mcg",
                "Biotin 315mcg",
                "Folic acid 800mcg",
                "Vit A (entire carotene complex) 3,334 iu",
                "Vit E (d-alpha tocopheral succinate) 100iu",
                "Lipoic Acid 2mg",
                "CoenzymeQ10 50mg",
                "Selenium (Se-Methyselenocysteine) 9.8mcg",
                "Zinc (methionate and succinate) 36 mg" ,
                "Iodine (potassium iodide) 100mcg",
                "Copper 1mg",
                "Chromium (picolinate) 96mcg",
                "Potassium (bicarbonate) 250mg",
                "Molybdenum 80mcg",
                "Manganese (gluconate 4mg",
                "Magnesium (citrate,Aspartate,glycinate ascorbate) 192mg",
                "L-Lysine 250mg",
                "L-cysteine 250mg",
                "L-methionine 250mg",
                "Taurine 250mg",
                "Choline complex",
            ];
            @endphp

            <div class="container-base max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl lg:text-5xl font-bold text-foreground mb-4">Why Choose Vital Boost</h2>
                    <p class="text-xl text-muted-foreground max-w-3xl mx-auto">
                        Stress and emotions can prevent you from enjoying a happy life.
                        Another key fact is undernourishment.
                        It’s an unfortunate fact, we’re not getting the nutrients we need to handle daily “bumps” in our every lives.
                        You can’t be happy if you don’t feel good.
                        You can’t feel good if your nutritionally unbalanced!!!<br>
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
        <section class="section-base py-20 gradient-subtle vital-boost-section">
            <div class="container-base max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-6xl mx-auto">
                    <div class="shadow-strong rounded-xl bg-white overflow-hidden">
                        <!-- Header Section -->
                        <div class="bg-gradient-to-r from-primary/10 to-primary/5 p-8 lg:p-12">
                            <div class="text-center">
                                <h2 class="text-3xl lg:text-5xl font-bold text-foreground mb-6">VITAL BOOST - IMMUNE SYSTEM ENHANCER</h2>
                                <div class="max-w-4xl mx-auto">
                                    <p class="text-lg lg:text-xl text-muted-foreground leading-relaxed mb-8">
                                        Today's world offers us a variety of choices. Some beneficial, others detrimental to our health. Although we all share common goals for a better, healthier life with energy and joy, we don't always make the right choices as to the foods we eat and environments in which we live.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Content Section -->
                        <div class="p-8 lg:p-12">
                            <!-- Main Description -->
                            <div class="prose prose-lg max-w-none mb-12">
                                <p class="text-muted-foreground leading-relaxed mb-6">
                                    Many outside factors prevent us from achieving good health. <span class="text-primary font-semibold">Stress, Pollution, Diet, Radiation, Cell phones, Microwaves, Computers, High tech communication devices</span>, and Electrical conveniences we rely on every day. Their debilitating effects upon us are constant and accumulative.
                                </p>
                                
                                <p class="text-muted-foreground leading-relaxed mb-6">
                                    Vital Boost was originally formulated by Dr. Zeines, DDS, to help protect his patients from the effects of dental X-rays. Dr. Zeines has expanded and improved upon his supplement to now help protect all of us from everyday devices that emit electro-magnetic radiation (including the Doppler effect from weather radar, wireless Internet).
                                </p>

                                <p class="text-muted-foreground leading-relaxed mb-8">
                                    Research is beginning to confirm that even low-level electromagnetic radiation can negatively affect our DNA and cellular health.
                                </p>

                                <!-- FACT Cards -->
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                                    <div class="bg-gradient-to-br from-red-50 to-red-100 border-l-4 border-red-500 p-4 md:p-6 rounded-lg shadow-sm">
                                        <div class="inline-block bg-red-500 text-white px-3 py-1 rounded-full text-sm font-bold mb-3">FACT</div>
                                        <p class="text-gray-800 font-medium">
                                            Sperm counts have been decreasing while cancers are increasing.
                                        </p>
                                    </div>
                                    <div class="bg-gradient-to-br from-orange-50 to-orange-100 border-l-4 border-orange-500 p-4 md:p-6 rounded-lg shadow-sm">
                                        <div class="inline-block bg-orange-500 text-white px-3 py-1 rounded-full text-sm font-bold mb-3">FACT</div>
                                        <p class="text-gray-800 font-medium">
                                            Life spans have increased but quality of life has decreased significantly.
                                        </p>
                                    </div>
                                    <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 border-l-4 border-yellow-500 p-4 md:p-6 rounded-lg shadow-sm">
                                        <div class="inline-block bg-yellow-500 text-white px-3 py-1 rounded-full text-sm font-bold mb-3">FACT</div>
                                        <p class="text-gray-800 font-medium">
                                            More people suffer from chronic pain, weaknesses, depression, fatigue and immune health disorders than ever before.
                                        </p>
                                    </div>
                                </div>

                                                            </div>

                            <!-- Ingredients Grid -->
                            <div class="mt-12">
                                <h3 class="text-2xl font-bold text-foreground mb-6 text-center">Premium Ingredients</h3>
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
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="rounded-lg border bg-card text-card-foreground shadow-sm shadow-medium">
                    <div class="flex flex-col space-y-1.5 p-6">
                        <h3 class="font-semibold tracking-tight text-3xl text-center">How to Use Vital Boost</h3>
                    </div>
                    <div class="p-6 pt-0 space-y-6">
                        <div class="grid md:grid-cols-3 gap-6">
                            <div class="text-center p-6 bg-secondary rounded-xl">
                                <div class="text-4xl font-bold gradient-primary text-transparent bg-clip-text mb-2">1</div>
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
                                <div class="text-4xl font-bold gradient-primary text-transparent bg-clip-text mb-2">30</div>
                                <p class="text-muted-foreground">Day Supply</p>
                                <p class="text-sm text-muted-foreground mt-2">per box</p>
                            </div>
                        </div>
                        <div class="p-6 bg-primary/5 rounded-xl border-2 border-primary/20">
                            <h4 class="font-semibold text-foreground mb-3">Recommended Use:</h4>
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
                                    For best results, use consistently daily for optimal health benefits
                                </li>
                            </ul>
                        </div>
                        <div class="p-6 bg-secondary rounded-xl">
                            <h4 class="font-semibold text-foreground mb-3">Why Powder Form?</h4>
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

        <section class="py-20 gradient-subtle">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <div class="rounded-lg border bg-card text-card-foreground shadow-sm shadow-strong">
                    <div class="p-8 lg:p-12">
                        <h2 class="text-3xl lg:text-5xl font-bold text-foreground mb-6">Start Your Journey to Vitality</h2>
                        <p class="text-xl text-muted-foreground mb-4">
                            Join thousands who have made Vital Boost part of their daily wellness routine
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-6">
                            <div class="text-center">
                                <div class="text-4xl font-bold gradient-primary text-transparent bg-clip-text">$79.99</div>
                                <p class="text-sm text-muted-foreground">One-time purchase</p>
                            </div>
                            <div class="text-muted-foreground hidden sm:block">or</div>
                            <div class="text-center p-4 bg-secondary rounded-lg">
                                <div class="text-4xl font-bold gradient-primary text-transparent bg-clip-text">$67.99</div>
                                <p class="text-sm text-muted-foreground">Subscribe &amp; Save 15%</p>
                            </div>
                        </div>
                        <x-button-use href="{{ url('/membership') }}" label="Get Membership" variant="primary"  class="w-2/3 justify-self-center" />
                        <p class="text-sm text-muted-foreground mt-4">
                        Members receive additional discounts. Free shipping on orders over <span class="text-primary heading-4">$50</span>..
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </main>
</div>
<script src="{{ asset('js/cart.js') }}"></script>
@endsection