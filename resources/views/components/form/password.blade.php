@props(['model' => '', 'placeholder' => ''])

<div class="relative space-y-1">
    <input 
        :type="showPass === '{{ $model }}' ? 'text' : 'password'"
        placeholder="{{ $placeholder }}"
        class="input-base"
        x-model="form.{{ $model }}"
        @input="validateField('{{ $model }}')"
        :class="{
            'border-red-500': errors.{{ $model }},
            'border-green-500': !errors.{{ $model }} && form.{{ $model }}
        }"
    >

    <!-- Hold to show password -->
    <button type="button"
        @mousedown="showPass = '{{ $model }}'"
        @mouseup="showPass = ''"
        @mouseleave="showPass = ''"
        @touchstart="showPass = '{{ $model }}'"
        @touchend="showPass = ''"
        class="absolute right-3 self-center"
    >
      
         <i data-lucide="eye" 
         :class="showPass ? 'text-green-700' : 'text-gray-400'"
          class="transition-colors duration-200 ">
         </i>
    </button>

    <p class="text-red-500 text-sm" x-text="errors.{{ $model }}"></p>
</div>

 


{{-- 
@props([
    'model' => '',
    'placeholder' => ''
])

<div class="relative space-y-1">
    <input 
        :type="show['{{ $model }}'] ? 'text' : 'password'"
        class="input-base"
        placeholder="{{ $placeholder }}"
        x-model="form.{{ $model }}"
        @input="clearError('{{ $model }}')"
        :class="{
            'border-red-500': errors.{{ $model }},
            'border-green-500': form.{{ $model }} && !errors.{{ $model }}
        }"
    >

    <button 
        type="button"
        class="absolute right-3 top-3"
        @mousedown="show['{{ $model }}'] = true"
        @mouseup="show['{{ $model }}'] = false"
        @mouseleave="show['{{ $model }}'] = false"
    >
        <i data-lucide="eye"
           :class="show['{{ $model }}'] ? 'text-green-700' : 'text-gray-400'"
           class="transition-colors duration-200">
        </i>
    </button>

    <p class="text-red-500 text-sm" x-text="errors.{{ $model }}"></p>
</div> --}}
