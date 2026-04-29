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