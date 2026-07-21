@extends('member.member')
@section('member-content')
<main class="bg-white text-foreground p-6">
    {{-- Cards --}}
    <div class="">
        <div>
            <h1 class="text-3xl font-bold text-foreground text-left">Dashboard</h1>
            <p class="text-muted-foreground ">Welcome back! Access your membership benefits below.</p>
        </div>
        <!-- Feature Cards Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <!-- Video Library -->
            <div class="rounded-lg border bg-card text-card-foreground shadow-sm hover:shadow-md transition-shadow cursor-pointer">
                <div class="flex flex-col space-y-1.5 p-6">
                    <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-video h-6 w-6 text-primary">
                            <path d="m16 13 5.223 3.482a.5.5 0 0 0 .777-.416V7.87a.5.5 0 0 0-.752-.432L16 10.5"></path>
                            <rect x="2" y="6" width="14" height="12" rx="2"></rect>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-semibold leading-none tracking-tight">Video Library</h3>
                    <p class="text-base text-muted-foreground mt-1">Access all educational videos and wellness content</p>
                </div>
                <div class="p-6 pt-0">
                    <a href="{{url('/member/video-library')}}">
                        <button class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 bg-primary text-primary-foreground hover:bg-primary/90 shadow-sm h-10 px-4 py-2 w-full">View Videos</button>
                    </a>
                </div>
            </div>

            <!-- Member Store -->
            <div class="rounded-lg border bg-card text-card-foreground shadow-sm hover:shadow-md transition-shadow cursor-pointer">
                <div class="flex flex-col space-y-1.5 p-6">
                    <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shopping-bag h-6 w-6 text-primary">
                            <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"></path>
                            <path d="M3 6h18"></path>
                            <path d="M16 10a4 4 0 0 1-8 0"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-semibold leading-none tracking-tight">Member Store</h3>
                    <p class="text-base text-muted-foreground mt-1">Browse products with exclusive member discounts</p>
                </div>
                <div class="p-6 pt-0">
                    <a href="{{url('/member/store')}}">
                        <button class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ... bg-primary text-primary-foreground hover:bg-primary/90 shadow-sm h-10 px-4 py-2 w-full">Browse Store</button>
                    </a>
                </div>
            </div>

            <!-- Collaborators -->
            <div class="rounded-lg border bg-card text-card-foreground shadow-sm hover:shadow-md transition-shadow cursor-pointer">
                <div class="flex flex-col space-y-1.5 p-6">
                    <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users h-6 w-6 text-primary">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-semibold leading-none tracking-tight">Collaborators</h3>
                    <p class="text-base text-muted-foreground mt-1">Connect with wellness experts and specialists</p>
                </div>
                <div class="p-6 pt-0">
                    <a href="{{url('/collaborators')}}">
                        <button class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ... bg-primary text-primary-foreground hover:bg-primary/90 shadow-sm h-10 px-4 py-2 w-full">View Collaborators</button>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="rounded-lg border bg-card text-card-foreground shadow-sm  p-6">
        <div class="flex  gap-2 mb-4   ">
            <i data-lucide="calendar" class="h-5 w-5 text-primary  mt-1"></i>
            <h2 class="text-2xl font-semibold text-left">Zoom Sessions</h2>
        </div>
        <div class="space-y-8" x-data="{ tab: 'upcoming_sessions' }">
            {{-- Tabs --}}
            <div>
                <div class="grid w-full max-w-full grid-cols-2 bg-gray-100 rounded-md p-1">
                    <button @click="tab='upcoming_sessions'" :class="tab=='upcoming_sessions' ? 'bg-white shadow font-semibold' : ''" class="px-3 py-2 text-sm rounded-md">Upcoming Sessions</button>
                    <button @click="tab='archieves_and_recordings'" :class="tab=='collaborator' ? 'bg-white shadow font-semibold' : ''" class="px-3 py-2 text-sm rounded-md">Archieves & Recordings</button>
                </div>

                {{-- Tab1 --}}
                <div x-show="tab=='upcoming_sessions'" class="mt-6 space-y-4">
                    @if(count($upcomingSessions) > 0)
                        @php $count = 0; @endphp
                        @foreach($upcomingSessions as $session)
                            @php
                                $todayDT = \Carbon\Carbon::now('Asia/Kolkata')->format('Y-m-d h:i A');
                                $sessionDT = \Carbon\Carbon::parse($session->date . ' ' . $session->time)->format('Y-m-d h:i A');

                                $todayDateTime = \Carbon\Carbon::parse($todayDT);
                                $sessionDateTime = \Carbon\Carbon::parse($sessionDT);

                                $start = \Carbon\Carbon::parse($session->date . ' ' . $session->time);
                                $end = $start->copy()->addMinutes((int) $session->duration);

                                $googleStart = $start->format('Ymd\THis');
                                $googleEnd = $end->format('Ymd\THis');

                                $response = json_decode($session->meeting_response);
                                $joinUrl = $response->join_url ?? null;

                                $title = urlencode($session->session_title);

                                // The join link has to be carried into the calendar entry itself,
                                // otherwise the invite lands with no way to get into the meeting.
                                $detailsText = strip_tags($session->description);
                                if ($joinUrl) {
                                    $detailsText .= "\n\nJoin Zoom Meeting:\n" . $joinUrl;
                                }
                                $details = urlencode($detailsText);
                                $location = urlencode($joinUrl ?? '');
                            @endphp

                            @if($sessionDateTime->gte($todayDateTime))
                                @php
                                    $hostDetail = DB::table('users')->where('id', $session->host)->first();
                                @endphp
                                <div class="rounded-lg border-2 bg-card shadow-sm hover:border-primary transition-all">
                                    <div class="p-5">
                                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-5">
                                            <div class="flex-1 space-y-3">
                                                <div class="flex items-start justify-between gap-3">
                                                    <h3 class="font-semibold text-lg text-foreground">{{$session->session_title}}</h3>
                                                    <!-- <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold bg-primary/10 text-primary border-primary/30 flex-shrink-0">monthly</div> -->
                                                </div>
                                                <div class="flex flex-wrap items-center gap-4 text-sm text-muted-foreground">
                                                    <div class="flex items-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user h-4 w-4 mr-1.5"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                                        @if(!empty($hostDetail)) {{$hostDetail->first_name}} {{$hostDetail->last_name}} @endif
                                                    </div>
                                                    <div class="flex items-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar h-4 w-4 mr-1.5"><path d="M8 2v4"></path><path d="M16 2v4"></path><rect width="18" height="18" x="3" y="4" rx="2"></rect><path d="M3 10h18"></path></svg>
                                                        {{ \Carbon\Carbon::parse($session->date)->format('M d, Y') }}
                                                    </div>
                                                    <div class="flex items-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock h-4 w-4 mr-1.5"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                                        {{$session->time}} ({{$session->duration}})
                                                    </div>
                                                </div>
                                                <p class="text-sm text-muted-foreground">{{ \Illuminate\Support\Str::limit(strip_tags($session->description), 80) }}</p>
                                                <!-- <div class="flex items-center gap-2">
                                                    <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold bg-primary/10 text-primary border-primary/30">
                                                        12 spots available
                                                    </div>
                                                </div> -->
                                            </div>
                                            <div class="flex flex-col gap-3 min-w-[140px]">
                                                @if($joinUrl)
                                                    <a href="{{ $joinUrl }}" target="_blank">
                                                        <button class="inline-flex items-center justify-center gap-2 rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2 w-full shadow-sm">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-video"><path d="m16 13 5.223 3.482a.5.5 0 0 0 .777-.416V7.87a.5.5 0 0 0-.752-.432L16 10.5"></path><rect x="2" y="6" width="14" height="12" rx="2"></rect></svg>
                                                            Join Session
                                                        </button>
                                                    </a>
                                                @else
                                                    <button type="button" disabled title="The meeting link is not available yet. Please contact support."
                                                        class="inline-flex items-center justify-center gap-2 rounded-md text-sm font-medium transition-colors disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground h-10 px-4 py-2 w-full shadow-sm">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-video"><path d="m16 13 5.223 3.482a.5.5 0 0 0 .777-.416V7.87a.5.5 0 0 0-.752-.432L16 10.5"></path><rect x="2" y="6" width="14" height="12" rx="2"></rect></svg>
                                                        Link Unavailable
                                                    </button>
                                                @endif
                                                <a href="https://www.google.com/calendar/render?action=TEMPLATE&text={{ $title }}&dates={{ $googleStart }}/{{ $googleEnd }}&details={{ $details }}&location={{ $location }}&sf=true&output=xml" target="_blank">
                                                    <button class="inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none
                                                    focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 border-2 border-primary bg-background text-primary hover:bg-primary hover:text-primary-foreground h-9 rounded-md px-3 w-full">
                                                        Add to Calendar
                                                    </button>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @php $count++; @endphp
                            @endif
                        @endforeach

                        @if($count == 0)
                            <p>No upcoming sessions found.</p>
                        @endif
                    @else
                        No upcoming sessions found.
                    @endif
                </div>

                {{-- Tab2 --}}
                <div x-show="tab=='archieves_and_recordings'" class="mt-6 space-y-4">
                    @if(count($recordedSessions) > 0)
                        @foreach($recordedSessions as $session)
                        @php
                            $response = json_decode($session->zoomSession->meeting_response);
                            $hostDetail = DB::table('users')->where('id', $session->zoomSession->host)->first();
                        @endphp
                        <div class="rounded-lg border-2 bg-card shadow-sm hover:border-primary transition-all">
                            <div class="p-5">
                                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-5">
                                    <div class="flex-1 space-y-3">
                                        <div class="flex items-start justify-between gap-3">
                                            <h3 class="font-semibold text-lg text-foreground">{{$session->zoomSession->session_title}}</h3>
                                            <!--<div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold bg-primary/10 text-primary border-primary/30 flex-shrink-0">monthly</div>-->
                                        </div>
                                        <div class="flex flex-wrap items-center gap-4 text-sm text-muted-foreground">
                                            <div class="flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user h-4 w-4 mr-1.5"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                                {{$hostDetail->first_name}} {{$hostDetail->last_name}}
                                            </div>
                                            <div class="flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar h-4 w-4 mr-1.5"><path d="M8 2v4"></path><path d="M16 2v4"></path><rect width="18" height="18" x="3" y="4" rx="2"></rect><path d="M3 10h18"></path></svg>
                                                {{ \Carbon\Carbon::parse($session->zoomSession->date)->format('M d, Y') }}
                                            </div>
                                            <div class="flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock h-4 w-4 mr-1.5"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                                {{$session->zoomSession->time}} ({{$session->zoomSession->duration}})
                                            </div>
                                        </div>
                                        <p class="text-sm text-muted-foreground">{{ \Illuminate\Support\Str::limit(strip_tags($session->zoomSession->description), 80) }}</p>
                                        <!--<div class="flex items-center gap-2">
                                            <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold bg-primary/10 text-primary border-primary/30">
                                                12 views
                                            </div>
                                        </div>-->
                                    </div>
                                    <div class="flex flex-col gap-3 min-w-[140px]">
                                        {{-- The recording link the admin saved for this session — not the
                                             parent meeting's join_url, which only re-opens the ended meeting. --}}
                                        @php $recordingUrl = $session->recorded_link ?: null; @endphp
                                        @if($recordingUrl)
                                            {{-- Recordings are Vimeo (domain-restricted), so open them in an
                                                 on-page iframe modal rather than a new tab. --}}
                                            <button type="button" data-video="{{ $recordingUrl }}" class="open-recording-btn inline-flex items-center justify-center gap-2 rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2 w-full shadow-sm">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-video"><path d="m16 13 5.223 3.482a.5.5 0 0 0 .777-.416V7.87a.5.5 0 0 0-.752-.432L16 10.5"></path><rect x="2" y="6" width="14" height="12" rx="2"></rect></svg>
                                                Watch Recording
                                            </button>
                                        @else
                                            <button type="button" disabled title="The recording is not available yet."
                                                class="inline-flex items-center justify-center gap-2 rounded-md text-sm font-medium transition-colors disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground h-10 px-4 py-2 w-full shadow-sm">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-video"><path d="m16 13 5.223 3.482a.5.5 0 0 0 .777-.416V7.87a.5.5 0 0 0-.752-.432L16 10.5"></path><rect x="2" y="6" width="14" height="12" rx="2"></rect></svg>
                                                Recording Unavailable
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                        No recordings found.
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Standard Process Store -->
    @if(auth()->user()->membership_number)
        @php
            $discountMap = [
                'standard' => '5%',
                'premium' => '10%',
                'lifetime' => '20%',
            ];
            $tier = strtolower(auth()->user()->plan_name ?? '');
            $discount = $discountMap[$tier] ?? '0%';
            $storeUrl = config('services.standard_process.store_url');
        @endphp
        <div class="rounded-lg border bg-card text-card-foreground shadow-sm mt-4 p-6">
            <div class="flex gap-2 mb-4">
                <i data-lucide="shopping-bag" class="h-5 w-5 text-primary mt-1"></i>
                <h2 class="text-2xl font-semibold text-left">Standard Process Store</h2>
            </div>
            <p class="text-sm text-muted-foreground mb-2">
                Your exclusive discount code for the Standard Process store:
            </p>
            <div class="bg-gray-100 rounded-lg p-4 text-center mb-4">
                <span class="text-2xl font-mono font-bold tracking-wider">
                    {{ auth()->user()->membership_number }}
                </span>
            </div>
            <p class="text-sm text-muted-foreground mb-4">
                Your {{ ucfirst($tier) ?: 'membership' }} membership gives you
                <strong>{{ $discount }} off</strong> all Standard Process products.
            </p>
            @if(!empty($storeUrl))
                <a href="{{ rtrim($storeUrl, '/') }}/discount/{{ auth()->user()->membership_number }}?redirect=/collections/all"
                   target="_blank"
                   class="inline-flex items-center justify-center gap-2 rounded-md text-sm font-medium transition-colors bg-primary text-primary-foreground hover:bg-primary/90 shadow-sm h-10 px-6 py-2">
                    Shop Standard Process
                </a>
            @else
                <p class="text-xs text-muted-foreground">Store link coming soon.</p>
            @endif
        </div>
    @endif

    <!-- Getting Started -->
    <div class="rounded-lg border bg-card text-card-foreground shadow-sm mt-4 ">
        <div class="flex flex-col space-y-1.5 p-6 text-left">
            <h3 class="text-2xl font-semibold leading-none tracking-tight flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-book-open h-6 w-6 mr-2 text-primary">
                    <path d="M12 7v14"></path>
                    <path d="M3 18a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h5a4 4 0 0 1 4 4 4 4 0 0 1 4-4h5a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1h-6a3 3 0 0 0-3 3 3 3 0 0 0-3-3z"></path>
                </svg>
                Getting Started
            </h3>
            <p class="text-base text-muted-foreground ">Quick guide to maximize your membership</p>
        </div>
        <div class="p-6 pt-0">
            <div class="space-y-4">
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0 w-8 h-8 rounded-full bg-primary text-primary-foreground flex items-center justify-center text-sm font-semibold">1</div>
                    <div>
                        <h4 class="font-semibold text-foreground">Watch the Introduction Videos</h4>
                        <p class="text-base text-muted-foreground ">Start with our welcome series to understand all your benefits</p>
                    </div>
                </div>
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0 w-8 h-8 rounded-full bg-primary text-primary-foreground flex items-center justify-center text-sm font-semibold">2</div>
                    <div>
                        <h4 class="font-semibold text-foreground">Explore the Product Store</h4>
                        <p class="text-base text-muted-foreground ">Browse wellness products with your exclusive member discount</p>
                    </div>
                </div>
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0 w-8 h-8 rounded-full bg-primary text-primary-foreground flex items-center justify-center text-sm font-semibold">3</div>
                    <div>
                        <h4 class="font-semibold text-foreground">Connect with Experts</h4>
                        <p class="text-base text-muted-foreground  ">Learn from our network of wellness collaborators and specialists</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Recording Video Modal (recordings are Vimeo, domain-restricted → embed on this domain) -->
<div id="recordingModal" class="fixed inset-0 bg-black bg-opacity-70 hidden items-center justify-center z-50">
    <div class="relative w-full max-w-4xl mx-auto px-4">
        <button id="closeRecordingVideoModal" type="button" class="absolute -top-10 right-4 text-white text-2xl">&times;</button>
        <div class="aspect-w-16 aspect-h-9 bg-black relative">
            <iframe
                id="recordingVideoFrame"
                src=""
                frameborder="0"
                allow="autoplay; fullscreen"
                allowfullscreen
                class="w-full h-[500px] rounded-lg">
            </iframe>
            {{-- Click shield over the Vimeo top bar so the Like / Watch Later / Share
                 tools can't be opened. Playback controls sit at the bottom and stay
                 usable. Note: this only blocks clicks — hiding the icons entirely
                 requires disabling interaction tools in the video's Vimeo embed settings. --}}
            <div class="absolute top-0 left-0 right-0 h-16 z-10"></div>
        </div>
    </div>
</div>
<script>
(function () {
    const modal = document.getElementById('recordingModal');
    const iframe = document.getElementById('recordingVideoFrame');
    const closeBtn = document.getElementById('closeRecordingVideoModal');
    if (!modal || !iframe) return;

    // Build a Vimeo player embed URL from whatever form the stored link takes:
    // vimeo.com/123, vimeo.com/video/123, vimeo.com/123/privacyhash, or a
    // player.vimeo.com URL with ?h=hash. Falls back to the raw URL if no id found.
    function vimeoEmbed(url) {
        let id = null, hash = null;
        const m = url.match(/vimeo\.com\/(?:video\/)?(\d+)(?:\/([0-9a-zA-Z]+))?/i);
        if (m) { id = m[1]; hash = m[2] || null; }
        const hm = url.match(/[?&]h=([0-9a-zA-Z]+)/i);
        if (hm) hash = hm[1];
        if (!id) { const dm = url.match(/(\d{6,})/); if (dm) id = dm[1]; }
        if (!id) return url;
        // Strip the player chrome / interaction tools: title, byline, portrait,
        // badge, and the Like / Watch Later / Share / Collections overlay; dnt=1
        // disables tracking cookies.
        let embed = 'https://player.vimeo.com/video/' + id
            + '?autoplay=1&title=0&byline=0&portrait=0&badge=0&dnt=1';
        if (hash) embed += '&h=' + hash;
        return embed;
    }

    function closeRecordingVideo() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        iframe.src = ''; // stop playback
    }

    document.querySelectorAll('.open-recording-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const url = this.getAttribute('data-video');
            if (!url) return;
            iframe.src = vimeoEmbed(url);
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        });
    });

    if (closeBtn) closeBtn.addEventListener('click', closeRecordingVideo);
    modal.addEventListener('click', function (e) { if (e.target === modal) closeRecordingVideo(); });
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape') closeRecordingVideo(); });
})();
</script>
@endsection