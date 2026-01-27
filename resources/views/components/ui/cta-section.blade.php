@props([
    'title'      => 'Your CTA Title',
    'subtitle'   => null,
    'buttons'    => [],
    'cardClass'  => 'shadow-strong',
    'align'      => 'center',
    'padding'    => 'p-10',
    'container'  => 'max-w-4xl',

    // Icon settings
    'icon'       => null,           // Lucide icon name
    'iconBg'     => 'bg-primary/10',
    'iconSize'   => 'w-12 h-12',

    'image'      => null,
])

<section class="section-base py-20 gradient-subtle">
    <div class="{{ $container }} mx-auto px-4 sm:px-4 lg:px-8">

        <x-card class="{{ $cardClass }}">

            <div class="{{ $padding }} text-{{ $align }}">

                {{-- ICON (optional) --}}
                    @if($icon)
                        <div class="flex justify-center mb-6">
                            <div class="{{ $iconBg }} p-4 rounded-full inline-flex items-center justify-center">
                                <i data-lucide="{{ $icon }}" class="{{ $iconSize }} text-primary"></i>
                            </div>
                        </div>
                    @endif

                {{-- IMAGE (optional) --}}
                @if($image)
                    <div class="flex justify-center mb-6">
                        <img src="{{ $image }}" class="{{ $iconSize }}" alt="CTA Image">
                    </div>
                @endif

                {{-- TITLE --}}
                @if($title)
                    <h2 class="text-3xl lg:text-5xl font-bold text-foreground mb-4">
                        {{ $title }}
                    </h2>
                @endif

                {{-- SUBTITLE --}}
                @if($subtitle)
                    <p class="text-xl text-muted-foreground mb-8">
                        {{ $subtitle }}
                    </p>
                @endif

                {{-- CUSTOM SLOT CONTENT (pricing etc.) --}}
                @if (isset($slot) && trim($slot) !== '')
                    <div class="mb-8">
                        {{ $slot }}
                    </div>
                @endif

                {{-- BUTTON GROUP --}}
                <div class="flex flex-col sm:flex-row gap-4 justify-{{ $align == 'center' ? 'center' : 'start' }}">
                    @foreach ($buttons as $btn)

                        @php
                            $href = $btn['href'] ?? null;
                            if(isset($btn['route'])) {
                                $href = route($btn['route'], $btn['params'] ?? []);
                            }

                            $label       = $btn['label'] ?? 'Click';
                            $variant     = $btn['variant'] ?? 'primary';
                            $iconBtn     = $btn['icon'] ?? null;
                            $customClass = $btn['class'] ?? '';
                            $onclick     = $btn['onclick'] ?? null;
                            $type        = $btn['type'] ?? 'button';
                        @endphp

                        <x-button-use
                            :href="$href"
                            :icon="$iconBtn"
                            :label="$label"
                            :variant="$variant"
                            :class="$customClass"
                            :onclick="$onclick"
                            :type="$type"
                        />
                    @endforeach
                </div>

            </div>
        </x-card>
    </div>
</section>
