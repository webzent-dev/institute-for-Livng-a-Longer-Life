@props([
    'name',
    'model' => '',
    'label' => null,        
    'placeholder' => '',
    'value' => null,
    'required' => false,
    'type' => null,
    'filter' => null,
    'lockOnValue' => false,
    'preview' => false,
])

@php
    $hasValue = filled(old($name, $value));
    $id = 'fld_'.$name;
@endphp

{{-- LABEL --}}
@if($label)
    <label
        for="{{ $id }}"
        class="mb-1 block text-sm font-medium leading-none
               peer-disabled:cursor-not-allowed
               peer-disabled:opacity-70">
        {{ $label }}
        @if($required) <span class="text-red-500">*</span> @endif
    </label>
@endif

@if($type === 'file')
    <input
        id="{{ $id }}"
        type="file"
        name="{{ $name }}"
        accept="image/*"
        @if($required) required @endif

        class="flex h-10 w-full rounded-md
            border border-input
            bg-background
            px-3 py-2
            text-[14px]
            placeholder:text-[14px]
            ring-offset-background
            focus-visible:outline-none
            focus-visible:ring-2
            focus-visible:ring-ring
            focus-visible:ring-offset-2
            disabled:cursor-not-allowed
            disabled:opacity-50
            @error($name) border-red-500 @enderror"
    >

    @if($preview && $hasValue)
        <img
            src="{{ asset($value) }}"
            class="mt-2 w-28 h-28 object-cover rounded border"
        >
    @endif

@else
    {{-- TEXT MODE --}}
    <input
        id="{{ $id }}"
        type="{{ $type }}"
        name="{{ $name }}"
        placeholder="{{ $placeholder }}"
        value="{{ old($name, $value) }}"
        @if($model) x-model="form.{{ $model }}" @endif
        @if($required) required @endif
        @if($lockOnValue && $hasValue) disabled @endif
        class="flex h-10 w-full rounded-md
            border border-input
            bg-background
            px-3 py-2
            text-[14px]
            placeholder:text-[14px]
            ring-offset-background
            focus-visible:outline-none
            focus-visible:ring-2
            focus-visible:ring-ring
            focus-visible:ring-offset-2
            disabled:cursor-not-allowed
            disabled:opacity-50
            @error($name) border-red-500 @enderror"
    >
@endif

@error($name)
<p class="mt-1 text-sm text-red-500">{{ $message }}</p>
@enderror

{{-- FILTER + UNLOCK LOGIC --}}
<script>
(function () {
    const el = document.getElementById('{{ $id }}');
    const filter = "{{ $filter }}";

    if (!el) return;

    if (el.disabled) {
        el.addEventListener('dblclick', () => {
            el.disabled = false;
            el.focus();
        });
    }

    el.addEventListener('input', () => {
        let v = el.value;
        switch (filter) {
            case 'alpha': v = v.replace(/[^a-zA-Z\s]/g, ''); break;
            case 'numeric': v = v.replace(/[^0-9]/g, ''); break;
            case 'alphanumeric': v = v.replace(/[^a-zA-Z0-9]/g, ''); break;
            case 'email': v = v.replace(/[^a-zA-Z0-9@._-]/g, ''); break;
        }
        el.value = v;
    });
})();
</script>


{{--

USAGE
1️⃣ For Text Input
<x-form.input name="first_name" filter="alpha" />

2️⃣ For Numeric
<x-form.input name="mobile" filter="numeric" />

3️⃣ For Email
<x-form.input name="email" filter="email" required />

4️⃣ For Image Upload (no preview)
<x-form.input name="profile_image" type="file" />

5️⃣ For Image Upload + Preview + DB Value + Editable
<x-form.input name="profile_image" type="file" :value="$user->profile_image ?? null" preview />

6️⃣ For Image Edit Case (DB value exists)
<x-form.input name="profile_image" type="file" preview :value="{{ $user->profile_image }}" />

    Text input
<x-form.input name="username"  type="text" :value="$user->username ?? ''" />

 Image upload with preview
<x-form.input  name="logo"  type="file" preview="true" :value="$user->profile_image ?? null"/>

Text Input With Existing DB Value
<x-form.input  name="username"  :value="$user->username ?? null"/>

Different Validation Filters like : <x-form.input  name="email" filter="email" placeholder="Email"/>
Filter	Behavior
alpha	A–Z only
numeric	0–9 only
alphanumeric	A–Z + 0–9
email	email allowed chars









--}}