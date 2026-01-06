{{-- <ul class="flex flex-col gap-1 p-2">
    {{ $slot }}
</ul> --}}



<nav class="flex-1 p-4 space-y-1  overflow-y-auto scrollbar-custom ">

    <x-dashboard.sidebar.nav_link icon="layout-dashboard" label="Dashboard" route="admin/dashboard/index" />

    {{-- @role('super_admin|admin') --}}
        <x-dashboard.sidebar.nav_link icon="users" label="Users" />
        <x-dashboard.sidebar.nav_link icon="user" label="Collaborators" />
        <x-dashboard.sidebar.nav_link icon="package-search" label="My Products"   />
        <x-dashboard.sidebar.nav_link icon="shopping-cart" label="Orders" />
        <x-dashboard.sidebar.nav_link icon="graduation-cap" label="My Courses" />
        <x-dashboard.sidebar.nav_link icon="settings" label="Settings" />
        <x-dashboard.sidebar.nav_link icon="dollar-sign" label="Payments" />
        <x-dashboard.sidebar.nav_link icon="users" label="Members" />
        <x-dashboard.sidebar.nav_link icon="file-text" label="Audit Logs" />


    {{-- @endrole --}} 

    {{-- @role('super_admin') --}}
        <x-dashboard.sidebar.nav_link icon="bar-chart-3" label="Analytics" />
        <x-dashboard.sidebar.nav_link icon="file-text" label="Reports"  />
    {{-- @endrole --}}

    {{-- @role('collaborator') --}}
       
       
    {{-- @endrole --}}

    {{-- @role('user') --}}
        <x-dashboard.sidebar.nav_link icon="graduation-cap" label="Enrolled Courses"   />
    {{-- @endrole --}}

</nav>
