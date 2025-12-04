@extends('front.layouts.app')

@section('content')
<div class="min-h-screen flex flex-col">
 
    <main class="flex-1">

        {{-- Hero Section --}}
        <section class="gradient-subtle py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-4xl lg:text-6xl font-bold text-foreground mb-6">
                    Member Success Stories
                </h1>
                <p class="text-xl text-muted-foreground max-w-3xl mx-auto">
                    Real people, real results. Read how our members are transforming their health 
                    and living longer, healthier lives.
                </p>
            </div>
        </section>

        {{-- Stats Section --}}
        <section class="py-16 bg-background">
            @php
                $stats = [
                    ['number' => '10,000+', 'label' => 'Active Members'],
                    ['number' => '4.9/5', 'label' => 'Average Rating'],
                    ['number' => '95%', 'label' => 'Satisfaction Rate'],
                    ['number' => '89%', 'label' => 'Report Better Health'],
                ];
            @endphp

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                    @foreach ($stats as $stat)
                        <x-card class="shadow-medium border-2">
                            <x-card-content class="p-6 text-center">
                                <div class="text-4xl font-bold btn-primary text-transparent bg-clip-text mb-2">
                                    {{ $stat['number'] }}
                                </div>
                                <p class="text-muted-foreground">{{ $stat['label'] }}</p>
                            </x-card-content>
                        </x-card>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- Video Testimonials Carousel --}}
        @php
            $videoTestimonials = [
                [
                    'id' => 1,
                    'videoUrl' => 'https://vimeo.com/1089873165',
                    'thumbnail' => 'https://instituteforlivinglonger.com/wp-content/uploads/2025/09/12.png',
                    'quote' => 'The videos really helped me a lot..',
                    'name' => 'Sarah M.'
                ],
                [
                    'id' => 2,
                    'videoUrl' => 'https://vimeo.com/1089872998',
                    'thumbnail' => 'https://instituteforlivinglonger.com/wp-content/uploads/2025/09/13.png',
                    'quote' => 'Loved the videos..',
                    'name' => 'Michael R.'
                ],
                [
                    'id' => 3,
                    'videoUrl' => 'https://vimeo.com/1089872688',
                    'thumbnail' => 'https://instituteforlivinglonger.com/wp-content/uploads/2025/09/14.png',
                    'quote' => 'IT CHANGED MY LIFE..',
                    'name' => 'Jennifer P.'
                ],
            ];
        @endphp

        <section class="py-10 bg-background">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <div class="text-center mb-12">
                    <h2 class="text-3xl lg:text-5xl font-bold text-foreground mb-4">
                        Video Testimonials
                    </h2>
                    <p class="text-xl text-muted-foreground">
                        Hear directly from our members about their transformation journeys
                    </p>
                </div>
               <x-ui.carousel :items="$videoTestimonials" autoplay="true" speed="3000" />
  
            </div>
        </section>
 
        
        {{-- Testimonials Grid --}}
        @php
            $testimonials = [
                [
                    'id' => 1,
                    'name' => 'Margaret Thompson',
                    'age' => 68,
                    'location' => 'Boston, MA',
                    'rating' => 5,
                    'quote' => "After just 6 months with the Institute, my energy levels have increased dramatically. Dr. Zeines' approach to wellness has truly transformed my life. I feel 20 years younger!",
                    'result' => 'Lost 25 lbs, improved mobility'
                ],
                [
                    'id' => 2,
                    'name' => 'Robert Chen',
                    'age' => 54,
                    'location' => 'San Francisco, CA',
                    'rating' => 5,
                    'quote' => "The collaborator network is incredible. I've learned so much from Dr. Rodriguez about fitness and Dr. Chen about nutrition. My blood work has improved remarkably.",
                    'result' => 'Reversed pre-diabetes'
                ],
                [
                    'id' => 3,
                    'name' => 'Linda Martinez',
                    'age' => 62,
                    'location' => 'Miami, FL',
                    'rating' => 5,
                    'quote' => "As a Premium member, I have access to such valuable content. The live Q&A sessions are my favorite - getting direct answers from experts is priceless.",
                    'result' => 'Better sleep, reduced stress'
                ],
                [
                    'id' => 4,
                    'name' => 'James Wilson',
                    'age' => 71,
                    'location' => 'Chicago, IL',
                    'rating' => 5,
                    'quote' => "I was skeptical at first, but the science-based approach won me over. Dr. Zeines and his team provide clear, actionable advice that actually works.",
                    'result' => 'Improved heart health markers'
                ],
                [
                    'id' => 5,
                    'name' => 'Patricia Davis',
                    'age' => 59,
                    'location' => 'Seattle, WA',
                    'rating' => 5,
                    'quote' => "The community support is amazing. I've made friends from all over the country who share the same wellness goals. We motivate each other daily.",
                    'result' => 'Consistent exercise routine'
                ],
                [
                    'id' => 6,
                    'name' => 'Michael Rodriguez',
                    'age' => 66,
                    'location' => 'Denver, CO',
                    'rating' => 5,
                    'quote' => "Elite membership was the best investment I've made in my health. The personalized consultations have helped me optimize my wellness plan perfectly.",
                    'result' => 'Enhanced cognitive function'
                ],
                [
                    'id' => 7,
                    'name' => 'Susan Anderson',
                    'age' => 57,
                    'location' => 'Austin, TX',
                    'rating' => 5,
                    'quote' => "The video lessons are so well-produced and easy to understand. I love learning at my own pace and revisiting the content whenever I need a refresher.",
                    'result' => 'Better nutrition habits'
                ],
                [
                    'id' => 8,
                    'name' => 'David Park',
                    'age' => 63,
                    'location' => 'Portland, OR',
                    'rating' => 5,
                    'quote' => "Dr. Zeines' holistic approach addresses the whole person, not just symptoms. This is the healthcare model of the future, and I'm grateful to be part of it.",
                    'result' => 'Reduced inflammation'
                ],
                [
                    'id' => 9,
                    'name' => 'Carol Williams',
                    'age' => 69,
                    'location' => 'Phoenix, AZ',
                    'rating' => 5,
                    'quote' => "The store products recommended by the collaborators are top-quality. I especially love the Vital Boost supplement - it's become a staple in my daily routine.",
                    'result' => 'Increased vitality'
                ],
            ];
           
           // Pagination 
           $perPage = 3;
           $page = request()->get('page', 1);
           $totalPages = ceil(count($testimonials)/$perPage);
           // Slice testimonials for current page
           $paginated = array_slice($testimonials, ($page - 1) * $perPage, $perPage);
             
        @endphp


            {{-- Testimonials --}}
            <section class="py-12 gradient-subtle">
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                            
                            <div  class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">

                                @foreach ($testimonials as $testimonial)
                                    <x-card class="testimonial-card flex flex-col border-2 hover:border-primary transition-all shadow-soft hover:shadow-medium">
                                        <x-card-content class="flex-1 p-6 space-y-4">

                                            {{-- Rating --}}
                                            <div class="flex items-center space-x-1">
                                                @for ($i = 0; $i < $testimonial['rating']; $i++)
                                                    {{-- <x-heroicon-s-star class="h-5 w-5 text-accent fill-accent" /> --}}
                                                    <i data-lucide="star" class="lucide-star h-5 w-5 text-accent fill-accent"></i>
                                                @endfor
                                            </div>

                                            {{-- Quote --}}
                                            <div class="relative">
                                                {{-- <x-heroicon-s-quote class="absolute -top-2 -left-2 h-8 w-8 text-primary/20" /> --}}
                                                <i data-lucide="quote" class="absolute -top-2 -left-2 h-8 w-8 text-primary/20"></i>
                                                <p class="text-muted-foreground italic pl-6">
                                                    "{{ $testimonial['quote'] }}"
                                                </p>
                                            </div>

                                            {{-- Result --}}
                                            <div class="p-3 bg-primary/10 rounded-lg border border-primary/20">
                                                <p class="text-sm font-semibold text-primary">
                                                    Result: {{ $testimonial['result'] }}
                                                </p>
                                            </div>

                                            {{-- Author --}}
                                            <div class="flex items-center space-x-3 pt-4 border-t border-border">
                                                
                                                    <x-ui.avatar name="{{ $testimonial['name'] }}"  size="3" />
                                                
                                                <div>
                                                    <p class="font-semibold text-foreground">{{ $testimonial['name'] }}</p>
                                                    <p class="text-sm text-muted-foreground">
                                                        Age {{ $testimonial['age'] }} • {{ $testimonial['location'] }}
                                                    </p>
                                                </div>
                                            </div>

                                        </x-card-content>
                                    </x-card>
                                @endforeach

                            </div>
                            {{-- Pagination --}}
                            <div class="flex justify-center mt-6">
                                <nav id="pagination" class="flex items-center space-x-2 text-sm"></nav>
                            </div>
                        </div>
            </section>

            {{-- Pagination --}}
            <div class="flex justify-center mt-6">
                <nav id="pagination" class="flex items-center space-x-2 text-sm"></nav>
            </div>

            {{-- JavaScript Pagination Logic --}}
            <script>
                let currentPage = 1;
                const perPage = {{ $perPage }};
                const totalPages = {{ $totalPages }};
                const cards = document.querySelectorAll(".testimonial-card");

                // Render testimonials for this page
                function renderPage() {
                    const start = (currentPage - 1) * perPage;
                    const end = start + perPage;

                    cards.forEach((card, index) => {
                        card.classList.toggle("hidden", !(index >= start && index < end));
                    });

                    renderPagination();
                }

                // Creates pagination number buttons with "..." ellipsis
                function renderPagination() {
                    const container = document.getElementById("pagination");
                    container.innerHTML = "";

                    // Helper to create button
                    const btn = (label, page, active = false, disabled = false) => {
                        const button = document.createElement("button");
                        button.textContent = label;
                        button.className =
                            "px-3 py-1 border rounded-md hover:bg-primary " +
                            (active ? "bg-primary text-white" : "hover:bg-gray-200") +
                            (disabled ? " opacity-50 cursor-not-allowed" : "");

                        if (!disabled && page) {
                            button.onclick = () => {
                                currentPage = page;
                                renderPage();
                            };
                        }

                        container.appendChild(button);
                    };

                    // Previous
                    btn("Previous", currentPage - 1, false, currentPage === 1);

                    // Always show first page
                    btn("1", 1, currentPage === 1);

                    // Show "..."
                    if (currentPage > 3) container.innerHTML += "<span>...</span>";

                    // Middle pages
                    for (let i = currentPage - 1; i <= currentPage + 1; i++) {
                        if (i > 1 && i < totalPages) {
                            btn(i, i, currentPage === i);
                        }
                    }

                    // Show "..."
                    if (currentPage < totalPages - 2) container.innerHTML += "<span>...</span>";

                    // Always show last page
                    if (totalPages > 1) {
                        btn(totalPages, totalPages, currentPage === totalPages);
                    }

                    // Next
                    btn("Next", currentPage + 1, false, currentPage === totalPages);
                }

                // Initial load
                renderPage();
            </script>


        {{-- CTA bookmark-check --}}
             <x-ui.cta-section 
                icon="bookmark-check"
                align="center"
                title="Ready to Write Your Success Story?"
                subtitle="Join thousands of members who are already transforming their lives. 
                            Start your journey to better health today."
                
                :buttons="[
                    ['route' => 'membership',   'label' => 'Get Started Today', 'variant' => 'outline', 'icon' => 'send'],
                    ['route' => 'intro-videos', 'label' => 'Watch Intro Videos', 'variant' => 'outline', 'icon' => 'tv-minimal'],
                ]"
            />  

    </main>

 

</div>
@endsection

<script>
document.addEventListener("DOMContentLoaded", function () {
    window.index = 0;
    const slides = document.querySelectorAll("#carousel > div");
    window.total = slides.length;
 
    window.showSlide = function () {
        document.getElementById("carousel").style.transform =
            `translateX(-${window.index * 100}%)`;
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