<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Profile Settings')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/alpinejs" defer></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body x-data="{ sidebarOpen: true, mobileSidebar: false }" class="bg-slate-100 antialiased">

{{-- Success Toast --}}
@if (session('success'))
<div 
    x-data="{ show: true }"
    x-init="setTimeout(() => show = false, 3000)"
    x-show="show"
    x-transition
    class="fixed top-5 right-5 bg-green-600 text-white px-5 py-3 rounded-xl shadow-lg z-50"
>
    {{ session('success') }}
</div>
@endif

<div class="flex min-h-screen">
    <x-dashboard.sidebar.sidebar />

    <div class="flex-1 flex flex-col">
        <x-dashboard.sidebar.header />

        <!-- MAIN CONTENT -->
        <main class="flex-1 p-4 md:p-8 overflow-y-auto">
           <div class="bg-white rounded-3xl shadow-sm border border-gray-200 p-8">
    <div class="flex flex-col lg:flex-row items-center gap-8">

        <!-- Left: Avatar + Info -->
        <div class="flex flex-col md:flex-row items-center md:items-start gap-6 flex-1">

            <!-- Avatar -->
            <div class="relative">
                <div class="w-28 h-28 rounded-full 
                            bg-gradient-to-br from-indigo-500 to-blue-600
                            text-white flex items-center justify-center 
                            text-4xl font-semibold 
                            ring-4 ring-indigo-100 shadow">
                    {{ strtoupper(substr(auth()->user()->first_name ?? auth()->user()->name, 0, 1)) }}
                </div>

                <!-- Online Status -->
                <span class="absolute bottom-1 right-1 w-4 h-4 bg-green-500 border-2 border-white rounded-full"></span>
            </div>

            <!-- User Info -->
            <div class="text-center md:text-left space-y-1">
                <h2 class="text-xl font-semibold text-gray-900">
                    {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}
                </h2>

                <p class="text-gray-500 flex items-center justify-center md:justify-start gap-2 text-sm">
                    <i data-lucide="mail" class="w-4 h-4"></i>
                    {{ ucfirst(auth()->user()->email) }}
                </p>

                <!-- Meta Info -->
                <div class="flex flex-wrap justify-center md:justify-start gap-4 pt-3 text-sm text-gray-500">
                    <div class="flex items-center gap-1">
                        <i data-lucide="user" class="w-4 h-4"></i>
                        {{ ucfirst(auth()->user()->role) }}
                    </div>
                    <div class="flex items-center gap-1">
                        <i data-lucide="calendar" class="w-4 h-4"></i>
                        Joined {{ auth()->user()->created_at->format('M Y') }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Demo Image / Placeholder -->
        <div class="flex-shrink-0">
            <div class="w-40 h-40 rounded-2xl 
                        bg-slate-50 border border-dashed border-gray-300 
                        flex flex-col items-center justify-center 
                        text-gray-400 hover:bg-slate-100 transition">
                
                <i data-lucide="image" class="w-10 h-10 mb-2"></i>
                <span class="text-xs text-center">
                    Profile Image<br>Coming Soon
                </span>
            </div>
        </div>

    </div>
</div>



                <!-- Update Profile -->
                <div class="bg-white rounded-3xl shadow border p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-6 flex items-center gap-2">
                        <i data-lucide="user-cog" class="w-5 h-5 text-indigo-600"></i>
                        Update Profile
                    </h2>

    <form action="{{ route('profile.update') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
     @csrf
     @method('PUT')
    <!-- Name -->
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-2">
            Full Name
        </label>
        <input
            type="text" name="first_name" value="{{ old('first_name', auth()->user()->first_name) }}" placeholder="Enter your first name" class="w-full h-11 px-4 rounded-lg 
                   bg-gray-50 border border-gray-300 
                   text-gray-800 placeholder-gray-400
                   focus:bg-white focus:border-indigo-500 
                   focus:ring-2 focus:ring-indigo-200
                   transition"
            required
        >
    </div>

    <!-- Email -->
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-2">
            Last Name
        </label>
        <input
            type="text"
            name="last_name"
            value="{{ old('last_name', auth()->user()->last_name) }}"
            placeholder="Enter your last name"
            class="w-full h-11 px-4 rounded-lg 
                   bg-gray-50 border border-gray-300 
                   text-gray-800 placeholder-gray-400
                   focus:bg-white focus:border-indigo-500 
                   focus:ring-2 focus:ring-indigo-200
                   transition"
            required
        >
    </div>

    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-2">
           Email Address
        </label>
        <input
            type="text" name="email" value="{{ old('email', auth()->user()->email) }}" placeholder="Enter your email address" class="w-full h-11 px-4 rounded-lg 
                   bg-gray-50 border border-gray-300 
                   text-gray-800 placeholder-gray-400
                   focus:bg-white focus:border-indigo-500 
                   focus:ring-2 focus:ring-indigo-200
                   transition"
            required
        >
    </div>

    <!-- Email -->
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-2">
           Phone
        </label>
        <input
            type="tel"
            name="phone"
            value="{{ old('phone', auth()->user()->phone) }}"
            placeholder="Enter your phone number"
            class="w-full h-11 px-4 rounded-lg 
                   bg-gray-50 border border-gray-300 
                   text-gray-800 placeholder-gray-400
                   focus:bg-white focus:border-indigo-500 
                   focus:ring-2 focus:ring-indigo-200
                   transition"
            required
        >
    </div>

    <!-- Password -->


    <!-- Save Button -->
    <div class="md:col-span-2 flex justify-end pt-6">
        <button
            type="submit"
            class="flex items-center gap-2 px-7 py-2.5 
                   bg-indigo-600 text-white font-medium 
                   rounded-lg hover:bg-indigo-700 
                   shadow-sm hover:shadow-md transition"
        >
            <i data-lucide="save" class="w-7 h-7"></i>
            Update Profile
        </button>
    </div>
</form>
                </div>

            </div>
        </main>
    </div>
</div>

<x-dashboard.sidebar.mobile-sidebar />

<script>
    lucide.createIcons();
</script>
</body>
</html>


 
<x-dashboard.sidebar.mobile-sidebar />

<script>lucide.createIcons()</script>
</body>
</html>
