<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'User Details | Living a Longer Life')</title>
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
<body x-data="{  sidebarOpen: true,  mobileSidebar: false  }"  class="bg-slate-50 antialiased">
  <div class="flex min-h-screen">
    <x-dashboard.sidebar.sidebar />
    <div class="flex-1 flex flex-col">
        <x-dashboard.sidebar.header />
        <main class="flex-1 p-8 bg-white ">
            <div class="space-y-6">
                <!-- Header -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <x-button-use href="{{route('admin.users.index')}}" variant="outline" icon="arrow-left" class=" bg-white h-10 w-10 pl-1 pr-0"/>
                    <div>
                        <h1 class="text-3xl font-bold text-left mb-0">User Details</h1>
                        <p class="text-muted-foreground text-lg">View and manage user information</p>
                    </div>
                </div>
                <div class="flex gap-2">
                    <!-- <x-button-use label="Delete" variant="outline" icon="trash2" onclick="deleteFromList('{{$userDetail->id}}','user')" /> -->
                    <button type="button" onclick="deleteFromList('{{$userDetail->id}}','user')" class="rounded-md flex items-center justify-center font-semibold gap-2 transition-all duration-150 select-none px-5 py-2 text-base h-10 border-2 border-primary text-primary hover:bg-primary hover:text-white font-semibold  text-[14px]">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="trash2" aria-hidden="true" class="lucide lucide-trash2 w-5 h-5 mr-2"><path d="M10 11v6"></path>
                            <path d="M14 11v6"></path>
                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"></path>
                            <path d="M3 6h18"></path>
                            <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                        </svg>
                        Delete
                    </button>
                    <!-- <x-button-use label="Save Changes" variant="primary" icon="save" onclick="updateUser()" /> -->
                    <button type="button" onclick="updateUser()" class="rounded-md flex items-center justify-center font-semibold gap-2 transition-all duration-150 select-none px-5 py-2 text-base h-10 gradient-primary text-primary-foreground hover:opacity-90 shadow-medium font-semibold h-10 px-4 py-2  font-semibold  text-[14px]">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="save" aria-hidden="true" class="lucide lucide-save w-5 h-5 mr-2">
                            <path d="M15.2 3a2 2 0 0 1 1.4.6l3.8 3.8a2 2 0 0 1 .6 1.4V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2z"></path>
                            <path d="M17 21v-7a1 1 0 0 0-1-1H8a1 1 0 0 0-1 1v7"></path>
                            <path d="M7 3v4a1 1 0 0 0 1 1h7"></path>
                        </svg>
                        Save Changes
                    </button>
                </div>
                <form id="user_delete_form_{{$userDetail->id}}" action="{{url('admin/collaborators/'.$userDetail->id)}}" method="POST">
                    @csrf
                    @method('DELETE')
                </form>
            </div>

            <!-- User Information -->
            <div class="py-4 rounded-lg border bg-card text-card-foreground shadow-sm">
                <div class="flex flex-col space-y-1.5 p-6">
                    <h3 class="text-2xl font-semibold leading-none tracking-tight">
                        User Information
                    </h3>
                </div>

                <!-- FORM -->
                <form method="POST" id="editUserForm" name="editUserForm" action="{{ route('admin.users.update') }}" class="space-y-3 scroll-smooth px-5">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="user_id" value="{{ $userDetail->id }}">
                    <div class="grid grid-cols-2 gap-4 mt-3">
                        <div class="space-y-2">
                            <x-form.input label="First Name" type="text" name="first_name" value="{{ $userDetail->first_name }}" placeholder="Enter First Name*" autocomplete="off" required  />
                        </div>
                        <div class="space-y-2">
                            <x-form.input label="Last Name" type="text" name="last_name" value="{{ $userDetail->last_name }}" placeholder="Enter Last Name*" autocomplete="off" required  />
                        </div>
                        <div class="space-y-2 z-20 relative">
                            <x-form.select label="Role*" name="role" class="z-20" placeholder="Select Role" required
                            :options="[
                                    ['label' => 'Member','value' => 'user'],
                                    ['label' => 'Collaborator','value' => 'collaborator'],
                                    ['label' => 'Admin','value' => 'admin']
                                ]"
                            :selected="[$userDetail->role]"/>
                        </div>
                        <div class="space-y-2 z-0">
                            <x-form.select label="Status*" name="status" placeholder="Select Status" required
                            :options="[
                                ['value' => 'active', 'label' => 'Active'],
                                ['value' => 'inactive', 'label' => 'Inactive'],
                            ]"
                            :selected="[$userDetail->status]"/>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Customer Information -->
            <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
                <div class="flex flex-col space-y-1.5 p-6">
                    <h3 class="text-2xl font-semibold leading-none tracking-tight">
                        Account Details
                    </h3>
                </div>
                <div class="p-6 pt-0">
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label class="text-md font-medium text-muted-foreground">User ID</label>
                            <p class="text-2xl font-bold text-black">{{$userDetail->id}}</p>
                        </div>
                        <div>
                            <label class="text-md font-medium text-muted-foreground">Created At</label>
                            <p class="text-lg text-black">{{$userDetail->created_at}}</p>
                        </div>
                        <!-- <div>
                            <label class="text-md font-medium text-muted-foreground">Last Login</label>
                            <p class="text-lg text-black">2024-02-01</p>
                        </div> -->
                    </div>
                </div>
            </div>
        </main>
    </div>
    @yield('content')
    </div>
</div>
<x-dashboard.sidebar.mobile-sidebar />
<script>lucide.createIcons()</script>
<script>
    function updateUser() {
        document.getElementById('editUserForm').submit();
    }
</script>
<script src="{{asset('js/constraint.js')}}"></script>
<script src="{{asset('js/common.js')}}"></script>
</body>
</html>