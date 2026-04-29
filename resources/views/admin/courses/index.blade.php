<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="base-url" content="{{ url('/admin') }}">
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'Courses | Institute for Living Longer - Your Journey to Wellness')</title>
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
    @php
        $categories = [
            'health_wellness' => 'Health & Wellness',
            'nutrition' => 'Nutrition',
            'biohacking' => 'Biohacking',
            'mental_health' => 'Mental Health',
            'fitness' => 'Fitness',
            'longevity_science' => 'Longevity Science',
            'supplements' => 'Supplements',
            'lifestyle' => 'Lifestyle'
        ];
    @endphp
    <body  x-data="{  sidebarOpen: true,  mobileSidebar: false  }"  class="bg-slate-50 antialiased">
        <div class="flex min-h-screen">
            <x-dashboard.sidebar.sidebar />
            <div class="flex-1 flex flex-col">
            <x-dashboard.sidebar.header />
            <main class="flex-1 p-8  bg-white ">
                <div class="space-y-6">
                    <!-- Header -->
                    <div class="flex justify-between items-center  ">
                        <div class="">
                            <h1 class="text-3xl font-bold text-left mb-0">Courses Management</h1>
                            <p class="text-muted-foreground text-lg">Manage all video courses and learning content</p>
                        </div>
                        <div class="right-3">
                            <x-button-use label=" Add Course" variant="primary" icon="plus" @click="$dispatch('open-modal', 'add-course-modal')" />
                        </div>
                    </div>
                    {{-- Modal Form --}}
                    <x-ui.modal name="add-course-modal" size="3xl" class="max-w-3xl sticky top-20">
                        <h2 class="text-lg font-semibold leading-none tracking-tight mb-2 text-left">Add New Course</h2>
                        <form method="POST" class="space-y-3 overflow-y-auto scrollbar-custom max-h-[60vh] scroll-smooth px-5" enctype="multipart/form-data">
                            @csrf
                            <!-- <x-form.select label="Instructor" name="role" placeholder="Select Instructor" required
                                :options="[
                                ['value' => 'Dr. Victor Zeines', 'label' => 'Dr. Victor Zeines'],
                                ['value' => 'Dr. Sarah Martinez', 'label' => 'Dr. Sarah Martinez'],
                                ['value' => 'Dr. Michael Chen', 'label' => 'Dr. Michael Chen'],
                                ['value' => 'Dr. Emily Thompson', 'label' => 'Dr. Emily Thompson'],
                                ]"
                                :selected="['Dr. Victor Zeines']"
                                /> -->
                            <div class="space-y-2">
                                <label class="text-sm font-medium leading-none">Instructor <span class="required" style="color: red;">*</span></label>
                                <select name="user_id" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm" required>
                                    <option value="">Select Instructor</option>
                                    @foreach ($instructors as $instructor)
                                        <option value="{{ $instructor->id }}">{{ $instructor->first_name }} {{ $instructor->last_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <x-form.select label="Category" name="category" placeholder="Select Category" required
                            :selected="['health_wellness']"
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
                            <x-form.input label="Course Title" type="text" name="title" placeholder="Enter course title*" autocomplete="off" required  />
                            <div class="space-y-2">
                                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Description <span class="required" style="color: red;">*</span></label>
                                <textarea name="description" rows="3" placeholder="Enter course description*" autocomplete="off" class="flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" required></textarea>
                            </div>
                            <div class="grid grid-cols-2 gap-4 mt-3">
                                <div class="space-y-2">
                                    <x-form.input label="Duration" type="number" name="duration" placeholder="Duration*" autocomplete="off" required />
                                </div>
                                <div class="space-y-2">
                                    <x-form.input label="Video URL" type="text" name="video_url" placeholder="Enter Video URL*" autocomplete="off" required  />
                                </div>
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Course Images</label>
                                <div class="rounded-lg border-2 border-dashed p-4">
                                    <input type="file" id="course-images" name="course_images[]" accept="image/*" class="hidden" multiple />
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
                            <x-button-use label="Add Course" type="submit" variant="primary" class="w-full"/>
                        </form>
                    </x-ui.modal>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach ($courseCategories as $key => $value)
                            @php
                                //Count the number of courses in each category
                                $count = App\Models\Course::where('category', $key)->count();
                            @endphp
                            <div class="rounded-lg border bg-card text-card-foreground shadow-sm  hover:bg-muted/50 cursor-pointer">
                                <div class=" p-4">
                                    <div class="flex items-center gap-3">
                                        <i data-lucide="folder-open" class="w-6 h-6 text-primary"></i>
                                        <div>
                                            <p class="text-sm font-medium mb-0">{{$value}}</p>
                                            <p class="text-lg font-bold">{{$count}} courses</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Tabs -->
                    <div data-orientation="horizontal" class="mt-6">
                        <div role="tablist" aria-orientation="horizontal" class="grid h-10 w-full grid-cols-2 items-center justify-center rounded-md bg-muted p-1 text-muted-foreground" tabindex="0">
                            <button role="tab" aria-selected="true" data-state="active" data-tab="member_courses" aria-controls="members" type="button" class="inline-flex items-center justify-center rounded-sm px-3 py-1.5 text-sm font-medium transition-all data-[state=active]:bg-background data-[state=active]:text-foreground data-[state=active]:shadow-sm">
                                Member Courses ({{$memberCourses->total()}})
                            </button>
                            <button role="tab" aria-selected="false" data-state="inactive" data-tab="collaborator_courses" aria-controls="collaborators" type="button" class="inline-flex items-center justify-center rounded-sm px-3 py-1.5 text-sm font-medium transition-all">
                                Collaborator Courses ({{$collaboratorCourses->total()}})
                            </button>
                        </div>
                    </div>

                    <!----Member Courses Start Here---->
                    <div id="member_courses" class="tab-content mt-2">
                        <div class="rounded-lg border bg-card shadow-sm">
                        <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
                            <div class="flex flex-col space-y-1.5 p-6">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <h3 class="text-2xl font-semibold leading-none tracking-tight">Member Courses</h3>
                                        <p class="text-sm text-muted-foreground">Featured courses from the Institute</p>
                                    </div>
                                    <div class="w-[220px]">
                                        <input id="search_member_course" type="text" name="search_member_course" placeholder="Search courses..." onkeyup="searchMemberCourse()" class="flex h-10 w-full rounded-md
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
                                            <tr class="border-b transition-colors hover:bg-muted/50">
                                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Thumbnail</th>
                                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Title</th>
                                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Category</th>
                                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Duration</th>
                                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Views</th>
                                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Status</th>
                                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="[&_tr:last-child]:border-0">
                                            @forelse($memberCourses as $key => $course)
                                                <tr class="border-b transition-colors hover:bg-muted/50">
                                                    <td class="p-4 align-middle">
                                                        <div class="w-16 h-10 rounded overflow-hidden bg-muted">
                                                            @if(!empty($course->thumbnail) && file_exists(public_path('course_images/'.$course->thumbnail)))
                                                                <img src="{{asset('course_images/'.$course->thumbnail)}}" alt="{{$course->title}}" class="w-full h-full object-cover"/>
                                                            @else
                                                                <img src="{{asset('/assets/placeholder.svg')}}" alt="{{$course->title}}" class="w-full h-full object-cover"/>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="p-4 align-middle font-medium max-w-[200px] truncate">{{$course->title}}</td>
                                                    <td class="p-4 align-middle">
                                                        <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold">
                                                            @if(key_exists($course->category, $categories))
                                                                {{ $categories[$course->category] }}
                                                            @else
                                                                {{ $course->category }}
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="p-4 align-middle">{{$course->duration}}</td>
                                                    <td class="p-4 align-middle">
                                                        <div class="flex items-center gap-1">
                                                            <svg class="lucide lucide-eye h-4 w-4 text-muted-foreground"></svg>0
                                                        </div>
                                                    </td>
                                                    <td class="p-4 align-middle">
                                                        <div 
                                                            class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold bg-primary text-primary-foreground cursor-pointer status-badge {{ $course->status === 'published' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}"
                                                            data-product-id="{{ $course->id }}"
                                                            data-status="{{ $course->status }}"
                                                            data-url="{{ route('admin.courses.status', $course->id) }}"
                                                        >
                                                            {{ ucfirst($course->status) }}
                                                        </div>
                                                    </td>
                                                    <td class=" justify-items-center ">
                                                        <div class="flex gap-2">
                                                            <x-button-use href="{{url('admin/courses/'.$course->course_id)}}" label="View" variant="outline" icon="eye" class="pl-0 pr-0 w-24 h-10"/>
                                                            <button class="h-9 rounded-md px-3 hover:bg-accent text-destructive" onclick="deleteFromList('{{$course->course_id}}','course')">
                                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                            </button>
                                                            <form id="course_delete_form_{{$course->course_id}}" action="{{ route('admin.courses.delete', $course->course_id) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                                                        No courses found
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <!-- PAGINATION UI -->
                                @if($memberCourses->hasPages())
                                    <div class="px-6 py-4 border-t border-gray-100">
                                        <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                                            <div class="text-sm text-gray-500">
                                                Showing <span class="font-semibold text-gray-700">{{ $memberCourses->firstItem() }}</span> 
                                                to <span class="font-semibold text-gray-700">{{ $memberCourses->lastItem() }}</span> 
                                                of <span class="font-semibold text-gray-700">{{ $memberCourses->total() }}</span> courses
                                            </div>
                                            <div class="custom-pagination">
                                                {{ $memberCourses->links('pagination::tailwind') }}
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        </div>
                    </div>
                    <!----Member Courses End Here---->

                    <!----Collaborator Courses Start Here---->
                    <div id="collaborator_courses" class="tab-content mt-2 hidden">
                        <div class="rounded-lg border bg-card shadow-sm">
                        <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
                            <div class="flex flex-col space-y-1.5 p-6">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <h3 class="text-2xl font-semibold leading-none tracking-tight mb-0">Collaborator Courses</h3>
                                        <p class="text-sm text-muted-foreground">Courses from network collaborators</p>
                                    </div>
                                    <div class="w-[220px]">
                                        <input id="search_collaborator_course" type="text" name="search_collaborator_course" placeholder="Search courses..." onkeyup="searchCollaboratorCourse()" class="flex h-10 w-full rounded-md
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
                                    <!-- <div class="w-[220px]">
                                        <x-form.select
                                            :options="[
                                            ['value' => 'all', 'label' => 'All  Categories'],
                                            ['value' => 'Health & Wellness', 'label' => 'Health & Wellness'],
                                            ['value' => 'Nutrition', 'label' => 'Nutrition'],
                                            ['value' => 'Biohacking', 'label' => 'Biohacking'],
                                            ['value' => 'Mental Health', 'label' => 'Mental Health'],
                                            ['value' => 'Fitness', 'label' => 'Fitness'],
                                            ['value' => 'Longevity Science', 'label' => 'Longevity Science'],
                                            ['value' => 'Supplements', 'label' => 'Supplements'],
                                            ['value' => 'Lifestyle', 'label' => 'Lifestyle'],
                                            ]"
                                            :selected="['all']"
                                            />
                                    </div> -->
                                </div>
                            </div>
                            <div class="p-6 pt-0">
                                <div class="relative w-full overflow-auto">
                                    <table class="w-full caption-bottom text-sm">
                                        <thead class="[&_tr]:border-b">
                                            <tr class="border-b transition-colors hover:bg-muted/50">
                                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Thumbnail</th>
                                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Title</th>
                                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Category</th>
                                                <!-- <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Collaborator</th> -->
                                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Duration</th>
                                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Views</th>
                                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Status</th>
                                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="[&_tr:last-child]:border-0">
                                            @forelse($collaboratorCourses as $key => $course)
                                                <tr class="border-b transition-colors hover:bg-muted/50">
                                                    <td class="p-4 align-middle">
                                                        <div class="w-16 h-10 rounded overflow-hidden bg-muted">
                                                            @if(!empty($course->thumbnail) && file_exists(public_path('course_images/'.$course->thumbnail)))
                                                                <img src="{{asset('course_images/'.$course->thumbnail)}}" alt="{{$course->title}}" class="w-full h-full object-cover"/>
                                                            @else
                                                                <img src="{{asset('/assets/placeholder.svg')}}" alt="{{$course->title}}" class="w-full h-full object-cover"/>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="p-4 align-middle font-medium max-w-[200px] truncate">{{$course->title}}</td>
                                                    <td class="p-4 align-middle">
                                                        <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold">
                                                            @if(key_exists($course->category, $categories))
                                                                {{ $categories[$course->category] }}
                                                            @else
                                                                {{ $course->category }}
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="p-4 align-middle">{{$course->duration}}</td>
                                                    <td class="p-4 align-middle">
                                                        <div class="flex items-center gap-1">
                                                            <svg class="lucide lucide-eye h-4 w-4 text-muted-foreground"></svg>0
                                                        </div>
                                                    </td>
                                                    <td class="p-4 align-middle">
                                                        <div class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold bg-primary text-primary-foreground cursor-pointer">
                                                            {{ucfirst($course->status)}}
                                                        </div>
                                                    </td>
                                                    <td class=" justify-items-center ">
                                                        <div class="flex gap-2">
                                                            <x-button-use href="{{url('admin/courses/'.$course->course_id)}}" label="View" variant="outline" icon="eye" class="pl-0 pr-0 w-24 h-10"/>
                                                            <button class="h-9 rounded-md px-3 hover:bg-accent text-destructive" onclick="deleteFromList('{{$course->course_id}}','course')">
                                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                            </button>
                                                            <form id="course_delete_form_{{$course->course_id}}" action="{{ route('admin.courses.delete', $course->course_id) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                                                        No courses found
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <!-- PAGINATION UI -->
                                @if($collaboratorCourses->hasPages())
                                    <div class="px-6 py-4 border-t border-gray-100">
                                        <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                                            <div class="text-sm text-gray-500">
                                                Showing <span class="font-semibold text-gray-700">{{ $collaboratorCourses->firstItem() }}</span> 
                                                to <span class="font-semibold text-gray-700">{{ $collaboratorCourses->lastItem() }}</span> 
                                                of <span class="font-semibold text-gray-700">{{ $collaboratorCourses->total() }}</span> courses
                                            </div>
                                            <div class="custom-pagination">
                                                {{ $collaboratorCourses->links('pagination::tailwind') }}
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        </div>
                    </div>
                    <!----Collaborator Courses End Here---->
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
                    let newStatus = currentStatus === 'published' ? 'draft' : 'published';
                    let url = $this.data('url');
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: { status: newStatus },
                        success: function () {
                            // Update badge
                            $this.data('status', newStatus);
                            $this.text(newStatus.charAt(0).toUpperCase() + newStatus.slice(1));
                            if (newStatus === 'published') {
                                $this.removeClass('bg-red-100 text-red-700').addClass('bg-green-100 text-green-700');
                                showToast('Course has been published successfully.', 'success');
                            } else {
                                $this.removeClass('bg-green-100 text-green-700').addClass('bg-red-100 text-red-700');
                                showToast('Course has been drafted successfully.', 'error');
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

        function searchMemberCourse() {
            const searchInput = document.getElementById('search_member_course');
            const filter = searchInput.value.toLowerCase();
            const table = document.querySelector('#member_courses table');
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

        function searchCollaboratorCourse() {
            const searchInput = document.getElementById('search_collaborator_course');
            const filter = searchInput.value.toLowerCase();
            const table = document.querySelector('#collaborator_courses table');
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