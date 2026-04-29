@props([
    'variant' => 'primary', 
])

@php
$styles = [
    'primary' => 'bg-blue-100 text-blue-700',
    'success' => 'bg-green-100 text-green-700',
    'danger'  => 'bg-red-100 text-red-700',
    'warning' => 'bg-yellow-100 text-yellow-700',
    'gray'    => 'bg-gray-200 text-gray-700',
];
@endphp

<span {{ $attributes->merge([
    'class' => "px-3 py-1 text-xs font-semibold rounded-full ".$styles[$variant]
]) }}>
    {{ $slot }}
</span>

 