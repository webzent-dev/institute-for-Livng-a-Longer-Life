@props(['title' => 'Metric', 'value' => '0', 'icon' => 'bar-chart'])

<div class="bg-white rounded-xl p-5 shadow-sm border border-gray-200 flex items-center gap-4">

    <div class="p-3 bg-gray-100 rounded-lg">
        <i data-lucide="{{ $icon }}" class="w-6 h-6 text-gray-600"></i>
    </div>

    <div>
        <p class="text-sm text-gray-500">{{ $title }}</p>
        <p class="text-xl font-semibold text-gray-900">{{ $value }}</p>
    </div>

</div>
{{-- how to use --}}
{{-- <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <x-dashboard.stat-card title="Users" value="1,204" icon="users" />
    <x-dashboard.stat-card title="Sales" value="$14,200" icon="shopping-cart" />
    <x-dashboard.stat-card title="Bounce Rate" value="32%" icon="arrow-down" />
</div> --}}


{{-- <x-dashboard.stat-card 
    title="Total Users" 
    value="1,234" 
    icon="users"    
/> --}}