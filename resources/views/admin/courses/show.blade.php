<!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="base-url" content="{{ url('/admin') }}">
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'Course Detail | Institute for Living Longer - Your Journey to Wellness')</title>
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
            <main class="flex-1 p-8 bg-white ">
                <div class="space-y-6">
                    <!-- Header -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <x-button-use href="{{ route('admin.courses') }}"   variant="outline" icon="arrow-left" class=" bg-white h-10 w-10 pl-1 pr-0"/>
                            <div>
                                <h1 class="text-3xl font-bold text-left mb-0">Course Details</h1>
                                <p class="text-muted-foreground text-lg">View and manage course information</p>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <!-- <x-button-use href=""  label="Delete" variant="outline" icon="trash2" class=" "/>
                            <x-button-use href=""  label="Save Changes" variant="primary" icon="save" class=" "/> -->
                            <button type="button" onclick="deleteFromList('{{$courseDetail->id}}','course')" class="rounded-md flex items-center justify-center font-semibold gap-2 transition-all duration-150 select-none px-5 py-2 text-base h-10 border-2 border-primary text-primary hover:bg-primary hover:text-white font-semibold  text-[14px]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="trash2" aria-hidden="true" class="lucide lucide-trash2 w-5 h-5 mr-2"><path d="M10 11v6"></path>
                                    <path d="M14 11v6"></path>
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"></path>
                                    <path d="M3 6h18"></path>
                                    <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                </svg>
                                Delete
                            </button>
                            <button type="button" onclick="updateCourse()" class="rounded-md flex items-center justify-center font-semibold gap-2 transition-all duration-150 select-none px-5 py-2 text-base h-10 gradient-primary text-primary-foreground hover:opacity-90 shadow-medium font-semibold h-10 px-4 py-2  font-semibold  text-[14px]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="save" aria-hidden="true" class="lucide lucide-save w-5 h-5 mr-2">
                                    <path d="M15.2 3a2 2 0 0 1 1.4.6l3.8 3.8a2 2 0 0 1 .6 1.4V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2z"></path>
                                    <path d="M17 21v-7a1 1 0 0 0-1-1H8a1 1 0 0 0-1 1v7"></path>
                                    <path d="M7 3v4a1 1 0 0 0 1 1h7"></path>
                                </svg>
                                Save Changes
                            </button>
                            <form id="course_delete_form_{{$courseDetail->id}}" action="{{ route('admin.courses.delete', $courseDetail->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </div>

                    <!-- Course Information Start Here-->
                    <div class="py-4 rounded-lg border bg-card text-card-foreground shadow-sm">
                        <div class="flex flex-col space-y-1.5 p-6">
                            <h3 class="text-2xl font-semibold leading-none tracking-tight">Course Information</h3>
                        </div>
                        
                        <form method="POST" id="editCourseForm" name="editCourseForm" action="{{ route('admin.courses.update', $courseDetail->id) }}" enctype="multipart/form-data" class="space-y-3 overflow-y-auto scrollbar-custom  scroll-smooth px-5">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="course_id" value="{{ $courseDetail->id }}">
                            <x-form.input label="Course Title" type="text" name="title" value="{{ $courseDetail->title }}" placeholder="Enter course title*" autocomplete="off" required  />
                            <div class="space-y-2">
                                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Description</label>
                                <textarea name="description" rows="3" placeholder="Learn the fundamentals of holistic health and wellness practices." class="flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" required>{{ $courseDetail->description }}</textarea>
                            </div>
                            <div class="grid grid-cols-2 gap-4 mt-3">
                                <div class="space-y-2">
                                    <x-form.select label="Category" name="category" placeholder="Select Category" required
                                    :selected="[$courseDetail->category]"
                                    :options="[
                                        ['value' => 'health_wellness', 'label' => 'Health & Wellness'],
                                        ['value' => 'nutrition', 'label' => 'Nutrition'],
                                        ['value' => 'biohacking', 'label' => 'Biohacking'],
                                        ['value' => 'mental_health', 'label' => 'Mental Health'],
                                        ['value' => 'fitness', 'label' => 'Fitness'],
                                        ['value' => 'longevity_science', 'label' => 'Longevity Science'],
                                        ['value' => 'supplements', 'label' => 'Supplements'],
                                        ['value' => 'lifestyle', 'label' => 'Lifestyle'],
                                        ]"
                                    />
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-medium leading-none">Instructor <span class="required" style="color: red;">*</span></label>
                                    <select name="user_id" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm" required>
                                        <option value="">Select Instructor</option>
                                        @foreach ($instructors as $instructor)
                                            <option value="{{ $instructor->id }}" @if($instructor->id == $courseDetail->user_id) selected @endif>{{ $instructor->first_name }} {{ $instructor->last_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="space-y-2">
                                    <x-form.input label="Duration" type="number" name="duration" value="{{ $courseDetail->duration }}" placeholder="Duration*" autocomplete="off" required />
                                </div>
                                <div class="space-y-2">
                                    <x-form.input label="Video URL" type="text" name="video_url" value="{{ $courseDetail->video_url }}" placeholder="Enter Video URL*" autocomplete="off" required  />
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Course Images</label>
                                    <div class="rounded-lg border-2 border-dashed p-4">
                                        <input type="file" name="course_images[]" id="course-images" accept="image/*" class="hidden" multiple />
                                        <div id="image-count" class="text-sm text-primary mt-2 hidden"></div>
                                        <label for="course-images" class="flex cursor-pointer flex-col items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="mb-2 h-8 w-8 text-muted-foreground" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                                <polyline points="17 8 12 3 7 8" />
                                                <line x1="12" y1="3" x2="12" y2="15" />
                                            </svg>
                                            <span class="text-sm text-muted-foreground">Click to upload images</span>
                                            <span class="text-xs text-muted-foreground">PNG, JPG up to 5MB each</span>
                                        </label>
                                    </div>
                                </div>

                                {{-- Show Existing Course Images --}}
                                @if(count($courseImages) > 0)
                                    <div class="mt-4">
                                        <!-- <label class="text-sm font-medium">Uploaded Images</label> -->
                                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 mt-3">
                                            @foreach($courseImages as $image)
                                                <div class="relative group border rounded-lg overflow-hidden">
                                                    @if(!empty($image->image) && file_exists(public_path('course_images/'.$image->image)))
                                                        <img src="{{ asset('course_images/'.$image->image) }}" class="w-full aspect-square object-cover">
                                                    @endif

                                                    {{-- Optional Delete Button --}}
                                                    <button type="button" onclick="removeImage('{{$image->id}}')" class="absolute top-1 right-1 bg-red-500 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition">&times;</button>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                <!-- <div class="space-y-2">
                                    <x-form.switch name="is_published" label="Published" :checked="true" on-value="published" off-value="draft" on-label="Published" off-label="Draft" class="pt-8"/>
                                </div> -->
                            </div>
                        </form>
                    </div>
                    <!-- Customer Information -->
                    <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
                        <div class="flex flex-col space-y-1.5 p-6">
                            <h3 class="text-2xl font-semibold leading-none tracking-tight">Statistics</h3>
                        </div>
                        <div class="p-6 pt-0">
                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <label class="text-md font-medium text-muted-foreground">Total Views</label>
                                <p class="text-2xl font-bold text-black">0</p>
                            </div>
                            <div>
                                <label class="text-md font-medium text-muted-foreground">Status</label>
                                <p class="text-lg">{{ucfirst($courseDetail->status)}}</p>
                            </div>
                            <div>
                                <label class="text-md font-medium text-muted-foreground">Created At</label>
                                <p class="text-lg text-black">{{$courseDetail->created_at}}</p>
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
        function updateCourse() {
            document.getElementById('editCourseForm').submit();
        }

        document.getElementById('course-images').addEventListener('change', function () {
            const files = this.files;
            const countDisplay = document.getElementById('image-count');
            if (files.length > 0) {
                // Optional: validate each file (5MB max)
                for (let i = 0; i < files.length; i++) {
                    if (files[i].size > 5 * 1024 * 1024) {
                        alert("Each image must be less than 5MB.");
                        this.value = "";
                        countDisplay.classList.add("hidden");
                        return;
                    }
                }
                countDisplay.innerText = files.length + " image(s) selected";
                countDisplay.classList.remove("hidden");
            } else {
                countDisplay.classList.add("hidden");
            }
        });

        function removeImage(imageId) {
            let r = confirm("Are you sure you want to delete this image?");
            if (r == true) {
                $.ajax({
                    url: "{{ route('admin.courses.removeImage') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        image_id: imageId
                    },
                    success: function (response) {
                        if (response.status) {
                            toastr.success(response.message);
                            location.reload();
                            //setTimeout(function () { location.reload(); }, 1000);
                        } else {
                            toastr.error(response.message);
                        }
                    }
                });
            }
        }
        </script>
        <script src="{{asset('js/constraint.js')}}"></script>
        <script src="{{asset('js/common.js')}}"></script>
    </body>
   </html>