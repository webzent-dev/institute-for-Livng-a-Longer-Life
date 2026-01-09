@php
    $role = auth()->user()->role;
@endphp

<x-dashboard.sidebar.nav_link
    icon="layout-dashboard"
    label="Dashboard"
    route="{{ $role === 'collaborator' ? 'collaborator.dashboard' : 'admin.dashboard' }}"
/>
@if(in_array($role, ['admin','super_admin']))
    <x-dashboard.sidebar.nav_link icon="users" label="Users" route="users.index" />
    <x-dashboard.sidebar.nav_link icon="user" label="Collaborators" route="collaborators.index" />
    <x-dashboard.sidebar.nav_link icon="package-search" label="My Products" route="admin.approved.products" />
    <x-dashboard.sidebar.nav_link icon="shopping-cart" label="Orders" />
    <x-dashboard.sidebar.nav_link icon="graduation-cap" label="My Courses"  route="admin.courses" />
    <x-dashboard.sidebar.nav_link icon="settings" label="Settings"  />
    {{-- <x-dashboard.sidebar.nav_link icon="dollar-sign" label="Payments"  />
    <x-dashboard.sidebar.nav_link icon="users" label="Members" /> --}}
    <x-dashboard.sidebar.nav_link icon="file-text" label="Audit Logs"  />
@endif

@if($role === 'collaborator')
    <x-dashboard.sidebar.nav_link icon="package-search" label="My Products" route="products.index" />
    <x-dashboard.sidebar.nav_link icon="shopping-cart" label="Orders" />
    <x-dashboard.sidebar.nav_link icon="graduation-cap" label="My Courses" route="courses.index" />
    <x-dashboard.sidebar.nav_link icon="user" label="Profile" route="profile.show" />
@endif