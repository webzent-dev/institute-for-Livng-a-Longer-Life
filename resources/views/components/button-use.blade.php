@props([
    'href'      => null,
    'label'     => null,
    'type'      => 'button',
    'id'        => null,
    'size'      => 'md',
    'variant'   => 'primary',
    'isPopular' => false,
    'class'     => 'font-semibold  text-[14px]',
    'icon'      => null,
    'method'    => 'get',
    'onclick'   => null,

    // NEW:
    'iconPosition' => 'left', // left | right
])


@php
    // Size classes
    $sizes = [
        'sm' => 'px-3 py-1.5 text-sm h-9',
        'md' => 'px-5 py-2 text-base h-10',
        'lg' => 'px-6 py-2 text-lg h-10',
        'full' => 'w-full px-6 py-2 h-10'
    ];

    // Variants
    $variants = [
        'primary' => 'gradient-primary text-primary-foreground hover:opacity-90 shadow-medium font-semibold h-10 px-4 py-2 ',
        'outline' => 'border-2 border-primary text-primary hover:bg-primary hover:text-white',
        'danger'  => 'bg-red-600 text-white hover:bg-red-700',
        'success' => 'bg-green-600 text-white hover:bg-green-700',
        'muted'   => 'bg-gray-200 text-gray-700 hover:bg-gray-300'
    ];

    // Override when Popular button
    if ($isPopular) {
        $variantClasses = 'gradient-primary text-primary-foreground hover:opacity-90 shadow-medium font-semibold';
    } else {
        $variantClasses = $variants[$variant] ?? $variants['primary'];
    }

    // Final classes
    $classes = collect([
        'rounded-md flex items-center justify-center font-semibold gap-2 transition-all duration-150 select-none',
        $sizes[$size] ?? $sizes['md'],
        $variantClasses,
        $class
    ])->implode(' ');
@endphp


{{-- ===================== --}}
{{--    FORM LINK VERSION   --}}
{{-- ===================== --}}
@if($href && strtolower($method) !== 'get')
    <form method="POST" action="{{ $href }}" class="inline"
          @if($onclick) onsubmit="{{ $onclick }}" @endif>
        @csrf
        @method(strtoupper($method))

        <button type="submit"
            @if($id) id="{{ $id }}" @endif
            {{ $attributes->merge(['class' => $classes]) }}>

            @if($icon && $iconPosition === 'left')
                <i data-lucide="{{ $icon }}" class="w-5 h-5 mr-2"></i>
            @endif

            {{ $label ?? $slot }}

            @if($icon && $iconPosition === 'right')
                <i data-lucide="{{ $icon }}" class="w-5 h-5 ml-2"></i>
            @endif
        </button>
    </form>


{{-- ===================== --}}
{{--    NORMAL LINK        --}}
{{-- ===================== --}}
@elseif($href)
    <a href="{{ $href }}"
       @if($id) id="{{ $id }}" @endif
       {{ $attributes->merge(['class' => $classes]) }}>

        @if($icon && $iconPosition === 'left')
            <i data-lucide="{{ $icon }}" class="w-4 h-4 mr-2"></i>
        @endif

        {{ $label ?? $slot }}

        @if($icon && $iconPosition === 'right')
            <i data-lucide="{{ $icon }}" class="w-5 h-5 ml-2"></i>
        @endif
    </a>


{{-- ===================== --}}
{{--    BUTTON VERSION     --}}
{{-- ===================== --}}
@else
    <button type="{{ $type }}"
        @if($id) id="{{ $id }}" @endif
        {{ $attributes->merge(['class' => $classes]) }}>

        @if($icon && $iconPosition === 'left')
            <i data-lucide="{{ $icon }}" class="w-5 h-5 mr-2"></i>
        @endif

        {{ $label ?? $slot }}

        @if($icon && $iconPosition === 'right')
            <i data-lucide="{{ $icon }}" class="w-5 h-5 ml-2"></i>
        @endif
    </button>
@endif
