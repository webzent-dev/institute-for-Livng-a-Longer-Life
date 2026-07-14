@extends('front.layouts.app')
@section('content')
@php
    // CMS sections (App\Models\PageContent, page_key "testimonials"), keyed by section_key. Every
    // value falls back to the original hard-coded copy, so the page still renders if a section has
    // not been seeded or an admin deactivates one.
    $sections = $sections ?? collect();
    $hero     = $sections['hero']   ?? null;
    $videos   = $sections['videos'] ?? null;
    $cta      = $sections['cta']    ?? null;
    $ctaMeta  = $cta->meta ?? [];
@endphp
<div class="py-10 min-h-screen flex flex-col">
    <main class="flex-1">
        @if($hero)
        <section class="py-10 gradient-subtle">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-4xl lg:text-5xl font-bold text-foreground mb-4">{{ $hero->heading }}</h1>
                <p class="text-xl text-muted-foreground max-w-3xl mx-auto">{{ $hero->body }}</p>
            </div>
        </section>
        @endif

        @if($videos || !$sections->count())
        <section class="py-10 bg-background">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl lg:text-5xl font-bold text-foreground mb-4">{{ $videos->heading ?? 'Video Testimonials' }}</h2>
                    <p class="text-xl text-muted-foreground">{{ $videos->subheading ?? 'Real Stories, Real Experiences' }}</p>
                </div>
               <x-ui.carousel :items="$videoTestimonials" autoplay="true" speed="3000" />
            </div>
        </section>
        @endif
        <section class="py-12 gradient-subtle">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($testimonials as $testimonial)
                        <x-card class="testimonial-card flex flex-col border-2 hover:border-primary transition-all shadow-soft hover:shadow-medium">
                            <x-card-content class="flex-1 p-6 space-y-4">
                                {{-- Rating Star--}}
                                <div class="flex items-center space-x-1">
                                    @for ($i = 0; $i < $testimonial->rating; $i++)
                                        <i data-lucide="star" class="lucide-star h-5 w-5 text-accent fill-accent"></i>
                                    @endfor
                                </div>

                                {{-- Quote --}}
                                <div class="relative">
                                    <i data-lucide="quote" class="absolute -top-2 -left-2 h-8 w-8 text-primary/20"></i>
                                    <p class="text-muted-foreground italic pl-6">
                                        "{{ $testimonial->quote }}"
                                    </p>
                                </div>

                                {{-- Author --}}
                                <div class="flex items-center space-x-3 pt-4 border-t border-border">
                                    <x-ui.avatar name="{{ $testimonial->name }}"  size="3" />
                                    <div>
                                        <p class="font-semibold text-foreground">{{ $testimonial->name }}</p>
                                        <p class="text-sm text-muted-foreground">
                                            {{ $testimonial->location }}
                                        </p>
                                    </div>
                                </div>
                            </x-card-content>
                        </x-card>
                    @endforeach
                </div>
                {{-- Pagination --}}
                <div class="flex justify-center mt-6">
                    {{ $testimonials->links('vendor.pagination.tailwind') }}
                </div>
            </div>
        </section>

        {{-- JavaScript Pagination Logic --}}
        {{-- CTA bookmark-check icon="bookmark-check" --}}
        @if($cta || !$sections->count())
        {{-- Bound with ":" so the value is escaped once by the component; "title=..." would double-escape apostrophes. --}}
        <x-ui.cta-section align="center" :title="$cta->heading ?? 'Ready to Write Your Success Story?'"
            :subtitle="$cta->subheading ?? 'Join thousands of members who are already transforming their lives. Start your journey to better health today.'"
            cardClass="hover:border-gray-200"
            :buttons="[
                ['route' => 'membership',   'label' => $ctaMeta['primary_label'] ?? 'Get Started Today', 'variant' => 'primary',  ],
                ['route' => 'intro-videos', 'label' => $ctaMeta['outline_label'] ?? 'Watch Intro Videos', 'variant' => 'outline',  ],
            ]"
        />
        @endif
    </main>
</div>
<script>
document.addEventListener("DOMContentLoaded", function () {
    window.index = 0;
    const slides = document.querySelectorAll("#carousel > div");
    window.total = slides.length;
    window.showSlide = function () {
        document.getElementById("carousel").style.transform = `translateX(-${window.index * 100}%)`;
    };
    window.nextSlide = function () {
        window.index = (window.index + 1) % window.total;
        window.showSlide();
    };
    window.prevSlide = function () {
        window.index = (window.index - 1 + window.total) % window.total;
        window.showSlide();
    };
});
</script>
@endsection