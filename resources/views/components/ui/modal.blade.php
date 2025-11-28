@props(['name'])

<div 
    x-data="{ open: false }"
    x-on:open-modal.window="if($event.detail === '{{ $name }}') open = true"
    x-on:close-modal.window="open = false"
>
    <!-- Backdrop -->
    <div 
        class="fixed inset-0 bg-black/40 z-40"
        x-show="open"
        x-transition.opacity
    ></div>

    <!-- Modal Box -->
    <div 
        class="fixed inset-0 z-50 flex items-center justify-center"
        x-show="open"
        x-transition
    >
        <div class="bg-white rounded-xl shadow-lg p-6 w-full max-w-lg">
            {{ $slot }}
        </div>
    </div>
</div>


{{-- Usage Example --}}

{{-- ✔ Open modal from ANYWHERE:
<button 
    @click="$dispatch('open-modal', 'signupModal')" 
    class="btn-primary">
    Open Modal
</button> --}}

{{-- ✔ Use the modal:
<x-ui.modal name="signupModal">
    <h2 class="text-xl font-bold mb-4">Signup</h2>
    <p>This is a modal!</p>
</x-ui.modal> --}}
{{-- ✔ Close modal:
<button @click="$dispatch('close-modal')">Close</button> --}}


{{-- <button 
    @click="$dispatch('open-modal', '{{ $name }}')"
    class="px-4 py-2 bg-blue-600 text-white rounded-lg"
>
    Open Modal    
</button> --}}