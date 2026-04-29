@extends('front.layouts.app')
@section('content')
<div class="py-10 min-h-screen flex flex-col">
    <main class="flex-1">
        {!! $testimonialPageContent->page_content !!}

        <section class="py-10 bg-background">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl lg:text-5xl font-bold text-foreground mb-4">Video Testimonials</h2>
                    <p class="text-xl text-muted-foreground">Real Stories, Real Experiences</p>
                </div>
               <x-ui.carousel :items="$videoTestimonials" autoplay="true" speed="3000" />
            </div>
        </section>
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

                                {{-- Result --}}
                                @if($testimonial->result)
                                <div class="p-3 bg-primary/10 rounded-lg border border-primary/20">
                                    <p class="text-sm font-semibold text-primary">
                                        Result: {{ $testimonial->result }}
                                    </p>
                                </div>
                                @endif

                                {{-- Author --}}
                                <div class="flex items-center space-x-3 pt-4 border-t border-border">
                                    <x-ui.avatar name="{{ $testimonial->name }}"  size="3" />
                                    <div>
                                        <p class="font-semibold text-foreground">{{ $testimonial->name }}</p>
                                        <p class="text-sm text-muted-foreground">
                                            Age {{ $testimonial->age }} • {{ $testimonial->location }}
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
        <x-ui.cta-section align="center" title="Ready to Write Your Success Story?"
            subtitle="Join thousands of members who are already transforming their lives. Start your journey to better health today."
            cardClass="hover:border-gray-200"
            :buttons="[
                ['route' => 'membership',   'label' => 'Get Started Today', 'variant' => 'primary',  ],
                ['route' => 'intro-videos', 'label' => 'Watch Intro Videos', 'variant' => 'outline',  ],
            ]"
        />
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