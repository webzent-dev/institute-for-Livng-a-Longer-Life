@extends('layouts.collaborator')

@section('content')
<div class="space-y-6" x-data="{ open:false, userId:'', role:'' }">

<div class="flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-bold">Users Management</h1>
        <p class="text-gray-500">Manage user roles and permissions</p>
    </div>

    <button @click="open=true"
        class="px-4 py-2 bg-green-600 text-white rounded-lg flex items-center gap-2">
        Assign Role
    </button>
</div>

{{-- TABLE --}}
<x-table>
    <x-slot:head>
        <tr>
            <x-table.head>User ID</x-table.head>
            <x-table.head>Role</x-table.head>
            <x-table.head>Created</x-table.head>
            <x-table.head>Action</x-table.head>
        </tr>
    </x-slot>

    @foreach($users as $user)
    <x-table.row>
        <x-table.cell class="font-mono text-xs">{{ $user['user_id'] }}</x-table.cell>
        <x-table.cell>
            <x-badge :role="$user['role']"/>
        </x-table.cell>
        <x-table.cell>{{ $user['created_at']->format('d M Y') }}</x-table.cell>
        <x-table.cell>
            <a href="#" class="border px-3 py-1 rounded text-sm">View</a>
        </x-table.cell>
    </x-table.row>
    @endforeach
</x-table>

{{-- MODAL --}}
<x-modal>
    <form method="POST" action="#">
        @csrf

        <x-select label="User">
            @foreach($users as $u)
                <option value="{{ $u['id'] }}">{{ $u['user_id'] }}</option>
            @endforeach
        </x-select>

        <x-select label="Role">
            <option value="admin">Admin</option>
            <option value="moderator">Moderator</option>
            <option value="collaborator">Collaborator</option>
            <option value="user">User</option>
        </x-select>

        <button class="w-full bg-green-600 text-white py-2 rounded">
            Update Role
        </button>
    </form>
</x-modal>

</div>
@endsection
