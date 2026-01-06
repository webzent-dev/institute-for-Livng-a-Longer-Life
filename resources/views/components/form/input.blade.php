@props([
    'model' => '',
    'name' => '',
    'placeholder' => '',
    'type' => 'text',
    'filter' => null
])

<div class="space-y-1">
    <input
        type="{{ $type }}"
        name="{{ $name }}"
        placeholder="{{ $placeholder }}"
        value="{{ old($name) }}"
        class="input-base
            @error($name) border-red-500 @enderror
        "
        x-model="form.{{ $model }}"
        @input="
            sanitizeField('{{ $model }}', '{{ $filter }}');
            validateField('{{ $model }}');
        "
        :class="{
            'border-red-500': errors.{{ $model }},
            'border-green-500': !errors.{{ $model }} && form.{{ $model }}
        }"
    >

    {{-- Alpine validation error --}}
    <p class="text-red-500 text-sm" x-text="errors.{{ $model }}"></p>

    {{-- Laravel validation error --}}
    @error($name)
        <p class="text-red-500 text-sm">{{ $message }}</p>
    @enderror
</div>