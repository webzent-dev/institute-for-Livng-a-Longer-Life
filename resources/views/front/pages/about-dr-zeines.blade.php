@extends('front.layouts.app')
@section('content')
@php
    // CMS sections (App\Models\PageContent, page_key "about"), keyed by section_key. Every value
    // below falls back to the original hard-coded copy, so the page still renders if a section
    // has not been seeded or an admin deactivates one.
    $sections   = $sections ?? collect();
    $hero       = $sections['hero']       ?? null;
    $highlights = $sections['highlights'] ?? null;
    $biography  = $sections['biography']  ?? null;
    $philosophy = $sections['philosophy'] ?? null;

    $bioMeta = $biography->meta ?? [];

    $highlightCards = $highlights->items['cards'] ?? [];
    if (empty($highlightCards)) {
        $highlightCards = [
            ['icon' => 'graduation-cap', 'title' => 'Education & Training', 'description' => 'Doctorate in Dental Medicine with specialized training in holistic health and longevity medicine'],
            ['icon' => 'award',          'title' => '40+ Years Experience', 'description' => 'Pioneering holistic approaches to health, wellness, and biological age reversal'],
            ['icon' => 'book-open',      'title' => 'Published Author',     'description' => 'Multiple publications on integrative health and evidence-based wellness practices'],
            ['icon' => 'heart',          'title' => 'Wellness Philosophy',  'description' => 'Dedicated to empowering individuals to take control of their health through education and community support'],
        ];
    }

    // Blank line between paragraphs in the admin textarea becomes one <p> each.
    $bioParagraphs = preg_split('/\R{2,}/', trim((string) ($biography->body ?? '')), -1, PREG_SPLIT_NO_EMPTY) ?: [];
    if (empty($bioParagraphs)) {
        $bioParagraphs = [
            'Dr. Victor Zeines has dedicated over four decades to understanding and teaching the principles of holistic health and longevity. As a pioneering voice in integrative medicine, he has helped thousands of individuals transform their lives through evidence-based wellness practices.',
            'His unique approach combines traditional medical knowledge with cutting-edge research in nutrition, exercise science, stress management, and biological age reversal. Dr. Zeines believes that true health is not merely the absence of disease, but a state of complete physical, mental, and social well-being.',
            'Through the Institute for Living Longer, Dr. Zeines has created a comprehensive educational platform that makes advanced wellness knowledge accessible to everyone. His teaching style is warm, engaging, and deeply rooted in scientific evidence, making complex health concepts easy to understand and implement.',
            'Beyond his individual practice, Dr. Zeines has assembled a network of world-class collaborators — expert physicians and health practitioners who share his vision of empowering individuals to take charge of their health destiny.',
        ];
    }

    $principles = $philosophy->items['principles'] ?? [];
    if (empty($principles)) {
        $principles = [
            ['number' => '01', 'title' => 'Prevention First',      'description' => 'Focus on preventing disease rather than just treating symptoms'],
            ['number' => '02', 'title' => 'Whole Person Care',     'description' => 'Address physical, mental, emotional, and spiritual health'],
            ['number' => '03', 'title' => 'Evidence-Based',        'description' => 'Combine traditional wisdom with scientific research'],
            ['number' => '04', 'title' => 'Personalized Approach', 'description' => "Recognize that each person's path to wellness is unique"],
            ['number' => '05', 'title' => 'Sustainable Habits',    'description' => 'Build lasting lifestyle changes, not quick fixes'],
            ['number' => '06', 'title' => 'Community Support',     'description' => 'Harness the power of community for lasting transformation'],
        ];
    }
@endphp

<main class="flex-1">
    @if($hero || !$sections->count())
    <section class="gradient-subtle py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div class="space-y-6">
                    <h1 class="text-4xl lg:text-6xl font-bold text-foreground text-left">{{ $hero->heading ?? 'Meet Dr. Victor Zeines' }}</h1>
                    <p class="text-xl text-muted-foreground">
                        {{ $hero->subheading ?? 'Founder of the Institute for Living Longer' }}
                    </p>
                    <div class="h-1 w-24 gradient-primary rounded-full"></div>
                </div>
                <div class="relative">
                    <div class="aspect-square rounded-2xl overflow-hidden shadow-strong">
                    <img src="{{ env('APP_URL') . '/assets/dr-zeines.webp' }}" alt="Dr. Victor Zeines"
                        class="w-full h-full object-cover" />
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    @if($highlights || !$sections->count())
    <section class="py-20 bg-background bg-white">
        <div class="max-w-7xl mx-auto grid md:grid-cols-2 lg:grid-cols-4 gap-8 px-4">
            @foreach($highlightCards as $card)
            <x-card class="equal-height">
                <x-card-content class="space-y-4">
                    <div class="iconbg w-14 h-14">
                        <i data-lucide="{{ $card['icon'] ?? 'heart' }}" class="w-7 h-7 text-primary-foreground"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-foreground">{{ $card['title'] ?? '' }}</h3>
                    <p class="text-muted-foreground text-[16px]">{{ $card['description'] ?? '' }}</p>
                </x-card-content>
            </x-card>
            @endforeach
        </div>
    </section>
    @endif

    @if($biography || !$sections->count())
    <section class="py-20 gradient-subtle">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="rounded-lg border bg-card text-card-foreground   shadow-sm">
                <div class="p-8 lg:p-12 space-y-6 ">
                    <h2 class="text-3xl font-bold text-foreground mb-6 text-left">{{ $biography->heading ?? 'A Lifetime Dedicated to Health & Wellness' }}</h2>
                    <div class="prose prose-lg max-w-none text-muted-foreground space-y-4 text-[16px]">
                        @foreach($bioParagraphs as $paragraph)
                            <p class="text-[16px]">{{ $paragraph }}</p>
                        @endforeach
                    </div>
                    <div class="mt-8 p-6 bg-secondary rounded-xl">
                        <p class="text-lg font-semibold text-foreground mb-2 text-[18px]">
                            "{{ $bioMeta['quote'] ?? 'My mission is simple: to empower you with the knowledge and tools you need to live a longer, healthier, and more vibrant life.' }}"
                        </p>
                        <p class="text-muted-foreground text-[16px]">{{ $bioMeta['quote_author'] ?? '- Dr. Victor Zeines' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    @if($philosophy || !$sections->count())
    <section class="py-20 bg-background">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl lg:text-5xl font-bold text-foreground mb-4">{{ $philosophy->heading ?? "Dr. Zeines' Wellness Philosophy" }}</h2>
                <p class="text-xl text-muted-foreground max-w-3xl mx-auto">
                    {{ $philosophy->subheading ?? 'Core principles for lasting health and vitality' }}
                </p>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-5xl mx-auto">
                @foreach($principles as $i => $principle)
                <x-card class="equal-height">
                    <x-card-content>
                        <div class="text-5xl font-bold gradient-primary text-transparent bg-clip-text mb-4">{{ ($principle['number'] ?? '') ?: str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</div>
                        <h3 class="text-xl font-semibold text-foreground mb-2 text-[20px]">{{ $principle['title'] ?? '' }}</h3>
                        <p class="text-muted-foreground text-[16px]">{{ $principle['description'] ?? '' }}</p>
                    </x-card-content>
                </x-card>
                @endforeach
            </div>
        </div>
    </section>
    @endif
</main>
@endsection
