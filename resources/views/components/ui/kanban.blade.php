@props(['columns' => []])

<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    @foreach($columns as $col)
        <div class="bg-gray-50 p-4 rounded-xl border">
            <h3 class="font-semibold mb-3">{{ $col['title'] }}</h3>

            <div class="space-y-3">
                @foreach($col['tasks'] as $task)
                    <div class="p-3 bg-white rounded shadow text-sm">
                        {{ $task }}
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</div>

{{-- or --}}

{{-- <div x-data x-init="
    const columns = document.querySelectorAll('[data-kanban-column]');
    columns.forEach(col => new Sortable(col, { group: 'kanban', animation: 150 }));
">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

        {{ $slot }}

    </div>
</div> --}}





{{-- Usage Example --}}
{{-- <x-ui.kanban :columns="[
    ['title' => 'To Do', 'tasks' => ['Task A', 'Task B']],
    ['title' => 'In Progress', 'tasks' => ['Task C']],
    ['title' => 'Done', 'tasks' => ['Task D', 'Task E']],
]" /> --}}

{{-- or --}}

{{-- <x-ui.kanban :columns="[
    [
        'title' => 'To Do',
        'tasks' => ['Task 1', 'Task 2', 'Task 3']
    ],
    [
        'title' => 'In Progress',
        'tasks' => ['Task 4', 'Task 5']
    ],
    [
        'title' => 'Done',
        'tasks' => ['Task 6']
    ]
]" />   --}}    



