@props([
    'label' => '',
    'field' => '',
    'type' => 'text',
    'placeholder' => '',
    'error' => '',
])

<div>
    {{-- <label class="text-sm font-medium">{{ $label }} *</label> --}}

    <input 
        {{ $attributes }}
        type="{{ $type }}"
        placeholder="{{ $placeholder }}"
        class="mt-1 w-full h-11 border rounded-md px-3 focus:ring-2 focus:ring-green-400 outline-none
        {{ $error ? 'border-red-500' : 'border-gray-300' }}"
    >

    @if($error)
        <p class="text-red-500 text-xs mt-1">{{ $error }}</p>
    @endif
</div>
