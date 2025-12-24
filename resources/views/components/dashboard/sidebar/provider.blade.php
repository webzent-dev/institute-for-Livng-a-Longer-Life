<div
    x-data
    x-init="$store.sidebar.init()"
    class="group/sidebar-wrapper flex min-h-screen w-full bg-sidebar"
    style="--sidebar-width:16rem; --sidebar-width-icon:3rem"
>
    {{ $slot }}
</div>
