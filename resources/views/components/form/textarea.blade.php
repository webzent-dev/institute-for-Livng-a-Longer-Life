@props([
    'model' => '',
    'placeholder' => '',
    'rows' => 4,
    'filter' => null
])

<div class="space-y-1">
    <textarea
        rows="{{ $rows }}"
        placeholder="{{ $placeholder }}"
        class="input-base resize-none"

        x-model="form.{{ $model }}"

        
        @if($filter)
            @input="sanitizeField('{{ $model }}', '{{ $filter }}'); validateField('{{ $model }}')"
        @else
            @input="validateField('{{ $model }}')"
        @endif

        @blur="validateField('{{ $model }}')"

        :class="{
            'border-red-500': errors.{{ $model }},
            'border-green-500': form.{{ $model }} && !errors.{{ $model }}
        }"
    ></textarea>

    <p class="text-red-500 text-sm" x-text="errors.{{ $model }}"></p>
</div>
