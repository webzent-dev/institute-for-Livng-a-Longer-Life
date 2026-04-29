@props(['events' => []])

<div x-data="{ selected: null }" class="p-6 bg-white rounded-xl shadow">
    <h2 class="font-semibold mb-3">Upcoming Events</h2>

    <ul class="space-y-3">
        @foreach ($events as $event)
            <li class="p-3 border rounded cursor-pointer hover:bg-gray-50"
                @click="selected = {{ json_encode($event) }}"
            >
                <div class="font-semibold">{{ $event['title'] }}</div>
                <div class="text-gray-500 text-sm">{{ $event['date'] }}</div>
            </li>
        @endforeach
    </ul>

    <div 
        x-show="selected" 
        class="mt-4 p-4 border rounded bg-gray-50"
    >
        <h3 class="font-semibold" x-text="selected.title"></h3>
        <p class="text-gray-600" x-text="selected.details"></p>
    </div>
</div>
{{-- Usage Example --}}

{{-- <x-ui.calendar-events :events="[
    ['title' => 'Meeting', 'date' => '2025-01-21', 'details' => 'Zoom call at 10 AM'],
    ['title' => 'Workshop', 'date' => '2025-01-24', 'details' => 'Laravel training'],
]" /> --}}

{{-- <x-ui.calendar-events :events="[
    ['title' => 'Health Seminar', 'date' => '2024-07-15', 'details' => 'Join us for a seminar on healthy living.'],
    ['title' => 'Wellness Workshop', 'date' => '2024-08-10', 'details' => 'A workshop focused on mental and physical wellness.'],
]" /> --}}  