<!DOCTYPE html>
{{-- <html lang="en"> --}}
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
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
    class="fixed top-5 right-5 bg-green-600 text-white px-5 py-3 rounded-lg shadow-lg z-50">
    {{ session('success') }}
</div>
@endif

<div id="toast" class="hidden fixed top-5 right-5 px-5 py-3 rounded-lg shadow-lg text-white z-50"></div>
<body  x-data="{  sidebarOpen: true,  mobileSidebar: false  }"  class="bg-slate-50 antialiased">
    <div class="flex min-h-screen">
        <x-dashboard.sidebar.sidebar />
        <div class="flex-1 flex flex-col">
            <x-dashboard.sidebar.header />
            <main class="flex-1 p-4 md:p-6 overflow-y-auto scrollbar-custom ">
                <div class="p-6 bg-gray-50 min-h-screen">
                    <!-- Header -->
                    <div class="flex items-center justify-between mb-5">
                        <h1 class="text-2xl font-semibold">Web Settings</h1>
                        <h1 class="text-2xl font-semibold">Update your website contents</h1>
                    </div>
                    @php
                        $settings = App\Models\WebSetting::find(1);
                    @endphp
                    <div class="max-w-4xl mx-auto p-6 bg-white shadow-sm rounded-lg">
                        <form method="POST" action="{{ route('admin.web.settings.update') }}" enctype="multipart/form-data" class="space-y-5">
                            @csrf 
                            <!-- Logo Upload -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="">
                                    <x-form.input name="logo" type="file"   />
                                </div>
                                <img src="{{ asset('storage/'.($settings->logo ?? 'logo.png')) }}" alt="Logo" class="w-12 h-12 ml-2">  
                            </div>

                            <!-- Phone + Email -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <x-form.input name="phone" :value="old('phone', ($settings->phone ?? ''))"  required placeholder="Phone Number" />
                                <x-form.input name="email" :value="old('email', ($settings->email ?? ''))" required placeholder="Email Address" />
                            </div>

                            <!-- Address -->
                            <div class="space-y-4">
                                <x-form.input name="address" :value="old('address', ($settings->address ?? ''))" required placeholder="Office Address" />
                                <x-form.input name="footer_content" :value="old('footer_content', ($settings->footer_content ?? ''))" required placeholder="Website footer content" />
                            </div>

                            <!-- Social Links -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <x-form.input name="facebook" :value="old('facebook', ($settings->facebook ?? ''))" required placeholder="Facebook URL" />
                                <x-form.input name="twitter" :value="old('twitter', ($settings->twitter ?? ''))" required placeholder="Twitter URL" />
                                <x-form.input name="instagram" :value="old('instagram', ($settings->instagram ?? ''))" required placeholder="Instagram URL" />
                                <x-form.input name="linkedin" :value="old('linkedin', ($settings->linkedin ?? ''))" required placeholder="LinkedIn URL" />
                            </div>

                            <!-- Logo Content -->
                            <div>
                                <x-form.textarea name="logo_content" :value="old('logo_content', ($settings->logo_content ?? ''))" rows="4" placeholder="About your company / footer text..." required />
                            </div>

                            <!-- Submit Button -->
                            <div class="pt-2">
                                <x-button-use type="submit" label="Update" variant="outline" icon="send" class="" />
                            </div>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div> 
</body>
</html> 