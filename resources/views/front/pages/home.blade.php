@extends('front.layouts.app')
@section('content')
@php
    // CMS sections (App\Models\PageContent, page_key "home"), keyed by section_key. Every value
    // below falls back to the same copy the seeder installs, so the page still renders in full
    // if a section has not been seeded. Deactivating a section in the admin hides it.
    $sections     = $sections ?? collect();
    $hero         = $sections['hero']         ?? null;
    $intro        = $sections['intro']        ?? null;
    $membership   = $sections['membership']   ?? null;
    $introVideo   = $sections['intro_video']  ?? null;
    $community    = $sections['community']    ?? null;
    $vitalBoost   = $sections['vital_boost']  ?? null;
    $testimonials = $sections['testimonials'] ?? null;
    $newsletter   = $sections['newsletter']   ?? null;
    $homeCta      = $sections['cta']          ?? null;

    $heroMeta       = $hero->meta       ?? [];
    $introMeta      = $intro->meta      ?? [];
    $introVideoMeta = $introVideo->meta ?? [];
    $commMeta       = $community->meta  ?? [];
    $vitalMeta      = $vitalBoost->meta ?? [];
    $ctaMeta        = $homeCta->meta    ?? [];

    $features = $introVideo->items['cards'] ?? [];
    if (empty($features)) {
        $features = [
            ['icon' => 'message-circle', 'title' => 'Ask Us Anything',           'description' => 'Take part in our exclusive monthly Q&A sessions, where you can ask your questions directly and receive clear, personal answers about the course.'],
            ['icon' => 'sparkles',       'title' => 'Fresh Expert Perspectives', 'description' => 'Each session welcomes a guest speaker who adds fresh, expert insight, making every class richer and more valuable.'],
            ['icon' => 'users',          'title' => 'Connect & Grow Together',   'description' => 'These sessions go beyond learning. They are a chance to connect with fellow members and enjoy the journey toward better health together.'],
        ];
    }

    $communityBlocks = $community->items['blocks'] ?? [];
    if (empty($communityBlocks)) {
        $communityBlocks = [
            ['title' => 'Comprehensive Health Information', 'description' => 'Get exclusive information about many different body functions and various health aspects.'],
            ['title' => 'Flexible Learning',                'description' => 'The lectures are divided into small, manageable parts that make learning easy.'],
            ['title' => 'Regular Updates',                  'description' => 'Our regularly updated lectures by guest speakers will keep you up-to-date about new health trends. Some of our lecture topics include:'],
        ];
    }

    $lectureTopics = $community->items['topics'] ?? [];
    if (empty($lectureTopics)) {
        $lectureTopics = [
            'Periodontal Disease Explained', 'Herbology Basics', 'Root Canal Safety Facts',
            'Preventing and Understanding Cancer', 'Why Acupuncture Works', 'Understanding Immunology',
            'Kinesiology Explained', 'Managing Mercury Toxicity', 'Magnet Therapy and Essential Oils',
            'Fluoride Exposure Awareness', 'Lifelong Nutrition', 'Understanding TMJ Disorders',
            'Color Therapy Explained', 'Stem Cell Science and Possibilities',
        ];
    }

    $benefits1 = $vitalBoost->items['cards'] ?? [];
    if (empty($benefits1)) {
        $benefits1 = [
            ['icon' => 'leaf',     'title' => 'A Superfood Symphony',     'description' => 'Packed with organic spirulina, barley grass, wheat grass, spinach, and more, Vital Boost is a symphony of superfoods.'],
            ['icon' => 'sparkles', 'title' => 'Easy to Use',              'description' => 'Just mix it into your smoothie or juice for a tasty, nutritious start to your day.'],
            ['icon' => 'pill',     'title' => 'More Than a Multivitamin', 'description' => 'Say goodbye to your old multivitamins. Vital Boost offers a more complete and potent nutritional profile.'],
            ['icon' => 'award',    'title' => 'Doctor-Approved',          'description' => 'Developed with insights from years of medical experience and research.'],
        ];
    }

    $newsletterCards = $newsletter->items['cards'] ?? [];
    if (empty($newsletterCards)) {
        $newsletterCards = [
            ['icon' => 'star',  'title' => 'Insider Access',         'description' => "Gain access to insightful articles, the latest breakthroughs, and expert advice you won't find anywhere else."],
            ['icon' => 'heart', 'title' => 'Tips Made for You',      'description' => 'Get wellness tips tailored specifically to your own health journey.'],
            ['icon' => 'users', 'title' => 'A Community That Cares', 'description' => 'Join a community that encourages and motivates one another toward a healthier, happier life.'],
        ];
    }
@endphp
<main class="flex-1 font-jakarta">
    <section class="section-base relative overflow-hidden mb-0">
        <div class="container-base ">
            <div class="flex flex-col sm:flex-row justify-center gap-4 ">
                <div class="left-0 -mt-16">
                    <img src="{{asset('assets/leaf-1.webp')}}" class="absolute left-6   w-20 opacity-80 hidden md:block" />
                    <img src="{{asset('assets/leaf-2.webp')}}" class="absolute left-6   w-20 opacity-80 hidden md:block" />
                </div>
                <div class="right-0 -mt-16 ">
                    <img src="{{asset('assets/leaf-1.webp')}}" class="absolute right-6 w-20 opacity-80 hidden md:block mt-2" />
                    <img src="{{asset('assets/leaf-2.webp')}}" class="absolute right-6 w-20 opacity-80 hidden md:block" />
                </div>
            </div>

            <div class="max-w-6xl mx-auto px-6 text-center pb-12">
                <!-- Heading -->
                @if($hero || !$sections->count())
                    <p class="text-lg md:text-xl font-light tracking-[0.2em] mb-2 uppercase text-gray-800">
                        {{ $heroMeta['eyebrow'] ?? 'Welcome To' }}
                    </p>
                    <h1 class="text-3xl md:text-4xl lg:text-5xl font-normal tracking-wide text-gray-900 uppercase">
                        {{ $hero->heading ?? 'The Science of Living Well, Made Simple' }}
                    </h1>
                    <p class="mt-8 text-2xl md:text-3xl font-light text-gray-700 max-w-4xl mx-auto leading-relaxed">
                        {{ $hero->subheading ?? 'Clear health education for real life and better living.' }}
                    </p>
                    <p class="mt-4 text-lg text-gray-600 max-w-3xl mx-auto leading-relaxed">
                        {{ $hero->body ?? 'In matters concerning your health, speculation takes time, effort, and progress. We provide you with all that you need through our classes and monthly expert sessions to help you build a healthy life.' }}
                    </p>

                    <!-- CTA -->
                    <div class="flex flex-col sm:flex-row justify-center gap-4 mt-8">
                        <x-button-use href="{{url('/membership')}}" :label="$heroMeta['primary_label'] ?? 'Join The Community'" variant="primary" icon="send" />
                        <x-button-use href="{{url('/intro-videos')}}" :label="$heroMeta['secondary_label'] ?? 'View Intro Videos'" variant="outline" icon="video" />
                    </div>
                @endif

                <!-- Main Illustration -->
                {{-- The illustration keeps the full container width and is never cropped.
                     One ingredient shape per side, tucked close to the artwork; the bowls sit back in
                     their original spot at the bottom-left/bottom-right corners. --}}
                <div class="relative mt-12 flex justify-center mx-0 px-0">
                    {{-- Left side --}}
                    <img src="{{asset('assets/ingredients_shape1.png')}}" class="absolute -left-4 top-8 w-20 opacity-80 hidden xl:block" />
                    <img src="{{asset('assets/ingredients_shap.webp')}}" class="absolute left-10 bottom-10 w-28 hidden md:block" />

                    {{-- Right side --}}
                    <img src="{{asset('assets/ingredients_shape1.png')}}" class="absolute -right-4 top-8 w-20 opacity-80 hidden xl:block" />
                    <img src="{{asset('assets/ingredients_shap.webp')}}" class="absolute right-10 bottom-10 w-28 hidden md:block" />

                    <img src="{{asset('assets/wellness.webp')}}" alt="Wellness Illustration" class="w-full h-auto object-contain" />
                </div>
            </div>
        </div>
    </section>

    <!-- Hero Section -->
    @if($intro || !$sections->count())
    <section class="section-base relative gradient-subtle py-20  overflow-hidden bg-stone-50">
        <div class="container-base max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class=" grid lg:grid-cols-2 gap-12 items-center">
                <div class="space-y-8 ">
                    <span class="text-sm font-semibold tracking-wide uppercase text-primary text-emerald-500">{{ $introMeta['eyebrow'] ?? 'STEP INTO THE INSTITUTE FOR LIVING LONGER' }}</span>
                    <h1 class="text-4xl lg:text-6xl font-bold leading-tight text-teal-950">{{ $intro->heading ?? 'Begin Your Journey to Lifelong Wellness' }}</h1>
                    <p class="text-xl text-muted-foreground text-neutral-500">
                        {{ $intro->body ?? 'Real change starts with the right knowledge and the right people around you. Our community brings together evidence-based guidance and expert support to help you build habits that truly last, for life.' }}
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{url('/membership')}}" class="btn-hero w-full sm:w-auto font-semibold  px-5 py-3 rounded-md  flex items-center justify-center bg-emerald-500 hover:bg-orange-600 text-white">
                            {{ $introMeta['primary_label'] ?? 'Start Your Journey' }} <i data-lucide="arrow-right" class="ml-2 w-5 h-5"></i>
                        </a>
                        <a href="{{url('/about-dr-zeines')}}" class="btn-outline w-full sm:w-auto flex items-center justify-center font-semibold px-5 py-3 rounded-md border-emerald-500 border-2 hover:bg-orange-600  hover:text-white hover:border-orange-600 ">
                            <i data-lucide="play" class="mr-2 w-5 h-5"></i> {{ $introMeta['secondary_label'] ?? 'Meet Your Guide' }}
                        </a>
                    </div>
                </div>
                {{-- No fixed aspect box and no object-cover: the portrait is 845x684, so forcing it
                     into a 16:9 frame would slice off the top and bottom. --}}
                <div class="rounded-lg overflow-hidden shadow-strong">
                    <img src="{{asset('assets/dr-zeines.webp')}}" alt="Dr. Victor Zeines" class="w-full h-auto object-contain" />
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- Membership Section -->
    @if(count($memberships) > 0)
    <section class="section-base py-20 gradient-subtle bg-stone-50">
        <div class="contatiner-base max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-5xl font-bold mb-4">{{ $membership->heading ?? 'Choose Your Membership' }}</h2>
                <p class="text-xl text-muted-foreground  max-w-3xl mx-auto">{{ $membership->subheading ?? 'Select the plan that best fits your wellness goals' }}</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 max-w-7xl mx-auto">
                @foreach($memberships as $plan)
                    @php
                        $isPopular = ($plan->popular == 'yes') ? true : false;
                        $isCurrentPlan = false;
                        if(Auth::check())
                            $isCurrentPlan = (auth()->user()->plan_id == $plan->id) ? true : false;

                        $membership_features = explode(",", $plan->membership_features);
                        $membership_benefits = explode(",", $plan->membership_benefits);
                    @endphp
                    {{-- h-full on both so every card fills its grid cell and all cards end up the same height,
                         whatever the number of features/benefits. --}}
                    <div class="relative h-full"   x-data="{ selectedPlan: { name: '', price: '', period: '' } }">
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

                        <div class=" border-gray-200 flex-1 flex flex-col px-6 pb-6">
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
                            <button type="button" class="{{ $isPopular ? 'gradient-primary text-primary-foreground shadow-medium font-semibold' : 'border-2 border-primary text-primary' }} {{ $isCurrentPlan ? 'opacity-50 cursor-not-allowed' : 'hover:opacity-90' }} h-11 rounded-md px-8 w-full mt-8" command="show-modal"  commandfor="dialog" data-plan-id="{{ $plan->id }}" data-plan-name="{{ $plan->membership_name }}" data-plan-price="{{ $plan->membership_price }}" data-plan-period="{{ $plan->membership_period }}" onclick="openPlanModal(this)" @if($isCurrentPlan) disabled @endif>
                                @if($isCurrentPlan)
                                    Current Plan
                                @else
                                    Get Started
                                @endif
                            </button>
                        <x-membership-card :plan="$plan" />
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Intro Videos Section -->
    @if($introVideo || !$sections->count())
    <section class="section-base py-20 bg-primary relative overflow-hidden">
        {{-- Background pattern --}}
        <div class="container-base absolute inset-0 opacity-10">
            <div class="absolute top-0 left-0 w-96 h-96 bg-background rounded-full -translate-x-1/2 -translate-y-1/2"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-background rounded-full translate-x-1/2 translate-y-1/2"></div>
        </div>
        <div class="container mx-auto px-4 lg:px-8 relative z-10">
            <h2 class="font-display text-3xl md:text-4xl font-bold text-primary-foreground text-center mb-12">{{ $introVideo->heading ?? 'Get a quick look inside' }}</h2>
            {{-- Video placeholder --}}
            <div class="max-w-6xl mx-auto mb-16">
                <button type="button" data-video="{{ $introVideoMeta['video_url'] ?? 'https://player.vimeo.com/video/817940268?h=5e53563' }}" class="open-video-btn block w-full text-left relative aspect-video bg-foreground/20 rounded-2xl overflow-hidden group cursor-pointer shadow-strong">
                    <div class="relative aspect-video bg-cover bg-center rounded-2xl overflow-hidden group" style="background-image: url('{{ asset('assets/home-bg.png') }}');">
                        <div class="absolute inset-0 bg-gradient-to-br from-primary-dark/80 to-primary/80 flex items-center justify-center">
                            <div class="w-20 h-20 rounded-full bg-primary-foreground flex items-center justify-center group-hover:scale-110 transition-transform shadow-lg">
                                <i data-lucide="play" class="h-8 w-8 text-primary ml-1"></i>
                            </div>
                        </div>
                        <div class="absolute bottom-4 left-4 right-4 text-primary-foreground z-10">
                            <p class="text-sm font-medium">{{ $introVideoMeta['video_label'] ?? 'DR. VICTOR ZEINES' }}</p>
                            <p class="text-lg font-display">{{ $introVideoMeta['video_title'] ?? 'HEALTHY LIFE VIDEO' }}</p>
                        </div>
                    </div>
                </button>
            </div>

            {{-- Features --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach ($features as $feature)
                    <div class="text-center">
                        <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-primary-foreground/10 flex items-center justify-center">
                            {{-- dynamic icon blade component --}}
                            <i data-lucide="{{ $feature['icon'] ?? 'sparkles' }}" class="h-8 w-8 text-primary-foreground" > </i>
                        </div>
                        <h3 class="font-display text-xl font-semibold text-primary-foreground mb-3">{{ $feature['title'] ?? '' }}</h3>
                        <p class="text-primary-foreground/80 text-sm leading-relaxed">{{ $feature['description'] ?? '' }}</p>
                    </div>
                @endforeach
            </div>

            {{-- Signature --}}
            <div class="text-center mt-16">
                <p class="text-primary-foreground/70 uppercase tracking-wider text-sm mb-2">{{ $introVideoMeta['signature_intro'] ?? 'We hope to see you soon' }}</p>
                <p class="font-display text-2xl text-primary-foreground italic">{{ $introVideoMeta['signature'] ?? 'Wishing you health and happiness, Victor Zeines' }}</p>
            </div>
        </div>

        <!-- Video Modal (opens the intro video in an iframe, same as the intro-videos page) -->
        <div id="videoModal" class="fixed inset-0 bg-black bg-opacity-70 hidden items-center justify-center z-50">
            <div class="relative w-full max-w-4xl mx-auto px-4">
                <!-- Close Button -->
                <button id="closeModal" type="button" class="absolute -top-10 right-4 text-white text-2xl">✕</button>
                <!-- Video container -->
                <div class="aspect-w-16 aspect-h-9 bg-black">
                    <iframe
                        id="videoFrame"
                        src=""
                        frameborder="0"
                        allow="autoplay; fullscreen"
                        allowfullscreen
                        class="w-full h-[500px] rounded-lg">
                    </iframe>
                </div>
            </div>
        </div>
    </section>
    <script>
    (function () {
        const modal = document.getElementById('videoModal');
        const iframe = document.getElementById('videoFrame');
        const closeBtn = document.getElementById('closeModal');
        if (!modal || !iframe) return;

        function closeModal() {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            iframe.src = ''; // stop playback
        }

        document.querySelectorAll('.open-video-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                const videoUrl = this.getAttribute('data-video');
                if (!videoUrl) return;
                // Convert a Vimeo link to its embed form; strip any query string
                // (e.g. ?h=...) so the id is clean before adding autoplay.
                const videoId = videoUrl.split('/').pop().split('?')[0];
                iframe.src = `https://player.vimeo.com/video/${videoId}?autoplay=1`;
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            });
        });

        if (closeBtn) closeBtn.addEventListener('click', closeModal);
        modal.addEventListener('click', function (e) {
            if (e.target === modal) closeModal();
        });
    })();
    </script>
    @endif

    {{-- Join Our Community Section --}}
    @if($community || !$sections->count())
    <section class="section-base py-20 bg-background">
        <div class="container-base mx-auto px-4 lg:px-8">
            {{-- Main Heading --}}
            <h2 class="heading-1 mb-4 ">
                {{ $community->heading ?? 'Join a Community Built for a Longer, Healthier Life' }}
            </h2>
            <div class="max-w-4xl mx-auto">
                @foreach ($communityBlocks as $block)
                    <div class="text-center my-12">
                        <h3 class="text-primary text-xl font-semibold uppercase tracking-wider mb-2">{{ $block['title'] ?? '' }}</h3>
                        <p class="text-muted-foreground">{{ $block['description'] ?? '' }}</p>
                    </div>
                @endforeach

                {{-- Topics Grid --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-12">
                    @foreach ($lectureTopics as $topic)
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full gradient-primary flex items-center justify-center flex-shrink-0">
                                <i data-lucide="circle-check-big" class="h-5 w-5 text-primary-foreground"></i>
                            </div>
                            <span class="text-foreground">{{ $topic }}</span>
                        </div>
                    @endforeach
                </div>

                {{-- Description --}}
                <p class="text-center text-muted-foreground mb-10">
                    {{ $community->body ?? 'Curious to learn more? Join our community and get full access to our complete collection of videos and resources, all built to support your path to better health.' }}
                </p>

                {{-- CTAs --}}
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <x-button-use href="{{url('/membership')}}" :label="$commMeta['primary_label'] ?? 'Join Us Today'" variant="outline" icon="send" />
                    <x-button-use href="{{url('/intro-videos')}}" :label="$commMeta['secondary_label'] ?? 'Preview Our Videos'" variant="outline" icon="tv-minimal" />
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- vital boost --}}
    @if(!empty($product) && ($vitalBoost || !$sections->count()))
    <section class="section-base bg-gray-100 bg-background relative overflow-hidden" style="background-image: url('{{ asset('assets/features_product_dots.png')}}')">
        <div class="container-base  ">
            <div class="flex justify-center -mt-8 sm:-mt-12">
                <span class="text-primary  bg-gray-100 hover:shadow-md px-4 py-2 rounded-full  text-sm font-semibold uppercase tracking-wider">
                    {{ $vitalMeta['badge'] ?? '** Unlock the Power of Vital Boost **' }}
                </span>
            </div>
            <div class="mx-auto px-4 lg:px-8" >
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center py-10">
                    {{-- Image --}}
                    <div class="relative" >
                        <img src="{{ asset('product_images/'.$product->image) }}" alt="Vital Boost superfood supplement" class="w-full max-w-md mx-auto"/>
                    </div>
                    {{-- Content --}}
                    <div>
                        <h2 class="font-display text-3xl md:text-4xl lg:text-5xl font-bold text-foreground mt-2 mb-6">{{ $product->name ?? 'Product Not Available' }}</h2>
                        <p class="text-muted-foreground mb-8 leading-relaxed">{{ $product->description ?? 'No product description available.' }}</p>
                        {{-- Benefits list --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-8">
                            @foreach ($benefits1 as $benefit)
                                <div class="flex items-start gap-3">
                                    <div class="w-10 h-10 rounded-full gradient-primary flex items-center justify-center flex-shrink-0">
                                        <i data-lucide="{{ $benefit['icon'] ?? 'leaf' }}" class="h-5 w-5 text-primary-foreground" ></i>
                                    </div>
                                    <div>
                                        <h3 class="heading-4 font-semibold text-foreground mb-1">{{ $benefit['title'] ?? '' }}</h3>
                                        <p class="text-sm text-muted-foreground">{{ $benefit['description'] ?? '' }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        {{-- Button --}}
                        <div class="flex justify-center ">
                            <x-button-use href="{{url('/vital-boost')}}" :label="$vitalMeta['cta_label'] ?? 'Learn More'" variant="primary" icon="arrow-right" class="w-2/3 self-center" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- testimonials --}}
    @if(count($videoTestimonials) > 0 && ($testimonials || !$sections->count()))
    <section class="py-10 bg-background">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl lg:text-5xl font-bold text-foreground mb-4">{{ $testimonials->heading ?? 'What Our Members Say' }}</h2>
            </div>
            <x-ui.carousel :items="$videoTestimonials" autoplay="true" speed="3000" />
        </div>
    </section>
    @endif

    {{-- newsletter section --}}
    @if($newsletter || !$sections->count())
    <section class="py-10 bg-primary relative overflow-hidden">
        <img src="{{ asset('assets/leaf-1.webp') }}" alt="" class="absolute top-10 left-10 w-32 opacity-20 animate-float"/>
        <img src="{{ asset('assets/leaf-1.webp') }}" alt="" class="absolute bottom-10 right-10 w-32 opacity-20 scale-x-[-1] animate-float-delayed"/>
        <div class="container mx-auto px-4 lg:px-8 relative z-10">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="heading-2 text-white my-5">{{ $newsletter->heading ?? 'Stay Connected With Us' }}</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    @foreach ($newsletterCards as $card)
                    <div class="text-center">
                        <div class="w-12 h-12 mx-auto mb-3 rounded-full bg-white/20 flex items-center justify-center">
                            <i data-lucide="{{ $card['icon'] ?? 'star' }}" class="w-6 h-6 text-white"></i>
                        </div>
                        <h3 class="text-white font-semibold text-lg mb-2">{{ $card['title'] ?? '' }}</h3>
                        <p class="text-primary-foreground/80 text-sm leading-relaxed px-2">{{ $card['description'] ?? '' }}</p>
                    </div>
                    @endforeach
                </div>
                <form action="{{ route('newsletter.subscribe') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <x-form.input type="text" name="firstName" placeholder="Enter First Name*" autocomplete="off" required />
                            @error('firstName')
                                <p class="text-red-800 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <x-form.input type="text" name="lastName" placeholder="Enter Last Name*" autocomplete="off" required />
                            @error('lastName')
                                <p class="text-red-800 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div>
                        <x-form.input type="email" name="email" placeholder="Enter Email*" autocomplete="off" required />
                    </div>
                    <div>
                        <x-form.select
                            name="gender"
                            :options="[
                                ['value'=>'not','label'=>'Not specified'],
                                ['value'=>'woman','label'=>'Woman'],
                                ['value'=>'man','label'=>'Man'],
                            ]"
                            required
                        />
                        @error('gender')
                            <p class="text-red-800 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex justify-center mt-12">
                        <x-button-use type="submit" variant="outline" size="lg" class="bg-accent hover:bg-gray-600 shadow-md text-white">Subscribe</x-button-use>
                    </div>
                </form>
            </div>
        </div>
    </section>
    @endif

    <!-- CTA Section -->
    @if($homeCta || !$sections->count())
    <section class="section-base py-10   text-center bg-white">
        <div class="container-base max-w-4xl mx-auto px-4 py-12 sm:px-6 lg:px-8 bg-gray-50 ">
        <h2 class="text-3xl lg:text-5xl font-bold mb-6">{{ $homeCta->heading ?? 'Excited To Have You With Us' }}</h2>
        <p class="text-2xl  mb-4">{{ $homeCta->subheading ?? 'With health and happiness,' }}</p>
        <p class="text-2xl font-semibold text-emerald-500  mb-8 ">{{ $ctaMeta['signature'] ?? 'Victor Zeines' }}</p>
            <div class="max-w-64 mx-auto">
                <a href="{{url('/membership')}}" class=" sm:w-auto flex items-center justify-center font-semibold px-5 py-3 rounded-md bg-emerald-500 border-2 hover:bg-orange-600  text-white  ">
                    {{ $ctaMeta['cta_label'] ?? 'Become a Member' }} <i data-lucide="arrow-right" class="ml-2 w-5 h-5"></i>
                </a>
            </div>
        </div>
    </section>
    @endif
</main>
@endsection
