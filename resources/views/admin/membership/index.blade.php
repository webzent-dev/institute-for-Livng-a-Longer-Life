<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="base-url" content="{{ url('/admin') }}">
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'Membership Management | Institute for Living Longer - Your Journey to Wellness')</title>
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
            <!-- Main Content -->
            <main class="flex-1 p-4 md:p-6 overflow-y-auto scrollbar-custom bg-white">
               <div class="p-6  min-h-screen">
                    <!-- Header -->
                    <div class="flex justify-between items-center ">
                        <div class="">
                            <h1 class="text-3xl font-bold text-left mb-0">Membership Management</h1>
                            <!-- <p class="text-muted-foreground text-lg">Manage memberships</p> -->
                        </div>
                        <div class="right-3">
                            <x-button-use label="Add Membership" variant="primary" icon="user-plus" @click="$dispatch('open-modal', 'add-membership-modal')" />
                        </div>
                    </div>

                    <!---------Add Membership Modal Start Here---------->
                    <x-ui.modal name="add-membership-modal" title="Add New Membership" size="md" class="max-w-2xl overflow-y-auto scrollbar-custom ">
                        <h2 class="text-lg font-semibold leading-none tracking-tight mb-2 text-left">Add Membership</h2>
                        <form method="POST" id="addMembershipForm" class="space-y-3 overflow-y-auto scrollbar-custom max-h-[60vh] scroll-smooth px-5" enctype="multipart/form-data">
                            @csrf
                            <div class="space-y-2">
                                <x-form.input label="Membership Name" type="text" name="membership_name" id="membership_name" autocomplete="off" placeholder="Enter Membership Name*" required />
                            </div>
                            <div class="grid grid-cols-2 gap-4 mt-3">
                                <div class="space-y-2">
                                    <x-form.input label="Membership Price" type="number" name="membership_price" id="membership_price" autocomplete="off" placeholder="Enter Membership Price*" required />
                                </div>
                                <div class="space-y-2">
                                    <x-form.input label="Membership Period (e.g. 'year','month')" type="text" name="membership_period" id="membership_period" autocomplete="off" placeholder="Enter Membership Period*" required />
                                </div>
                            </div>
                            <div class="space-y-2">
                                <x-form.input label="Membership Description" type="text" name="membership_description" id="membership_description" autocomplete="off" placeholder="Enter Membership Description*" required />
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Membership Features (Comma Separated) <span class="text-red-500">*</span></label>
                                <textarea name="membership_features" id="membership_features" class="flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" placeholder="Enter Membership Features*" rows="4"></textarea>
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Membership Benefits (Comma Separated) <span class="text-red-500">*</span></label>
                                <textarea name="membership_benefits" id="membership_benefits" class="flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" placeholder="Enter Membership Benefits*" rows="4"></textarea>
                            </div>
                            <x-button-use label="Add Membership" type="submit" variant="primary" class="w-full"/>
                        </form>
                    </x-ui.modal>
                    <!---------Add Membership Modal End Here---------->

                    

                    <div id="memberships" class="rounded-lg border bg-card text-card-foreground shadow-sm">
                        <div class="flex flex-col space-y-1.5 p-6">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h3 class="text-2xl font-semibold leading-none tracking-tight">All Memberships</h3>
                                </div>
                                <div class="w-[220px]">
                                    <input id="search_membership" type="text" name="search_membership" placeholder="Search memberships..." onkeyup="searchMembership()" class="flex h-10 w-full rounded-md
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
                        </div>
                        <div class="p-6 pt-0">
                            <div class="relative w-full overflow-auto">
                                <table class="w-full caption-bottom text-sm">
                                    <thead class="[&_tr]:border-b">
                                        <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">S.No.</th>
                                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Name</th>
                                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Price</th>
                                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Period</th>
                                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Make Popular</th>
                                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Status</th>
                                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="[&_tr:last-child]:border-0">
                                        @forelse($memberships as $key => $membership)
                                        <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                                            <td class="p-4 align-middle">{{$key + 1 ?? '-'}}</td>
                                            <td class="p-4 align-middle font-medium">{{$membership->membership_name}}</td>
                                            <td class="p-4 align-middle">${{ $membership->membership_price ?? '-'}}</td>
                                            <td class="p-4 align-middle">{{ucfirst($membership->membership_period) ?? '-'}}</td>
                                            <td class="p-4 align-middle">
                                                <span id="membership_popular_{{$membership->id}}" class="rounded-full self-center px-3 py-1 text-xs font-semibold text-primary-foreground {{ $membership->popular == 'yes' ? 'bg-primary text-green-700' : 'bg-red-100 text-red-700' }}" data-popular="{{ $membership->popular }}" data-url="{{ route('admin.manage-membership.makepopular', $membership->id) }}" onclick="makePopular({{$membership->id}})">
                                                    {{ucfirst($membership->popular)}}
                                                </span>
                                            </td>
                                            <td class="p-4 align-middle">
                                                <div 
                                                    class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold bg-primary text-primary-foreground cursor-pointer status-badge {{ $membership->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}"
                                                    data-membership-id="{{ $membership->id }}"
                                                    data-status="{{ $membership->status }}"
                                                    data-url="{{ route('admin.manage-membership.status', $membership->id) }}"
                                                >
                                                    {{ ucfirst($membership->status) }}
                                                </div>
                                            </td>
                                            <td class="p-4 align-middle">
                                                <div class="flex gap-2">
                                                    <x-button-use href="{{url('admin/manage-membership/'.$membership->id)}}" label="View" variant="outline" icon="eye" class="pl-0 pr-0 w-24 h-10"/>
                                                    <button class="h-9 rounded-md px-3 hover:bg-accent text-destructive" onclick="deleteFromList('{{$membership->id}}','membership')">
                                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                    </button>
                                                    <form id="membership_delete_form_{{$membership->id}}" action="{{url('admin/manage-membership/'.$membership->id)}}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                                            No memberships found
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            @yield('content')
            </main>
         </div>
        </div>
        <x-dashboard.sidebar.mobile-sidebar />
        <script>lucide.createIcons()</script>
        <script>
        const tabs = document.querySelectorAll('[role="tab"]');
        const contents = document.querySelectorAll('.tab-content');
        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                tabs.forEach(t => {
                    t.setAttribute('aria-selected', 'false');
                    t.setAttribute('data-state', 'inactive');
                    t.classList.remove('bg-background', 'shadow-sm');
                });
                contents.forEach(c => c.classList.add('hidden'));
                tab.setAttribute('aria-selected', 'true');
                tab.setAttribute('data-state', 'active');
                tab.classList.add('bg-background', 'shadow-sm');
                const activeContent = document.getElementById(tab.dataset.tab);
                if (activeContent) {
                    activeContent.classList.remove('hidden');
                }
            });
        });

        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).on('click', '.status-badge', function () {
                let $this = $(this);
                let currentStatus = $this.data('status');
                let newStatus = currentStatus === 'active' ? 'inactive' : 'active';
                let url = $this.data('url');
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: { status: newStatus },
                    success: function () {
                        // Update badge
                        $this.data('status', newStatus);
                        $this.text(newStatus.charAt(0).toUpperCase() + newStatus.slice(1));
                        if (newStatus === 'active') {
                            $this.removeClass('bg-red-100 text-red-700').addClass('bg-green-100 text-green-700');
                            showToast('Membership has been active successfully.', 'success');
                        } else {
                            $this.removeClass('bg-green-100 text-green-700').addClass('bg-red-100 text-red-700');
                            showToast('Membership has been inactive successfully.', 'error');
                        }
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText);
                        showToast('Status update failed', 'error');
                    }
                });
            });

        });

        function showToast(message, type = 'success') {
            let toast = $('#toast');
            toast.removeClass('hidden bg-green-600 bg-red-600');
            toast.addClass('bg-green-600');
            toast.text(message).fadeIn();
            setTimeout(() => {
                toast.fadeOut();
            }, 2000);
        }

        /*function editMembership(id, membership_name, membership_price, membership_period, membership_description, membership_features, membership_benefits) {
            $('#editMembershipId').val(id);
            $('#editMembershipName').val(membership_name);
            $('#editMembershipPrice').val(membership_price);
            $('#editMembershipPeriod').val(membership_period);
            $('#editMembershipDescription').val(membership_description);
            $('#editMembershipFeatures').val(membership_features);
            $('#editMembershipBenefits').val(membership_benefits);
            document.getElementById('editMembershipModal').classList.remove('hidden');
        }*/

        function closeModal() {
            document.getElementByName('add-membership-modal').classList.add('hidden');
        }

        // Close when clicking outside modal
        document.getElementById('add-membership-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        // Close on ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === "Escape") {
                closeModal();
            }
        });

        function searchMembership() {
            const searchInput = document.getElementById('search_membership');
            const filter = searchInput.value.toLowerCase();
            const table = document.querySelector('#memberships table');
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
        <script src="{{asset('js/membership.js')}}"></script>
   </body>
</html>