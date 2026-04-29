<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="base-url" content="{{ url('/admin') }}">
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'Collaborators Management | Institute for Living Longer - Your Journey to Wellness')</title>
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
                            <h1 class="text-3xl font-bold text-left mb-0">Collaborators Management</h1>
                            <p class="text-muted-foreground text-lg">Manage collaborator profiles and access</p>
                        </div>
                        <div class="right-3">
                            <x-button-use label="Add Collaborator" variant="primary" icon="user-plus" @click="$dispatch('open-modal', 'add-user-modal')" />
                        </div>
                    </div>
                    {{-- Modal Form --}}
                    <x-ui.modal name="add-user-modal" title="Add New Collaborator" size="md" class="max-w-2xl overflow-y-auto scrollbar-custom ">
                        <h2 class="text-lg font-semibold leading-none tracking-tight mb-2 text-left">Add Collaborator</h2>
                        <form method="POST" class="space-y-3 overflow-y-auto scrollbar-custom max-h-[60vh] scroll-smooth px-5" enctype="multipart/form-data">
                            @csrf
                            <!-- Profile Image Upload -->
                            <div class="flex justify-center" x-data="{profileImage: null,preview: ''}">
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium">Profile Image</label>
                                    <div class="relative flex h-32 w-32 items-center justify-center overflow-hidden rounded-full border-2 border-dashed">
                                        <input type="file" accept="image/*" name="profile_image" class="hidden" x-ref="fileInput" @change="profileImage = $event.target.files[0];preview = URL.createObjectURL(profileImage);"/>
                                        <template x-if="preview">
                                            <div class="relative h-full w-full">
                                                <img :src="preview" alt="Profile preview" class="h-full w-full object-cover"/>
                                                <button type="button" @click="profileImage = null;preview = '';$refs.fileInput.value = null;" class="absolute right-0 top-0 rounded-full bg-destructive p-1 text-destructive-foreground">&times;</button>
                                            </div>
                                        </template>
                                        <!-- Upload State -->
                                        <template x-if="!preview">
                                            <button type="button" @click="$refs.fileInput.click()" class="flex cursor-pointer flex-col items-center justify-center text-muted-foreground">
                                                <!-- Upload Icon -->
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-upload h-8 w-8 text-muted-foreground">
                                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                                    <polyline points="17 8 12 3 7 8"></polyline>
                                                    <line x1="12" x2="12" y1="3" y2="15"></line>
                                                </svg>
                                                <span class="mt-1 text-xs">Upload</span>
                                            </button>
                                        </template>
                                    </div>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4 mt-3">
                                <div class="space-y-2">
                                    <x-form.input label="First Name" type="text" name="first_name" id="first_name" autocomplete="off" placeholder="Enter First Name*" required />
                                </div>
                                <div class="space-y-2">
                                    <x-form.input label="Last Name" type="text" name="last_name" id="last_name" autocomplete="off" placeholder="Enter Last Name*" required />
                                </div>
                                <div class="space-y-2">
                                    <x-form.input label="Email" type="email" name="email" id="email" autocomplete="off" placeholder="Enter Email*" required />
                                </div>
                                <div class="space-y-2">
                                    <x-form.input label="Phone" type="text" name="phone" id="phone" autocomplete="off" placeholder="Enter Phone*" required />
                                </div>
                            </div>
                            <div class="space-y-2">
                                <x-form.input label="Specialty/Area of Expertise" type="text" name="speciality" id="speciality" autocomplete="off" placeholder="Enter Specialty/Area of Expertise*" required />
                            </div>
                            <div class="space-y-2">
                                <x-form.input label="Professional Credentials" type="text" name="professional_credentials" id="professional_credentials" autocomplete="off" placeholder="Enter Professional Credentials*" required />
                            </div>
                            <div class="grid grid-cols-2 gap-4 mt-3">
                                <div class="space-y-2">
                                    <x-form.input label="Years of Experience" type="number" name="experience" id="experience" autocomplete="off" placeholder="e.g., 10+ years" required />
                                </div>
                                <div class="space-y-2">
                                    <x-form.input label="Practice/Organization" type="text" name="organization" id="organization" autocomplete="off" placeholder="Clinic or organization name*" required />
                                </div>
                            </div>
                            <div class="space-y-2">
                                <x-form.input label="Website (Optional)" type="text" name="website" id="website" autocomplete="off" placeholder="https://yourwebsite.com" />
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Bio <span class="text-red-500">*</span></label>
                                <textarea name="collaborator_message" id="collaborator_message" class="flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" placeholder="Brief professional biography..." rows="4"></textarea>
                            </div>
                            <x-button-use label="Add Collaborator" type="submit" variant="primary" class="w-full"/>
                        </form>
                    </x-ui.modal>
                    <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
                        <div class="flex flex-col space-y-1.5 p-6">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h3 class="text-2xl font-semibold leading-none tracking-tight">All Collaborators</h3>
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
                        </div>
                        <div id="collaborators" class="p-6 pt-0">
                            <div class="relative w-full overflow-auto">
                                <table class="w-full caption-bottom text-sm">
                                    <thead class="[&_tr]:border-b">
                                        <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Profile</th>
                                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Name</th>
                                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Speciality</th>
                                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Email</th>
                                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Products</th>
                                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Courses</th>
                                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Status</th>
                                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="[&_tr:last-child]:border-0">
                                        @forelse($collaborators as $key => $collaborator)
                                        <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                                            <td class="p-4 align-middle">
                                            <div class="h-10 w-10 overflow-hidden rounded-full bg-muted">
                                                @if(!empty($collaborator->profile_image) && file_exists(public_path('user_images/'.$collaborator->profile_image)))
                                                    <img src="{{ asset('user_images/'.$collaborator->profile_image) }}" alt="{{$collaborator->first_name . ' ' . $collaborator->last_name ?? '-'}}" class="h-full w-full object-cover"/>
                                                @else
                                                    <img src="{{ asset('user_images/user.png') }}" alt="{{$collaborator->first_name . ' ' . $collaborator->last_name ?? '-'}}" class="h-full w-full object-cover"/>
                                                @endif
                                            </div>
                                            </td>
                                            <td class="p-4 align-middle font-medium">{{$collaborator->first_name . ' ' . $collaborator->last_name ?? '-'}}</td>
                                            <td class="p-4 align-middle">{{ $collaborator->specialty ?? '-'}}</td>
                                            <td class="p-4 align-middle">{{$collaborator->email}}</td>
                                            <td class="p-4 align-middle">{{$collaborator->products_count ?? 0}}</td>
                                            <td class="p-4 align-middle">{{$collaborator->courses_count ?? 0}}</td>
                                            <td class="p-4 align-middle">
                                                <!-- <span class="rounded-full self-center px-3 py-1 text-xs font-semibold text-primary-foreground {{ $collaborator->status === 'active' ? 'bg-primary text-green-700' : 'bg-red-100 text-red-700' }}"
                                                    data-id="{{ $collaborator->id }}"
                                                    data-status="{{ $collaborator->status }}"
                                                    data-url="{{ route('admin.collaborators.status', $collaborator->id) }}">
                                                    <span class="status-text">{{ ucfirst($collaborator->status ?? 'inactive') }}</span>
                                                </span> -->
                                                <!-- Loader -->
                                                <!-- <svg class="loader hidden w-3 h-3 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                                </svg> -->
                                                <span id="user_status_{{$collaborator->id}}" class="rounded-full self-center px-3 py-1 text-xs font-semibold text-primary-foreground {{ $collaborator->status === 'active' ? 'bg-primary text-green-700' : 'bg-red-100 text-red-700' }}" data-status="{{ $collaborator->status }}" data-url="{{ route('admin.users.changestatus', $collaborator->id) }}" onclick="changeStatus('{{$collaborator->id}}','user')">
                                                    {{ucfirst($collaborator->status)}}
                                                </span>
                                            </td>
                                            <td class="p-4 align-middle">
                                                <div class="flex gap-2">
                                                    <x-button-use href="{{ route('collaborators.show', $collaborator->id) }}" label="View" variant="outline" icon="eye" class="pl-0 pr-0 w-24 h-10"/>
                                                    <button class="h-9 rounded-md px-3 hover:bg-accent text-destructive" onclick="deleteFromList('{{$collaborator->id}}','collaborator')">
                                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                    </button>
                                                    <form id="collaborator_delete_form_{{$collaborator->id}}" action="{{url('admin/collaborators/'.$collaborator->id)}}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                                            No collaborator found
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
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
            </main>
            @yield('content')
            <!-- </main>
         </div> -->
        </div>
        <x-dashboard.sidebar.mobile-sidebar />
        <script>
        lucide.createIcons();
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

        //Add validation for phone number input to allow only digits and maximum lengeth of 10 characters
        $('#fld_phone').on('input', function() {
            let value = $(this).val();
            // Remove any non-digit characters
            value = value.replace(/[^0-9]/g, '');
            // Limit to 10 characters
            value = value.substring(0, 10);
            $(this).val(value);
        });
        </script>
        <script src="{{asset('js/constraint.js')}}"></script>
        <script src="{{asset('js/common.js')}}"></script>
    </body>
</html>