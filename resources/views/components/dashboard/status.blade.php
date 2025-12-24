@props(['type'])

@php
$map = [
 'Delivered' => 'bg-green-100 text-green-700',
 'Shipped' => 'bg-blue-100 text-blue-700',
 'Processing' => 'bg-orange-100 text-orange-700',
 'Completed' => 'bg-green-100 text-green-700',
];
@endphp

<span class="px-3 py-1 rounded-full text-xs font-semibold {{ $map[$type] ?? '' }}">
    {{ $type }}
</span>
