<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Video Testimonial Detail | Living a Longer Life')</title>
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
                        <x-button-use href="{{route('admin.video-testimonials')}}" variant="outline" icon="arrow-left" class=" bg-white h-10 w-10 pl-1 pr-0"/>
                    <div>
                        <h1 class="text-3xl font-bold text-left mb-0">Video Testimonial Detail</h1>
                        <p class="text-muted-foreground text-lg">View and manage video testimonial information</p>
                    </div>
                </div>
                <div class="flex gap-2">
                    <!-- <x-button-use label="Delete" variant="outline" icon="trash2" />
                    <x-button-use label="Save Changes" variant="primary" icon="save" /> -->
                    <button type="button" onclick="deleteFromList('{{$testimonialDetail->id}}','video_testimonial')" class="rounded-md flex items-center justify-center font-semibold gap-2 transition-all duration-150 select-none px-5 py-2 text-base h-10 border-2 border-primary text-primary hover:bg-primary hover:text-white font-semibold  text-[14px]">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="trash2" aria-hidden="true" class="lucide lucide-trash2 w-5 h-5 mr-2"><path d="M10 11v6"></path>
                            <path d="M14 11v6"></path>
                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"></path>
                            <path d="M3 6h18"></path>
                            <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                        </svg>
                        Delete
                    </button>
                    <button type="button" onclick="updateTestimonial()" class="rounded-md flex items-center justify-center font-semibold gap-2 transition-all duration-150 select-none px-5 py-2 text-base h-10 gradient-primary text-primary-foreground hover:opacity-90 shadow-medium font-semibold h-10 px-4 py-2  font-semibold  text-[14px]">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="save" aria-hidden="true" class="lucide lucide-save w-5 h-5 mr-2">
                            <path d="M15.2 3a2 2 0 0 1 1.4.6l3.8 3.8a2 2 0 0 1 .6 1.4V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2z"></path>
                            <path d="M17 21v-7a1 1 0 0 0-1-1H8a1 1 0 0 0-1 1v7"></path>
                            <path d="M7 3v4a1 1 0 0 0 1 1h7"></path>
                        </svg>
                        Save Changes
                    </button>
                    <form id="video_testimonial_delete_form_{{$testimonialDetail->id}}" action="{{url('admin/video-testimonials/'.$testimonialDetail->id)}}" method="POST">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>

            <!-- Video Testimonial Information -->
            <div class="py-4 rounded-lg border bg-card text-card-foreground shadow-sm">
                <div class="flex flex-col space-y-1.5 p-6">
                    <h3 class="text-2xl font-semibold leading-none tracking-tight">Video Testimonial Information</h3>
                </div>

                <!-- FORM -->
                <form method="POST" id="editTestimonialForm" name="editTestimonialForm" action="{{ route('admin.video-testimonials.update', $testimonialDetail->id) }}" class="space-y-3 scroll-smooth px-5" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="testmonial_id" value="{{ $testimonialDetail->id }}">
                    <div class="grid grid-cols-2 gap-4 mt-3">
                        <div class="space-y-2">
                            <x-form.input label="Name" type="text" name="name" value="{{ $testimonialDetail->name }}" placeholder="Enter Name*" autocomplete="off" required  />
                        </div>
                        <div class="space-y-2">
                            <x-form.input label="Video URL" type="url" name="video_url" id="video_url" value="{{ $testimonialDetail->video_url }}" autocomplete="off" placeholder="Enter Video URL*" required />
                        </div>
                        <div class="space-y-2">
                            <x-form.input label="Quote" type="text" name="quote" value="{{ $testimonialDetail->quote }}" placeholder="Enter Quote*" autocomplete="off" required  />
                        </div>
                        <div class="space-y-2 z-0">
                            <x-form.select label="Status*" name="is_active" placeholder="Select Status" required
                            :options="[
                                ['value' => 1, 'label' => 'Active'],
                                ['value' => 0, 'label' => 'Inactive'],
                            ]"
                            :selected="[$testimonialDetail->is_active]"
                            />
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Thumbnail</label>
                            <div class="rounded-lg border-2 border-dashed p-4">
                                <input type="file" name="thumbnail" id="thumbnail" accept="image/*" class="hidden" />
                                <div id="image-count" class="text-sm text-primary mt-2 hidden"></div>
                                <label for="thumbnail" class="flex cursor-pointer flex-col items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="mb-2 h-8 w-8 text-muted-foreground" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                        <polyline points="17 8 12 3 7 8" />
                                        <line x1="12" y1="3" x2="12" y2="15" />
                                    </svg>
                                    <span class="text-sm text-muted-foreground">Click to upload images</span>
                                    <span class="text-xs text-muted-foreground">PNG, JPG up to 5MB each</span>
                                </label>
                            </div>
                            <!--Show uploaded favicon preview-->
                            <div class="mt-4">
                                @if(!empty($testimonialDetail->thumbnail) && file_exists(public_path('testimonial_images/'.$testimonialDetail->thumbnail)))
                                    <img src="{{ asset('testimonial_images/'.$testimonialDetail->thumbnail) }}" alt="{{$testimonialDetail->name}}" class="mx-auto h-20 object-contain" id="thumbnail-preview-img"/>
                                @else
                                    <img src="#" alt="Testimonial Image" class="mx-auto h-20 object-contain hidden" id="thumbnail-preview-img"/>
                                @endif
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </main>
    </div>
    @yield('content')
    </div>
</div>
<x-dashboard.sidebar.mobile-sidebar />
<script>lucide.createIcons()</script>
<script>
function updateTestimonial() {
    document.getElementById('editTestimonialForm').submit();
}

document.getElementById('thumbnail').addEventListener('change', function(event) {
    //remove class hidden from og image preview img
    document.getElementById('thumbnail-preview-img').classList.remove('hidden');

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
            document.getElementById('thumbnail-preview-img').src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
});
</script>
<script src="{{asset('js/constraint.js')}}"></script>
<script src="{{asset('js/common.js')}}"></script>
</body>
</html>