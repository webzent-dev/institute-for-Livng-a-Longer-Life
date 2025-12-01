@props(['items' => []])

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
    @foreach($items as $stat)
        <div class="p-5 rounded-xl bg-white shadow text-center">
            <div class="text-gray-500 text-sm">{{ $stat['label'] }}</div>
            <div class="text-2xl font-bold mt-1">{{ $stat['value'] }}</div>
            @if(isset($stat['icon']))
                <div class="mt-2 text-primary">
                    <i data-lucide="{{ $stat['icon'] }}"></i>
                </div>
            @endif
        </div>
    @endforeach
</div>


{{-- how to use --}}

{{-- <x-ui.stats :items="[
    ['label' => 'Users', 'value' => 1200, 'icon' => 'users'],
    ['label' => 'Sales', 'value' => '$24,000', 'icon' => 'credit-card'],
    ['label' => 'Orders', 'value' => 340],
    ['label' => 'Visits', 'value' => '45k'],
]" /> --}}


