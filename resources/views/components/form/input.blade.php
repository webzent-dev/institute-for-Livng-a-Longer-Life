@props([ 'model' => '', 'name' => '', 'placeholder' => '', 'type' => 'text', 'filter' => null  {{-- ex: filter="name" --}} ])


<div class="space-y-1">
    <input
        type="{{ $type }}"
        name="{{ $name}}"
        placeholder="{{ $placeholder }}"
        class="input-base"
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

    <p class="text-red-500 text-sm" x-text="errors.{{ $model }}"></p>
</div>






{{-- @props([
    'model' => '',
    'placeholder' => '',
    'type' => 'text'
])

<div class="space-y-1">
    <input 
        type="{{ $type }}"
        placeholder="{{ $placeholder }}"
        class="input-base"
        x-model="form.{{ $model }}"
        @input="clearError('{{ $model }}')"
        :class="{
            'border-red-500': errors.{{ $model }},
            'border-green-500': form.{{ $model }} && !errors.{{ $model }}
        }"
    >
    <p class="text-red-500 text-sm" x-text="errors.{{ $model }}"></p>
</div> --}}
