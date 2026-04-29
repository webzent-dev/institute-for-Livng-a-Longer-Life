@props([
    'name',
    'id' => null,
    'label' => 'Published',
    'checked' => false,
    'onValue' => 'published',
    'offValue' => 'draft',
    'onLabel' => 'Published',
    'offLabel' => 'Draft',
    'class' => '',
])

@php
    $inputId = $id ?: 'sw_' . preg_replace('/[^a-z0-9_]/i', '_', $name);
    $initialChecked = old($name) !== null ? old($name) === $onValue : (bool) $checked;
@endphp

<div
    x-data="{ checked: @js($initialChecked) }"
    class="flex items-center space-x-2 {{ $class }}"
>
    <input
        type="hidden"
        name="{{ $name }}"
        :value="checked ? @js($onValue) : @js($offValue)"
    >

    <button
        id="{{ $inputId }}"
        type="button"
        role="switch"
        :aria-checked="checked.toString()"
        :data-state="checked ? 'checked' : 'unchecked'"
        @click="checked = !checked"
        class="peer inline-flex h-6 w-11 shrink-0 cursor-pointer items-center rounded-full border-2 border-transparent transition-colors data-[state=checked]:bg-primary data-[state=unchecked]:bg-input focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:ring-offset-background disabled:cursor-not-allowed disabled:opacity-50"
    >
        <span
            :data-state="checked ? 'checked' : 'unchecked'"
            class="pointer-events-none block h-5 w-5 rounded-full bg-background shadow-lg ring-0 transition-transform data-[state=checked]:translate-x-5 data-[state=unchecked]:translate-x-0"
        ></span>
    </button>

    <label
        for="{{ $inputId }}"
        class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
    >
        {{ $label }}
    </label>

    {{-- Output --}}
    {{-- <span class="text-xs text-muted-foreground" x-text="checked ? @js($onLabel) : @js($offLabel)"></span> --}}
</div>
