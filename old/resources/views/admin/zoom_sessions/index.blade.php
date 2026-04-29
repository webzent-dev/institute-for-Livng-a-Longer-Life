<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="base-url" content="{{ url('/admin') }}">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Zoom Sessions Management | Living Longer a Life')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/alpinejs" defer></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
@if (session('success'))
<div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition class="fixed top-5 right-5 bg-green-600 text-white px-5 py-3 rounded-lg shadow-lg z-50">
    {{ session('success') }}
</div>
@endif
<div id="toast" class="hidden fixed top-5 right-5 px-5 py-3 rounded-lg shadow-lg text-white z-50"></div>
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
                        <h1 class="text-3xl font-bold text-left mb-0">Zoom Sessions Management</h1>
                        <p class="text-muted-foreground text-lg">Schedule and manage Zoom sessions for members</p>
                    </div>
                    <div class="right-3">
                        <x-button-use label="Schedule Session" variant="primary" icon="user-plus" @click="$dispatch('open-modal', 'add-session-modal')" />
                    </div>
                </div>

                <!--Add Session Modal Start-->
                <x-ui.modal name="add-session-modal" size="3xl" class="max-w-3xl sticky top-20">
                    <h2 class="text-lg font-semibold leading-none tracking-tight mb-2 text-left">Schedule New Zoom Session</h2>
                    <form method="POST" class="space-y-3 overflow-y-auto scrollbar-custom max-h-[60vh] scroll-smooth px-5 mb-6">
                        @csrf
                        <x-form.input label="Session Title" name="session_title" type="text" autocomplete="off" placeholder="Enter Session Title*" required />
                        <div class="space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Description <span class="required" style="color: red;">*</span></label>
                            <textarea rows="3" name="description" placeholder="Describe the session topic..." class="flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" required></textarea>
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-medium leading-none">Host <span class="required" style="color: red;">*</span></label>
                            <select name="host" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm" required>
                                <option value="">Select host</option>
                                @foreach ($hosts as $host)
                                    <option value="{{ $host->id }}">{{ $host->first_name }} {{ $host->last_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="grid grid-cols-2 gap-4 mt-3">
                            <div class="space-y-2">
                                <x-form.date-picker name="date" label="Date" placeholder="dd-mm-yyyy" autocomplete="off" required/>
                            </div>
                            <div class="space-y-2">
                                <x-form.time-picker name="time" label="Time" placeholder="02:15 PM" autocomplete="off" required/>
                            </div>
                        </div>
                        <x-form.select label="Duration" name="duration" placeholder="Select duration"
                            :options="[
                                ['value' => '30 minutes', 'label' => '30 minutes'],
                                ['value' => '45 minutes', 'label' => '45 minutes'],
                                ['value' => '60 minutes', 'label' => '1 hour'],
                                ['value' => '90 minutes', 'label' => '1.5 hours'],
                                ['value' => '120 minutes', 'label' => '2 hours'],
                            ]" :selected="['30 minutes']" required/>
                        <x-form.input label="Zoom Meeting Link" type="text" name="meeting_link" placeholder="Enter Zoom Meeting Link*" autocomplete="off" required  />
                        <x-button-use label="Schedule Session" type="submit" variant="primary"  class="w-full" icon="calendar"/>
                    </form>
                </x-ui.modal>
                <!--Add Session Modal End-->

                <!-- Edit / Schedule Session Modal Start -->
                <?php /*
                <div id="editScheduleSessionModal" class="fixed inset-0 z-50 hidden bg-black/50 flex items-center justify-center">
                    <!-- Modal Box -->
                    <div class="bg-white w-full max-w-3xl rounded-xl shadow-xl max-h-[90vh] flex flex-col">
                        <!-- Header -->
                        <div class="flex items-center justify-between px-6 py-4 border-b">
                            <h2 class="text-lg font-semibold leading-none tracking-tight mb-2 text-left">Schedule New Zoom Session</h2>
                            <button type="button" onclick="closeModal()" class="text-gray-500 hover:text-gray-700 text-xl">&times;</button>
                        </div>

                        <!-- Scrollable Body -->
                        <form id="editScheduleZoomSessionForm" method="POST" action="{{ route('admin.zoom-sessions.update') }}" class="space-y-3 overflow-y-auto scrollbar-custom max-h-[60vh] scroll-smooth px-5 mb-6">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="zoom_session_id" id="zoom_session_id">

                            <!-- Session Title -->
                            <div>
                                <label class="block text-sm font-medium mb-1">Session Title <span class="text-red-500">*</span></label>
                                <input type="text" name="session_title" id="session_title" class="w-full h-11 rounded-lg border border-gray-300 px-3 text-sm focus:ring-2 focus:ring-primary focus:outline-none" required>
                            </div>

                            <!-- Description -->
                            <div>
                                <label class="block text-sm font-medium mb-1">Description <span class="text-red-500">*</span></label>
                                <textarea rows="4" name="description" id="description" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-primary focus:outline-none" required></textarea>
                            </div>

                            <!-- Host -->
                            <div>
                                <label class="block text-sm font-medium mb-1">Host <span class="text-red-500">*</span></label>
                                <select name="host" id="host" class="w-full h-11 rounded-lg border border-gray-300 px-3 text-sm focus:ring-2 focus:ring-primary focus:outline-none" required>
                                    <option value="">Select host</option>
                                    @foreach ($hosts as $host)
                                        <option value="{{ $host->id }}">
                                            {{ $host->first_name }} {{ $host->last_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Date & Time -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium mb-1">Date <span class="text-red-500">*</span></label>
                                    <input type="date" name="date" id="date" class="w-full h-11 rounded-lg border border-gray-300 px-3 text-sm focus:ring-2 focus:ring-primary focus:outline-none" required>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium mb-1">Time <span class="text-red-500">*</span></label>
                                    <input type="time" name="time" id="time" class="w-full h-11 rounded-lg border border-gray-300 px-3 text-sm focus:ring-2 focus:ring-primary focus:outline-none" required>
                                </div>
                            </div>

                            <!-- Duration -->
                            <div>
                                <label class="block text-sm font-medium mb-1">Duration <span class="text-red-500">*</span></label>
                                <select name="duration" id="duration" class="w-full h-11 rounded-lg border border-gray-300 px-3 text-sm focus:ring-2 focus:ring-primary focus:outline-none" required>
                                    <option value="">Select Duration</option>
                                    <option value="30 minutes">30 minutes</option>
                                    <option value="45 minutes">45 minutes</option>
                                    <option value="60 minutes">1 hour</option>
                                    <option value="90 minutes">1.5 hours</option>
                                    <option value="120 minutes">2 hours</option>
                                </select>
                            </div>

                            <!-- Zoom Link -->
                            <div>
                                <label class="block text-sm font-medium mb-1">Zoom Meeting Link <span class="text-red-500">*</span></label>
                                <input type="text" name="meeting_link" id="meeting_link" class="w-full h-11 rounded-lg border border-gray-300 px-3 text-sm focus:ring-2 focus:ring-primary focus:outline-none" required>
                            </div>

                            <!-- Submit -->
                            <button type="submit" class="w-full bg-primary text-white py-3 rounded-lg font-medium hover:bg-accent transition">Save Changes</button>
                        </form>
                    </div>
                <!-- </x-ui.modal> -->
                </div>
                */?>
                <!-- Edit / Schedule Session Modal End -->


                <!--Save Recording Session Modal Start-->
                <!-- <x-ui.modal name="save-recording-modal" size="3xl" class="max-w-3xl sticky top-20">
                    <h2 class="text-lg font-semibold leading-none tracking-tight mb-2 text-left">Add Recording URL</h2>
                    <p class="text-muted-foreground">Add the recording URL for: <strong>Monthly Wellness Check-in</strong></p>
                    <form method="POST" action="#" class="space-y-3 overflow-y-auto scrollbar-custom max-h-[60vh] scroll-smooth px-5 mb-6">
                        <x-form.input label="Recording URL" type="text" name="recorded_link" placeholder="https://example.com/recording..."  required  />
                        <x-button-use label="Save Recording" type="submit" variant="primary"  class="w-full" icon="link"/>
                    </form>
                </x-ui.modal> -->
                
                <div id="uploadRecordingSessionModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50">
                    <div class="bg-white w-full max-w-3xl rounded-xl shadow-lg sticky top-20">
                        <button type="button" onclick="closeRecordingModal()" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-xl">&times;</button>
                        <div class="p-6 border-b">
                            <h2 class="text-lg font-semibold leading-none tracking-tight text-left">Add Recording URL</h2>
                            <p class="text-gray-500 mt-1">Add the recording URL for:<strong id="recording-title">Monthly Wellness Check-in</strong></p>
                        </div>
                        <!-- Modal Body -->
                        <form method="POST" action="{{ route('admin.zoom-sessions.save-recording') }}" class="space-y-4 overflow-y-auto scrollbar-custom max-h-[60vh] scroll-smooth px-6 py-4">
                            @csrf
                            <input type="hidden" name="zoom_session_table_id" id="zoom_session_table_id" value="">
                            <!-- Recording URL Input -->
                            <div class="space-y-2">
                                <label for="recorded_link" class="text-sm font-medium">Recording URL <span class="text-red-500">*</span></label>
                                <input type="text" name="recorded_link" id="recorded_link" placeholder="https://example.com/recording..." class="flex h-10 w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary" required>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="w-full bg-primary text-white py-2.5 rounded-lg font-medium hover:bg-accent transition flex items-center justify-center gap-2">
                                <!-- Link Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"  fill="none"  viewBox="0 0 24 24"  stroke="currentColor">
                                    <path stroke-linecap="round"  stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 010 5.656l-2 2a4 4 0 01-5.656-5.656l1.414-1.414M10.172 13.828a4 4 0 010-5.656l2-2a4 4 0 115.656 5.656l-1.414 1.414"/>
                                </svg>
                                Save Recording
                            </button>
                        </form>
                    </div>
                </div>
                <!--Save Recording Session Modal End-->

                <!-- Tabs -->
                <div dir="ltr" data-orientation="horizontal" class="mt-6">
                    <div role="tablist" aria-orientation="horizontal" class="grid h-10 w-full grid-cols-2 items-center justify-center rounded-md bg-muted p-1 text-muted-foreground"tabindex="0">
                        <button role="tab" aria-selected="true" data-state="active" data-tab="upcoming" aria-controls="members" type="button" class="inline-flex items-center justify-center rounded-sm px-3 py-1.5 text-sm font-medium transition-all data-[state=active]:bg-background data-[state=active]:text-foreground data-[state=active]:shadow-sm">
                            Upcoming Sessions ({{ count($zoom_sessions) }})
                        </button>
                        <button role="tab" aria-selected="false" data-state="inactive" data-tab="recordings" aria-controls="collaborators" type="button" class="inline-flex items-center justify-center rounded-sm px-3 py-1.5 text-sm font-medium transition-all">
                            Recordings ({{ count($recordings) }})
                        </button>
                    </div>
                </div>

                <!-- TAB CONTENT -->
                <div id="upcoming" class="tab-content mt-2">
                    <div class="rounded-lg border bg-card shadow-sm">
                        <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
                            <div class="flex flex-col space-y-1.5 p-6">
                                <h3 class="text-2xl font-semibold leading-none tracking-tight">Upcoming Sessions</h3>
                            </div>
                            <!-- Table Container -->
                            <div class="p-6 pt-0">
                                <div class="relative w-full overflow-auto">
                                    <table class="w-full caption-bottom text-sm">
                                        <thead class="[&_tr]:border-b">
                                            <tr class="border-b transition-colors data-[state=selected]:bg-muted hover:bg-muted/50">
                                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Title</th>
                                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Host</th>
                                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Date &amp; Time</th>
                                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Duration</th>
                                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Status</th>
                                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="[&_tr:last-child]:border-0">
                                            @forelse($zoom_sessions as $key => $zoom_session)
                                            <tr class="border-b transition-colors data-[state=selected]:bg-muted hover:bg-muted/50">
                                                <td class="p-4 align-middle font-medium">{{ $zoom_session->session_title }}</td>
                                                <td class="p-4 align-middle">
                                                    <div class="flex items-center gap-2">
                                                        @php 
                                                           $hostDetail = DB::table('users')->where('id', $zoom_session->host)->first();
                                                        @endphp
                                                        {{ $hostDetail->first_name }} {{ $hostDetail->last_name }}
                                                        <!-- <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold border-transparent bg-primary text-primary-foreground">
                                                            Institute
                                                        </div> -->
                                                    </div>
                                                </td>
                                                <td class="p-4 align-middle">{{ $zoom_session->date . ' ' . $zoom_session->time }}</td>
                                                <td class="p-4 align-middle">{{ $zoom_session->duration }}</td>
                                                <td class="p-4 align-middle">
                                                    <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold border-transparent bg-green-500 text-primary-foreground">
                                                        Scheduled
                                                    </div>
                                                </td>
                                                <td class="p-4 align-middle">
                                                    <div class="flex gap-2">
                                                        <!-- <button class="inline-flex items-center justify-center h-9 px-3 rounded-md border-2 border-primary bg-background text-primary hover:bg-primary hover:text-primary-foreground" onclick="editScheduleSessionModal({{ $zoom_session->id }},'{{ $zoom_session->session_title }}','{{ $zoom_session->description }}','{{ $zoom_session->host }}','{{ $zoom_session->date }}','{{ $zoom_session->time }}','{{ $zoom_session->duration }}','{{ $zoom_session->meeting_link }}')" >
                                                            <svg class="lucide lucide-pencil h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                                <path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"/>
                                                                <path d="m15 5 4 4"/>
                                                            </svg>
                                                        </button> -->
                                                        <x-button-use href="{{url('admin/zoom-sessions/'.$zoom_session->id)}}" label="View" variant="outline" icon="eye" class="pl-0 pr-0 w-24 h-10"/>
                                                        <!-- Upload -->
                                                        <button class="inline-flex items-center justify-center h-9 px-3 rounded-md border-2 border-primary bg-background text-primary hover:bg-primary hover:text-primary-foreground" onclick="uploadRecordingSessionModal({{ $zoom_session->id}},'{{ $zoom_session->session_title }}')">
                                                            <svg class="lucide lucide-upload h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                                                <polyline points="17 8 12 3 7 8"/>
                                                                <line x1="12" y1="3" x2="12" y2="15"/>
                                                            </svg>
                                                        </button>
                                                        <!-- Delete -->
                                                        <button class="inline-flex items-center justify-center h-9 px-3 rounded-md hover:bg-accent" onclick="deleteFromList('{{$zoom_session->id}}','zoom_session')">
                                                            <svg class="lucide lucide-trash2 h-4 w-4 text-destructive" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                                <path d="M3 6h18"/>
                                                                <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/>
                                                                <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/>
                                                                <line x1="10" y1="11" x2="10" y2="17"/>
                                                                <line x1="14" y1="11" x2="14" y2="17"/>
                                                            </svg>
                                                        </button>
                                                        <form id="zoom_session_delete_form_{{$zoom_session->id}}" action="{{url('admin/zoom-sessions/'.$zoom_session->id)}}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="7" class="p-4 text-center text-muted-foreground">
                                                    No upcoming sessions found.
                                                </td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="recordings" class="tab-content mt-2 hidden">
                    <div class="rounded-lg border bg-card shadow-sm">
                        <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
                            <div class="flex flex-col space-y-1.5 p-6">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <h3 class="text-2xl font-semibold leading-none tracking-tight mb-0">Session Recordings</h3>
                                    </div>
                                </div>
                            </div>
                            <!-- Table -->
                            <div class="p-6 pt-0">
                                <div class="relative w-full overflow-auto">
                                    <table class="w-full caption-bottom text-sm">
                                        <thead class="[&_tr]:border-b">
                                            <tr class="border-b transition-colors data-[state=selected]:bg-muted hover:bg-muted/50">
                                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Title</th>
                                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Host</th>
                                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Date</th>
                                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Attendees</th>
                                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Recording</th>
                                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="[&_tr:last-child]:border-0">
                                            @forelse ($recordings as $key => $recording)
                                            <tr class="border-b transition-colors data-[state=selected]:bg-muted hover:bg-muted/50">
                                                <td class="p-4 align-middle font-medium">{{$recording->zoomSession->session_title}}</td>
                                                <td class="p-4 align-middle">
                                                    <div class="flex items-center gap-2">
                                                        @php 
                                                           $hostDetail = DB::table('users')->where('id', $recording->zoomSession->host)->first();
                                                        @endphp
                                                        {{ $hostDetail->first_name }} {{ $hostDetail->last_name }}
                                                        <!-- <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold border-transparent bg-primary text-primary-foreground">
                                                        Institute
                                                        </div> -->
                                                    </div>
                                                </td>
                                                <td class="p-4 align-middle">{{$recording->zoomSession->date}}</td>
                                                <td class="p-4 align-middle">0</td>
                                                <td class="p-4 align-middle">
                                                    <a href="{{$recording->recorded_link}}" target="_blank" rel="noopener noreferrer" class="flex items-center gap-1 text-primary hover:underline">
                                                        <svg class="lucide lucide-video h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                            <path d="m16 13 5.223 3.482a.5.5 0 0 0 .777-.416V7.87a.5.5 0 0 0-.752-.432L16 10.5"></path>
                                                            <rect x="2" y="6" width="14" height="12" rx="2"></rect>
                                                        </svg>View
                                                    </a>
                                                </td>
                                                <td class="p-4 align-middle">
                                                    <button class="inline-flex items-center justify-center h-9 px-3 rounded-md hover:bg-accent hover:text-accent-foreground" onclick="deleteFromList('{{$recording->id}}','zoom_session_recorded_links')">
                                                        <svg class="lucide lucide-trash2 h-4 w-4 text-destructive" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                            <path d="M3 6h18"></path>
                                                            <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                                                            <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                                                            <line x1="10" y1="11" x2="10" y2="17"></line>
                                                            <line x1="14" y1="11" x2="14" y2="17"></line>
                                                        </svg>
                                                    </button>
                                                    <form id="zoom_session_recorded_links_delete_form_{{$recording->id}}" action="{{url('admin/delete-recording-session/'.$recording->id)}}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="7" class="p-4 text-center text-muted-foreground">
                                                    No recordings found
                                                </td>
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

/*
function editScheduleSessionModal(id, session_title, description, host, date, time, duration, meeting_link) {
    document.getElementById('zoom_session_id').value = id;
    document.getElementById('session_title').value = session_title;
    document.getElementById('description').value = description;
    document.getElementById('host').value = host;
    document.getElementById('date').value = date;
    document.getElementById('time').value = time;
    document.getElementById('duration').value = duration;
    document.getElementById('meeting_link').value = meeting_link;
    document.getElementById('editScheduleSessionModal').classList.remove('hidden');
    document.getElementById('editScheduleSessionModal').classList.add('flex');
    document.body.classList.add('overflow-hidden');
}

function closeModal() {
    document.getElementById('editScheduleSessionModal').classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
}

// Close when clicking outside modal
document.getElementById('editScheduleSessionModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});*/

function uploadRecordingSessionModal(id,session_title) {
    document.getElementById('zoom_session_table_id').value = id;
    $('#recording-title').text(session_title);
    document.getElementById('uploadRecordingSessionModal').classList.remove('hidden');
    document.getElementById('uploadRecordingSessionModal').classList.add('flex');
}

function closeRecordingModal() {
    document.getElementById('uploadRecordingSessionModal').classList.add('hidden');
    document.getElementById('uploadRecordingSessionModal').classList.remove('flex');
}

// Close when clicking outside modal
document.getElementById('uploadRecordingSessionModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeRecordingModal();
    }
});

// Close on ESC key
document.addEventListener('keydown', function(e) {
    if (e.key === "Escape") {
        closeRecordingModal();
        closeModal();
    }
});
</script>
<script src="{{asset('js/constraint.js')}}"></script>
<script src="{{asset('js/common.js')}}"></script>
</body>
</html>