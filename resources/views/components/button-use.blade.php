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
@endif




 


