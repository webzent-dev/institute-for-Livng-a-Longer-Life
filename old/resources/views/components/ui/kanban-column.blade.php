@props(['title'])

<div class="bg-white rounded-xl p-4 border border-gray-200 shadow-sm">
    <h3 class="font-semibold text-gray-800 mb-3">{{ $title }}</h3>

    <div data-kanban-column class="space-y-3">
        {{ $slot }}
    </div>
</div>



{{-- Usage Example --}}
{{-- <x-ui.kanban-column title="To Do">
    <div class="p-3 bg-white rounded shadow text-sm">Task 1</div>
    <div class="p-3 bg-white rounded shadow text-sm">Task 2</div>
    <div class="p-3 bg-white rounded shadow text-sm">Task 3</div>    
</x-ui.kanban-column> --}}

{{-- <x-ui.kanban-column title="In Progress">
    <div class="p-3 bg-white rounded shadow text-sm">Task A</div>
    <div class="p-3 bg-white rounded shadow text-sm">Task B</div>    
</x-ui.kanban-column> --}}

{{-- <x-ui.kanban-column title="Done">
    <div class="p-3 bg-white rounded shadow text-sm">Task X</div>
    <div class="p-3 bg-white rounded shadow text-sm">Task Y</div>    
</x-ui.kanban-column> --}}

