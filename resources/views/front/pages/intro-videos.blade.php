@extends('front.layouts.app')
@section('content')
    @php
    $videos = [
        [
            'id' => 1,
            'title' => 'Welcome to Your Wellness Journey',
            'duration' => '8:45',
            'instructor' => 'Dr. Victor Zeines',
            'category' => 'Getting Started',
            'description' => 'An introduction to the Institute and what you can expect from your membership.',
            'featured' => true,
        ],
        [
            'id' => 2,
            'title' => 'The Science of Longevity',
            'duration' => '12:30',
            'instructor' => 'Dr. Victor Zeines',
            'category' => 'Foundation',
            'description' => 'Understanding the biological mechanisms of aging and how to slow them down.',
            'featured' => true,
        ],
        [
            'id' => 3,
            'title' => 'Nutrition Fundamentals for Longevity',
            'duration' => '15:20',
            'instructor' => 'Dr. Sarah Chen',
            'category' => 'Nutrition',
            'description' => 'Key nutritional principles that support cellular health and longevity.',
            'featured' => false,
        ],
        [
            'id' => 4,
            'title' => 'Movement for Life',
            'duration' => '10:15',
            'instructor' => 'Dr. Michael Rodriguez',
            'category' => 'Exercise',
            'description' => 'Essential movement patterns to maintain strength and mobility at any age.',
            'featured' => false,
        ],
        [
            'id' => 5,
            'title' => 'Stress and Your Health',
            'duration' => '14:00',
            'instructor' => 'Dr. Jennifer Park',
            'category' => 'Mind-Body',
            'description' => 'How chronic stress affects aging and simple techniques to manage it.',
            'featured' => false,
        ],
        [
            'id' => 6,
            'title' => 'Sleep Optimization Basics',
            'duration' => '11:45',
            'instructor' => 'Dr. Emily Thompson',
            'category' => 'Sleep',
            'description' => 'Understanding sleep architecture and strategies for better rest.',
            'featured' => false,
            ],
        ];
        @endphp

<div class="min-h-screen flex flex-col">
    <main class="flex-1">
        <!-- <section class="gradient-subtle py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div>
                        <h1 class="text-4xl lg:text-6xl font-bold text-foreground mb-6">Explore Healthier Living with Our Sample Videos</h1>
                        <p class="text-xl text-muted-foreground">
                           Discover alternatives for a longer and healthier life through our educational and inspiring video content.A Glimpse into Our Educational Resources: Check out a few sample videos from our courses to see the wealth of knowledge we offer. These previews are just the beginning of what you can learn with us.<br>Ready to Learn More? Join our community to access our full range of comprehensive videos and resources, all designed to guide you to a healthier lifestyle.
                        </p>
                    </div>
                    <div class="relative">
                        <div class="aspect-video rounded-2xl overflow-hidden shadow-strong">
                            <img src="{{ asset('assets/video-learning.jpg') }}" alt="Modern video learning platform for wellness education" class="w-full h-full object-cover"/>
                        </div>
                    </div>
                </div>
            </div>
        </section> -->

        <!-- Featured Videos -->
        <!-- <section class="py-12 bg-background">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 ">
                <h2 class="text-3xl font-bold text-foreground mb-8 text-left">Featured Videos</h2>
                <div class="grid md:grid-cols-2 gap-8 mb-12 ">
                    @foreach ($videos as $video)
                        @if ($video['featured'])
                            <x-card class="">
                                <x-card-header>
                                    <div class="aspect-video bg-gradient-to-tr  from-green-100 to-amber-100 rounded-lg mb-4 flex items-center justify-center relative overflow-hidden">
                                        <div class="absolute inset-0 flex items-center justify-center">
                                            <div class="w-20 h-20 rounded-full bg-emerald-500  gradient-primary flex items-center justify-center shadow-strong cursor-pointer hover:scale-110 transition-transform">
                                                <i data-lucide="play" class="w-10 h-10 text-white text-primary-foreground ml-1"></i>
                                            </div>
                                        </div>
                                        @if ($video['featured'])
                                            <x-badge class="absolute top-4 left-4 gradient-accent text-accent-foreground border-0">
                                                Featured
                                            </x-badge>
                                        @endif
                                        <x-badge class="bg-gray-200 text-black absolute top-4 right-4 gradient-accent text-accent-foreground border-0 hover:text-white hover:bg-emerald-500">
                                            {{ $video['duration'] }}
                                        </x-badge>
                                    </div>
                                    <h2 class="font-semibold tracking-tight text-2xl mb-2 text-left">{{ $video['title'] }}</h2>
                                    <div class="flex items-center text-sm text-muted-foreground text-[16px]">
                                        <i data-lucide="user" class="h-4 w-4 mr-1"></i>
                                        {{ $video['instructor']}}
                                        <span class="mx-2">•</span>
                                        <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 text-foreground">{{ $video ['category'] }}</span>
                                    </div>
                                    <div class=" pt-0">
                                        <p class="text-muted-foreground mb-4 text-[16px]">A{{ $video['description'] }}</p>
                                    </div>
                                </x-card-header>
                                <x-card-content>
                                    <x-button-use href="{{ url('/membership') }}" label="Watch Now" variant="primary" icon="play"  />
                                </x-card-content>
                            </x-card>
                        @endif
                    @endforeach
                </div>
            </div>
        </section> -->

        <!-- More Introduction Videos -->
        <section class="py-12 bg-background">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold text-foreground mb-8">Explore Healthier Living with Our Sample Videos</h2>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($introVideos as $video)
                        <x-card class="">
                            <!-- <x-card-header class="pb-4 ">
                                <div class="aspect-video bg-gradient-to-tr  from-green-50 to-amber-100  rounded-lg mb-4 flex items-center justify-center relative">
                                    <div class="w-16 h-16 rounded-full gradient-primary flex items-center justify-center cursor-pointer hover:scale-110 transition-transform">
                                        <i data-lucide="play" class="h-8 w-8 text-primary-foreground ml-1"></i>
                                    </div>
                                    <x-badge class="absolute top-3 right-3 bg-background/80 backdrop-blur-sm flex items-center">
                                        <i data-lucide="clock" class="h-3 w-3 mr-1"></i>
                                        {{ $video['duration'] }}
                                    </x-badge>
                                </div>
                            </x-card-header> -->
                            <x-card-content class="space-y-3">
                                <div>
                                    <h3 class="text-xl  font-bold text-teal-950   text-foreground mb-2 line-clamp-2">
                                        {{ $video['title'] }}
                                    </h3>
                                    <!-- <div class="flex items-center text-sm text-muted-foreground text-neutral-500">
                                        <i data-lucide="user" class="h-3 w-3 mr-1"></i>
                                        {{ $video['instructor']}}
                                        <span class="ml-2 inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 text-foreground">{{ $video ['category'] }}</span>
                                    </div> -->
                                </div>
                                <p class="text-sm text-muted-foreground line-clamp-2">{{ $video['description'] }}</p>
                                <x-button-use label="Watch Now" variant="outline" icon="play" data-video="{{ $video['video_url'] }}" class="open-video-btn" />
                                <!--<button class="open-video-btn inline-flex items-center justify-center px-4 py-2 border border-green-600 text-green-600 rounded-md" data-video="{{ $video['video_url'] }}">-->
                                <!--    ▶ Watch Now-->
                                <!--</button>-->
                            </x-card-content>
                        </x-card>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- CTA  icon="check-circle" --}}
        <x-ui.cta-section
            align="center"
            title="Ready for More?"
            subtitle="Become a member to access our complete video library with hundreds of
            hours of expert content on health, nutrition, exercise, and longevity."
            padding="p-2 md:p-2 lg:p-20"
            cardClass="hover:border-gray-200"
            container="max-w-7xl"
            :buttons="[
                ['route' => 'membership',   'label' => 'Explore Membership Plans', 'variant' => 'outline', 'icon' => 'external-link'],
            ]"
        />
    </main>
    
    <!-- Video Modal -->
    <div id="videoModal" class="fixed inset-0 bg-black bg-opacity-70 hidden items-center justify-center z-50">
        <div class="relative w-full max-w-4xl mx-auto">
            
            <!-- Close Button -->
            <button id="closeModal" class="absolute -top-10 right-0 text-white text-2xl">
                ✕
            </button>
    
            <!-- Video कंटेनर -->
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
</div>
<script>
const modal = document.getElementById('videoModal');
const iframe = document.getElementById('videoFrame');
const closeBtn = document.getElementById('closeModal');

document.querySelectorAll('.open-video-btn').forEach(btn => {
    btn.addEventListener('click', function () {
        let videoUrl = this.getAttribute('data-video');

        // Convert Vimeo link to embed format
        let videoId = videoUrl.split('/').pop();
        let embedUrl = `https://player.vimeo.com/video/${videoId}?autoplay=1`;

        iframe.src = embedUrl;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    });
});

closeBtn.addEventListener('click', function () {
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    iframe.src = ""; // stop video
});

// Close on outside click
modal.addEventListener('click', function(e) {
    if (e.target === modal) {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        iframe.src = "";
    }
});
</script>
@endsection