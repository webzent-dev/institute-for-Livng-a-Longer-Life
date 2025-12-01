@props([
    'type' => 'button',
    'variant' => 'primary',   // primary | outline | danger | success | muted
    'size' => 'md',           // sm | md | lg
    'full' => false           // full width
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
        'primary' => 'bg-primary text-white hover:bg-primary/90',
        'outline' => 'border border-gray-500 text-gray-700 hover:bg-gray-100',
        'danger'  => 'bg-red-600 text-white hover:bg-red-700',
        'success' => 'bg-green-600 text-white hover:bg-green-700',
        'muted'   => 'bg-gray-200 text-gray-700 hover:bg-gray-300',
    ];
@endphp

<button
    type="{{ $type }}"
    {{ $attributes->merge([
        'class' =>
            'rounded-md font-semibold transition ' .
            ($full ? 'w-full ' : '') .
            ($sizes[$size] ?? $sizes['md']) . ' ' .
            ($variants[$variant] ?? $variants['primary'])
    ]) }}
>
    {{ $slot }}
</button>
