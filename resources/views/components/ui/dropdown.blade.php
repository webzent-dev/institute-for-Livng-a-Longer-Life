@props([
    'label' => 'Menu',
    'align' => 'left', // left | right
])

<div x-data="{ open: false }" class="relative inline-block text-left">

    <!-- Toggle Button -->
    <button 
        @click="open = !open" 
        class="px-4 py-2 bg-gray-100 rounded-lg hover:bg-gray-200 flex items-center gap-2"
    >
        {{ $label }}
        <i data-lucide="chevron-down" class="w-4 h-4"></i>
    </button>

    <!-- Dropdown Menu -->
    <div 
        x-show="open"
        @click.away="open = false"
        x-transition
        class="absolute mt-2 w-48 bg-white border shadow-lg rounded-xl z-50
            {{ $align === 'right' ? 'right-0' : 'left-0' }}"
    >
        {{ $slot }}
    </div>
</div>
{{-- Usage Example --}}
{{-- <x-ui.dropdown label="Account" align="right">
    <a class="block px-4 py-2 hover:bg-gray-100">Profile</a>
    <a class="block px-4 py-2 hover:bg-gray-100">Settings</a>
    <button class="block w-full text-left px-4 py-2 hover:bg-gray-100">Logout</button>
</x-ui.dropdown> --}}

{{-- <x-ui.dropdown label="Options" align="right">
    <a href="#" class="block px-4 py-2 hover:bg-gray-100">Profile</a>
    <a href="#" class="block px-4 py-2 hover:bg-gray-100">Settings</a>
    <a href="#" class="block px-4 py-2 hover:bg-gray-100">Logout</a>
</x-ui.dropdown> --}}