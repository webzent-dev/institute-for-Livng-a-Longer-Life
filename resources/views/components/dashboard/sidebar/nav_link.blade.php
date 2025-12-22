@props([
    'icon',
    'label',
    'route' => null,
])

@php
    $isActive = $route && request()->routeIs($route);
@endphp

<a
    href="{{ $route ? route($route) : '#' }}"
    class="
        flex items-center gap-3 px-4 py-3 rounded-xl 
        transition-all duration-200 text-md font-semibold bg-gray-50 hover:bg-amber-50
        {{ $isActive
            ? ' text-green-600 font-medium shadow-sm bg-blue-50 hover:bg-blue-100' 
            : 'text-slate-600 hover:bg-slate-50'
        }}
    "
>
    <i data-lucide="{{ $icon }}" class="w-5 h-5 shrink-0"></i>
    <span class="truncate">{{ $label }}</span>
</a>
