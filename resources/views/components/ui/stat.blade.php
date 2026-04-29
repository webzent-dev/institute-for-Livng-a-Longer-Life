
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
  