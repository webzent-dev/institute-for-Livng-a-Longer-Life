@props([
    'name',
    'title' => '',
    'size' => 'md', // sm, md, lg, xl, 2xl, 3xl, 4xl, full
    'width' => null,      // e.g. "560px" or "70vw"
    'height' => null,     // e.g. "520px"
    'maxWidth' => "600px",   // e.g. "900px" or "2xl"  
    'maxHeight' => '88vh',
    'class' => '',
])

@php
    $sizeClasses = [
        'sm' => 'max-w-sm',
        'md' => 'max-w-lg',
        'lg' => 'max-w-xl',
        'xl' => 'max-w-2xl',
        '2xl' => 'max-w-3xl',
        '3xl' => 'max-w-4xl',
        '4xl' => 'max-w-5xl',
        'full' => 'max-w-[95vw]',
    ];

    $resolvedSizeClass = $sizeClasses[$size] ?? $sizeClasses['md'];

    // Support maxWidth as either a token (e.g. "2xl") or CSS value (e.g. "900px")
    $maxWidthStyle = null;
    if ($maxWidth) {
        if (isset($sizeClasses[$maxWidth])) {
            $resolvedSizeClass = $sizeClasses[$maxWidth];
        } else {
            $maxWidthStyle = "max-width: {$maxWidth}";
        }
    }

    $style = collect([
        $width ? "width: {$width}" : null,
        $height ? "height: {$height}" : null,
        $maxWidthStyle,
        $maxHeight ? "max-height: {$maxHeight}" : null,
    ])->filter()->implode('; ');
@endphp

<div
    x-data="{ open: false }"
    x-on:open-modal.window="if($event.detail === '{{ $name }}') { open = true; $nextTick(() => $refs.panel && ($refs.panel.scrollTop = 0)); }"
    x-on:close-modal.window="open = false"
>
    <style>[x-cloak]{display:none !important;}</style>
    <div class="fixed inset-0 z-40 bg-black/80" x-cloak x-show="open" x-transition.opacity></div>

    <div class="fixed inset-0 z-50 flex items-center justify-center p-4" x-cloak x-show="open" x-transition>
        <div x-ref="panel" style="{{ $style }}" class="relative w-full {{ $resolvedSizeClass }} overflow-y-auto rounded-xl bg-white p-6 shadow-lg scrollbar-custom {{ $class }}">
            <button
                type="button"
                @click="$dispatch('close-modal')"
                class="absolute right-3 top-3 text-xl text-gray-600"
                aria-label="Close modal"
            >&times;</button>

            {{ $slot }}
        </div>
    </div>
</div>

{{-- Usage Example --}}
{{-- <button @click="$dispatch('open-modal', 'signupModal')" class="btn-primary h-10 px-4 py-2">Open Modal</button> --}}
{{-- <x-ui.modal name="signupModal"><h2 class="text-xl font-bold mb-4">Signup</h2><p>This is a modal!</p></x-ui.modal> --}}
{{-- <button @click="$dispatch('close-modal')">Close</button> --}}
