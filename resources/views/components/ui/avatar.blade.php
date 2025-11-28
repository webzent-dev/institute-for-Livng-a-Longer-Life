@props(['src' => null, 'name' => '', 'size' => '12'])

@php
$initials = collect(explode(' ', $name))
    ->map(fn($w) => strtoupper($w[0] ?? ''))
    ->take(2)
    ->join('');
@endphp

<div 
    class="flex items-center justify-center bg-emerald-500 text-white rounded-full font-semibold"
    style="width: {{ $size }}rem; height: {{ $size }}rem; font-size: {{ $size / 2 }}rem;"
>
    @if ($src)
        <img src="{{ $src }}" class="w-full h-full rounded-full object-cover">
    @else
        {{ $initials }}
    @endif
</div>

{{-- how to use --}}
{{-- <x-ui.avatar name="John Doe" size="10" />
<x-ui.avatar src="/users/jane.jpg" /> --}}

