<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="base-url" content="{{ url('/admin') }}">
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'Collaborator Profile | Institute for Living Longer - Your Journey to Wellness')</title>
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
                            <x-button-use href="{{ route('collaborators.index') }}" variant="outline" icon="arrow-left" class=" bg-white h-10 w-10 pl-1 pr-0"/>
                            <div>
                                <h1 class="text-3xl font-bold text-left mb-0">Collaborator Details</h1>
                                <p class="text-muted-foreground text-lg">View and manage collaborator information</p>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <!-- <x-button-use label="Delete" variant="outline" icon="trash2" />
                            <x-button-use label="Save Changes" variant="primary" icon="save" /> -->
                            <button type="button" onclick="deleteFromList('{{$collaboratorDetail->id}}','collaborator')" class="rounded-md flex items-center justify-center font-semibold gap-2 transition-all duration-150 select-none px-5 py-2 text-base h-10 border-2 border-primary text-primary hover:bg-primary hover:text-white font-semibold  text-[14px]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="trash2" aria-hidden="true" class="lucide lucide-trash2 w-5 h-5 mr-2"><path d="M10 11v6"></path>
                                    <path d="M14 11v6"></path>
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"></path>
                                    <path d="M3 6h18"></path>
                                    <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                </svg>
                                Delete
                            </button>
                            <button type="button" onclick="updateUser()" class="rounded-md flex items-center justify-center font-semibold gap-2 transition-all duration-150 select-none px-5 py-2 text-base h-10 gradient-primary text-primary-foreground hover:opacity-90 shadow-medium font-semibold h-10 px-4 py-2  font-semibold  text-[14px]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="save" aria-hidden="true" class="lucide lucide-save w-5 h-5 mr-2">
                                    <path d="M15.2 3a2 2 0 0 1 1.4.6l3.8 3.8a2 2 0 0 1 .6 1.4V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2z"></path>
                                    <path d="M17 21v-7a1 1 0 0 0-1-1H8a1 1 0 0 0-1 1v7"></path>
                                    <path d="M7 3v4a1 1 0 0 0 1 1h7"></path>
                                </svg>
                                Save Changes
                            </button>
                            <form id="collaborator_delete_form_{{$collaboratorDetail->id}}" action="{{url('admin/collaborators/'.$collaboratorDetail->id)}}" method="POST">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </div>
                    <!-- Tabs -->
                    <div dir="ltr" data-orientation="horizontal">
                        <div role="tablist" aria-orientation="horizontal" class="grid h-10 w-full grid-cols-3 items-center justify-center rounded-md bg-muted p-1 text-muted-foreground" tabindex="0">
                            <button role="tab" aria-selected="true" data-state="active" data-tab="profile_information" aria-controls="profile_information" type="button" class="inline-flex items-center justify-center rounded-sm px-3 py-1.5 text-sm font-medium transition-all data-[state=active]:bg-background data-[state=active]:text-foreground data-[state=active]:shadow-sm">
                                Profile Information
                            </button>
                            <button role="tab" aria-selected="false" data-state="inactive" data-tab="products" aria-controls="collaborators" type="button" class="inline-flex items-center justify-center rounded-sm px-3 py-1.5 text-sm font-medium transition-all">
                                Products ({{count($collaboratorProducts)}})
                            </button>
                            <button role="tab" aria-selected="false" data-state="inactive" data-tab="courses" aria-controls="admins" type="button" class="inline-flex items-center justify-center rounded-sm px-3 py-1.5 text-sm font-medium transition-all">
                                Courses ({{count($collaboratorCourses)}})
                            </button>
                        </div>
                    </div>

                    <!-- TAB CONTENT -->
                    <div id="profile_information" class="tab-content mt-2">
                        <form method="POST" id="editUserForm" name="editUserForm" action="{{ route('admin.collaborators.update') }}" class="space-y-3 scroll-smooth px-5" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="user_id" value="{{ $collaboratorDetail->id }}">
                            <div class="p-6 pt-0 space-y-6">
                                <div class="flex items-center gap-6">
                                    <div class="w-24 h-24 rounded-full border-2 border-dashed flex items-center justify-center overflow-hidden">
                                        <input type="file" id="edit-profile-image" name="profile_image" accept="image/*" class="hidden"/>
                                        @if(!empty($collaboratorDetail->profile_image) && file_exists(public_path('user_images/'.$collaboratorDetail->profile_image)))
                                            <img id="profilePreview" src="{{ asset('user_images/'.$collaboratorDetail->profile_image) }}" alt="{{$collaboratorDetail->first_name . ' ' . $collaboratorDetail->last_name ?? '-'}}" class="w-full h-full object-cover"/>
                                        @else
                                            <img id="profilePreview" src="{{ asset('user_images/avatar.jpg') }}" name="profile_image" alt="{{$collaboratorDetail->first_name . ' ' . $collaboratorDetail->last_name ?? '-'}}" class="w-full h-full object-cover"/>
                                        @endif
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 cursor-pointer text-primary hover:underline" for="edit-profile-image">
                                            Change Profile Image
                                        </label>
                                        <p class="text-sm text-muted-foreground">JPG, PNG up to 5MB</p>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="space-y-2">
                                        <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="name">First Name <span class="text-red-500">*</span></label>
                                        <input type="text" name="first_name" id="first_name" value="{{$collaboratorDetail->first_name}}" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-base md:text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" placeholder="Enter First Name*" autocomplete="off" required/>
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="name">Last Name <span class="text-red-500">*</span></label>
                                        <input type="text" name="last_name" id="last_name" value="{{$collaboratorDetail->last_name}}" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-base md:text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" placeholder="Enter First Name*" autocomplete="off" required/>
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-sm font-medium" for="speciality">Specialty/Area of Expertise <span class="text-red-500">*</span></label>
                                        <input type="text" name="speciality" id="speciality" value="{{$collaboratorDetail->speciality}}" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-base md:text-sm" placeholder="Enter Specialty/Area of Expertise*" autocomplete="off" required/>
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-sm font-medium" for="professional_credentials">Professional Credentials <span class="text-red-500">*</span></label>
                                        <input type="text" name="professional_credentials" id="professional_credentials" value="{{$collaboratorDetail->professional_credentials}}" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-base md:text-sm" placeholder="Enter Professional Credentials*" autocomplete="off" required/>
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-sm font-medium" for="phone">Phone <span class="text-red-500">*</span></label>
                                        <input type="tel" name="phone" id="phone" value="{{$collaboratorDetail->phone}}" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-base md:text-sm" placeholder="Enter Phone*" autocomplete="off" required/>
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-sm font-medium" for="website">Website (Optional)</label>
                                        <input type="url" name="website" id="website" value="{{$collaboratorDetail->website}}" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-base md:text-sm" placeholder="https://yourwebsite.com" autocomplete="off"/>
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-sm font-medium" for="experience">Experience <span class="text-red-500">*</span></label>
                                        <input type="number" name="experience" id="experience" value="{{$collaboratorDetail->experience}}" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-base md:text-sm" placeholder="Enter Experience*" autocomplete="off" required/>
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-sm font-medium" for="organization">Practice/Organization <span class="text-red-500">*</span></label>
                                        <input type="text" name="organization" id="organization" value="{{$collaboratorDetail->organization}}" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-base md:text-sm" placeholder="Enter Practice/Organization*" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-medium" for="bio">Bio <span class="text-red-500">*</span></label>
                                    <textarea name="collaborator_message" id="collaborator_message" rows="4" class="flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm" required>{{$collaboratorDetail->collaborator_message}}</textarea>
                                </div>
                            </div>
                        </form>

                        <div class="rounded-lg border bg-card text-card-foreground shadow-sm mt-6">
                            <div class="flex flex-col space-y-1.5 p-6">
                                <h3 class="text-2xl font-semibold">Statistics</h3>
                            </div>
                            <div class="p-6 pt-0">
                                <div class="grid grid-cols-3 gap-4">
                                    <div class="text-center p-4 bg-muted rounded-lg">
                                        <i data-lucide="package"  class="h-6 w-6 mx-auto mb-2 text-primary" ></i>
                                        <p class="text-2xl font-bold text-black">{{count($collaboratorProducts)}}</p>
                                        <p class="text-sm text-muted-foreground">Products</p>
                                    </div>
                                    <div class="text-center p-4 bg-muted rounded-lg">
                                        <i data-lucide="video"  class="h-6 w-6 mx-auto mb-2 text-primary" ></i>
                                        <p class="text-2xl font-bold text-black">{{count($collaboratorCourses)}}</p>
                                        <p class="text-sm text-muted-foreground">Courses</p>
                                    </div>
                                    <div class="text-center p-4 bg-muted rounded-lg">
                                        <i data-lucide="eye"  class="h-6 w-6 mx-auto mb-2 text-primary" ></i>
                                        <p class="text-2xl font-bold text-black">2,456</p>
                                        <p class="text-sm text-muted-foreground">Total Views</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Products -->
                    <div id="products" class="tab-content mt-2 hidden">
                        <div class="rounded-lg border bg-card shadow-sm">
                            <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
                            <div class="flex flex-col space-y-1.5 p-6">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <h3 class="text-2xl font-semibold leading-none tracking-tight text-black mb-0">Collaborator Products</h3>
                                        <p class="text-sm text-muted-foreground">Manage products for this collaborator</p>
                                    </div>
                                </div>
                            </div>
                            <div class="p-6 pt-0">
                                <div class="relative w-full overflow-auto">
                                    <table class="w-full caption-bottom text-sm">
                                        <thead class="[&_tr]:border-b">
                                            <tr class="border-b transition-colors data-[state=selected]:bg-muted hover:bg-muted/50">
                                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Product Name</th>
                                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Price</th>
                                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Stock</th>
                                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Status</th>
                                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="[&_tr:last-child]:border-0">
                                            @forelse($collaboratorProducts as $product)
                                                <tr class="border-b transition-colors data-[state=selected]:bg-muted hover:bg-muted/50">
                                                    <td class="p-4 align-middle font-medium">{{$product->name}}</td>
                                                    <td class="p-4 align-middle">${{$product->price}}</td>
                                                    <td class="p-4 align-middle">{{$product->stock_quantity}}</td>
                                                    <td class="p-4 align-middle">
                                                        <div class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $product->status === 'active' ? 'bg-green-500' : 'bg-gray-100' }} text-primary-foreground">
                                                            {{ucfirst($product->status)}}
                                                        </div>
                                                    </td>
                                                    <td class="p-4 align-middle">
                                                        <a href="{{url('admin/products/'.$product->id)}}"><button class="inline-flex items-center gap-2 text-sm font-medium border-2 border-primary bg-background text-primary hover:bg-primary hover:text-primary-foreground h-9 rounded-md px-3">View</button></a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr class="border-b transition-colors data-[state=selected]:bg-muted hover:bg-muted/50">
                                                    <td class="p-4 align-middle font-medium">No products found</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>

                    <!-- Courses -->
                    <div id="courses" class="tab-content mt-2 hidden">
                        <div class="rounded-lg border bg-card shadow-sm">
                            <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
                            <div class="space-y-1.5 p-6">
                                <h3 class="text-2xl font-semibold leading-none tracking-tight text-black mb-0">Collaborator Courses</h3>
                                <p class="text-sm text-muted-foreground">Manage courses for this collaborator</p>
                            </div>
                            <div class="p-6 pt-0">
                                <div class="relative w-full overflow-auto">
                                    <table class="w-full caption-bottom text-sm">
                                        <thead class="[&_tr]:border-b">
                                            <tr class="border-b transition-colors data-[state=selected]:bg-muted hover:bg-muted/50">
                                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Course Title</th>
                                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Category</th>
                                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Views</th>
                                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Status</th>
                                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="[&_tr:last-child]:border-0">
                                            @forelse($collaboratorCourses as $course)
                                                <tr class="border-b transition-colors data-[state=selected]:bg-muted hover:bg-muted/50">
                                                    <td class="p-4 align-middle font-medium">{{ucfirst($course->title)}}</td>
                                                    <td class="p-4 align-middle">
                                                        <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold text-foreground">
                                                            {{ucfirst($course->category)}}
                                                        </div>
                                                    </td>
                                                    <td class="p-4 align-middle">0</td>
                                                    <td class="p-4 align-middle">
                                                        <div class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $course->status == 'draft' ? 'bg-gray-100' : 'bg-green-500' }} text-primary-foreground">
                                                            {{ucfirst($course->status)}}
                                                        </div>
                                                    </td>
                                                    <td class="p-4 align-middle">
                                                        <a href="{{url('admin/courses/'.$course->id)}}">
                                                            <button class="inline-flex items-center gap-2 text-sm font-medium border-2 border-primary bg-background text-primary hover:bg-primary hover:text-primary-foreground h-9 rounded-md px-3">View</button>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr class="border-b transition-colors data-[state=selected]:bg-muted hover:bg-muted/50">
                                                    <td class="p-4 align-middle font-medium">No courses found</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
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
            
            document.getElementById('edit-profile-image').addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    // Validate file size (5MB max)
                    if (file.size > 5 * 1024 * 1024) {
                        alert("File size must be less than 5MB.");
                        event.target.value = "";
                        return;
                    }

                    // Validate image type
                    const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                    if (!allowedTypes.includes(file.type)) {
                        alert("Only JPG and PNG files are allowed.");
                        event.target.value = "";
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById('profilePreview').src = e.target.result;
                    }
                    reader.readAsDataURL(file);
                }
            });


            function updateUser() {
                let first_name = $('#first_name').val();
                let last_name = $('#last_name').val();
                let speciality = $('#speciality').val();
                let professional_credentials = $('#professional_credentials').val();
                let phone = $('#phone').val();
                let website = $('#website').val();
                let experience = $('#experience').val();
                let organization = $('#organization').val();
                let collaborator_message = $('#collaborator_message').val();
                let user_id = $('#user_id').val();

                if(first_name == '' || last_name == '' || speciality == '' || professional_credentials == '' || phone == '' || experience == '' || organization == '' || collaborator_message == '') {
                    toastr.error('Please fill all the fields.');
                    return false;
                }else{
                    document.getElementById('editUserForm').submit();
                }
            }
        </script>
        <script src="{{asset('js/constraint.js')}}"></script>
        <script src="{{asset('js/common.js')}}"></script>
    </body>
</html>