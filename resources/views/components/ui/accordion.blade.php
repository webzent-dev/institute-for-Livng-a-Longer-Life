@props(['title' => 'Accordion'])

<div x-data="{ open: false }" class="border rounded-xl">
    
    <button 
        @click="open = !open" 
        class="w-full text-left px-4 py-3 flex justify-between items-center"
    >
        {{ $title }}
        <i data-lucide="chevron-down" 
           :class="{ 'rotate-180': open }"
           class="transition-transform"></i>
    </button>

    <div x-show="open" x-transition class="px-4 pb-4 text-gray-700">
        {{ $slot }}
    </div>

</div>
{{-- Usage Example --}}
{{-- <x-ui.accordion title="What is your refund policy?">
    We offer a 30-day refund policy.
</x-ui.accordion> --}}

{{-- <x-ui.accordion title="More Information">
    <p>
        This is the content inside the accordion. You can put any HTML content here, such as text, images, or other components.
    </p>    
</x-ui.accordion> --}}