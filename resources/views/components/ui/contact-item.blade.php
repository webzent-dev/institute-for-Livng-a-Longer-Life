@props([
    'type' => 'link',     // mail | phone | location | link
    'text' => null,       // visible text
    'value' => null,      // actual value (email, phone no, map url)
    'icon' => null,       // lucide icon name
    'class' => '',        // custom class for styling
])

@php
    // Auto-generate href based on type
    switch ($type) {
        case 'mail':
            $href = "mailto:$value";
            break;

        case 'phone':
            $href = "tel:$value";
            break;

        case 'location':
            $href = $value; // full map URL
            break;

        default:
            $href = $value; // normal link
    }
@endphp

<a href="{{ $href }}"
   target="_blank"
   rel="noopener noreferrer"
   class="flex items-center text-primary gap-3 p-4 rounded-xl   hover:bg-gray-50 transition {{ $class }}">

    {{-- Lucide Icon --}}
    @if($icon)
        <div class="iconbg">
        <i data-lucide="{{ $icon }}" class="w-6 h-6 text-white"></i>
        </div>
    @endif

    {{-- Text --}}
    <span class="text-lg font-semibold text-primary mb-2">{{ $text }}</span>
</a>
