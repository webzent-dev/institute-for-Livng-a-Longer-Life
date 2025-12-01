@props([
    'variant' => 'info', // info | success | danger | warning
])

@php
$styles = [
    'info'    => 'bg-blue-50 text-blue-700 border-blue-200',
    'success' => 'bg-green-50 text-green-700 border-green-200',
    'danger'  => 'bg-red-50 text-red-700 border-red-200',
    'warning' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
];
@endphp

<div {{ $attributes->merge([
    'class' => "border px-4 py-3 rounded-lg flex items-start gap-3 ".$styles[$variant]
]) }}>
    <i data-lucide="alert-circle" class="w-5 h-5 mt-0.5"></i>

    <div class="flex-1">
        {{ $slot }}
    </div>
</div>



{{-- Usage Example --}}
{{-- <x-ui.alert variant="success">
    Your registration was successful!
</x-ui.alert>

<x-ui.alert variant="danger">
    Something went wrong.
</x-ui.alert> --}}

{{-- <x-ui.alert variant="info">
    This is an informational alert. Please be aware of the updates.
</x-ui.alert> --}}