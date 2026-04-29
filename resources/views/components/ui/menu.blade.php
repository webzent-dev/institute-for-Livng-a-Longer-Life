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
 


