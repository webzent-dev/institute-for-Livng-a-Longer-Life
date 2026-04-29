<x-card class="border-2 hover:border-primary transition-all shadow-soft hover:shadow-medium">

    <x-card-header class="pb-4">
        <div class="aspect-video bg-gradient-to-br from-primary/10 to-accent/10 rounded-lg mb-4 flex items-center justify-center relative">
            <div class="w-16 h-16 rounded-full gradient-primary flex items-center justify-center cursor-pointer hover:scale-110 transition-transform">
                <i data-lucide="play" class="h-8 w-8 text-primary-foreground ml-1"></i>
            </div>

            <x-badge class="absolute top-3 right-3 bg-background/80 backdrop-blur-sm flex items-center">
                <i data-lucide="clock" class="h-3 w-3 mr-1"></i>
                {{ $video->duration }}
            </x-badge>
        </div>
    </x-card-header>

    <x-card-content class="space-y-3">

        <div>
            <h3 class="font-semibold text-foreground mb-2 line-clamp-2">
                {{ $video->title }}
            </h3>

            <div class="flex items-center text-sm text-muted-foreground mb-2">
                <i data-lucide="user" class="h-3 w-3 mr-1"></i>
                {{ $video->instructor }}
            </div>

            <x-badge variant="outline" class="mb-3">{{ $video->category }}</x-badge>
        </div>

        <p class="text-sm text-muted-foreground line-clamp-2">
            {{ $video->description }}
        </p>

        <x-button variant="outline" class="w-full">
            <i data-lucide="play" class="mr-2 h-4 w-4"></i>
            Watch
        </x-button>

    </x-card-content>

</x-card>
