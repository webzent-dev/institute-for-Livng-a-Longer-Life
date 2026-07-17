<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'Membership Detail | Institute for Living Longer - Your Journey to Wellness')</title>
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
                            <x-button-use href="{{ route('admin.manage-membership') }}"   variant="outline" icon="arrow-left" class=" bg-white h-10 w-10 pl-1 pr-0"/>
                            <div>
                                <h1 class="text-3xl font-bold text-left mb-0">Membership Details</h1>
                                <p class="text-muted-foreground text-lg">View and manage membership information</p>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <button type="button" onclick="deleteFromList('{{$membershipDetail->id}}','membership')" class="rounded-md flex items-center justify-center font-semibold gap-2 transition-all duration-150 select-none px-5 py-2 text-base h-10 border-2 border-primary text-primary hover:bg-primary hover:text-white font-semibold  text-[14px]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="trash2" aria-hidden="true" class="lucide lucide-trash2 w-5 h-5 mr-2"><path d="M10 11v6"></path>
                                    <path d="M14 11v6"></path>
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"></path>
                                    <path d="M3 6h18"></path>
                                    <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                </svg>
                                Delete
                            </button>
                            <button type="button" onclick="updateMembership()" class="rounded-md flex items-center justify-center font-semibold gap-2 transition-all duration-150 select-none px-5 py-2 text-base h-10 gradient-primary text-primary-foreground hover:opacity-90 shadow-medium font-semibold h-10 px-4 py-2  font-semibold  text-[14px]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="save" aria-hidden="true" class="lucide lucide-save w-5 h-5 mr-2">
                                    <path d="M15.2 3a2 2 0 0 1 1.4.6l3.8 3.8a2 2 0 0 1 .6 1.4V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2z"></path>
                                    <path d="M17 21v-7a1 1 0 0 0-1-1H8a1 1 0 0 0-1 1v7"></path>
                                    <path d="M7 3v4a1 1 0 0 0 1 1h7"></path>
                                </svg>
                                Save Changes
                            </button>
                            <form id="membership_delete_form_{{$membershipDetail->id}}" action="{{url('admin/manage-membership/'.$membershipDetail->id)}}" method="POST">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </div>
                    
                    <!-- Membership Information Start Here-->
                    <div class="py-4 rounded-lg border bg-card text-card-foreground shadow-sm">
                        <div class="flex flex-col space-y-1.5 p-6">
                            <h3 class="text-2xl font-semibold leading-none tracking-tight">Membership Information</h3>
                        </div>
                        <form method="POST" id="editMembershipForm" name="editMembershipForm" action="{{route('admin.manage-membership.update',$membershipDetail['id'])}}" enctype="multipart/form-data" class="space-y-3 overflow-y-auto scrollbar-custom scroll-smooth px-5">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="membership_id" value="{{ $membershipDetail->id }}">
                            <x-form.input label="Membership Name" type="text" name="membership_name" id="membership_name" value="{{ $membershipDetail->membership_name }}" autocomplete="off" placeholder="Enter Membership Name*" required />
                            <div class="grid grid-cols-2 gap-4 mt-3">
                                <div class="space-y-2">
                                    <x-form.input label="Membership Price" type="number" name="membership_price" id="membership_price" value="{{ $membershipDetail->membership_price }}" autocomplete="off" placeholder="Enter Membership Price*" required />
                                </div>
                                <div class="space-y-2">
                                    <x-form.input label="Membership Period (e.g. 'year','month')" type="text" name="membership_period" id="membership_period" value="{{ $membershipDetail->membership_period }}" autocomplete="off" placeholder="Enter Membership Period*" required />
                                </div>
                            </div>
                            <div class="space-y-2 mt-3">
                                <x-form.input label="Member Discount (%)" type="number" name="discount_percent" id="discount_percent" value="{{ $membershipDetail->discount_percent }}" autocomplete="off" placeholder="e.g. 10 for 10% off Vital Boost" />
                                <p class="text-xs text-muted-foreground">Exclusive percentage discount members on this plan get on Vital Boost. 0 = no discount.</p>
                            </div>
                            <div class="space-y-2">
                                <x-form.input label="Membership Description" type="text" name="membership_description" id="membership_description" value="{{ $membershipDetail->membership_description }}" autocomplete="off" placeholder="Enter Membership Description*" required />
                            </div>                            
                            <div class="space-y-2">
                                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Membership Features (Comma Separated) <span class="required" style="color: red;">*</span></label>
                                <textarea rows="3" name="membership_features" placeholder="Enter Membership Features*" autocomplete="off" class="flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" required>{{ $membershipDetail->membership_features }}</textarea>
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Membership Benefits (Comma Separated) <span class="required" style="color: red;">*</span></label>
                                <textarea rows="3" name="membership_benefits" placeholder="Enter Membership Benefits*" autocomplete="off" class="flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" required>{{ $membershipDetail->membership_benefits }}</textarea>
                            </div>
                        </form>
                    </div>
                    <!-- Membership Information End Here-->
                </div>
            </main>
        </div>
        </main>
        @yield('content')
        </main>
        </div>
        </div>
        <x-dashboard.sidebar.mobile-sidebar />
        <script>lucide.createIcons()</script>
        <script>
        function updateMembership() {
            document.getElementById('editMembershipForm').submit();
        }
        </script>
        <script src="{{asset('js/constraint.js')}}"></script>
        <script src="{{asset('js/common.js')}}"></script>
    </body>
</html>