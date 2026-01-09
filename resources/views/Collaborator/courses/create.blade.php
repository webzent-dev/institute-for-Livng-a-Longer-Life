<!DOCTYPE html>
{{-- <html lang="en"> --}}
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/alpinejs" defer></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

@if (session('success'))
<div 
    x-data="{ show: true }"
    x-init="setTimeout(() => show = false, 3000)"
    x-show="show"
    x-transition
    class="fixed top-5 right-5 bg-green-600 text-white px-5 py-3 rounded-lg shadow-lg z-50"
>
    {{ session('success') }}
</div>
@endif
<body  x-data="{  sidebarOpen: true,  mobileSidebar: false  }"  class="bg-slate-50 antialiased">
<div class="flex min-h-screen">
    <x-dashboard.sidebar.sidebar />
    <div class="flex-1 flex flex-col">
     <x-dashboard.sidebar.header />

        <main class="flex-1 p-4 md:p-6 overflow-y-auto">
        <!-- Main Content -->
        <main class="flex-1 p-4 md:p-6 overflow-y-auto scrollbar-custom ">
             <div class="bg-white rounded-2xl shadow p-6">

    <!-- Header -->
  <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow p-6">

    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">
            {{ isset($course) ? 'Edit Course' : 'Add Course' }}
        </h2>

        <a href="{{ route('courses.index') }}"
           class="text-sm text-gray-600 hover:text-gray-900">
            ← Back
        </a>
    </div>
    <!-- Form -->
<form
    action="{{ isset($course) ? route('courses.update', $course->id) : route('courses.store') }}"
method="POST">
@csrf
@if(isset($course))
    @method('PUT')
@endif
    <!-- REQUIRED DEFAULT VALUES -->
    <input type="hidden" name="status" value="{{ old('status', $course->status ?? 'draft') }}">
    <input type="hidden" name="approval_status" value="{{ old('approval_status', $course->approval_status ?? 'pending') }}">
    <input type="hidden" name="published" value="{{ old('published', $course->published ?? 0) }}">

    <!-- Row 1 -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Title -->
        <div>
            <label class="block text-sm font-medium mb-1">Title</label>
            <input type="text" name="title"
                value="{{ old('title', $course->title ?? '') }}"
                class="w-full border rounded-lg px-4 py-2" required>
            @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Duration -->
        <div>
            <label class="block text-sm font-medium mb-1">Duration</label>
            <input type="text" name="duration"
                placeholder="e.g. 8:45"
                value="{{ old('duration', $course->duration ?? '') }}"
                class="w-full border rounded-lg px-4 py-2">
        </div>
    </div>

    <!-- Row 2 -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Instructor -->
        <div>
            <label class="block text-sm font-medium mb-1">Instructor</label>
            <input type="text" name="instructor"
                value="{{ old('instructor', $course->instructor ?? '') }}"
                class="w-full border rounded-lg px-4 py-2">
        </div>

        <!-- Category -->
        <div>
            <label class="block text-sm font-medium mb-1">Category</label>
            <input type="text" name="category"
                value="{{ old('category', $course->category ?? '') }}"
                class="w-full border rounded-lg px-4 py-2">
        </div>
    </div>

    <!-- Description -->
    <div>
        <label class="block text-sm font-medium mb-1">Description</label>
        <textarea name="description" rows="4"
            class="w-full border rounded-lg px-4 py-2">{{ old('description', $course->description ?? '') }}</textarea>
    </div>

    <!-- Row 3 -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Video Upload -->
        <div>
            <label class="block text-sm font-medium mb-1">Upload Video</label>
            <input type="file" name="video_file" accept="video/*"
                class="w-full border rounded-lg px-4 py-2">
            <p class="text-xs text-gray-500 mt-1">MP4 / WebM</p>

            @if(!empty($course->video_file))
                <p class="text-xs text-green-600 mt-1">✔ Existing video uploaded</p>
            @endif
        </div>

        <!-- Video URL -->
        <div>
            <label class="block text-sm font-medium mb-1">Video URL</label>
            <input type="url" name="video_url"
                placeholder="https://youtube.com/..."
                value="{{ old('video_url', $course->video_url ?? '') }}"
                class="w-full border rounded-lg px-4 py-2">
        </div>
    </div>

    <!-- Row 4 -->
    <div class="flex items-center gap-3">
        <input type="checkbox" name="featured" value="1"
            {{ old('featured', $course->featured ?? false) ? 'checked' : '' }}
            class="rounded border-gray-300">
        <span class="text-sm font-medium">Featured Course</span>
    </div>

    <!-- Buttons -->
    <div class="flex justify-end gap-3 pt-6 border-t">
        <button type="reset"
            class="px-4 py-2 rounded-lg border text-gray-700 hover:bg-gray-50">
            Reset
        </button>

        <button type="submit"
            class="px-6 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700">
            {{ isset($course) ? 'Update Course' : 'Save Course' }}
        </button>
    </div>

</form>


</div>


        </main>

               
           

            @yield('content')
            
        </main>
    </div>
</div>

 
<x-dashboard.sidebar.mobile-sidebar />

<script>lucide.createIcons()</script>
</body>
</html>



