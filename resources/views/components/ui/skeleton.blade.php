@props(['lines' => 3])

<div class="animate-pulse space-y-2">
    @for ($i = 0; $i < $lines; $i++)
        <div class="h-3 bg-gray-300 rounded"></div>
    @endfor
</div>


{{-- Usage Example --}}
{{-- <x-ui.skeleton lines="5" /> --}}

{{-- <x-ui.skeleton :lines="5" /> --}}  