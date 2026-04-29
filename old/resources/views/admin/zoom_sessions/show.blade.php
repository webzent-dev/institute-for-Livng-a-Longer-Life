<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="base-url" content="{{ url('/admin') }}">
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'Zoom Session Detail | Institute for Living Longer - Your Journey to Wellness')</title>
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
                            <x-button-use href="{{ route('admin.zoom-sessions') }}" variant="outline" icon="arrow-left" class=" bg-white h-10 w-10 pl-1 pr-0"/>
                            <div>
                                <h1 class="text-3xl font-bold text-left mb-0">Zoom Session Detail</h1>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <button type="button" onclick="deleteFromList('{{$zoomSessionDetail->id}}','zoom_session')" class="rounded-md flex items-center justify-center font-semibold gap-2 transition-all duration-150 select-none px-5 py-2 text-base h-10 border-2 border-primary text-primary hover:bg-primary hover:text-white font-semibold  text-[14px]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="trash2" aria-hidden="true" class="lucide lucide-trash2 w-5 h-5 mr-2"><path d="M10 11v6"></path>
                                    <path d="M14 11v6"></path>
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"></path>
                                    <path d="M3 6h18"></path>
                                    <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                </svg>
                                Delete
                            </button>
                            <button type="button" onclick="updateZoomSession()" class="rounded-md flex items-center justify-center font-semibold gap-2 transition-all duration-150 select-none px-5 py-2 text-base h-10 gradient-primary text-primary-foreground hover:opacity-90 shadow-medium font-semibold h-10 px-4 py-2  font-semibold  text-[14px]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="save" aria-hidden="true" class="lucide lucide-save w-5 h-5 mr-2">
                                    <path d="M15.2 3a2 2 0 0 1 1.4.6l3.8 3.8a2 2 0 0 1 .6 1.4V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2z"></path>
                                    <path d="M17 21v-7a1 1 0 0 0-1-1H8a1 1 0 0 0-1 1v7"></path>
                                    <path d="M7 3v4a1 1 0 0 0 1 1h7"></path>
                                </svg>
                                Save Changes
                            </button>
                            <form id="zoom_session_delete_form_{{$zoomSessionDetail->id}}" action="{{url('admin/zoom-sessions/'.$zoomSessionDetail->id)}}" method="POST">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </div>
                    
                    <!-- Zoom Session Detail Start -->
                    <div class="py-4 rounded-lg border bg-card text-card-foreground shadow-sm">
                        <div class="flex flex-col space-y-1.5 p-6">
                            <h3 class="text-2xl font-semibold leading-none tracking-tight">Zoom Session Information</h3>
                        </div>
                        <form method="POST" id="editZoomSessionForm" name="editZoomSessionForm" action="{{ route('admin.zoom-sessions.update', $zoomSessionDetail->id) }}" enctype="multipart/form-data" class="space-y-3 overflow-y-auto scrollbar-custom scroll-smooth px-5">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="zoom_session_id" value="{{ $zoomSessionDetail->id }}">
                            <x-form.input label="Session Title" type="text" name="session_title" value="{{ $zoomSessionDetail->session_title }}" placeholder="Enter session title*" autocomplete="off" required />
                            <div class="space-y-2">
                                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Description <span class="required" style="color: red;">*</span></label>
                                <textarea rows="3" name="description" placeholder="Enter description*" autocomplete="off" class="flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" required>{{ $zoomSessionDetail->description }}</textarea>
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-medium leading-none">Host <span class="required" style="color: red;">*</span></label>
                                <select name="host" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm" required>
                                    <option value="">Select Host</option>
                                    @foreach ($hosts as $host)
                                        <option value="{{ $host->id }}" @if($host->id == $zoomSessionDetail->host) selected @endif>{{ $host->first_name }} {{ $host->last_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="grid grid-cols-2 gap-4 mt-3">
                                <div class="space-y-2">
                                    <!-- <label for="date" class="text-sm font-medium">Date <span class="text-red-500">*</span></label>
                                    <input type="date" name="date" value="{{ \Carbon\Carbon::parse($zoomSessionDetail->date)->format('Y-m-d') }}" class="flex h-10 w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary" required> -->
                                    <x-form.input label="Date" type="date" name="date" value="{{ \Carbon\Carbon::parse($zoomSessionDetail->date)->format('Y-m-d') }}" placeholder="Select Date*" automcomplete="off" required  />
                                </div>
                                <div class="space-y-2">
                                    <x-form.input label="Time" type="time" name="time" value="{{ \Carbon\Carbon::parse($zoomSessionDetail->time)->format('H:i') }}" placeholder="Choose Time*" automcomplete="off" required />
                                </div>
                            </div>
                            <x-form.select label="Duration" name="duration" placeholder="Select Duration*" required
                                :selected="[$zoomSessionDetail->duration]"
                                :options="[
                                    ['value' => '30 minutes', 'label' => '30 minutes'],
                                    ['value' => '45 minutes', 'label' => '45 minutes'],
                                    ['value' => '60 minutes', 'label' => '1 hour'],
                                    ['value' => '90 minutes', 'label' => '1.5 hours'],
                                    ['value' => '120 minutes', 'label' => '2 hours'],
                                ]"
                            />
                            <x-form.input label="Zoom Meeting Link" type="text" name="meeting_link" value="{{ $zoomSessionDetail->meeting_link }}" placeholder="Enter Zoom Meeting Link*" autocomplete="off" required  />
                        </form>
                    </div>
                    <!-- Zoom Session Detail End -->
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
        function updateZoomSession() {
            document.getElementById('editZoomSessionForm').submit();
        }
        </script>
        <script src="{{asset('js/constraint.js')}}"></script>
        <script src="{{asset('js/common.js')}}"></script>
    </body>
</html>