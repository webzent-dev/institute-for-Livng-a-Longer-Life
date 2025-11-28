<div x-data="{ open: false }" class="relative inline-block">
    <button @click="open = !open" class="px-3 py-2 border rounded">
        {{ $trigger }}
    </button>

    <div 
        x-show="open" 
        x-transition 
        class="absolute right-0 mt-2 w-40 bg-white shadow-lg rounded-md border z-50"
    >
        {{ $slot }}
    </div>
</div>

{{-- how to use --}}
{{-- <x-ui.menu>
    <x-slot name="trigger">Menu</x-slot>

    <a class="block px-4 py-2 hover:bg-gray-100">Profile</a>
    <a class="block px-4 py-2 hover:bg-gray-100">Settings</a>
    <a class="block px-4 py-2 hover:bg-gray-100">Logout</a>
</x-ui.menu> --}}


