<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="base-url" content="{{ url('/admin') }}">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Users Management | Institute for Living Longer - Your Journey to Wellness')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/alpinejs" defer></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="{{asset('css/toastr.min.css')}}" />
    <script src="{{asset('js/toastr.min.js')}}"></script>
</head>
@if (session('success'))
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition class="fixed top-5 right-5 bg-green-600 text-white px-5 py-3 rounded-lg shadow-lg z-50">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition class="fixed top-5 right-5 bg-red-600 text-white px-5 py-3 rounded-lg shadow-lg z-50">
        {{ session('error') }}
    </div>
@endif
<div id="toast" class="hidden fixed top-5 right-5 px-5 py-3 rounded-lg shadow-lg text-white z-50"></div>
<body  x-data="{  sidebarOpen: true,  mobileSidebar: false  }"  class="bg-slate-50 antialiased">
    <div class="flex min-h-screen">
        <x-dashboard.sidebar.sidebar />
        <div class="flex-1 flex flex-col">
            <x-dashboard.sidebar.header />
            <main class="flex-1 p-8 bg-gradient-subtle">
                <div class="space-y-6">
                    <!-- Header -->
                    <div class="flex justify-between items-center ">
                        <div class="">
                            <h1 class="text-3xl font-bold text-left">Users Management</h1>
                            <p class="text-muted-foreground text-lg">
                                Manage all users, collaborators, and administrators
                            </p>
                        </div>
                        <div class="right-3">
                            <x-button-use label="Add User" variant="primary" icon="user-plus" @click="$dispatch('open-modal', 'add-user-modal')" />
                        </div>
                    </div>

                    <!-- Add User Modal Start Here -->
                    <x-ui.modal name="add-user-modal">
                        <h2 class="text-lg font-semibold leading-none tracking-tight mb-2 text-left">Add New User</h2>
                        <form id="addUserForm" method="POST" class="space-y-3">
                            @csrf
                            <x-form.input label="First Name" type="text" name="first_name" id="first_name" autocomplete="off" placeholder="Enter first name*" required  />
                            <x-form.input label="Last Name" type="text" name="last_name" id="last_name" autocomplete="off" placeholder="Enter last name*" required  />
                            <x-form.input label="Email" type="email" id="email" name="email" autocomplete="off" placeholder="Enter email*" required />
                            <x-form.select label="Role" name="role" placeholder="Select Role*" required
                                :selected="[old('role', 'admin')]"
                                :options="$currentUserRole === 'admin' ? [
                                    ['label' => 'Admin','value' => 'admin', 'selected' => true]
                                ] : [
                                    ['label' => 'Member','value' => 'user'],
                                    ['label' => 'Collaborator','value' => 'collaborator'],
                                    ['label' => 'Admin','value' => 'admin', 'selected' => true]
                                ]"/>
                            <x-form.select label="Status" name="status" placeholder="Select Status*" required
                                :selected="[old('status', 'active')]"
                                :options="[
                                    ['label' => 'Active','value' => 'active'],
                                    ['label' => 'Inactive','value' => 'inactive']
                                ]"/>
                            <x-button-use label="Add User" variant="primary" type="submit" class="w-full"/>
                            <x-button-use label="Cancel" variant="outline" type="button" class="w-full" @click="$dispatch('close-modal', 'add-user-modal')" />
                        </form>
                    </x-ui.modal>
                    <!-- Add User Modal End Here -->

                    <!-- Edit User Modal Start Here -->
                    <!-- <x-ui.modal id="edit-user-modal" name="edit-user-modal" >
                        <h2 class="text-lg font-semibold leading-none tracking-tight mb-2 text-left">Edit User</h2>
                        <form id="editUserForm" method="POST" action="{{ route('admin.users.update') }}" class="space-y-3">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="user_id" id="editUserId">

                            <x-form.input label="First Name" type="text" name="first_name" id="editFirstName" autocomplete="off" placeholder="Enter first name*" required  />
                            <x-form.input label="Last Name" type="text" name="last_name" id="editLastName" autocomplete="off" placeholder="Enter last name*" required  />
                            <!-- <x-form.input label="Email" type="email" id="email" name="email" autocomplete="off" placeholder="Enter email*" required /> -->
                            <!-- <x-form.select label="Role" name="role" placeholder="Select Role*" required
                                :selected="[old('role', 'user')]"
                                :options="[
                                    ['label' => 'Member','value' => 'user'],
                                    ['label' => 'Collaborator','value' => 'collaborator'],
                                    ['label' => 'Admin','value' => 'admin', 'selected' => true]
                                ]"/> -->
                            <!-- <x-form.select label="Status" name="status" id="editStatus" placeholder="Select Status*" required
                                :selected="[old('status', 'active')]"
                                :options="[
                                    ['label' => 'Active','value' => 'active'],
                                    ['label' => 'Inactive','value' => 'inactive']
                                ]"/>
                            <x-button-use label="Save Changes" variant="primary" type="submit" class="w-full"/>
                            <x-button-use label="Cancel" variant="outline" type="button" class="w-full" @click="$dispatch('close-modal', 'edit-user-modal')" />
                        </form>
                    </x-ui.modal> -->

                    <div id="editUserModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 flex">
                        <div class="bg-white w-full max-w-3xl rounded-xl shadow-lg sticky top-20">
                            <button type="button" onclick="closeEditModal()" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-xl">&times;</button>
                            <div class="p-6 border-b">
                                <h2 class="text-lg font-semibold leading-none tracking-tight text-left">Edit User</h2>
                            </div>
                            <!-- Modal Body -->
                            <form method="POST" action="{{ route('admin.users.update') }}" class="space-y-4 overflow-y-auto scrollbar-custom max-h-[60vh] scroll-smooth px-6 py-4">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="user_id" id="editUserId">

                                <div class="space-y-2">
                                    <label for="editFirstName" class="text-sm font-medium">First Name <span class="text-red-500">*</span></label>
                                    <input type="text" name="first_name" id="editFirstName" placeholder="Enter First Name*" class="flex h-10 w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary" autocomplete="off" required>
                                </div>

                                <div class="space-y-2">
                                    <label for="editLastName" class="text-sm font-medium">Last Name <span class="text-red-500">*</span></label>
                                    <input type="text" name="last_name" id="editLastName" placeholder="Enter Last Name*" class="flex h-10 w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary" autocomplete="off" required>
                                </div>

                                <div class="space-y-2">
                                    <label class="text-sm font-medium">Status <span class="text-red-500">*</span></label>
                                    <select name="status" id="editStatus" class="w-full h-11 rounded-lg border border-gray-300 px-3 text-sm focus:ring-2 focus:ring-primary focus:outline-none" required>
                                        <option value="">Select Status</option>
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                </div>

                                <!-- Submit Button -->
                                <button type="submit" class="w-full bg-primary text-white py-2.5 rounded-lg font-medium hover:bg-accent transition flex items-center justify-center gap-2">
                                    <!-- Link Icon -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"  fill="none"  viewBox="0 0 24 24"  stroke="currentColor">
                                        <path stroke-linecap="round"  stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 010 5.656l-2 2a4 4 0 01-5.656-5.656l1.414-1.414M10.172 13.828a4 4 0 010-5.656l2-2a4 4 0 115.656 5.656l-1.414 1.414"/>
                                    </svg>
                                    Save Changes
                                </button>
                                <button type="button" onclick="closeEditModal()" class="w-full bg-gray-200 text-gray-800 py-2.5 rounded-lg font-medium hover:bg-gray-300 transition flex items-center justify-center gap-2">Cancel</button>
                            </form>
                        </div>
                    </div>
                    <!-- Edit User Modal End Here -->

                    <!-- Tabs -->
                    <div data-orientation="horizontal">
                       <div role="tablist" class="grid h-10 w-full grid-cols-3 rounded-md bg-muted p-1 text-muted-foreground">
                            <button role="tab" aria-selected="true" data-tab="members" class="rounded-sm bg-background px-3 py-1.5 text-sm font-medium shadow-sm">
                                Members ({{$members->total()}})
                            </button>
                            <button role="tab" aria-selected="false" data-tab="collaborators" class="rounded-sm px-3 py-1.5 text-sm font-medium">
                                Collaborators ({{$collaborators->total()}})
                            </button>
                            <button role="tab" aria-selected="false" data-tab="admins" class="rounded-sm px-3 py-1.5 text-sm font-medium">
                                Administrators ({{$admins->total()}})
                            </button>
                        </div>

                        <!-- Members tab content start -->
                        <div id="members" class="tab-content mt-2">
                            <div class="rounded-lg border bg-card shadow-sm">
                                <div class="flex justify-between items-center p-6">
                                    <div>
                                        <h3 class="text-2xl font-semibold">Members</h3>
                                    </div>
                                    <div class="w-[220px]">
                                        <input id="search_members" type="text" name="search_members" placeholder="Search members..." onkeyup="searchMembers()" class="flex h-10 w-full rounded-md
                                        border border-input
                                        bg-background
                                        px-3 py-2
                                        text-[14px]
                                        placeholder:text-[14px]
                                        ring-offset-background
                                        focus-visible:outline-none
                                        focus-visible:ring-2
                                        focus-visible:ring-ring
                                        focus-visible:ring-offset-2
                                        disabled:cursor-not-allowed
                                        disabled:opacity-50">
                                    </div>
                                </div>

                                <div class="p-6 pt-0 overflow-auto">
                                    <table class="w-full text-sm">
                                        <thead>
                                            <tr class="border-b text-muted-foreground">
                                                <th class="px-4 py-3 text-left">Name</th>
                                                <th class="px-4 py-3 text-left">Email</th>
                                                <th class="px-4 py-3 text-left">Status</th>
                                                <th class="px-4 py-3 text-left">Created At</th>
                                                <th class="px-4 py-3 text-left">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse( $members as $key => $member)
                                            <tr class="border-b hover:bg-muted/50">
                                                <td class="px-4 py-3 font-medium">{{$member->first_name . ' ' . $member->last_name ?? 'N/A' }}</td>
                                                <td class="px-4 py-3">{{$member->email}}</td>
                                                <td class="px-4 py-3">
                                                    <span id="user_status_{{$member->id}}" class="rounded-full self-center px-3 py-1 text-xs font-semibold text-primary-foreground {{ $member->status === 'active' ? 'bg-primary text-green-700' : 'bg-red-100 text-red-700' }}" data-status="{{ $member->status }}" data-url="{{ route('admin.users.changestatus', $member->id) }}" onclick="changeStatus('{{$member->id}}','user')">
                                                        {{ucfirst($member->status)}}
                                                    </span>
                                                </td>
                                                <td class="px-4 py-3">{{$member->created_at}}</td>
                                                <td class="justify-items-center">
                                                    <div class="flex gap-2">
                                                        <a href="{{ route('admin.members.show', $member->id) }}" title="View full member profile" class="h-9 flex items-center rounded-md px-3 hover:bg-accent">
                                                            <i data-lucide="eye" class="w-4 h-4"></i>
                                                        </a>
                                                        <button class="h-9 rounded-md px-3 hover:bg-accent text-destructive" onclick="openEditModal({{ $member->id }}, '{{ $member->first_name }}', '{{ $member->last_name }}', '{{ $member->status }}', 'members')">
                                                            <i data-lucide="pencil" class="w-4 h-4"></i>
                                                        </button>
                                                        <button class="h-9 rounded-md px-3 hover:bg-accent text-destructive" onclick="deleteFromList('{{$member->id}}','user')">
                                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                        </button>
                                                        <form id="user_delete_form_{{$member->id}}" action="{{url('admin/users/'.$member->id)}}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center py-4 text-muted-foreground">
                                                        No members found
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                    <!-- PAGINATION UI -->
                                    @if($members->hasPages())
                                        <div class="px-6 py-4 border-t border-gray-100">
                                            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                                                <div class="text-sm text-gray-500">
                                                    Showing <span class="font-semibold text-gray-700">{{ $members->firstItem() }}</span> 
                                                    to <span class="font-semibold text-gray-700">{{ $members->lastItem() }}</span> 
                                                    of <span class="font-semibold text-gray-700">{{ $members->total() }}</span> members
                                                </div>
                                                <div class="custom-pagination">
                                                    {{ $members->links('pagination::tailwind') }}
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- Members tab content end -->

                        <!-- Collaborators tab content start -->
                        <div id="collaborators" class="tab-content mt-2 hidden">
                            <div class="rounded-lg border bg-card shadow-sm">
                                <div class="flex justify-between items-center p-6">
                                    <div>
                                        <h3 class="text-2xl font-semibold">Collaborators</h3>
                                    </div>
                                    <div class="w-[220px]">
                                        <input id="search_collaborators" type="text" name="search_collaborators" placeholder="Search collaborators..." onkeyup="searchCollaborators()" class="flex h-10 w-full rounded-md
                                        border border-input
                                        bg-background
                                        px-3 py-2
                                        text-[14px]
                                        placeholder:text-[14px]
                                        ring-offset-background
                                        focus-visible:outline-none
                                        focus-visible:ring-2
                                        focus-visible:ring-ring
                                        focus-visible:ring-offset-2
                                        disabled:cursor-not-allowed
                                        disabled:opacity-50">
                                    </div>
                                </div>
                                <div class="p-6 pt-0 overflow-auto">
                                    <table class="w-full text-sm">
                                        <thead>
                                            <tr class="border-b text-muted-foreground">
                                                <th class="px-4 py-3 text-left">Name</th>
                                                <th class="px-4 py-3 text-left">Email</th>
                                                <th class="px-4 py-3 text-left">Status</th>
                                                <th class="px-4 py-3 text-left">Created At</th>
                                                <th class="px-4 py-3 text-left">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse( $collaborators as $key => $collaborator)
                                            <tr class="border-b hover:bg-muted/50">
                                                <td class="px-4 py-3 font-medium">{{$collaborator->first_name . ' ' . $collaborator->last_name ?? 'N/A' }}</td>
                                                <td class="px-4 py-3">{{$collaborator->email}}</td>
                                                <td class="px-4 py-3">
                                                    <span id="user_status_{{$collaborator->id}}" class="rounded-full self-center px-3 py-1 text-xs font-semibold text-primary-foreground {{ $collaborator->status === 'active' ? 'bg-primary text-green-700' : 'bg-red-100 text-red-700' }}" data-status="{{ $collaborator->status }}" data-url="{{ route('admin.users.changestatus', $collaborator->id) }}" onclick="changeStatus('{{$collaborator->id}}','user')">
                                                        {{ucfirst($collaborator->status)}}
                                                    </span>
                                                </td>
                                                <td class="px-4 py-3">{{$collaborator->created_at}}</td>
                                                <td class="px-4 py-3">
                                                    <div class="flex gap-2">
                                                        <a href="{{ route('collaborators.show', $collaborator->id) }}" title="View full collaborator profile" class="h-9 flex items-center rounded-md px-3 hover:bg-accent">
                                                            <i data-lucide="eye" class="w-4 h-4"></i>
                                                        </a>
                                                        <button class="h-9 rounded-md px-3 hover:bg-accent text-destructive" onclick="openEditModal({{ $collaborator->id }}, '{{ $collaborator->first_name }}', '{{ $collaborator->last_name }}', '{{ $collaborator->status }}', 'collaborators')">
                                                            <i data-lucide="pencil" class="w-4 h-4"></i>
                                                        </button>
                                                        <button class="h-9 rounded-md px-3 hover:bg-accent text-destructive" onclick="deleteFromList('{{$collaborator->id}}','user')">
                                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                        </button>
                                                        <form id="user_delete_form_{{$collaborator->id}}" action="{{url('admin/users/'.$collaborator->id)}}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center py-4 text-muted-foreground">
                                                        No collaborators found
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                    <!-- PAGINATION UI -->
                                    @if($collaborators->hasPages())
                                        <div class="px-6 py-4 border-t border-gray-100">
                                            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                                                <div class="text-sm text-gray-500">
                                                    Showing <span class="font-semibold text-gray-700">{{ $collaborators->firstItem() }}</span> 
                                                    to <span class="font-semibold text-gray-700">{{ $collaborators->lastItem() }}</span> 
                                                    of <span class="font-semibold text-gray-700">{{ $collaborators->total() }}</span> collaborators
                                                </div>
                                                <div class="custom-pagination">
                                                    {{ $collaborators->links('pagination::tailwind') }}
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- Collaborators tab content end -->

                        <!-- Admins tab content start -->
                        <div id="admins" class="tab-content mt-2 hidden">
                            <div class="rounded-lg border bg-card shadow-sm">
                                <div class="flex justify-between items-center p-6">
                                    <div>
                                        <h3 class="text-2xl font-semibold">Admins</h3>
                                    </div>
                                    <div class="w-[220px]">
                                        <input id="search_admins" type="text" name="search_admins" placeholder="Search admins..." onkeyup="searchAdmins()" class="flex h-10 w-full rounded-md
                                        border border-input
                                        bg-background
                                        px-3 py-2
                                        text-[14px]
                                        placeholder:text-[14px]
                                        ring-offset-background
                                        focus-visible:outline-none
                                        focus-visible:ring-2
                                        focus-visible:ring-ring
                                        focus-visible:ring-offset-2
                                        disabled:cursor-not-allowed
                                        disabled:opacity-50">
                                    </div>
                                </div>
                                <div class="p-6 pt-0 overflow-auto">
                                    <table class="w-full text-sm">
                                        <thead>
                                            <tr class="border-b text-muted-foreground">
                                                <th class="px-4 py-3 text-left">Name</th>
                                                <th class="px-4 py-3 text-left">Email</th>
                                                <th class="px-4 py-3 text-left">Status</th>
                                                <th class="px-4 py-3 text-left">Created At</th>
                                                <th class="px-4 py-3 text-left">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse( $admins as $key => $admin)
                                            <tr class="border-b hover:bg-muted/50">
                                                <td class="px-4 py-3 font-medium">{{$admin->first_name . ' ' . $admin->last_name ?? 'N/A' }}</td>
                                                <td class="px-4 py-3">{{$admin->email}}</td>
                                                <td class="px-4 py-3">
                                                    <span id="user_status_{{$admin->id}}" class="rounded-full self-center px-3 py-1 text-xs font-semibold text-primary-foreground {{ $admin->status === 'active' ? 'bg-primary text-green-700' : 'bg-red-100 text-red-700' }}" data-status="{{ $admin->status }}" data-url="{{ route('admin.users.changestatus', $admin->id) }}" onclick="changeStatus('{{$admin->id}}','user')">
                                                        {{ucfirst($admin->status)}}
                                                    </span>
                                                </td>
                                                <td class="px-4 py-3">{{$admin->created_at}}</td>
                                                <td class="px-4 py-3">
                                                    <div class="flex gap-2">
                                                        <a href="{{ route('users.show', $admin->id) }}" title="View admin account" class="h-9 flex items-center rounded-md px-3 hover:bg-accent">
                                                            <i data-lucide="eye" class="w-4 h-4"></i>
                                                        </a>
                                                        <button class="h-9 rounded-md px-3 hover:bg-accent text-destructive" onclick="openEditModal({{ $admin->id }}, '{{ $admin->first_name }}', '{{ $admin->last_name }}', '{{ $admin->status }}', 'admins')">
                                                            <i data-lucide="pencil" class="w-4 h-4"></i>
                                                        </button>
                                                        <button class="h-9 rounded-md px-3 hover:bg-accent text-destructive" onclick="deleteFromList('{{$admin->id}}','user')">
                                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                        </button>
                                                        <form id="user_delete_form_{{$admin->id}}" action="{{url('admin/users/'.$admin->id)}}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center py-4 text-muted-foreground">
                                                        No admins found
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                    <!-- PAGINATION UI -->
                                    @if($admins->hasPages())
                                        <div class="px-6 py-4 border-t border-gray-100">
                                            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                                                <div class="text-sm text-gray-500">
                                                    Showing <span class="font-semibold text-gray-700">{{ $admins->firstItem() }}</span> 
                                                    to <span class="font-semibold text-gray-700">{{ $admins->lastItem() }}</span> 
                                                    of <span class="font-semibold text-gray-700">{{ $admins->total() }}</span> admins
                                                </div>
                                                <div class="custom-pagination">
                                                    {{ $admins->links('pagination::tailwind') }}
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- Admins tab content end -->
                    </div>

                </div>
            </main>
            @yield('content')
        </div>
    </div>

    <x-dashboard.sidebar.mobile-sidebar />
    <script>lucide.createIcons()</script>
    <script>
    const tabs = document.querySelectorAll('[role="tab"]');
    const contents = document.querySelectorAll('.tab-content');
    
    // Function to switch to a specific tab
    function switchToTab(tabName) {
        tabs.forEach(t => {
            t.setAttribute('aria-selected', 'false');
            t.classList.remove('bg-background', 'shadow-sm');
        });
        contents.forEach(c => c.classList.add('hidden'));
        
        const targetTab = document.querySelector(`[data-tab="${tabName}"]`);
        if (targetTab) {
            targetTab.setAttribute('aria-selected', 'true');
            targetTab.classList.add('bg-background', 'shadow-sm');
            document.getElementById(tabName).classList.remove('hidden');
        }
    }
    
    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            switchToTab(tab.dataset.tab);
        });
    });
    
    // Handle URL parameter for tab on page load
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const tabParam = urlParams.get('tab');
        if (tabParam) {
            switchToTab(tabParam);
        }
    });

    function openEditModal(id, firstName, lastName, status, currentTab) {
        document.getElementById('editUserId').value = id;
        document.getElementById('editFirstName').value = firstName;
        document.getElementById('editLastName').value = lastName;
        document.getElementById('editStatus').value = status;
        
        // Store current tab in a hidden field
        let tabField = document.getElementById('currentTabField');
        if (!tabField) {
            tabField = document.createElement('input');
            tabField.type = 'hidden';
            tabField.name = 'current_tab';
            tabField.id = 'currentTabField';
            document.querySelector('#editUserModal form').appendChild(tabField);
        }
        tabField.value = currentTab || 'members';
        
        document.getElementById('editUserModal').classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('editUserModal').classList.add('hidden');
    }

    // Close when clicking outside modal
    document.getElementById('editUserModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeEditModal();
        }
    });

    // Close on ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === "Escape") {
            closeEditModal();
        }
    });

    function searchMembers() {
        const searchInput = document.getElementById('search_members');
        const filter = searchInput.value.toLowerCase();
        const table = document.querySelector('#members table');
        const rows = table.getElementsByTagName('tr');
        for (let i = 1; i < rows.length; i++) {
            const cells = rows[i].getElementsByTagName('td');
            let match = false;
            for (let j = 0; j < cells.length; j++) {
                if (cells[j]) {
                    const cellText = cells[j].textContent || cells[j].innerText;
                    if (cellText.toLowerCase().indexOf(filter) > -1) {
                        match = true;
                        break;
                    }
                }
            }
            rows[i].style.display = match ? '' : 'none';
        }
    }

    function searchCollaborators() {
        const searchInput = document.getElementById('search_collaborators');
        const filter = searchInput.value.toLowerCase();
        const table = document.querySelector('#collaborators table');
        const rows = table.getElementsByTagName('tr');
        for (let i = 1; i < rows.length; i++) {
            const cells = rows[i].getElementsByTagName('td');
            let match = false;
            for (let j = 0; j < cells.length; j++) {
                if (cells[j]) {
                    const cellText = cells[j].textContent || cells[j].innerText;
                    if (cellText.toLowerCase().indexOf(filter) > -1) {
                        match = true;
                        break;
                    }
                }
            }
            rows[i].style.display = match ? '' : 'none';
        }
    }

    function searchAdmins() {
        const searchInput = document.getElementById('search_admins');
        const filter = searchInput.value.toLowerCase();
        const table = document.querySelector('#admins table');
        const rows = table.getElementsByTagName('tr');
        for (let i = 1; i < rows.length; i++) {
            const cells = rows[i].getElementsByTagName('td');
            let match = false;
            for (let j = 0; j < cells.length; j++) {
                if (cells[j]) {
                    const cellText = cells[j].textContent || cells[j].innerText;
                    if (cellText.toLowerCase().indexOf(filter) > -1) {
                        match = true;
                        break;
                    }
                }
            }
            rows[i].style.display = match ? '' : 'none';
        }
    }
    </script>
    <script src="{{asset('js/constraint.js')}}"></script>
    <script src="{{asset('js/common.js')}}"></script>
<style>
    .rounded-full {
        cursor: pointer;
    }
</style>
</body>
</html>