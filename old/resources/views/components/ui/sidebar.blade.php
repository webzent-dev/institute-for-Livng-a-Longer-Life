<aside class="w-64 bg-white dark:bg-gray-800 shadow-lg h-screen sticky top-0 flex flex-col" x-bind:class="{ 'hidden': sidebar.collapsed }">
    <div class="p-4 font-bold text-xl">
        Dashboard 
    </div>
    <nav class="flex-1 space-y-1 px-4">
        <a href="{{url('/dashboard')}}" class="block p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
            <i data-lucide="layout-dashboard"></i>
            <span>Overview</span>
        </a>
        <a href="{{url('/dashboard/users')}}" class="block p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
            <i data-lucide="users"></i>
            <span>Users</span>
        </a>
        <a href="{{url('/dashboard/analytics')}}" class="block p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
            <i data-lucide="bar-chart"></i>
            <span>Analytics</span>
        </a>
        <a href="{{url('/dashboard/projects')}}" class="block p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
            <i data-lucide="kanban-square"></i>
            <span>Kanban</span>
        </a>
    </nav>
</aside>