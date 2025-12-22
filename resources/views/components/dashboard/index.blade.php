@extends('front.dashboard.dashboard')

@section('content')

<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

    {{-- SUPER ADMIN --}}
    {{-- @role('super_admin') --}}
        <x-stat title="Revenue" :value="$stats['revenue']" />
        <x-stat title="Orders" :value="$stats['orders']" />
        <x-stat title="Sales" :value="$stats['sales']" />
        <x-stat title="Products" :value="$stats['products']" />
        <x-stat title="Categories" :value="$stats['categories']" />
        <x-stat title="Subcategories" :value="$stats['subcategories']" />
        <x-stat title="Brands" :value="$stats['brands']" />
        <x-stat title="Tags" :value="$stats['tags']" />
        <x-stat title="Users" :value="$stats['users']" />
        <x-stat title="Collaborators" :value="$stats['collaborators']" />
        <x-stat title="Admins" :value="$stats['admins']" />
        <x-stat title="Subscribers" :value="$stats['subscribers']" />
        <x-stat title="Subscribers" :value="$stats['subscribers']" />
        <x-stat title="Subscribers" :value="$stats['subscribers']" />
        
        <x-stat title="Conversion Rate" :value="$stats['conversion']" />
    {{-- @endrole --}}

    {{-- ADMIN --}}
    {{-- @role('admin') --}}
        <x-stat title="Users" :value="$stats['users']" />
        <x-stat title="Collaborators" :value="$stats['collaborators']" />
    {{-- @endrole --}}

    {{-- COLLABORATOR --}}
    {{-- @role('collaborator') --}}
        <x-stat title="My Sales" :value="$stats['sales']" />
        <x-stat title="My Courses" :value="$stats['courses']" />
    {{-- @endrole --}}  

    {{-- USER --}}
    {{-- @role('user')    --}}
        <x-stat title="My Sales" :value="$stats['sales']" />
        <x-stat title="Enrolled Courses" :value="$stats['courses']" />
    {{-- @endrole --}}

</div>

@endsection
{{-- @include('components.dashboard.sidebar.menu')    --}}