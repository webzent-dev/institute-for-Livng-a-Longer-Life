@props([
    'icon' => null,
    'label',
    'route' => null,
])

{{-- <a href="{{ $route ? route($route) : '#' }}"
   class="flex items-center px-4 py-2 rounded-lg hover:bg-gray-100
   {{ $route && request()->routeIs($route) ? 'bg-gray-200 font-semibold' : '' }}"> --}}

   <a href="{{ $route && Route::has($route) ? route($route) : '#' }}"
   class="flex items-center px-4 py-2 rounded-lg 
   {{ $route && Route::has($route) && request()->routeIs($route)
        ? 'bg-primary text-white font-semibold'
        : 'hover:bg-gray-100' }}">

    
    {{-- ICON --}}
    <span class="mr-3 text-gray-500">
        @if($icon)
           
            <i data-lucide="{{ $icon }}" class="w-5 h-5  {{ $route && Route::has($route) && request()->routeIs($route)
        ? 'bg-primary text-white font-semibold hover:bg-primary hover:text-white'
        : '' }}"></i>
       
        @endif
    </span>
    <span>{{ $label }}</span>
</a>
