<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="base-url" content="{{ url('/admin') }}">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'FAQ Category Management | Institute for Living Longer - Your Journey to Wellness')</title>
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
                            <h1 class="text-3xl font-bold text-left">FAQ Category Management</h1>
                            <p class="text-muted-foreground text-lg">
                                Manage faq categories
                            </p>
                        </div>
                        <div class="right-3">
                            <x-button-use label="Add FAQ Category" variant="primary" icon="plus" @click="$dispatch('open-modal', 'add-faq-category-modal')" />
                        </div>
                    </div>

                    <!-- Add FAQ Category Modal Start Here -->
                    <x-ui.modal name="add-faq-category-modal">
                        <h2 class="text-lg font-semibold leading-none tracking-tight mb-2 text-left">Add New Category</h2>
                        <form id="addFAQCategoryForm" method="POST" class="space-y-3">
                            @csrf
                            <x-form.input label="Name" type="text" name="name" id="name" autocomplete="off" placeholder="Enter name*" required  />
                            <x-button-use label="Add FAQ Category" variant="primary" type="submit" class="w-full"/>
                            <x-button-use label="Cancel" variant="outline" type="button" class="w-full" @click="$dispatch('close-modal', 'add-faq-category-modal')" />
                        </form>
                    </x-ui.modal>
                    <!-- Add FAQ Category Modal End Here -->

                    <!-- Edit FAQ Category Modal Start Here -->
                    <div id="editFAQCategoryModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50">
                        <div class="bg-white w-full max-w-3xl rounded-xl shadow-lg sticky top-20">
                            <button type="button" onclick="closeEditModal()" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-xl">&times;</button>
                            <div class="p-6 border-b">
                                <h2 class="text-lg font-semibold leading-none tracking-tight text-left">Edit FAQ Category</h2>
                            </div>
                            <!-- Modal Body -->
                            <form method="POST" action="{{ route('admin.faq-categories.update') }}" class="space-y-4 overflow-y-auto scrollbar-custom max-h-[60vh] scroll-smooth px-6 py-4">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="faq_category_id" id="editFAQCategoryId">

                                <div class="space-y-2">
                                    <label for="name" class="text-sm font-medium">Name <span class="text-red-500">*</span></label>
                                    <input type="text" name="name" id="editName" class="flex h-10 w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary" placeholder="Enter Name*" autocomplete="off" required>
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
                    <!-- Edit FAQ Category Modal End Here -->

                    <div class="rounded-lg border bg-card shadow-sm">
                        <div class="p-6">
                            <h3 class="text-2xl font-semibold">Members</h3>
                        </div>

                        <div class="p-6 pt-0 overflow-auto">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="border-b text-muted-foreground">
                                        <th class="px-4 py-3 text-left">Name</th>
                                        <th class="px-4 py-3 text-left">Created At</th>
                                        <th class="px-4 py-3 text-left">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse( $faqCategories as $key => $faqcategory)
                                    <tr class="border-b hover:bg-muted/50">
                                        <td class="px-4 py-3">{{$faqcategory->name}}</td>
                                        <td class="px-4 py-3">{{$faqcategory->created_at}}</td>
                                        <td class="justify-items-center">
                                            <div class="flex gap-2">
                                                <button class="h-9 rounded-md px-3 hover:bg-accent text-destructive" onclick="openEditModal({{ $faqcategory->id }}, '{{ $faqcategory->name }}')">
                                                    <i data-lucide="pencil" class="w-4 h-4"></i>
                                                </button>
                                                <button class="h-9 rounded-md px-3 hover:bg-accent text-destructive" onclick="deleteFromList('{{$faqcategory->id}}','faq_category')">
                                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                </button>
                                                <form id="faq_category_delete_form_{{$faqcategory->id}}" action="{{url('admin/faq-categories/'.$faqcategory->id)}}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4 text-muted-foreground">
                                                No faq category found
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
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
    const tabs = document.querySelectorAll('[role="tab"]');
    const contents = document.querySelectorAll('.tab-content');
    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => {
                t.setAttribute('aria-selected', 'false');
                t.classList.remove('bg-background', 'shadow-sm');
            });
            contents.forEach(c => c.classList.add('hidden'));
            tab.setAttribute('aria-selected', 'true');
            tab.classList.add('bg-background', 'shadow-sm');
            document.getElementById(tab.dataset.tab).classList.remove('hidden');
        });
    });

    function openEditModal(id, name) {
        document.getElementById('editFAQCategoryId').value = id;
        document.getElementById('editName').value = name;
        document.getElementById('editFAQCategoryModal').classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('editFAQCategoryModal').classList.add('hidden');
    }

    // Close when clicking outside modal
    document.getElementById('editFAQCategoryModal').addEventListener('click', function(e) {
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
    </script>
    <script src="{{asset('js/constraint.js')}}"></script>
    <script src="{{asset('js/common.js')}}"></script>
</body>
</html>