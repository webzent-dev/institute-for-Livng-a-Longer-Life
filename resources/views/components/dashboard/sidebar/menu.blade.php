@php
    $role = auth()->user()->role;
@endphp

<x-dashboard.sidebar.nav_link icon="layout-dashboard" label="Dashboard" route="{{ $role === 'collaborator' ? 'collaborator.dashboard' : 'admin.dashboard' }}"/>
@if(in_array($role, ['admin','super_admin']))
    <x-dashboard.sidebar.nav_link icon="users" label="Users" route="admin.users.index" />
    <x-dashboard.sidebar.nav_link icon="user" label="Collaborators" route="collaborators.index" />
    <x-dashboard.sidebar.nav_link icon="package-search" label="Products" route="admin.products" />
    <x-dashboard.sidebar.nav_link icon="shopping-cart" label="Orders" route="admin.orders" />
    <x-dashboard.sidebar.nav_link icon="graduation-cap" label="Courses"  route="admin.courses" />
    <x-dashboard.sidebar.nav_link icon="user-plus" label="Memberships Plans"  route="admin.manage-membership" />
    <x-dashboard.sidebar.nav_link icon="settings" label="Settings" route="admin.settings.index"  />
    <x-dashboard.sidebar.nav_link icon="dollar-sign" label="Zoom Sessions" route="admin.zoom-sessions" />
    <x-dashboard.sidebar.nav_link icon="globe" label="Content Management" route="admin.content.management" />
    <x-dashboard.sidebar.nav_link icon="map-pin" label="Locations" route="admin.locations" />
    <x-dashboard.sidebar.nav_link icon="star" label="Testimonials" route="admin.testimonials" />
    <x-dashboard.sidebar.nav_link icon="star" label="Video Testimonials" route="admin.video-testimonials" />
    <x-dashboard.sidebar.nav_link icon="star" label="FAQ Categories" route="admin.faq-categories" />
    <x-dashboard.sidebar.nav_link icon="star" label="FAQs" route="admin.faqs" />
    <x-dashboard.sidebar.nav_link icon="star" label="Help Categories" route="admin.help-categories" />
    <x-dashboard.sidebar.nav_link icon="star" label="Help Articles" route="admin.help-articles" />
    <x-dashboard.sidebar.nav_link icon="star" label="Intro Videos" route="admin.intro-videos" />
    <x-dashboard.sidebar.nav_link icon="mail" label="Email Management" route="admin.email.index" />
    <x-dashboard.sidebar.nav_link icon="user" label="Subscribers" route="admin.subscribers" />
    <!-- <x-dashboard.sidebar.nav_link icon="file-text" label="Audit Logs" route="admin.audit.logs" /> -->
@endif

@if($role === 'collaborator')
    <x-dashboard.sidebar.nav_link icon="package-search" label="My Products" route="collaborator.products" />
    <x-dashboard.sidebar.nav_link icon="shopping-cart" label="Orders" route="collaborator.orders" />
    <x-dashboard.sidebar.nav_link icon="graduation-cap" label="My Courses" route="collaborator.courses" />
    <x-dashboard.sidebar.nav_link icon="user" label="Profile" route="profile.show" />
    <x-dashboard.sidebar.nav_link icon="briefcase" label="Business Details" route="collaborator.business-details" />
    <x-dashboard.sidebar.nav_link icon="credit-card" label="Bank Details" route="collaborator.bank-details" />
@endif
