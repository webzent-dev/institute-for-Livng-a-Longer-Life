@props(['title' => ''])

<div 
    x-data="{ open: false }"
    x-on:open-dialog.window="open = true"
    x-on:close-dialog.window="open = false"
    x-show="open"
    x-cloak
    class="fixed inset-0 bg-black/50 flex items-center justify-center z-50"
>

    <div 
        x-show="open"
        x-transition
        class="bg-white rounded-xl shadow-xl p-6 w-full max-w-lg"
    >
        <div class="flex justify-between mb-4">
            <h2 class="text-lg font-semibold">{{ $title }}</h2>
            <button @click="open = false">&times;</button>
        </div>

        {{ $slot }}
    </div>
</div>

{{-- use parts --}}
{{-- <button @click="$dispatch('open-dialog')">Open</button>

<x-ui.dialog title="Confirm Action">
    Are you sure?
</x-ui.dialog> --}}