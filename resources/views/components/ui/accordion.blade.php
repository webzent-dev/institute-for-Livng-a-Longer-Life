@props(['items'])

<div x-data="{ openItem: null }" class="space-y-4">
    @foreach ($items as $index => $item)
        <div class="border rounded-lg overflow-hidden">
            <button 
                @click="openItem === {{ $index }} ? openItem = null : openItem = {{ $index }}"
                class="w-full text-left p-4 font-semibold flex items-center justify-between"
            >
                {{ $item['q'] }}
                <span x-show="openItem !== {{ $index }}">+</span>
                <span x-show="openItem === {{ $index }}">−</span>
            </button>

            <div 
                x-show="openItem === {{ $index }}"
                x-collapse
                class="p-4 text-gray-600"
            >
                {{ $item['a'] }}
            </div>
        </div>
    @endforeach
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