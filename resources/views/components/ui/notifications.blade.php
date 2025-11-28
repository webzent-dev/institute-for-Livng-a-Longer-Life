<div x-data="{ open: false }" class="relative">
    <button @click="open = !open" class="relative">
        <i data-lucide="bell" class="w-6 h-6"></i>
        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full px-1">
            {{ $count ?? 0 }}
        </span>
    </button>

    <div 
        x-show="open"
        x-transition
        class="absolute right-0 mt-3 w-80 bg-white shadow-xl rounded-xl p-4 z-50 border"
    >
        <h3 class="font-semibold mb-2">Notifications</h3>

        <div class="space-y-3 max-h-72 overflow-y-auto">
            {{ $slot }}
        </div>
    </div>
</div>
{{-- or --}}
{{-- <div 
    x-show="notifications.open"
    class="absolute right-6 top-20 w-80 bg-white dark:bg-gray-800 shadow-xl rounded-xl p-4 space-y-3 z-50"
>

    <template x-for="note in notifications.items">
        <div class="p-3 border-b dark:border-gray-700">
            <p class="font-semibold" x-text="note.title"></p>
            <p class="text-sm text-gray-600 dark:text-gray-300" x-text="note.message"></p>
        </div>
    </template>

    <button 
        class="mt-2 w-full py-2 bg-gray-100 dark:bg-gray-700 rounded-lg"
        @click="notifications.clear()"
    >
        Clear All
    </button>

</div> --}}







{{-- how to use --}}

{{-- <x-ui.notifications :count="3">
    <div class="p-3 bg-gray-50 rounded">
        New user registered!
    </div>
    <div class="p-3 bg-gray-50 rounded">
        Payment received.
    </div>
    <div class="p-3 bg-gray-50 rounded">
        System update completed.
    </div>
</x-ui.notifications> --}}


{{-- <x-ui.notifications :count="3">
    <div class="p-2 bg-gray-100 rounded">
        <p class="text-sm">New comment on your post.</p>
        <span class="text-xs text-gray-500">2 mins ago</span>
    </div>
    <div class="p-2 bg-gray-100 rounded">
        <p class="text-sm">Your profile was updated.</p>
        <span class="text-xs text-gray-500">1 hour ago</span>
    </div>
    <div class="p-2 bg-gray-100 rounded">
        <p class="text-sm">New follower: Jane Doe.</p>
        <span class="text-xs text-gray-500">3 hours ago</span>
    </div>
</x-ui.notifications> --}}      




