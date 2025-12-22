
@props(['bg', 'textColor', 'change', 'changeClass', 'changeBg', 'icon', 'label', 'value'  ])

<div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100">
    <div class="flex items-center justify-between mb-4">
        <div class="p-3 rounded-xl {{ $bg }} {{ $textColor }}">
            <i data-lucide="{{ $icon }}" class="w-6 h-6"></i>
        </div>
        <span class="{{ $changeClass }} text-sm font-medium bg-{{ $changeBg }} px-2.5 py-1 rounded-full">{{ $change }}</span>
    </div>
    <h3 class="text-2xl font-semibold text-slate-800 mb-1">{{ $value }}</h3>
    <p class="text-slate-500 text-sm">{{ $label }}</p>
</div>




{{-- @props(['title', 'value', 'note'])

<div class="bg-white border rounded-xl p-6">
    <div class="text-sm text-muted mb-1">{{ $title }}</div>
    <div class="text-2xl font-bold">{{ $value }}</div>
    <div class="text-xs text-green-600 mt-2">
        ↑ {{ $note }}
    </div>
</div> --}}





{{-- @props(['items' => []])

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
</div> --}}






{{-- how to use --}}

{{-- <x-ui.stats :items="[
    ['label' => 'Users', 'value' => 1200, 'icon' => 'users'],
    ['label' => 'Sales', 'value' => '$24,000', 'icon' => 'credit-card'],
    ['label' => 'Orders', 'value' => 340],
    ['label' => 'Visits', 'value' => '45k'],
]" /> --}}


