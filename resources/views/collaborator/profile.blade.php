<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="base-url" content="{{ url('/admin') }}">
    <title>@yield('title', 'Profile Settings | Institute for Living Longer - Your Journey to Wellness')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/alpinejs" defer></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="{{asset('css/toastr.min.css')}}" />
    <script src="{{asset('js/toastr.min.js')}}"></script>
</head>
<body x-data="{ sidebarOpen: true, mobileSidebar: false }" class="bg-slate-100 antialiased">
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
    <div class="flex min-h-screen">
        <x-dashboard.sidebar.sidebar />
        <div class="flex-1 flex flex-col">
            <x-dashboard.sidebar.header />
            <!-- MAIN CONTENT -->
            <main class="flex-1 p-4 md:p-8 overflow-y-auto bg-white">
            <div class="space-y-8 max-w-4xl ">
                <!-- Header -->
                <div>
                    <h1 class="text-3xl font-bold text-foreground mb-2 text-left">Profile Settings</h1>
                    <p class="text-muted-foreground">Update your profile information that appears on the site</p>
                </div>
                <form action="{{ route('collaborator.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
                        <!-- Card Header -->
                        <div class="flex flex-col space-y-1.5 p-6">
                            <h3 class="text-2xl font-semibold leading-none tracking-tight">Personal Information</h3>
                            <p class="text-sm text-muted-foreground">This information will be displayed publicly</p>
                        </div>
                        <!-- Card Content -->
                        <div class="p-6 pt-0 space-y-6">
                            <div class="flex items-center gap-6">
                                <div class="w-24 h-24 rounded-full border-2 border-dashed flex items-center justify-center overflow-hidden">
                                    <input type="file" id="edit-profile-image" name="profile_image" accept="image/*" class="hidden"/>
                                    @if(!empty(Auth::user()->profile_image) && file_exists(public_path('user_images/'.Auth::user()->profile_image)))
                                        <img id="profilePreview" src="{{ asset('user_images/'.Auth::user()->profile_image) }}" alt="{{Auth::user()->first_name . ' ' . Auth::user()->last_name ?? '-'}}" class="w-full h-full object-cover"/>
                                    @else
                                        <img id="profilePreview" src="{{ asset('user_images/avatar.jpg') }}" name="profile_image" alt="{{Auth::user()->first_name . ' ' . Auth::user()->last_name ?? '-'}}" class="w-full h-full object-cover"/>
                                    @endif
                                </div>
                                <div>
                                    <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 cursor-pointer text-primary hover:underline" for="edit-profile-image">Change Profile Image</label>
                                    <p class="text-sm text-muted-foreground">JPG, PNG up to 5MB</p>
                                </div>
                            </div>
                                                    
                            <div class="space-y-2">
                                <label for="first_name" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">First Name <span class="text-red-500">*</span></label>
                                <input type="text" name="first_name" id="first_name" value="{{ Auth::user()->first_name }}" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-base ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 md:text-sm" placeholder="Enter First Name*" autocomplete="off" required  />
                            </div>

                            <div class="space-y-2">
                                <label for="last_name" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Last Name <span class="text-red-500">*</span></label>
                                <input type="text" name="last_name" id="last_name" value="{{ Auth::user()->last_name }}" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-base ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 md:text-sm" placeholder="Enter Last Name*" autocomplete="off" required  />
                            </div>

                            <div class="grid md:grid-cols-2 gap-4">
                                <div class="space-y-2">
                                    <label for="speciality" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">SpecialitySpecialty/Area of Expertise <span class="text-red-500">*</span></label>
                                    <input type="text" name="speciality" id="speciality" value="{{ Auth::user()->speciality }}" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-base ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 md:text-sm" placeholder="Enter Specialty/Area of Expertise*" autocomplete="off" required/>
                                </div>
                                <div class="space-y-2">
                                    <label for="professional_credentials" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Professional Credentials <span class="text-red-500">*</span></label>
                                    <input type="text" name="professional_credentials" id="professional_credentials" value="{{ Auth::user()->professional_credentials }}" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-base ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 md:text-sm" placeholder="Enter Professional Credentials*" autocomplete="off" required/>
                                </div>
                            </div>

                            <!-- Phone & Website -->
                            <div class="grid md:grid-cols-2 gap-4">
                                <div class="space-y-2">
                                    <label for="phone" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Phone <span class="text-red-500">*</span></label>
                                    <input type="tel" name="phone" id="phone" value="{{ Auth::user()->phone }}" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-base ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 md:text-sm" placeholder="Enter Phone" autocomplete="off" required/>
                                </div>

                                <div class="space-y-2">
                                    <label for="website" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Website (Optional)</label>
                                    <input type="url" name="website" id="website" placeholder="https://yourwebsite.com" value="{{ Auth::user()->website }}" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-base ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 md:text-sm" autocomplete="off"/>
                                </div>
                            </div>

                            <!-- Experience & Practice/Organization -->
                            <div class="grid md:grid-cols-2 gap-4">
                                <div class="space-y-2">
                                    <label for="experience" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Experience (Years) <span class="text-red-500">*</span></label>
                                    <input type="number" name="experience" id="experience" value="{{ Auth::user()->experience }}" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-base ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 md:text-sm" placeholder="Enter Experience in Years" autocomplete="off" required/>
                                </div>

                                <div class="space-y-2">
                                    <label for="organization" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Practice/Organization <span class="text-red-500">*</span></label>
                                    <input type="text" name="organization" id="organization" value="{{ Auth::user()->organization }}" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-base ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 md:text-sm" placeholder="Enter Organization Name" autocomplete="off" required/>
                                </div>
                            </div>

                            <!-- Bio -->
                            <div class="space-y-2">
                                <label for="collaborator_message" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Bio <span class="text-red-500">*</span></label>
                                <textarea name="collaborator_message" id="collaborator_message" rows="5" maxlength="2000" placeholder="Tell us about yourself..." class="flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" required>{{ Auth::user()->collaborator_message }}</textarea>
                                <p class="text-xs text-muted-foreground">0/2000 characters</p>
                            </div>


                            <!-- Submit Button -->
                            <button type="submit" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-primary text-primary-foreground hover:bg-primary/90 shadow-soft h-10 px-4 py-2 w-full">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-save h-4 w-4 mr-2">
                                    <path d="M15.2 3a2 2 0 0 1 1.4.6l3.8 3.8a2 2 0 0 1 .6 1.4V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2z"></path>
                                    <path d="M17 21v-7a1 1 0 0 0-1-1H8a1 1 0 0 0-1 1v7"></path>
                                    <path d="M7 3v4a1 1 0 0 0 1 1h7"></path>
                                </svg>
                                Save Profile
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            </main>
        </div>
    </div>
    <x-dashboard.sidebar.mobile-sidebar />
    <script>lucide.createIcons()</script>
    <script>
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
    </script>
    <script src="{{asset('js/constraint.js')}}"></script>
    <script src="{{asset('js/common.js')}}"></script>
</body>
</html>