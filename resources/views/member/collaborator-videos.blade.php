@extends('member.member')
@section('member-content')
<main class="bg-white text-foreground p-6">
    <div class="space-y-8">
        <div class="flex items-center gap-4 mb-6">
            <a href="{{ route('member.video-library', 'collaborator') }}" class="text-primary hover:underline flex items-center gap-2">
                <i data-lucide="arrow-left" class="h-4 w-4"></i>
                Back to Video Library
            </a>
        </div>
        
        <div>
            <div class="flex items-center gap-4 mb-6">
                <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center">
                    <i data-lucide="user" class="h-8 w-8 text-muted-foreground"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-foreground">{{ $collaborator->first_name }} {{ $collaborator->last_name }}</h1>
                    <p class="text-muted-foreground">{{ $collaborator->speciality ?? 'Collaborator' }}</p>
                </div>
            </div>
            
            @if($courses->count() > 0)
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
                                <span>{{ $course->duration }} min</span>
                                <span>{{ $course->category }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <i data-lucide="video" class="h-16 w-16 text-muted-foreground mx-auto mb-4"></i>
                    <h3 class="text-lg font-semibold mb-2">No videos found</h3>
                    <p class="text-muted-foreground">This collaborator hasn't uploaded any videos yet.</p>
                </div>
            @endif
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
