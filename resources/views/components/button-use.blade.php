
@props([
    'href'      => null,          // if present → render <a>
    'label'     => null,
    'type'      => 'button',      // button type
    'id'        => null,
    'size'      => 'md',
    'variant'   => 'primary',
    'isPopular' => false,
    'class'     => 'font-semibold',
    'icon'      => null,          // optional lucide icon
])

@php
    // Size classes
    $sizes = [
        'sm' => 'px-3 py-1.5 text-sm h-9',
        'md' => 'px-4 py-2 text-base h-11',
        'lg' => 'px-6 py-3 text-lg h-14',
        'full' => 'w-full px-4 py-3 h-12'
    ];

    // Variants
    $variants = [
        'primary' => 'bg-primary text-white hover:bg-accent',
        'outline' => 'border-2 border-primary text-primary hover:bg-primary hover:text-white',
        'danger'  => 'bg-red-600 text-white hover:bg-red-700',
        'success' => 'bg-green-600 text-white hover:bg-green-700',
        'muted'   => 'bg-gray-200 text-gray-700 hover:bg-gray-300'
    ];

    // Override when Popular button
    if ($isPopular) {
        $variantClasses = 'gradient-primary text-primary-foreground hover:opacity-90 shadow-medium font-semibold';
    } else {
        $variantClasses = $variants[$variant] ?? $variants['primary'];
    }

    // Final classes
    $classes = collect([
        'rounded-md flex items-center justify-center font-semibold gap-2 transition-all duration-150 select-none',
        $sizes[$size] ?? $sizes['md'],
        $variantClasses,
        $class
    ])->implode(' ');
@endphp


{{-- ===================== --}}
{{--    LINK VERSION        --}}
{{-- ===================== --}}
@if($href)
    <a
        href="{{ $href }}"
        @if($id) id="{{ $id }}" @endif
        {{ $attributes->merge(['class' => $classes]) }}
    >
        @if($icon)
            <i data-lucide="{{ $icon }}" class="w-5 h-5"></i>
        @endif

        {{ $label ?? $slot }}
    </a>


{{-- ===================== --}}
{{--    BUTTON VERSION     --}}
{{-- ===================== --}}
@else
    <button
        type="{{ $type }}"
        @if($id) id="{{ $id }}" @endif
        {{ $attributes->merge(['class' => $classes]) }}
    >
        @if($icon)
            <i data-lucide="{{ $icon }}" class="w-5 h-5"></i>
        @endif

        {{ $label ?? $slot }}
    </button>
@endif




















{{-- 
@props([
    'href' => null,          // if null → button
    'isPopular' => false,
    'label' => 'Get Started',
    'type' => 'button',
    'id' => null,            // dynamic id
    'class' => '', 
    'sizes' => '',
    'variant' => '',          // dynamic class (user can override/add)
])


@php
    // Size classes
    $sizes = [
        'sm' => 'px-3 py-1.5 text-sm',
        'md' => 'px-4 py-2 text-base',
        'lg' => 'px-6 py-3 text-lg',
    ];

    // Variant classes
    $variants = [
        'primary' => 'bg-primary text-white hover:bg-primary/90 ',
        'outline' => 'border-2 border-primary text-primary hover:bg-primary hover:text-primary-foreground',
        'danger'  => 'bg-red-600 text-white hover:bg-red-700',
        'success' => 'bg-green-600 text-white hover:bg-green-700',
        'muted'   => 'bg-gray-200 text-gray-700 hover:bg-gray-300',
    ];
 
    // Static base classes
    $baseClasses = "h-11 rounded-md px-8 w-full mt-8 flex items-center justify-center";

    // Conditional classes
    $variantClasses = $isPopular
        ?'gradient-primary text-primary-foreground hover:opacity-90 shadow-medium font-semibold'
        : ($variants[$variant] ?? $variants['primary']);

        //  "gradient-primary text-primary-foreground hover:opacity-90 shadow-medium font-semibold"
        // : "border-2 border-primary text-primary hover:bg-primary hover:text-primary-foreground";

    // Final merged classes
    $classes = trim("$baseClasses $variantClasses $class");
@endphp


@if($href)
    <!-- LINK VERSION -->
    <a 
        href="{{ $href }}" 
        @if($id) id="{{ $id }}" @endif
        class="{{ $classes }}"
    >
        {{ $label }}
    </a>

@else
    <!-- BUTTON VERSION -->
    <button 
        type="{{ $type }}" 
        @click="$dispatch('open-register-modal', { plan: @js($plan) })"
        @if($id) id="{{ $id }}" @endif
        class='{{ $classes }}'.($sizes[$size] ?? $sizes['md']) . ' ' .
            ($variants[$variant] ?? $variants['primary']
        size                        
    >
        {{ $label }}
    </button>
@endif --}}




 


