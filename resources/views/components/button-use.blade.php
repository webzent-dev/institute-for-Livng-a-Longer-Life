@props([
    'href' => null,          // if null → button
    'isPopular' => false,
    'label' => 'Get Started',
    'type' => 'button',
    'id' => null,            // dynamic id
    'class' => '',           // dynamic class (user can override/add)
])

@php
    // Static base classes
    $baseClasses = "h-11 rounded-md px-8 w-full mt-8 flex items-center justify-center";

    // Conditional classes
    $variantClasses = $isPopular
        ? "gradient-primary text-primary-foreground hover:opacity-90 shadow-medium font-semibold"
        : "border-2 border-primary text-primary hover:bg-primary hover:text-primary-foreground";

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
        class="{{ $classes }}"
    >
        {{ $label }}
    </button>
@endif




 


