@props(['items' => []])

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
    @foreach($items as $stat)
        {{-- <div class="p-5 rounded-xl bg-white shadow text-center"> --}}
       <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100">     
            @if(isset($stat['icon']))   
                {{-- <div class="mt-2 text-primary"> --}}
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 rounded-xl {{ $stat['iconbg'] ?? 'bg-green-50'}} {{ $stat['icon_color'] ?? 'text-green-600' }}">
                            <i data-lucide="{{ $stat['icon'] }}" ></i>
                        </div>
                        <span class="text-sm {{ $stat['percent_change_bg'] ?? 'text-green-600' }} font-medium bg-green-50 px-2.5 py-1 rounded-full">{{ $stat['percent_change'] ?? '12.5' }}%</span>
                    </div>
            @endif
           
            <div class="text-2xl font-bold mt-1">{{ $stat['value'] }}</div>
             <div class="text-gray-500 text-sm">{{ $stat['label'] }}</div>
            
        </div>
    @endforeach
</div>




{{-- how to use --}}

{{-- <x-ui.stats :items="[
    ['label' => 'Users', 'value' => 1200, 'icon' => 'users', 'iconbg' => 'bg-blue-50', 'icon_color' => 'bg-blue-50 text-blue-600', 'percent_change' => '+8.5%', 'percent_change_bg' => 'bg-green-50 text-green-600'],
    ['label' => 'Sales', 'value' => '$24,000', 'icon' => 'credit-card'],
    ['label' => 'Orders', 'value' => 340],
    ['label' => 'Visits', 'value' => '45k'],
]" /> --}}


