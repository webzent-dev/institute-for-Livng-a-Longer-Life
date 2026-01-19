@extends('member.member')

@section('member-content')


<!-- Dashboard Page -->
{{-- <div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8"> --}}
  
  <div class="max-w-7xl mx-auto">
          <!-- Welcome Message -->
        <div class="mb-8">
          <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
          <p class="text-gray-600 mt-2">Welcome back! Access your membership benefits below.</p>
        </div>

          <!-- Feature Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
          <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center mb-4">
              <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
              </div>
              <h2 class="text-lg font-semibold text-gray-900">Video Library</h2>
            </div>
            <p class="text-gray-600 mb-4">Access all educational videos and wellness content</p>
            {{-- <button class="w-full bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-md font-medium">View Videos</button> --}}
            <x-button-use href="/member/video-library" label="View Videos" variant="outline" icon="" />
          </div>
          <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center mb-4">
              <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
              </div>
              <h2 class="text-lg font-semibold text-gray-900">Member Store</h2>
            </div>
            <p class="text-gray-600 mb-4">Browse products with exclusive member discounts</p>
            {{-- <button class="w-full bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-md font-medium">Browse Store</button> --}}
            <x-button-use href="/member/store" label="Browse Store" variant="outline" icon="" />
          </div>
          <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center mb-4">
              <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
              </div>
              <h2 class="text-lg font-semibold text-gray-900">Collaborators</h2>
            </div>
            <p class="text-gray-600 mb-4">Connect with wellness experts and specialists</p>
            {{-- <button class="w-full bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-md font-medium">View Collaborators</button> --}}
            <x-button-use href="/collaborators" label="View Collaborators" variant="outline" icon="" />
          </div>
        </div>

        <!-- Zoom Sessions Card -->
         <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <header class="mb-8">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900">Zoom Sessions</h1>
                <p class="text-gray-600 mt-2">Join live wellness sessions or watch recordings from our experts</p>
            </header>

            <!-- Tab Navigation -->
            <div class="mb-10">
                <div class="border-b border-gray-200">
                    <nav class="flex space-x-8">
                        <button id="upcoming-tab" class="tab-active py-3 px-1 text-lg font-medium">
                            Upcoming Sessions
                        </button>
                        <button id="archives-tab" class="py-3 px-1 text-lg font-medium text-gray-500 hover:text-gray-700">
                            Archives & Recordings
                        </button>
                    </nav>
                </div>
            </div>

            <!-- Tab Content -->
            <div id="upcoming-content" class="tab-content">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">Upcoming Sessions</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Upcoming sessions will be rendered here by JavaScript -->
                </div>
            </div>

            <div id="archives-content" class="tab-content hidden">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">Archives & Recordings</h2>
                    
                    <!-- Filter Dropdown -->
                    <div class="relative">
                        <select id="filter-type" class="appearance-none bg-white border border-gray-300 rounded-lg py-2 pl-4 pr-10 text-gray-700 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
                            <option value="all">All Sessions</option>
                            <option value="monthly">Monthly Sessions</option>
                            <option value="weekly">Weekly Sessions</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <i class="fas fa-chevron-down"></i>
                        </div>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Archived sessions will be rendered here by JavaScript -->
                </div>
            </div>
        </div>

        <!-- Getting Started Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
          <div class="flex items-center mb-4">
            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
              <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
            </div>
            <h2 class="text-xl font-semibold text-gray-900">Getting Started</h2>
          </div>
          <p class="text-gray-600 mb-6">Quick guide to maximize your membership</p>
          
          <ol class="space-y-4 text-sm text-gray-700">
            <li class="flex items-center">
              <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mr-3">
                <span class="text-xs font-semibold text-green-600">1</span>
              </div>
              <span>Watch the welcome videos to understand all your benefits</span>
            </li>
            <li class="flex items-center">
              <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mr-3">
                <span class="text-xs font-semibold text-green-600">2</span>
              </div>
              <span>Explore the Product Store with your exclusive member discount</span>
            </li>
            <li class="flex items-center">
              <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mr-3">
                <span class="text-xs font-semibold text-green-600">3</span>
              </div>
              <span>Browse wellness products with your exclusive member discount</span>
            </li>
            <li class="flex items-center">
              <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mr-3">
                <span class="text-xs font-semibold text-green-600">Connect with experts</span>
              </div>
              <span>Learn from our network of wellness collaborators and specialists</span>
            </li>
          </ol>
        </div>
  </div>
{{-- </div> --}}



   

    <!-- Data Arrays -->
    <script>
        const ZoomSession = [
            {
                id: 1,
                title: "Q&A with Dr. Victor Zeines",
                host: "Dr. Victor Zeines",
                date: "Nov 15, 2025",
                time: "2:00 PM EST",
                duration: "60 min",
                type: "monthly",
                spots: 12,
                description: "Monthly live session covering your wellness questions and latest health insights"
            },
            {
                id: 2,
                title: "Functional Nutrition Deep Dive",
                host: "Dr. Sarah Chen",
                date: "Nov 18, 2025",
                time: "6:00 PM EST",
                duration: "45 min",
                type: "weekly",
                spots: 8,
                description: "Weekly discussion on optimizing nutrition for longevity and metabolic health"
            },
            {
                id: 3,
                title: "Movement & Mobility Masterclass",
                host: "Dr. Michael Rodriguez",
                date: "Nov 22, 2025",
                time: "10:00 AM EST",
                duration: "90 min",
                type: "weekly",
                spots: 5,
                description: "Weekly hands-on training for strength and flexibility at any age"
            },
            {
                id: 4,
                title: "Holistic Health Workshop",
                host: "Dr. Victor Zeines",
                date: "Nov 25, 2025",
                time: "3:00 PM EST",
                duration: "75 min",
                type: "monthly",
                spots: 15,
                description: "Comprehensive approach to integrating wellness practices into daily life"
            }
        ];

        const ArchivedSession = [
            {
                id: 101,
                title: "October Q&A with Dr. Victor Zeines",
                host: "Dr. Victor Zeines",
                date: "Oct 12, 2025",
                duration: "58 min",
                type: "monthly",
                description: "Live Q&A covering dental health, nutrition, and holistic wellness practices",
                views: 234
            },
            {
                id: 102,
                title: "Gut Health & Immunity",
                host: "Dr. Sarah Chen",
                date: "Oct 8, 2025",
                duration: "47 min",
                type: "weekly",
                description: "Deep dive into the gut-immune connection and practical dietary strategies",
                views: 189
            },
            {
                id: 103,
                title: "Stress Management Techniques",
                host: "Dr. Michael Rodriguez",
                date: "Oct 5, 2025",
                duration: "52 min",
                type: "weekly",
                description: "Practical breathwork and movement exercises for daily stress relief",
                views: 156
            },
            {
                id: 104,
                title: "September Monthly Wellness Review",
                host: "Dr. Victor Zeines",
                date: "Sep 18, 2025",
                duration: "72 min",
                type: "monthly",
                description: "Comprehensive review of member progress and new wellness protocols",
                views: 312
            },
            {
                id: 105,
                title: "Sleep Optimization Workshop",
                host: "Dr. Sarah Chen",
                date: "Sep 10, 2025",
                duration: "41 min",
                type: "weekly",
                description: "Science-backed strategies for improving sleep quality and duration",
                views: 278
            }
        ];
    </script>

    <!-- JavaScript for Functionality -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tab elements
            const upcomingTab = document.getElementById('upcoming-tab');
            const archivesTab = document.getElementById('archives-tab');
            const upcomingContent = document.getElementById('upcoming-content');
            const archivesContent = document.getElementById('archives-content');
            const filterType = document.getElementById('filter-type');
            
            // Tab switching functionality
            upcomingTab.addEventListener('click', function() {
                switchToUpcoming();
            });
            
            archivesTab.addEventListener('click', function() {
                switchToArchives();
            });
            
            // Filter functionality for archived sessions
            filterType.addEventListener('change', function() {
                renderArchivedSessions(this.value);
            });
            
            // Initial render
            renderUpcomingSessions();
            renderArchivedSessions('all');
            
            // Tab switching functions
            function switchToUpcoming() {
                upcomingTab.classList.add('tab-active');
                upcomingTab.classList.remove('text-gray-500');
                archivesTab.classList.remove('tab-active');
                archivesTab.classList.add('text-gray-500');
                
                upcomingContent.classList.remove('hidden');
                archivesContent.classList.add('hidden');
            }
            
            function switchToArchives() {
                archivesTab.classList.add('tab-active');
                archivesTab.classList.remove('text-gray-500');
                upcomingTab.classList.remove('tab-active');
                upcomingTab.classList.add('text-gray-500');
                
                archivesContent.classList.remove('hidden');
                upcomingContent.classList.add('hidden');
            }
            
            // Render upcoming sessions
            function renderUpcomingSessions() {
                const container = upcomingContent.querySelector('.grid');
                container.innerHTML = '';
                
                ZoomSession.forEach(session => {
                    const sessionCard = createUpcomingSessionCard(session);
                    container.appendChild(sessionCard);
                });
            }
            
            // Render archived sessions with optional filtering
            function renderArchivedSessions(filter = 'all') {
                const container = archivesContent.querySelector('.grid');
                container.innerHTML = '';
                
                let sessionsToRender = ArchivedSession;
                
                if (filter !== 'all') {
                    sessionsToRender = ArchivedSession.filter(session => session.type === filter);
                }
                
                sessionsToRender.forEach(session => {
                    const sessionCard = createArchivedSessionCard(session);
                    container.appendChild(sessionCard);
                });
            }
            
            // Create HTML for an upcoming session card
            function createUpcomingSessionCard(session) {
                const card = document.createElement('div');
                card.className = 'session-card bg-white rounded-xl shadow-md p-6 border border-gray-100';
                
                // Badge for session type
                const typeBadge = session.type === 'monthly' 
                    ? '<span class="inline-block bg-blue-100 text-primary text-xs font-semibold px-2.5 py-0.5 rounded-full">Monthly</span>'
                    : '<span class="inline-block bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">Weekly</span>';
                
                card.innerHTML = `
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="text-xl font-bold text-gray-900">${session.title}</h3>
                        ${typeBadge}
                    </div>
                    <p class="text-gray-600 mb-4">${session.host}</p>
                    
                    <div class="space-y-2 mb-4">
                        <div class="flex items-center text-gray-700">
                            <i class="fas fa-calendar-alt mr-2 text-gray-500"></i>
                            <span>${session.date}</span>
                        </div>
                        <div class="flex items-center text-gray-700">
                            <i class="fas fa-clock mr-2 text-gray-500"></i>
                            <span>${session.time} (${session.duration})</span>
                        </div>
                    </div>
                    
                    <p class="text-gray-700 mb-5">${session.description}</p>
                    
                    <div class="flex justify-between items-center mb-5">
                        <div class="text-sm font-semibold ${session.spots < 10 ? 'text-amber-600' : 'text-gray-700'}">
                            <i class="fas fa-user-friends mr-1"></i>
                            ${session.spots} spots available
                        </div>
                        <button class="text-primary-foreground hover:text-primary text-sm font-medium" onclick="addToCalendar(${session.id})">
                            <i class="far fa-calendar-plus mr-1"></i>Add to Calendar
                        </button>
                    </div>
                    
                    <div class="flex space-x-3">
                        <button class="btn-primary flex-1 py-3 px-4 rounded-lg font-medium" onclick="joinSession(${session.id})">
                            Join Session
                        </button>
                        <button class="btn-outline py-3 px-4 rounded-lg font-medium" onclick="shareSession(${session.id})">
                            <i class="fas fa-share-alt mr-2"></i>Share
                        </button>
                    </div>
                `;
                
                return card;
            }
            
            // Create HTML for an archived session card
            function createArchivedSessionCard(session) {
                const card = document.createElement('div');
                card.className = 'session-card bg-white rounded-xl shadow-md p-6 border border-gray-100';
                
                // Badge for session type
                const typeBadge = session.type === 'monthly' 
                    ? '<span class="inline-block bg-blue-100 text-primary text-xs font-semibold px-2.5 py-0.5 rounded-full">Monthly</span>'
                    : '<span class="inline-block bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">Weekly</span>';
                
                card.innerHTML = `
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="text-xl font-bold text-gray-900">${session.title}</h3>
                        ${typeBadge}
                    </div>
                    <p class="text-gray-600 mb-4">${session.host}</p>
                    
                    <div class="flex items-center text-gray-700 mb-4">
                        <i class="fas fa-calendar-alt mr-2 text-gray-500"></i>
                        <span>${session.date} • ${session.duration}</span>
                    </div>
                    
                    <p class="text-gray-700 mb-5">${session.description}</p>
                    
                    <div class="flex justify-between items-center">
                        <div class="text-gray-600">
                            <i class="fas fa-eye mr-1"></i>
                            ${session.views} views
                        </div>
                        <button class="btn-primary py-2 px-5 rounded-lg font-medium" onclick="watchRecording(${session.id})">
                            <i class="fas fa-play mr-2"></i>Watch Recording
                        </button>
                    </div>
                `;
                
                return card;
            }
            
            // Function to simulate joining a session
            window.joinSession = function(id) {
                const session = ZoomSession.find(s => s.id === id);
                if (session) {
                    if (session.spots > 0) {
                        alert(`Joining session: "${session.title}" with ${session.host}\n\nYou will be redirected to the Zoom meeting shortly.`);
                        // In a real app, this would redirect to the Zoom link
                    } else {
                        alert('Sorry, this session is fully booked. Please check other available sessions.');
                    }
                }
            };
            
            // Function to add a session to calendar
            window.addToCalendar = function(id) {
                const session = ZoomSession.find(s => s.id === id);
                if (session) {
                    alert(`Added "${session.title}" to your calendar.\n\nDate: ${session.date}\nTime: ${session.time}\nDuration: ${session.duration}`);
                    // In a real app, this would generate an .ics file or connect to calendar APIs
                }
            };
            
            // Function to watch a recording
            window.watchRecording = function(id) {
                const session = ArchivedSession.find(s => s.id === id);
                if (session) {
                    alert(`Playing recording: "${session.title}" with ${session.host}\n\nDuration: ${session.duration}`);
                    // In a real app, this would open a video player
                }
            };
            
            // Function to share a session
            window.shareSession = function(id) {
                const session = ZoomSession.find(s => s.id === id);
                if (session) {
                    alert(`Share "${session.title}" with others.\n\nCopy the link or share via email or social media.`);
                    // In a real app, this would open a share dialog
                }
            };
        });
    </script>
 

@endsection

