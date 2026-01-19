{{-- @props([
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
    > --}}

    {{-- Alpine validation error --}}
    {{-- <p class="text-red-500 text-sm" x-text="errors.{{ $model }}"></p> --}}

    {{-- Laravel validation error --}}
    {{-- @error($name)
        <p class="text-red-500 text-sm">{{ $message }}</p>
    @enderror
</div> --}}
@props([
    'name',
    'placeholder' => '',
    'value' => null,       // text value or image path for preview
    'required' => false,
    'type' => 'text',      // text|file
    'filter' => null,      // alpha|numeric|alphanumeric|email
    'lockOnValue' => false, // for inputs with DB values
    'preview' => false,    // image preview enable
])

@php
    $hasValue = filled(old($name, $value));
    $id = 'fld_'.uniqid();
@endphp

@if($type === 'file')
    <input
        id="{{ $id }}"
        type="file"
        name="{{ $name }}"
        accept="image/*"
        @if($required) required @endif
        class="w-full input-base file:cursor-pointer"
    >

    {{-- Preview if enabled + image exists --}}
    @if($preview && $hasValue)
        <img
            src="{{ asset($value) }}"
            class="mt-2 w-28 h-28 object-cover rounded border"
        >
    @endif

    @error($name)
    <p class="text-red-500 text-sm">{{ $message }}</p>
    @enderror

    <script>
    (function() {
        const el = document.getElementById('{{ $id }}');
        const previewEnabled = {{ $preview ? 'true' : 'false' }};

        if (previewEnabled) {
            el.addEventListener('change', (e) => {
                const file = e.target.files[0];
                if (!file) return;

                const img = document.createElement('img');
                img.className = "mt-2 w-28 h-28 object-cover rounded border";
                img.src = URL.createObjectURL(file);

                // remove old preview
                const next = el.nextElementSibling;
                if (next && next.tagName === "IMG") next.remove();

                el.insertAdjacentElement('afterend', img);
            });
        }
    })();
    </script>

@else
    {{-- TEXT MODE --}}
    <input
        id="{{ $id }}"
        type="text"
        name="{{ $name }}"
        placeholder="{{ $placeholder }}"
        value="{{ old($name, $value) }}"
        @if($required) required @endif
        @if($lockOnValue && $hasValue) disabled @endif

        class="w-full input-base disabled:opacity-60 disabled:cursor-not-allowed
            @error($name) border-red-500 @enderror"
    >

    @error($name)
    <p class="text-red-500 text-sm">{{ $message }}</p>
    @enderror

    <script>
    (function() {
        const el = document.getElementById('{{ $id }}');
        const filter = "{{ $filter }}";

        if (!el) return;

        if (el.disabled) {
            el.addEventListener('dblclick', () => {
                el.disabled = false;
                el.focus();
            });
        }

        el.addEventListener('input', function() {
            let v = el.value;

            switch(filter) {
                case 'alpha':        v = v.replace(/[^a-zA-Z\s]/g, ''); break;
                case 'numeric':      v = v.replace(/[^0-9]/g, ''); break;
                case 'alphanumeric': v = v.replace(/[^a-zA-Z0-9]/g, ''); break;
                case 'email':        v = v.replace(/[^a-zA-Z0-9@._-]/g, ''); break;
            }

            el.value = v;
        });
    })();
    </script>
@endif



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