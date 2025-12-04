@props([
    'title' => 'Your CTA Title',
    'subtitle' => null,
    'buttons' => [],                 // Array of buttons → full dynamic
    'cardClass' => 'shadow-strong',  // Extra card classes
    'align' => 'center',             // left | center
    'padding' => 'p-10',              
    'container' => 'max-w-4xl',
     'icon' => null,               // <— accept icon or null
    'iconBg' => 'iconbg',   // class for icon color
    'iconSize' => 'w-10 h-10',
    'image' => null,   
    'onclick' => null, 
    'type' => 'button',
    
])

<section class="py-20 gradient-subtle">
    <div class="{{ $container }} mx-auto px-4 sm:px-6 lg:px-8">

        <x-card class="{{ $cardClass }}">

            <div class="{{ $padding }} text-{{ $align }}">

                 {{-- ICON (OPTIONAL) --}}
                
                @if($icon)
                    <div class="iconbg w-20 h-20 rounded-full mb-4 ">
                    
                            <i data-lucide="{{ $icon }}" class=" {{ $iconSize }}"  > </i>
                      
                    </div>
                @endif
                @if($image)
                    <div class="flex justify-center mb-6">
                       
                            <img src="{{ $image }}" class="{{ $iconBg }} {{ $iconSize }}" alt="icon">
                        
                    </div>
                @endif

                {{-- TITLE  --}}
                @if($title)
                    <h2 class="text-3xl lg:text-5xl font-bold text-foreground mb-6">
                        {{ $title }}
                    </h2>
                @endif

                {{-- SUBTITLE  --}}
                @if($subtitle)
                    <p class="text-xl text-muted-foreground mb-8">
                        {{ $subtitle }}
                    </p>
                @endif

                {{-- BUTTON GROUP --}}
                <div class="flex flex-col sm:flex-row gap-4 justify-{{ $align == 'center' ? 'center' : 'start' }}">
                    @foreach ($buttons as $btn)
                        <div class="max-w-xl">
                           {{-- @foreach($btn as $b) <p> {{ $b }} </p>@endforeach --}}
                            @php
                                $href = $btn['href'] ?? null;

                                // If route() is passed, build the URL
                                if(isset($btn['route'])) {
                                    $href = route($btn['route'], $btn['params'] ?? []);
                                }

                                $label = $btn['label'] ?? 'Click';
                                $variant = $btn['variant'] ?? 'primary';
                                $customClass = $btn['class'] ?? '';
                                $onclick = $btn['onclick'] ?? null;
                                $class = $btn['class'] ?? '';
                                $icon = $btn['icon'] ?? null;
                            @endphp
                            
                            <x-button-use
                                :href="$href" 
                                :icon="$icon"
                                :label="$label"
                                :variant="$variant"
                                :class="$customClass"
                                :onclick="$onclick"
                                :type="($btn['type'] ?? 'button')"
                            />
                        </div>
                    @endforeach
                </div> 
            </div>

        </x-card>

    </div>
</section>
 

