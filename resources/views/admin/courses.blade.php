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
       
<div class="bg-white rounded-2xl shadow p-6">

    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">Courses</h2>

        <!-- Add Course Button -->
        <!-- <a href="{{ route('courses.create') }}"
           class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
            <i data-lucide="plus"></i>
            Add Course
        </a> -->
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden">
            <thead class="bg-gray-100 text-gray-700 text-sm">
                <tr>
                    <th class="px-4 py-3 text-left">ID</th>
                    <th class="px-4 py-3 text-left">Title</th>
                    <th class="px-4 py-3 text-left">Duration</th>
                    <th class="px-4 py-3 text-left">Instructor</th>
                    <th class="px-4 py-3 text-left">Category</th>
                    <th class="px-4 py-3 text-left">Featured</th>
                    <th class="px-4 py-3 text-left">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y text-sm">

           @foreach ($courses as $key => $course)
<tr class="hover:bg-gray-50">
    <td class="px-4 py-3">{{ $key + 1 }}</td>
    
    <td class="px-4 py-3 font-medium">
        {{ $course->title }}
    </td>

    <td class="px-4 py-3">
        {{ $course->duration ?? 'N/A' }}
    </td>

    <td class="px-4 py-3">
        {{ $course->instructor ?? 'N/A' }}
    </td>

    <td class="px-4 py-3">
        {{ $course->category ?? 'N/A' }}
    </td>

    <td class="px-4 py-3">
        <span class="px-2 py-1 text-xs rounded
            {{ $course->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
            {{ ucfirst($course->status ?? 'No') }}
        </span>
    </td>

   <td class="px-4 py-3 flex gap-3">

    <!-- Edit Icon -->
    <!-- <a href="{{ route('courses.edit', $course->id) }}"
       class="text-blue-600 hover:text-blue-800"
       title="Edit">
        <svg xmlns="http://www.w3.org/2000/svg"
             class="h-5 w-5"
             viewBox="0 0 20 20"
             fill="currentColor">
            <path d="M17.414 2.586a2 2 0 010 2.828l-10 10a2 2 0 01-.708.414l-5 1a1 1 0 01-1.212-1.212l1-5a2 2 0 01.414-.708l10-10a2 2 0 012.828 0zM15 5l-1-1L4 14v1h1L15 5z"/>
        </svg>
    </a> -->

    <!-- Delete Icon -->
    <form action="{{ route('courses.destroy', $course->id) }}" method="POST" 
          onsubmit="return confirm('Are you sure you want to delete this course?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="text-red-600 hover:text-red-800" title="Delete">
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="h-5 w-5"
                 viewBox="0 0 20 20"
                 fill="currentColor">
                <path fill-rule="evenodd"
                      d="M8.257 3.099c.366-.446.958-.446 1.324 0l.917 1.112h5.502a.75.75 0 010 1.5h-1.26l-.345 10.448a2 2 0 01-2 1.952H6.14a2 2 0 01-2-1.952L3.795 5.711H2.535a.75.75 0 010-1.5h5.502l.22-.267z"
                      clip-rule="evenodd"/>
            </svg>
        </button>
    </form>

</td>

</tr>
@endforeach

            </tbody>
        </table>
    </div>

</div>
               
           

            @yield('content')
            
        </main>
    </div>
</div>

 
<x-dashboard.sidebar.mobile-sidebar />

<script>lucide.createIcons()</script>
</body>
</html>
