<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="base-url" content="{{ url('/admin') }}">
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'Help Category Management | Institute for Living Longer - Your Journey to Wellness')</title>
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
                            <h1 class="text-3xl font-bold text-left mb-0">Help Categories Management</h1>
                            <p class="text-muted-foreground text-lg">Manage help categories</p>
                        </div>
                        <div class="right-3">
                            <x-button-use label="Add Help Categories" variant="primary" icon="plus" @click="$dispatch('open-modal', 'add-help-category-modal')" />
                        </div>
                    </div>
                    {{-- Modal Form --}}
                    <x-ui.modal name="add-help-category-modal" title="Add New Help Category" size="md" class="max-w-2xl overflow-y-auto scrollbar-custom ">
                        <h2 class="text-lg font-semibold leading-none tracking-tight mb-2 text-left">Add Help Category</h2>
                        <form method="POST" class="space-y-3 overflow-y-auto scrollbar-custom max-h-[60vh] scroll-smooth px-5" enctype="multipart/form-data">
                            @csrf
                            <div class="grid grid-cols-2 gap-4 mt-3">
                                <div class="space-y-2">
                                    <x-form.input label="Icon" type="text" name="icon" id="icon" autocomplete="off" placeholder="Enter Icon*" required />
                                </div>
                                <div class="space-y-2">
                                    <x-form.input label="Title" type="text" name="title" id="title" autocomplete="off" placeholder="Enter Title*" required />
                                </div>
                            </div>
                            <div class="space-y-2">
                                <x-form.input label="Description" type="text" name="description" id="description" autocomplete="off" placeholder="Enter Description*" required />
                            </div>
                            <x-button-use label="Add Help Category" type="submit" variant="primary" class="w-full"/>
                        </form>
                    </x-ui.modal>
                    <div id="help_categories" class="rounded-lg border bg-card text-card-foreground shadow-sm">
                        <div class="flex flex-col space-y-1.5 p-6">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h3 class="text-2xl font-semibold leading-none tracking-tight">All Help Categories</h3>
                                </div>
                                <div class="w-[220px]">
                                    <input id="search_help_category" type="text" name="search_help_category" placeholder="Search help categories..." onkeyup="searchHelpCategory()" class="flex h-10 w-full rounded-md
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
                                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Icon</th>
                                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Title</th>
                                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Description</th>
                                            <!-- <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Status</th> -->
                                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="[&_tr:last-child]:border-0">
                                        @forelse($helpCategories as $key => $helpCategory)
                                        <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                                            <td class="p-4 align-middle">{{$helpCategory->icon ?? '-'}}</td>
                                            <td class="p-4 align-middle">{{$helpCategory->title ?? '-'}}</td>
                                            <td class="p-4 align-middle">{{$helpCategory->description ?? '-'}}</td>
                                            {{-- <td class="p-4 align-middle">
                                                <div 
                                                    class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold bg-primary text-primary-foreground cursor-pointer status-badge {{ $testimonial->is_active == 1 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}"
                                                    data-testimonial-id="{{ $testimonial->id }}"
                                                    data-status="{{ $status }}"
                                                    data-url="{{ route('admin.testimonials.status', $testimonial->id) }}"
                                                >
                                                    {{ ucfirst($status) }}
                                                </div>
                                            </td>--}}
                                            <td class="p-4 align-middle">
                                                <div class="flex gap-2">
                                                    <x-button-use href="{{url('admin/help-categories/'.$helpCategory->id)}}" label="View" variant="outline" icon="eye" class="pl-0 pr-0 w-24 h-10"/>
                                                    <button class="h-9 rounded-md px-3 hover:bg-accent text-destructive" onclick="deleteFromList('{{$helpCategory->id}}','help_category')">
                                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                    </button>
                                                    <form id="help_category_delete_form_{{$helpCategory->id}}" action="{{url('admin/help-categories/'.$helpCategory->id)}}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                                            No help categories found
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <!-- PAGINATION UI -->
                            @if($helpCategories->hasPages())
                                <div class="px-6 py-4 border-t border-gray-100">
                                    <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                                        <div class="text-sm text-gray-500">
                                            Showing <span class="font-semibold text-gray-700">{{ $helpCategories->firstItem() }}</span> 
                                            to <span class="font-semibold text-gray-700">{{ $helpCategories->lastItem() }}</span> 
                                            of <span class="font-semibold text-gray-700">{{ $helpCategories->total() }}</span> help categories
                                        </div>
                                        <div class="custom-pagination">
                                            {{ $helpCategories->links('pagination::tailwind') }}
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

        function searchHelpCategory() {
            const searchInput = document.getElementById('search_help_category');
            const filter = searchInput.value.toLowerCase();
            const table = document.querySelector('#help_categories table');
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