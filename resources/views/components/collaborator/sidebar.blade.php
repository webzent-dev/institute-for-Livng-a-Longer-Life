<x-sidebar.sidebar>
    <x-sidebar.menu>
        <x-sidebar.menu-item :active="request()->routeIs('collaborator.dashboard')" href="{{ route('collaborator.dashboard') }}">
            Dashboard
        </x-sidebar.menu-item>

        <x-sidebar.menu-item :active="request()->routeIs('collaborator.products')" href="{{ route('collaborator.products') }}">
            Products
        </x-sidebar.menu-item>

        <x-sidebar.menu-item :active="request()->routeIs('collaborator.orders')" href="{{ route('collaborator.orders') }}">
            Orders
        </x-sidebar.menu-item>

        <x-sidebar.menu-item :active="request()->routeIs('collaborator.courses')" href="{{ route('collaborator.courses') }}">
            Courses
        </x-sidebar.menu-item>

        <x-sidebar.menu-item :active="request()->routeIs('collaborator.profile')" href="{{ route('collaborator.profile') }}">
            Profile
        </x-sidebar.menu-item>
    </x-sidebar.menu>
</x-sidebar.sidebar>
