<x-card class="border-2 border-primary shadow-medium hover:shadow-strong transition-all">

    <x-card-header>
        <div class="aspect-video bg-gradient-to-br from-primary/20 to-accent/20 rounded-lg mb-4 flex items-center justify-center relative overflow-hidden">

            {{-- Play button --}}
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="w-20 h-20 rounded-full gradient-primary flex items-center justify-center shadow-strong cursor-pointer hover:scale-110 transition-transform">
                    <i data-lucide="play" class="w-10 h-10 text-primary-foreground ml-1"></i>
                </div>
            </div>

            {{-- Featured Badge --}}
            <x-badge class="absolute top-4 left-4 gradient-accent text-accent-foreground border-0">
                Featured
            </x-badge>

            {{-- Duration Badge --}}
            {{-- <x-badge class="absolute top-4 right-4 bg-background/80 backdrop-blur-sm flex items-center">
                <i data-lucide="clock" class="w-3 h-3 mr-1"></i>
                {{ $video->duration }}
            </x-badge> --}}
             <x-badge class="">
                         
                                {{ $video->duration }}

                            

                                       
             </x-badge>

        </div>

        <x-card-title class="text-2xl mb-2">{{ $video->title }}</x-card-title>

        <div class="flex items-center text-sm text-muted-foreground">
            <i data-lucide="user" class="h-4 w-4 mr-1"></i>
            {{ $video->instructor }}
            <span class="mx-2">•</span>
            {{-- <x-badge variant="outline">{{ $video->category }}</x-badge> --}}
        </div>
    </x-card-header>

    <x-card-content>
        <p class="text-muted-foreground mb-4">
            {{ $video->description }}
        </p>

        <x-button variant="hero" class="w-full">
            <i data-lucide="play" class="mr-2 h-4 w-4"></i>
            Watch Now
        </x-button>
    </x-card-content>

</x-card>
