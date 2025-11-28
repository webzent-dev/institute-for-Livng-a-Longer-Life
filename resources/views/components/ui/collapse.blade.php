@props(['title' => ''])

<div x-data="{ open: false }" class="border rounded-xl bg-white shadow-sm">

    <button @click="open = !open"
        class="w-full flex justify-between items-center p-4 text-left">
        <span class="font-semibold">{{ $title }}</span>
        <i data-lucide="chevron-down" :class="open ? 'rotate-180' : ''" class="transition"></i>
    </button>

    <div x-show="open" x-collapse class="p-4 border-t">
        {{ $slot }}
    </div>

</div>



{{-- how to use --}}
{{-- <x-ui.collapse title="More Details">
    Extra content here...
</x-ui.collapse> --}}


{{-- <x-ui.collapse title="More Information">
    <p>This is the content that will be shown or hidden when the collapse component is toggled.</p>
</x-ui.collapse> --}}   


