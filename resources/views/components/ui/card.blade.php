@props([
    'title'      => null,
    'subtitle'   => null,
    'media'      => null,          // image/video/icon/etc.
    'footer'     => null,
    'layout'     => 'single',      // single | dual | triple
    'header'     => null,
])

@php
    // Layout presets (fully responsive)
    $layouts = [
        'single' => 'flex flex-col',
        'dual'   => 'grid grid-cols-1 md:grid-cols-2 gap-6',
        'triple' => 'grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6',
    ];
@endphp

<div {{ $attributes->merge(['class' => 'rounded-2xl bg-card border text-card-foreground shadow-soft overflow-hidden']) }}>

    {{-- ===================== --}}
    {{--      MEDIA BLOCK      --}}
    {{-- ===================== --}}
    @if($media)
        <div class="w-full overflow-hidden rounded-t-2xl">
            {!! $media !!}
        </div>
    @endif


    {{-- ===================== --}}
    {{--     HEADER AREA       --}}
    {{-- ===================== --}}
    @if($header || $title || $subtitle)
        <div class="flex flex-col space-y-1.5 p-6 border-b">

            {{-- Custom header slot --}}
            @if($header)
                {!! $header !!}
            @endif

            {{-- Title --}}
            @if($title)
                <h3 class="text-2xl font-semibold leading-none tracking-tight">
                    {!! $title !!}
                </h3>
            @endif

            {{-- Subtitle --}}
            @if($subtitle)
                <p class="text-sm text-muted-foreground">
                    {!! $subtitle !!}
                </p>
            @endif
        </div>
    @endif


    {{-- ===================== --}}
    {{--     CONTENT AREA      --}}
    {{-- ===================== --}}
    <div class="p-6 {{ $layouts[$layout] ?? $layouts['single'] }}">
        {{ $slot }}
    </div>


    {{-- ===================== --}}
    {{--      FOOTER AREA      --}}
    {{-- ===================== --}}
    @if($footer)
        <div class="p-6 border-t">
            {!! $footer !!}
        </div>
    @endif

</div>
