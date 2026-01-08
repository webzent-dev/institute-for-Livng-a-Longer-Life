<x-dashboard.sidebar.nav_link
    icon="layout-dashboard"
    label="Dashboard"
    route="admin.dashboard"
/>
@php
    $role = auth()->user()->role;
@endphp
@if(in_array($role, ['admin','super_admin']))
    <x-dashboard.sidebar.nav_link icon="users" label="Users" />
    <x-dashboard.sidebar.nav_link icon="user" label="Collaborators"  />
    <x-dashboard.sidebar.nav_link icon="package-search" label="My Products"  />
    <x-dashboard.sidebar.nav_link icon="shopping-cart" label="Orders" />
    <x-dashboard.sidebar.nav_link icon="graduation-cap" label="My Courses" />
    <x-dashboard.sidebar.nav_link icon="settings" label="Settings"  />
    <x-dashboard.sidebar.nav_link icon="dollar-sign" label="Payments"  />
    <x-dashboard.sidebar.nav_link icon="users" label="Members" />
    <x-dashboard.sidebar.nav_link icon="file-text" label="Audit Logs"  />
@endif

@if($role === 'collaborator')
    <x-dashboard.sidebar.nav_link icon="package-search" label="My Products" route="products.index" />
    <x-dashboard.sidebar.nav_link icon="shopping-cart" label="Orders"  />
    <x-dashboard.sidebar.nav_link icon="graduation-cap" label="My Courses"  />
    <x-dashboard.sidebar.nav_link icon="user" label="Profile"  />
@endif
