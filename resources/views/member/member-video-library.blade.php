@php
use Illuminate\Support\Facades\DB;
@endphp
@extends('member.member')
@section('member-content')
<main class="bg-white text-foreground p-6">
    @php
    $featuredVideos = [
        [
        "id" => 1,
        "title" => "Foundations of Holistic Dentistry",
        "instructor" => "Dr. Victor Zeines",
        "duration" => "45 min",
        "thumbnail" => "/images/dr-zeines.jpg",
        "category" => "Dental Health",
        "featured" => true
        ],
        [
        "id" => 2,
        "title" => "Natural Approaches to Gum Health",
        "instructor" => "Dr. Victor Zeines",
        "duration" => "32 min",
        "thumbnail" => "/images/dr-zeines.jpg",
        "category" => "Dental Health",
        "featured" => true
        ],
        [
        "id" => 3,
        "title" => "Mercury-Free Dentistry Explained",
        "instructor" => "Dr. Victor Zeines",
        "duration" => "28 min",
        "thumbnail" => "/images/dr-zeines.jpg",
        "category" => "Dental Health",
        "featured" => true
        ],
    ];
    $categoryVideos = [
        "Dental Health" => [
        ["id" => 4, "title" => "Understanding Tooth Decay Naturally", "instructor" => "Dr. Sarah Mitchell", "duration" => "25 min"],
        ["id" => 5, "title" => "Oral Microbiome Basics", "instructor" => "Dr. James Chen", "duration" => "30 min"],
        ["id" => 14, "title" => "Understanding Tooth Decay Naturally", "instructor" => "Dr. Sarah Mitchell", "duration" => "25 min"],
        ["id" => 15, "title" => "Oral Microbiome Basics", "instructor" => "Dr. James Chen", "duration" => "30 min"],
        ],
        "Nutrition" => [
        ["id" => 6, "title" => "Anti-Inflammatory Diet Essentials", "instructor" => "Lisa Thompson, RD", "duration" => "40 min"],
        ["id" => 7, "title" => "Supplements for Longevity", "instructor" => "Dr. Michael Ross", "duration" => "35 min"],
        ["id" => 16, "title" => "Anti-Inflammatory Diet Essentials", "instructor" => "Lisa Thompson, RD", "duration" => "40 min"],
        ["id" => 17, "title" => "Supplements for Longevity", "instructor" => "Dr. Michael Ross", "duration" => "35 min"],
        ],
        "Wellness" => [
        ["id" => 8, "title" => "Stress Management Techniques", "instructor" => "Dr. Emily Carter", "duration" => "22 min"],
        ["id" => 9, "title" => "Sleep Optimization Guide", "instructor" => "Dr. Robert Lee", "duration" => "28 min"],
        ["id" => 18, "title" => "Stress Management Techniques", "instructor" => "Dr. Emily Carter", "duration" => "22 min"],
        ["id" => 19, "title" => "Sleep Optimization Guide", "instructor" => "Dr. Robert Lee", "duration" => "28 min"],
        ],
        "Mind-Body" => [
        ["id" => 10, "title" => "Meditation for Beginners", "instructor" => "Anna Williams", "duration" => "20 min"],
        ["id" => 11, "title" => "Breathing Exercises for Health", "instructor" => "Mark Johnson", "duration" => "18 min"],
        ["id" => 20, "title" => "Meditation for Beginners", "instructor" => "Anna Williams", "duration" => "20 min"],
        ["id" => 21, "title" => "Breathing Exercises for Health", "instructor" => "Mark Johnson", "duration" => "18 min"],
        ],
    ];
    @endphp
    <div class="space-y-8" x-data="{ tab: '{{ $activeTab ?? 'category' }}' }">
        <div>
            <h1 class="text-3xl font-bold text-foreground text-left">Video Library</h1>
            <p class="text-muted-foreground">Access all educational videos and wellness content</p>
        </div>
        <!-- <section>
            <div class="flex gap-2 mb-4">
                <i data-lucide="star" class="h-5 w-5 text-primary fill-primary mt-1"></i>
                <h2 class="text-xl font-semibold">Featured: Dr. Victor Zeines</h2>
            </div>
            <div class="grid md:grid-cols-3 gap-6">
                <div class="rounded-lg border bg-card text-card-foreground shadow-sm overflow-hidden hover:shadow-lg transition-shadow">
                    <div class="relative aspect-video bg-muted">
                        <img src="{{ asset('images/dr-zeines.jpg') }}" alt="Foundations of Holistic Dentistry" class="w-full h-full object-cover"/>
                        <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity">
                            <button class="inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-secondary text-secondary-foreground hover:bg-secondary/80 h-11 px-8 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-play h-6 w-6">
                                    <polygon points="6 3 20 12 6 21 6 3"></polygon>
                                </svg>
                            </button>
                        </div>
                        <div class="absolute top-2 right-2 bg-primary text-primary-foreground text-xs px-2 py-1 rounded">Featured</div>
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold line-clamp-2">Foundations of Holistic Dentistry</h3>
                        <div class="flex items-center gap-4 mt-2 text-sm text-muted-foreground">
                            <span class="flex items-center gap-1">
                                <i data-lucide="user" class="h-3 w-3 mt-1"></i>
                                Dr. Victor Zeines
                            </span>
                            <span class="flex items-center gap-1">
                                <i data-lucide="clock" class="h-3 w-3 mt-1"></i>
                                45 min
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </section> -->
        {{-- Tabs --}}
        <div>
            <div class="grid w-full max-w-sm grid-cols-2 bg-gray-100 rounded-md p-1">
                <button @click="tab='category'" :class="tab=='category' ? 'bg-white shadow font-semibold rounded-md' : ''" class="px-3 py-2 text-sm rounded-md">By Category</button>
                <button @click="tab='collaborator'" :class="tab=='collaborator' ? 'bg-white shadow font-semibold' : ''" class="px-3 py-2 text-sm rounded-md">By Collaborator</button>
            </div>
            {{-- Category View --}}
            <div x-show="tab=='category'" class="mt-6 space-y-8">
                @forelse($courseCategories as $key => $value)
                    @php
                        //Count the number of courses in each category
                        $count = App\Models\Course::where('category', $key)->count();

                        $courses = App\Models\Course::with('user')->where('category', $key)->get();
                       
                    @endphp
                    @if($count > 0)
                    <section>
                        
                        <h3 class="text-lg font-semibold mb-4">{{$value}}</h3>
                        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-4">
                            @foreach ($courses as $course)
                            <div class="rounded-lg border bg-card text-card-foreground shadow-sm hover:shadow-md transition-shadow cursor-pointer">
                                <div class="p-4">
                                    <div class="aspect-video bg-muted rounded-lg mb-3 overflow-hidden">
                                        @if($course->video_url)
                                            @php
                                                // Extract Vimeo video ID from URL
                                                $videoId = '';
                                                if (preg_match('/vimeo\.com\/(\d+)/', $course->video_url, $matches)) {
                                                    $videoId = $matches[1];
                                                }
                                            @endphp
                                            @if($videoId)
                                                <iframe 
                                                    src="https://player.vimeo.com/video/{{ $videoId }}?h=xxxxxx&autoplay=0&loop=0&title=0&byline=0&portrait=0"
                                                    class="w-full h-full rounded-lg"
                                                    frameborder="0"
                                                    allow="autoplay; fullscreen; picture-in-picture"
                                                    allowfullscreen
                                                    data-vimeo-id="{{ $videoId }}"
                                                    onclick="pauseAllOtherVideos(this)">
                                                </iframe>
                                            @else
                                                <div class="w-full h-full flex items-center justify-center">
                                                    <i data-lucide="play" class="h-8 w-8 text-muted-foreground"></i>
                                                </div>
                                            @endif
                                        @else
                                            <div class="w-full h-full flex items-center justify-center">
                                                <i data-lucide="play" class="h-8 w-8 text-muted-foreground"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <h4 class="font-medium text-sm line-clamp-2">{{ $course->title }}</h4>
                                    <div class="flex items-center justify-between mt-2 text-xs text-muted-foreground">
                                        <span>{{ $course->user->first_name }} {{ $course->user->last_name }}</span>
                                        <span>{{ $course->duration }} min</span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </section>
                    @endif
                @empty
                    <seection>
                        No videos found.
                    </section>
                @endforelse
            </div>
            
            <div x-show="tab=='collaborator'" class="mt-6">
                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach ($collaborators as $collaborator)
                    <div class="rounded-lg border bg-card text-card-foreground shadow-sm hover:shadow-md transition-shadow cursor-pointer">
                        <div class="flex flex-col space-y-1.5 p-6 text-center">
                            <div class="w-16 h-16 bg-primary/10 rounded-full mx-auto flex items-center justify-center mb-2">
                                <i data-lucide="user" class="h-8 w-8 text-muted-foreground" ></i>
                            </div>
                            <h3 class="font-semibold tracking-tight text-base">{{ $collaborator->first_name }} {{ $collaborator->last_name }}</h3>
                            <p class="text-sm text-muted-foreground">{{ $collaborator->speciality }}</p>
                        </div>
                        <div class="p-6 pt-0 text-center">
                            <!-- <p class="text-sm text-muted-foreground">0 videos</p> -->
                            <a href="{{ route('member.video-library.collaborator', $collaborator->id) }}" class="inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium ring-offset-background transition-colors border-2 border-primary bg-background text-primary hover:bg-primary hover:text-primary-foreground h-9 rounded-md px-3 mt-3">View Videos</a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</main>

<script>
function pauseAllOtherVideos(currentIframe) {
    // Get all Vimeo iframes on the page
    const allIframes = document.querySelectorAll('iframe[data-vimeo-id]');
    
    // Pause all other videos
    allIframes.forEach(iframe => {
        if (iframe !== currentIframe) {
            const player = new Vimeo.Player(iframe);
            player.pause().catch(function(error) {
                console.error('Error pausing video:', error);
            });
        }
    });
}

// Load Vimeo Player API
(function() {
    const script = document.createElement('script');
    script.src = 'https://player.vimeo.com/api/player.js';
    script.onload = function() {
        console.log('Vimeo Player API loaded');
    };
    document.head.appendChild(script);
})();
</script>

@endsection