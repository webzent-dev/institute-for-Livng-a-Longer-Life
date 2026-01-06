@props(['active' => false])

<li class="relative group">
    <button
        class="
            flex items-center gap-2 w-full rounded-md px-2 h-8 text-sm
            hover:bg-sidebar-accent
            {{ $active ? 'bg-sidebar-accent font-medium' : '' }}
        "
    >
        {{ $slot }}
    </button>
</li>
