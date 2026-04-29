@props([
    'icon' => null,
    'label',
    'route' => null,
])

@php
    $isActive = false;

    if ($route && Route::has($route)) {
        $patterns = [$route, $route . '.*'];

        // If route is an index route, match the whole section (e.g. admin.users.*).
        if (\Illuminate\Support\Str::endsWith($route, '.index')) {
            $patterns[] = \Illuminate\Support\Str::beforeLast($route, '.index') . '.*';
        }

        $isActive = request()->routeIs(...array_unique($patterns));

        // Fallback by concrete URL path so section remains active on detail/inner pages
        // even if route naming is inconsistent (e.g. users.show vs admin.users.index).
        if (!$isActive) {
            $resolvedPath = parse_url(route($route, [], false), PHP_URL_PATH) ?? '';
            $resolvedPath = trim($resolvedPath, '/');

            if ($resolvedPath !== '') {
                $isActive = request()->is($resolvedPath) || request()->is($resolvedPath . '/*');
            }
        }
    }
@endphp

   <a href="{{ $route && Route::has($route) ? route($route) : '#' }}"
   class="flex items-center px-4 py-2 rounded-lg
   {{ $isActive
        ? 'bg-gray-100 text-gray-800 font-semibold'
        : 'hover:bg-gray-100' }}">


    {{-- ICON --}}
    <span class="mr-3 text-gray-500">
        @if($icon)

            <i data-lucide="{{ $icon }}" class="w-5 h-5  {{ $isActive
       ? 'text-gray-800  font-semibold  hover:text-white'
        : '' }}"></i>

        @endif
    </span>
    <span>{{ $label }}</span>
</a>
