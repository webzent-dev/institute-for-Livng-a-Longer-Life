@props(['variant' => 'default'])

@php
$styles = [
    'default' => 'bg-primary text-white hover:bg-primary/80',
    'outline' => 'border border-primary text-primary hover:bg-primary/10',
    'hero'    => 'bg-gradient-to-r from-primary to-accent text-white shadow-lg hover:opacity-90'
][$variant];
@endphp

<button {{ $attributes->merge(['class' => "w-full py-3 rounded-xl font-semibold transition $styles"]) }}>
    {{ $slot }}
</button>



