<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="base-url" content="{{ url('/admin') }}">
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'Location Management | Institute for Living Longer - Your Journey to Wellness')</title>
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
                            <h1 class="text-3xl font-bold text-left mb-0">Location Management</h1>
                            <p class="text-muted-foreground text-lg">Manage locations</p>
                        </div>
                        <div class="right-3">
                            <x-button-use label="Add Location" variant="primary" icon="map-pin-plus" @click="$dispatch('open-modal', 'add-location-modal')" />
                        </div>
                    </div>
                    {{-- Modal Form --}}
                    <x-ui.modal name="add-location-modal" title="Add New Location" size="md" class="max-w-2xl overflow-y-auto scrollbar-custom ">
                        <h2 class="text-lg font-semibold leading-none tracking-tight mb-2 text-left">Add Location</h2>
                        <form method="POST" class="space-y-3 overflow-y-auto scrollbar-custom max-h-[60vh] scroll-smooth px-5" enctype="multipart/form-data">
                            @csrf
                            <div class="grid grid-cols-2 gap-4 mt-3">
                                <div class="space-y-2">
                                    <x-form.input label="Name" type="text" name="name" id="name" autocomplete="off" placeholder="Enter Name*" required />
                                </div>
                                <div class="space-y-2">
                                    <x-form.input label="City" type="text" name="city" id="city" autocomplete="off" placeholder="Enter City*" required />
                                </div>
                                <div class="space-y-2">
                                    <x-form.input label="State" type="text" name="state" id="state" autocomplete="off" placeholder="Enter State*" required />
                                </div>
                                <div class="space-y-2">
                                    <x-form.input label="Zip Code" type="text" name="zip" id="zip" autocomplete="off" placeholder="Enter Zip Code*" required />
                                </div>
                                <div class="space-y-2">
                                    <x-form.input label="Country" type="text" name="country" id="country" autocomplete="off" placeholder="Enter Country*" required />
                                </div>
                            </div>
                            <div class="space-y-2">
                                <x-form.input label="Address" type="text" name="address" id="address" autocomplete="off" placeholder="Enter Address*" required />
                            </div>
                            <div class="grid grid-cols-2 gap-4 mt-3">
                                <div class="space-y-2">
                                    <x-form.input label="Latitude" type="number" name="latitude" id="latitude" autocomplete="off" placeholder="Enter Latitude*" required />
                                </div>
                                <div class="space-y-2">
                                    <x-form.input label="Longitude" type="number" name="longitude" id="longitude" autocomplete="off" placeholder="Enter Longitude*" required />
                                </div>
                            </div>
                            <x-button-use label="Add Location" type="submit" variant="primary" class="w-full"/>
                        </form>
                    </x-ui.modal>
                    <div id="locations" class="rounded-lg border bg-card text-card-foreground shadow-sm">
                        <div class="flex flex-col space-y-1.5 p-6">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h3 class="text-2xl font-semibold leading-none tracking-tight">All Locations</h3>
                                </div>
                                <div class="w-[220px]">
                                    <input id="search_location" type="text" name="search_location" placeholder="Search locations..." onkeyup="searchLocation()" class="flex h-10 w-full rounded-md
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
                                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Name</th>
                                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">City</th>
                                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">State</th>
                                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Zip Code</th>
                                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Country</th>
                                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Address</th>
                                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Latitude</th>
                                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Longitude</th>
                                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Status</th>
                                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="[&_tr:last-child]:border-0">
                                        @forelse($locations as $key => $location)
                                        <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                                            <td class="p-4 align-middle">{{$location->name ?? '-'}}</td>
                                            <td class="p-4 align-middle font-medium">{{$location->city}}</td>
                                            <td class="p-4 align-middle">{{ $location->state ?? '-'}}</td>
                                            <td class="p-4 align-middle">{{$location->zip ?? '-'}}</td>
                                            <td class="p-4 align-middle">{{$location->country ?? '-'}}</td>
                                            <td class="p-4 align-middle">{{$location->address ?? '-'}}</td>
                                            <td class="p-4 align-middle">{{$location->latitude ?? '-'}}</td>
                                            <td class="p-4 align-middle">{{$location->longitude ?? '-'}}</td>
                                            <td class="p-4 align-middle">
                                                <div 
                                                    class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold bg-primary text-primary-foreground cursor-pointer status-badge {{ $location->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}"
                                                    data-location-id="{{ $location->id }}"
                                                    data-status="{{ $location->status }}"
                                                    data-url="{{ route('admin.locations.status', $location->id) }}"
                                                >
                                                    {{ ucfirst($location->status) }}
                                                </div>
                                            </td>
                                            <td class="p-4 align-middle">
                                                <div class="flex gap-2">
                                                    <x-button-use href="{{url('admin/locations/'.$location->id)}}" label="View" variant="outline" icon="eye" class="pl-0 pr-0 w-24 h-10"/>
                                                    <button class="h-9 rounded-md px-3 hover:bg-accent text-destructive" onclick="deleteFromList('{{$location->id}}','location')">
                                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                    </button>
                                                    <form id="location_delete_form_{{$location->id}}" action="{{url('admin/locations/'.$location->id)}}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                                            No location found
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <!-- PAGINATION UI -->
                            @if($locations->hasPages())
                                <div class="px-6 py-4 border-t border-gray-100">
                                    <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                                        <div class="text-sm text-gray-500">
                                            Showing <span class="font-semibold text-gray-700">{{ $locations->firstItem() }}</span> 
                                            to <span class="font-semibold text-gray-700">{{ $locations->lastItem() }}</span> 
                                            of <span class="font-semibold text-gray-700">{{ $locations->total() }}</span> locations
                                        </div>
                                        <div class="custom-pagination">
                                            {{ $locations->links('pagination::tailwind') }}
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </main>
            @yield('content')
            </div>
        </div>
        <x-dashboard.sidebar.mobile-sidebar />
        <script>lucide.createIcons()</script>
        <script>
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
                            showToast('Status has been changed successfully.', 'success');
                        } else {
                            $this.removeClass('bg-green-100 text-green-700').addClass('bg-red-100 text-red-700');
                            showToast('Status has been changed successfully.', 'error');
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

        function searchLocation() {
            const searchInput = document.getElementById('search_location');
            const filter = searchInput.value.toLowerCase();
            const table = document.querySelector('#locations table');
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
    </body>
</html>