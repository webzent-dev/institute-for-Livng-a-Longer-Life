
@extends('front.layouts.app')
@section('content') 


<div class="max-w-7xl mx-auto">




    <main class="bg-gray-100">

            <!--Collaborator PROFILE HEADER -->
            <div class="bg-white shadow  max-w-7xl max-auto justify-items-center">
                <div class=" px-6 py-8 flex flex-col lg:flex-row  lg:items-start gap-6 justify-center">

                    <img src="https://i.pravatar.cc/200?img=12"
                    class="w-40 h-40 object-cover rounded-full border-4 border-gray-200 shadow" />

                    <div class="flex-1">
                    <h1 class="text-2xl font-bold text-left">Dr. Michael Rodriguez</h1>
                    {{-- <p class="text-gray-600 text-sm mt-1">, , </p> --}}
                        <div class="flex flex-wrap gap-2">
                                <span class="px-3 py-1 bg-blue-100 text-primary rounded-full text-xs">Exercise Physiology</span>
                                <span class="px-3 py-1 bg-green-100 text-green-600 rounded-full text-xs">Integrative Cardiology</span>
                                <span class="px-3 py-1 bg-orange-100 text-orange-600 rounded-full text-xs">Strength Training & Cardio Specialist</span>
                        </div>
                        <p class="mt-3 text-muted-foreground">Expert in age-defying fitness protocols and movement optimization for enhanced vitality and strength.</p>
                    <div class="flex items-center mt-3 text-yellow-500">
                        <span class="text-lg">★★★★☆</span>
                        <span class="text-gray-600 ml-2 text-sm">(4.5 - 182 Reviews)</span>
                    </div>

                    <div class="flex gap-3 mt-4">
                        <button class="px-5 py-2 bg-primary text-white rounded-lg hover:bg-green-700">Book Session</button>
                        <button class="px-5 py-2 bg-gray-100 border rounded-lg hover:bg-gray-200">Message</button>
                    </div>
                    </div>

                </div>
            </div>

            <!-- MAIN LAYOUT -->
            <div class="max-w-7xl mx-auto px-6 py-8 flex flex-col lg:flex-row gap-8">

                    <!-- LEFT SIDEBAR -->
                    {{-- <aside class="w-full lg:w-80 bg-white p-5 rounded-xl shadow">
                        <h2 class="font-semibold text-lg mb-4">Details</h2>

                        <ul class="space-y-3 text-sm">
                        <li><strong>Experience:</strong> 5+ Years</li>
                        <li><strong>Price:</strong> ₹1200 / Session</li>
                        <li><strong>Languages:</strong> English, Hindi</li>
                        <li><strong>Location:</strong> Mumbai, India</li>
                        <li><strong>Certification:</strong> ACE Certified Trainer</li>
                        <li><strong>Specialties:</strong> Weight Loss, Cardio, Muscle Gain</li>
                        </ul>

                        <div class="mt-6">
                        <h3 class="font-semibold mb-1">Available For</h3>
                        <div class="flex flex-wrap gap-2">
                            <span class="px-3 py-1 bg-blue-100 text-primary rounded-full text-xs">Online</span>
                            <span class="px-3 py-1 bg-green-100 text-green-600 rounded-full text-xs">Offline</span>
                            <span class="px-3 py-1 bg-orange-100 text-orange-600 rounded-full text-xs">Workshops</span>
                        </div>
                        </div>
                    </aside> --}}

                    <!-- RIGHT CONTENT -->
                    <main class="grid grid-flow-row lg:grid-cols-3 gap-4">

                        <section class=" card-hover card">
                             <h2 class="font-semibold text-lg mb-4">Details</h2>

                                <ul class="space-y-3 text-sm">
                                <li><strong>Experience:</strong> 5+ Years</li>
                                <li><strong>Price:</strong> $120 / Session</li>
                                <li><strong>Languages:</strong> English, Spanish</li>
                                <li><strong>Location:</strong> USA</li>
                                <li><strong>Certification:</strong> ACE Certified Trainer</li>
                                <li><strong>Specialties:</strong> Weight Loss, Cardio, Muscle Gain</li>
                                </ul>

                                <div class="mt-6">
                                <h3 class="font-semibold mb-1">Available For</h3>
                                <div class="flex flex-wrap gap-2">
                                    <span class="px-3 py-1 bg-blue-100 text-primary rounded-full text-xs">Online</span>
                                    <span class="px-3 py-1 bg-green-100 text-green-600 rounded-full text-xs">Offline</span>
                                    <span class="px-3 py-1 bg-orange-100 text-orange-600 rounded-full text-xs">Workshops</span>
                                </div>
                                </div>
                        </section>

                        <!-- ABOUT SECTION -->
                        <section class="card-hover card">
                            <h2 class="text-xl font-semibold mb-3">About</h2>
                            <p class="text-sm text-gray-700 leading-relaxed">
                                Dr. Michael Rodriguez is a leading specialist in exercise physiology and integrative cardiology, combining advanced medical science with performance-driven training strategies to help individuals build strength, resilience, and long-term cardiovascular health. As a Strength Training & Cardio Specialist, he designs precision-based programs that optimize heart function, muscular performance, and metabolic efficiency across all stages of life.
                            </p>
                        </section>

                        <!-- SERVICES SECTION -->
                        <section class=" card-hover card">
                            <h2 class="text-xl font-semibold mb-3">Services Offered</h2>
                            <ul class="list-disc ml-6 text-sm text-gray-700 space-y-1">
                                <li>1-on-1 Personal Training</li>
                                <li>Online Training Sessions</li>
                                <li>Custom Workout Plans</li>
                                <li>Diet & Nutrition Planning</li>
                            </ul>
                        </section>

                        <!-- WORKSHOPS SECTION -->
                        <section class=" card-hover card">
                            <h2 class="text-xl font-semibold mb-3">Workshops & Events</h2>

                            <div class="space-y-4">
                                <div class="border rounded-lg p-4 flex justify-between items-center">
                                <div>
                                    <p class="font-medium">Weight Loss Bootcamp</p>
                                    <p class="text-xs text-gray-500">Starts: 15th Feb 2026 • 6 Sessions</p>
                                </div>
                                <button class="px-4 py-2 text-sm bg-primary text-white rounded-md">Join</button>
                                </div>

                                <div class="border rounded-lg p-4 flex justify-between items-center">
                                <div>
                                    <p class="font-medium">Cardio & Endurance Masterclass</p>
                                    <p class="text-xs text-gray-500">Starts: 20th Feb 2026 • 4 Sessions</p>
                                </div>
                                <button class="px-4 py-2 text-sm bg-primary text-white rounded-md">Join</button>
                                </div>
                            </div>
                        </section>

                        <!-- REVIEWS SECTION -->
                        <section class=" card-hover card">
                            <h2 class="text-xl font-semibold mb-3">Reviews</h2>

                            <div class="space-y-4">
                                <div class="border rounded-lg p-3">
                                <div class="flex justify-between">
                                    <span class="font-medium">Aditi Verma</span>
                                    <span class="text-yellow-500">★★★★★</span>
                                </div>
                                <p class="text-xs text-gray-600 mt-1">Very professional and helpful! Highly recommended!</p>
                                </div>

                                <div class="border rounded-lg p-3">
                                <div class="flex justify-between">
                                    <span class="font-medium">Sanjay Gupta</span>
                                    <span class="text-yellow-500">★★★★☆</span>
                                </div>
                                <p class="text-xs text-gray-600 mt-1">Good trainer with detailed guidance.</p>
                                </div>
                            </div>

                        </section>
                        <!-- WORKSHOPS SECTION -->
                        <section class=" card-hover card">
                            <h2 class="text-xl font-semibold mb-3">Courses And Live Courses</h2>

                            <div class="space-y-4">
                                <div class="border rounded-lg p-4 flex justify-between items-center">
                                <div>
                                    <p class="font-medium">Weight Loss Bootcamp</p>
                                    <p class="text-xs text-gray-500">Starts: 15th Feb 2026 • 6 Sessions</p>
                                </div>
                                <button class="px-4 py-2 text-sm bg-primary text-white rounded-md">Join</button>
                                </div>

                                <div class="border rounded-lg p-4 flex justify-between items-center">
                                <div>
                                    <p class="font-medium">Cardio & Endurance Masterclass</p>
                                    <p class="text-xs text-gray-500">Starts: 20th Feb 2026 • 4 Sessions</p>
                                </div>
                                <button class="px-4 py-2 text-sm bg-primary text-white rounded-md">Join</button>
                                </div>
                            </div>
                        </section>

                    </main>
            </div>

    </main>

    {{-- Wellness Marketplace Data --}}


    <main class="bg-gradient-to-br from-gray-50 to-blue-50">
        <div class="container mx-auto px-4 py-6 max-w-screen-xxl">
            <!-- Header with search -->
            <header class="mb-8">
                <div class="flex flex-col md:flex-row justify-between items-center mb-6">
                    <div class="mb-4 md:mb-0">
                        <h1 class="text-3xl md:text-4xl font-bold text-gray-800" style="font-family: 'Playfair Display', serif;">
                            <span class="text-primary">Wellness</span> Marketplace
                        </h1>
                        <p class="text-gray-600 mt-1">Your journey to better health starts here</p>
                    </div>

                    <div class="relative w-full md:w-1/3">
                        <input
                            type="text"
                            id="searchInput"
                            placeholder="Search videos, products, books, testimonials..."
                            class="w-full p-4 pl-12 pr-10 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent shadow-sm"
                        >
                        <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400">
                            <i class="fas fa-search"></i>
                        </div>
                        <button id="searchButton" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-primary">
                            <i class="fas fa-sliders-h"></i>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <p class="text-gray-600 hidden md:block">Discover videos, supplements, books, and inspiring stories for your wellness journey</p>
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-600 hidden md:block">View:</span>
                        <button id="gridView" class="p-2 rounded-lg bg-blue-100 text-primary">
                            <i class="fas fa-th-large"></i>
                        </button>
                        <button id="listView" class="p-2 rounded-lg text-gray-500 hover:bg-gray-100">
                            <i class="fas fa-list"></i>
                        </button>
                    </div>
                </div>
            </header>

            <!-- Mobile filter toggle button -->
            <div class="md:hidden mb-4">
                <button id="mobileFilterToggle" class="w-full p-3 bg-primary text-white rounded-xl font-medium flex items-center justify-center">
                    <i class="fas fa-filter mr-2"></i> Show Filters
                </button>
            </div>

            <!-- Main content area -->
            <div class="flex flex-col md:flex-row">
                <!-- Filters sidebar -->
                <aside id="filtersSidebar" class="w-full md:w-1/4 lg:w-1/5 pr-0 md:pr-6 filter-transition">
                    <div class="bg-white rounded-xl p-6 shadow-sm mb-6 sticky top-6">
                        <!-- Close button for mobile -->
                        <div class="flex justify-between items-center mb-6 md:hidden">
                            <h2 class="text-xl font-bold text-gray-800">Filters</h2>
                            <button id="closeFilters" class="p-2 text-gray-500">
                                <i class="fas fa-times text-xl"></i>
                            </button>
                        </div>

                        <!-- Content Type filter -->
                        <div class="mb-8">
                            <h3 class="font-bold text-lg text-gray-800 mb-4">Content Type</h3>
                            <div class="space-y-3">
                                <label class="flex items-center cursor-pointer">
                                    <div class="relative">
                                        <input type="checkbox" class="checkbox-custom appearance-none w-5 h-5 border border-gray-300 rounded checked:border-primary focus:outline-none" data-filter="type" value="video">
                                        <span class="ml-3 text-gray-700">Videos</span>
                                    </div>
                                    <span class="ml-auto text-gray-500">(6)</span>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <div class="relative">
                                        <input type="checkbox" class="checkbox-custom appearance-none w-5 h-5 border border-gray-300 rounded checked:border-primary focus:outline-none" data-filter="type" value="product">
                                        <span class="ml-3 text-gray-700">Products</span>
                                    </div>
                                    <span class="ml-auto text-gray-500">(6)</span>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <div class="relative">
                                        <input type="checkbox" class="checkbox-custom appearance-none w-5 h-5 border border-gray-300 rounded checked:border-primary focus:outline-none" data-filter="type" value="book">
                                        <span class="ml-3 text-gray-700">Books</span>
                                    </div>
                                    <span class="ml-auto text-gray-500">(6)</span>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <div class="relative">
                                        <input type="checkbox" class="checkbox-custom appearance-none w-5 h-5 border border-gray-300 rounded checked:border-primary focus:outline-none" data-filter="type" value="testimonial">
                                        <span class="ml-3 text-gray-700">Testimonials</span>
                                    </div>
                                    <span class="ml-auto text-gray-500">(6)</span>
                                </label>
                            </div>
                        </div>

                        <!-- Category filter -->
                        <div class="mb-8">
                            <h3 class="font-bold text-lg text-gray-800 mb-4">Category</h3>
                            <div class="space-y-3">
                                <label class="flex items-center cursor-pointer">
                                    <div class="relative">
                                        <input type="checkbox" class="checkbox-custom appearance-none w-5 h-5 border border-gray-300 rounded checked:border-primary focus:outline-none" data-filter="category" value="introduction">
                                        <span class="ml-3 text-gray-700">Introduction</span>
                                    </div>
                                    <span class="ml-auto text-gray-500">(1)</span>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <div class="relative">
                                        <input type="checkbox" class="checkbox-custom appearance-none w-5 h-5 border border-gray-300 rounded checked:border-primary focus:outline-none" data-filter="category" value="science">
                                        <span class="ml-3 text-gray-700">Science</span>
                                    </div>
                                    <span class="ml-auto text-gray-500">(1)</span>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <div class="relative">
                                        <input type="checkbox" class="checkbox-custom appearance-none w-5 h-5 border border-gray-300 rounded checked:border-primary focus:outline-none" data-filter="category" value="nutrition">
                                        <span class="ml-3 text-gray-700">Nutrition</span>
                                    </div>
                                    <span class="ml-auto text-gray-500">(2)</span>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <div class="relative">
                                        <input type="checkbox" class="checkbox-custom appearance-none w-5 h-5 border border-gray-300 rounded checked:border-primary focus:outline-none" data-filter="category" value="exercise">
                                        <span class="ml-3 text-gray-700">Exercise</span>
                                    </div>
                                    <span class="ml-auto text-gray-500">(2)</span>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <div class="relative">
                                        <input type="checkbox" class="checkbox-custom appearance-none w-5 h-5 border border-gray-300 rounded checked:border-primary focus:outline-none" data-filter="category" value="mental-health">
                                        <span class="ml-3 text-gray-700">Mental Health</span>
                                    </div>
                                    <span class="ml-auto text-gray-500">(2)</span>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <div class="relative">
                                        <input type="checkbox" class="checkbox-custom appearance-none w-5 h-5 border border-gray-300 rounded checked:border-primary focus:outline-none" data-filter="category" value="sleep">
                                        <span class="ml-3 text-gray-700">Sleep</span>
                                    </div>
                                    <span class="ml-auto text-gray-500">(2)</span>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <div class="relative">
                                        <input type="checkbox" class="checkbox-custom appearance-none w-5 h-5 border border-gray-300 rounded checked:border-primary focus:outline-none" data-filter="category" value="supplement">
                                        <span class="ml-3 text-gray-700">Supplements</span>
                                    </div>
                                    <span class="ml-auto text-gray-500">(6)</span>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <div class="relative">
                                        <input type="checkbox" class="checkbox-custom appearance-none w-5 h-5 border border-gray-300 rounded checked:border-primary focus:outline-none" data-filter="category" value="holistic-health">
                                        <span class="ml-3 text-gray-700">Holistic Health</span>
                                    </div>
                                    <span class="ml-auto text-gray-500">(1)</span>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <div class="relative">
                                        <input type="checkbox" class="checkbox-custom appearance-none w-5 h-5 border border-gray-300 rounded checked:border-primary focus:outline-none" data-filter="category" value="longevity">
                                        <span class="ml-3 text-gray-700">Longevity</span>
                                    </div>
                                    <span class="ml-auto text-gray-500">(1)</span>
                                </label>
                            </div>
                        </div>

                        <!-- Price filter -->
                        <div class="mb-8">
                            <h3 class="font-bold text-lg text-gray-800 mb-4">Price Range</h3>
                            <div class="space-y-3">
                                <label class="flex items-center cursor-pointer">
                                    <div class="relative">
                                        <input type="radio" name="price" class="appearance-none w-5 h-5 border border-gray-300 rounded-full checked:border-primary focus:outline-none checked:before:content-[''] checked:before:block checked:before:w-3 checked:before:h-3 checked:before:bg-primary checked:before:rounded-full checked:before:absolute checked:before:top-1/2 checked:before:left-1/2 checked:before:transform checked:before:-translate-x-1/2 checked:before:-translate-y-1/2" data-filter="price" value="0-20">
                                        <span class="ml-3 text-gray-700">Under $20</span>
                                    </div>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <div class="relative">
                                        <input type="radio" name="price" class="appearance-none w-5 h-5 border border-gray-300 rounded-full checked:border-primary focus:outline-none checked:before:content-[''] checked:before:block checked:before:w-3 checked:before:h-3 checked:before:bg-primary checked:before:rounded-full checked:before:absolute checked:before:top-1/2 checked:before:left-1/2 checked:before:transform checked:before:-translate-x-1/2 checked:before:-translate-y-1/2" data-filter="price" value="20-40">
                                        <span class="ml-3 text-gray-700">$20 - $40</span>
                                    </div>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <div class="relative">
                                        <input type="radio" name="price" class="appearance-none w-5 h-5 border border-gray-300 rounded-full checked:border-primary focus:outline-none checked:before:content-[''] checked:before:block checked:before:w-3 checked:before:h-3 checked:before:bg-primary checked:before:rounded-full checked:before:absolute checked:before:top-1/2 checked:before:left-1/2 checked:before:transform checked:before:-translate-x-1/2 checked:before:-translate-y-1/2" data-filter="price" value="40-60">
                                        <span class="ml-3 text-gray-700">$40 - $60</span>
                                    </div>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <div class="relative">
                                        <input type="radio" name="price" class="appearance-none w-5 h-5 border border-gray-300 rounded-full checked:border-primary focus:outline-none checked:before:content-[''] checked:before:block checked:before:w-3 checked:before:h-3 checked:before:bg-primary checked:before:rounded-full checked:before:absolute checked:before:top-1/2 checked:before:left-1/2 checked:before:transform checked:before:-translate-x-1/2 checked:before:-translate-y-1/2" data-filter="price" value="60+">
                                        <span class="ml-3 text-gray-700">Over $60</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Rating filter -->
                        {{-- <div class="mb-8">
                            <h3 class="font-bold text-lg text-gray-800 mb-4">Rating</h3>
                            <div class="flex flex-wrap gap-2">
                                <button class="filter-rating px-3 py-1 bg-gray-100 rounded-full text-gray-700 hover:bg-blue-100 hover:text-primary" data-rating="5">
                                    5 <i class="fas fa-star text-yellow-500 ml-1"></i>
                                </button>
                                <button class="filter-rating px-3 py-1 bg-gray-100 rounded-full text-gray-700 hover:bg-blue-100 hover:text-primary" data-rating="4.5">
                                    4.5+ <i class="fas fa-star text-yellow-500 ml-1"></i>
                                </button>
                                <button class="filter-rating px-3 py-1 bg-gray-100 rounded-full text-gray-700 hover:bg-blue-100 hover:text-primary" data-rating="4">
                                    4+ <i class="fas fa-star text-yellow-500 ml-1"></i>
                                </button>
                                <button class="filter-rating px-3 py-1 bg-gray-100 rounded-full text-gray-700 hover:bg-blue-100 hover:text-primary" data-rating="3.5">
                                    3.5+ <i class="fas fa-star text-yellow-500 ml-1"></i>
                                </button>
                            </div>
                        </div> --}}

                        <!-- Clear filters button -->
                        <button id="clearFilters" class="w-full py-3 bg-gray-100 text-gray-700 rounded-lg font-medium hover:bg-gray-200 transition-colors">
                            <i class="fas fa-times-circle mr-2"></i> Clear All Filters
                        </button>
                    </div>

                    <!-- Active filters display -->
                    <div id="activeFilters" class="bg-white rounded-xl p-4 shadow-sm mb-6 hidden">
                        <h3 class="font-bold text-gray-800 mb-3">Active Filters</h3>
                        <div id="filterTags" class="flex flex-wrap gap-2">
                            <!-- Filter tags will appear here -->
                        </div>
                    </div>
                </aside>

                <!-- Content view -->
                <main class="w-full md:w-3/4 lg:w-4/5">
                    <div class="mb-6 flex flex-col md:flex-row justify-between items-start md:items-center">
                        <div class="mb-4 md:mb-0">
                            <h2 class="text-2xl font-bold text-accent">Wellness <span class="text-primary">Resources</span></h2>
                            {{-- <p id="resultsCount" class="text-gray-600">Showing 1-12 of 24 results</p> --}}
                        </div>

                        <div class="flex flex-col md:flex-row items-start md:items-center space-y-3 md:space-y-0 md:space-x-4">
                            <!-- Second Clear All Filters Button -->
                            <button id="clearFiltersTop" class="hidden px-4 py-2 bg-gray-100 text-gray-700 rounded-lg font-medium hover:bg-gray-200 transition-colors md:order-first">
                                <i class="fas fa-times-circle mr-2"></i> Clear All Filters
                            </button>

                            <div class="flex items-center space-x-4">
                                <div class="hidden md:flex items-center space-x-4">
                                    <span class="text-gray-600">Sort by:</span>
                                    <select id="sortSelect" class="p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                                        <option value="rating">Highest Rated</option>
                                        <option value="price-low">Price: Low to High</option>
                                        <option value="price-high">Price: High to Low</option>
                                        <option value="name">Name: A to Z</option>
                                        <option value="views">Most Views</option>
                                    </select>
                                </div>
                                <div class="md:hidden">
                                    <select id="sortSelectMobile" class="p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                                        <option value="rating">Highest Rated</option>
                                        <option value="price-low">Price: Low to High</option>
                                        <option value="price-high">Price: High to Low</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content grid/list -->
                    <div id="contentView" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3  gap-6">
                        <!-- Content cards will be dynamically loaded here -->
                    </div>

                    <!-- Pagination -->
                    <div class="mt-10 flex flex-col sm:flex-row justify-between items-center">
                        {{-- <div id="paginationInfo" class="text-gray-600 mb-4 sm:mb-0">
                            Showing <span id="pageStart">1</span> to <span id="pageEnd">12</span> of <span id="totalItems">24</span> results
                        </div> --}}

                        <div class="flex items-center space-x-2" id="paginationControls">
                            <!-- Pagination buttons will be dynamically generated here -->
                        </div>
                    </div>
                </main>
            </div>

        </div>
    </main>
    <script>
        // Wellness content data array - optimized from the provided data
        const contentItems = [
            // Videos
            { id: 1, type: "video", title: "Welcome to Your Wellness Journey", duration: "8:46", category: "introduction", views: 15000, rating: 4.9, thumbnail: "https://media.gettyimages.com/id/1849601083/video/nature-hiking-group-talking-and-laughing-people-walking-on-outdoor-fitness-journey-travel.jpg?s=640x640&k=20&c=_8-B35ubK1DfoUJA4i0Axqq289Iii9yoj6N-pmv3TF0=", presenter: "Dr. Victor Zeines", description: "An introduction to the Institute for Living Longer and getting started on your wellness path.", price: 0 },
            { id: 2, type: "video", title: "The Science of Longevity", duration: "14:30", category: "science", views: 12000, rating: 4.8, thumbnail: "https://embed-ssl.wistia.com/deliveries/b3bf154dd95d6fe5c5bcf64065858aa5.webp?image_crop_resized=640x360", presenter: "Dr. Victor Zeines", description: "Foundational biological mechanisms of aging and how to slow them down.", price: 0 },
            { id: 3, type: "video", title: "Nutrition Fundamentals for Longevity", duration: "12:58", category: "nutrition", views: 18000, rating: 4.7, thumbnail: "https://study.com/cimages/videopreview/videopreview-full/2524_myplate_125234.jpg", presenter: "Dr. Sarah Chen", description: "Key principles of nutrition supported by cellular health and longevity.", price: 0 },
            { id: 4, type: "video", title: "Exercise for Life", duration: "10:15", category: "exercise", views: 14000, rating: 4.6, thumbnail: "https://media.gettyimages.com/id/497041804/video/woman-running-towards-setting-sun.jpg?s=640x640&k=20&c=-uGWp0UwsCEkTdaZCxCSEx7WxSNPBXDw5kZU7aDl_3E=", presenter: "Dr. Michael Rodriguez", description: "Essential exercises to maintain vitality and strength as you age.", price: 0 },
            { id: 5, type: "video", title: "Stress and Your Health - Mind-Body", duration: "14:40", category: "mental-health", views: 16000, rating: 4.8, thumbnail: "https://d3imrogdy81qei.cloudfront.net/video_images/7179/How_stress_affects_the_body-01.jpg", presenter: "Dr. Jennifer Park", description: "Techniques to manage stress and its impact on aging.", price: 0 },
            { id: 6, type: "video", title: "Sleep Optimization Basics", duration: "11:45", category: "sleep", views: 13000, rating: 4.7, thumbnail: "https://disk.subscribr.ai/cdn-cgi/image/width=1280,height=720,fit=contain,quality=90,format=auto/https://subscribr-disk.nyc3.digitaloceanspaces.com/pages/thumb_sleep-tips-youtube-video-ideas_a85b510946945844.jpg", presenter: "Dr. Emily Thompson", description: "Strategies for better sleep to enhance recovery and longevity.", price: 0 },
            { id: 7, type: "video", title: "Stress and Your Health - Mind-Body", duration: "14:40", category: "mental-health", views: 16000, rating: 4.8, thumbnail: "https://d3imrogdy81qei.cloudfront.net/video_images/7179/How_stress_affects_the_body-01.jpg", presenter: "Dr. Jennifer Park", description: "Techniques to manage stress and its impact on aging.", price: 0 },
            { id: 8, type: "video", title: "Sleep Optimization Basics", duration: "11:45", category: "sleep", views: 13000, rating: 4.7, thumbnail: "https://disk.subscribr.ai/cdn-cgi/image/width=1280,height=720,fit=contain,quality=90,format=auto/https://subscribr-disk.nyc3.digitaloceanspaces.com/pages/thumb_sleep-tips-youtube-video-ideas_a85b510946945844.jpg", presenter: "Dr. Emily Thompson", description: "Strategies for better sleep to enhance recovery and longevity.", price: 0 },
            { id: 9, type: "video", title: "Stress and Your Health - Mind-Body", duration: "14:40", category: "mental-health", views: 16000, rating: 4.8, thumbnail: "https://d3imrogdy81qei.cloudfront.net/video_images/7179/How_stress_affects_the_body-01.jpg", presenter: "Dr. Jennifer Park", description: "Techniques to manage stress and its impact on aging.", price: 0 },
            { id: 10, type: "video", title: "Sleep Optimization Basics", duration: "11:45", category: "sleep", views: 13000, rating: 4.7, thumbnail: "https://disk.subscribr.ai/cdn-cgi/image/width=1280,height=720,fit=contain,quality=90,format=auto/https://subscribr-disk.nyc3.digitaloceanspaces.com/pages/thumb_sleep-tips-youtube-video-ideas_a85b510946945844.jpg", presenter: "Dr. Emily Thompson", description: "Strategies for better sleep to enhance recovery and longevity.", price: 0 },

            { id: 11, type: "video", title: "Stress and Your Health - Mind-Body", duration: "14:40", category: "mental-health", views: 16000, rating: 4.8, thumbnail: "https://d3imrogdy81qei.cloudfront.net/video_images/7179/How_stress_affects_the_body-01.jpg", presenter: "Dr. Jennifer Park", description: "Techniques to manage stress and its impact on aging.", price: 0 },
            { id: 12, type: "video", title: "Sleep Optimization Basics", duration: "11:45", category: "sleep", views: 13000, rating: 4.7, thumbnail: "https://disk.subscribr.ai/cdn-cgi/image/width=1280,height=720,fit=contain,quality=90,format=auto/https://subscribr-disk.nyc3.digitaloceanspaces.com/pages/thumb_sleep-tips-youtube-video-ideas_a85b510946945844.jpg", presenter: "Dr. Emily Thompson", description: "Strategies for better sleep to enhance recovery and longevity.", price: 0 },

            // Products
            { id: 7, type: "product", name: "Vital Boost Superfood Formula", category: "supplement", price: 79.99, rating: 4.9, stock: 500, image: "https://m.media-amazon.com/images/I/61oUe3SdUGL.jpg", ingredients: ["Vitamins C, B Complex", "Folic Acid", "Zinc", "Magnesium"], description: "Daily powdered nutritional supplement for immune support and vitality." },
            { id: 8, type: "product", name: "Heart Health Optimizer", category: "supplement", price: 49.99, rating: 4.7, stock: 300, image: "https://m.media-amazon.com/images/I/71vq1jILmXL.jpg", ingredients: ["CoQ10", "Omega-3", "Garlic Extract"], description: "Supports cardiovascular function and blood pressure." },
            { id: 9, type: "product", name: "Cognitive Enhancement Blend", category: "supplement", price: 59.99, rating: 4.8, stock: 400, image: "https://m.media-amazon.com/images/I/71DL0+weiHL._AC_UF1000,1000_QL80_.jpg", ingredients: ["Bacopa", "Ginkgo Biloba", "Phosphatidylserine"], description: "Boosts memory, focus, and mental clarity." },
            { id: 10, type: "product", name: "Sleep Aid Formula", category: "supplement", price: 39.99, rating: 4.6, stock: 250, image: "https://m.media-amazon.com/images/I/612yj213I7L._AC_UF1000,1000_QL80_.jpg", ingredients: ["Melatonin", "Valerian Root", "Chamomile"], description: "Natural aid for better sleep and recovery." },
            { id: 11, type: "product", name: "Hormone Balance Support", category: "supplement", price: 54.99, rating: 4.7, stock: 350, image: "https://m.media-amazon.com/images/I/71wXNLPd63L.jpg", ingredients: ["Ashwagandha", "Maca Root", "Vitamin D"], description: "Optimizes hormonal health for energy and vitality." },
            { id: 12, type: "product", name: "Immune Strength Booster", category: "supplement", price: 44.99, rating: 4.8, stock: 450, image: "https://m.media-amazon.com/images/I/81GP7ZmwngL._AC_UF1000,1000_QL80_.jpg", ingredients: ["Elderberry", "Echinacea", "Vitamin C"], description: "Enhances natural defenses against illnesses." },

            // Books
            { id: 13, type: "book", title: "Healthy Body, Healthy Mouth", author: "Dr. Victor Zeines", category: "holistic-health", price: 24.99, rating: 4.8, pages: 256, image: "https://assets.prod.dp.digitellcdn.com/api/services/imgopt/mw_400,mh_400/akamai-opus-nc-public.digitellcdn.com/americandentalassociation/product-icons/0bcf0d9fa31cefcf82b063a65688a72ebbbd43e2f9cc634184ca017d15de5b74.png.webp", description: "Explores the connection between oral health and overall wellness." },
            { id: 14, type: "book", title: "The Science of Living Longer", author: "Dr. Victor Zeines", category: "longevity", price: 29.99, rating: 4.9, pages: 320, image: "https://i.kickstarter.com/assets/046/153/762/54033058c21a63bf0bfdb9555e29a4cc_original.jpg?anim=false&fit=cover&gravity=auto&height=576&origin=ugc&q=92&v=1724193482&width=1024&sig=4ZDaPH4PUNdqJZWIQjvYObB%2BixrrVhTWQ84ke5EAssQ%3D", description: "Evidence-based strategies for extending lifespan and healthspan." },
            { id: 15, type: "book", title: "Nutrition for Metabolic Health", author: "Dr. Sarah Chen", category: "nutrition", price: 19.99, rating: 4.7, pages: 224, image: "https://m.media-amazon.com/images/I/71KICuTYMUL.jpg", description: "Personalized nutrition plans for optimal metabolic function." },
            { id: 16, type: "book", title: "Age-Defying Fitness Protocols", author: "Dr. Michael Rodriguez", category: "exercise", price: 22.99, rating: 4.6, pages: 192, image: "https://m.media-amazon.com/images/I/81asgCMfgHL.jpg", description: "Exercises to maintain strength and vitality throughout life." },
            { id: 17, type: "book", title: "Mind-Body Stress Reduction", author: "Dr. Jennifer Park", category: "mental-health", price: 21.99, rating: 4.8, pages: 240, image: "https://m.media-amazon.com/images/I/71eIy2Wl6rL.jpg", description: "Techniques for reducing stress and improving mental-physical balance." },
            { id: 18, type: "book", title: "Optimizing Sleep for Longevity", author: "Dr. Emily Thompson", category: "sleep", price: 18.99, rating: 4.7, pages: 208, image: "https://m.media-amazon.com/images/I/71uHS9QXb4L.jpg", description: "Practical guide to achieving restorative sleep." },

            // Testimonials
            { id: 19, type: "testimonial", name: "Michael R.", age: 55, location: "Denver, CO", rating: 5, image: "https://www.denverheadshotco.com/wp-content/uploads/2023/12/Denver-Headshot-Co-Small1103.jpg", quote: "The videos really helped a lot.", description: "Improved overall health through the program.", category: "Testimonials" },
            { id: 20, type: "testimonial", name: "Jennifer P.", age: 48, location: "Seattle, WA", rating: 5, image: "https://images.seattletimes.com/wp-content/uploads/2018/04/Karla_Miller02-crop-web-tzr.jpg?d=780x502", quote: "IT CHANGED MY LIFE.", description: "Transformed daily routine and wellness.", category: "Testimonials" },
            { id: 21, type: "testimonial", name: "James Wilson", age: 41, location: "Chicago, IL", rating: 5, image: "https://news.wttw.com/sites/default/files/article/image-non-gallery/Negro%20Boys%20on%20Easter%20Morning.jpeg", quote: "Improved heart health markers.", description: "Science-based approach won me over.", category: "Testimonials" },
            { id: 22, type: "testimonial", name: "Patricia Davis", age: 59, location: "Seattle, WA", rating: 5, image: "https://i0.wp.com/pauldorpat.com/wp-content/uploads/2025/07/1957-01-20-SPI-p90.jpg?resize=474%2C344&ssl=1", quote: "Consistent exercise routine.", description: "Community support is amazing.", category: "Testimonials" },
            { id: 23, type: "testimonial", name: "Michael Rodriguez", age: 66, location: "Denver, CO", rating: 5, image: "https://i1.wp.com/www.denverpost.com/wp-content/uploads/2018/11/BRAUCHLER__6AO2962x.jpg?fit=620%2C9999px&ssl=1", quote: "Elite membership was the best investment.", description: "Personalized consultations helped.", category: "Testimonials" },
            { id: 24, type: "testimonial", name: "Anonymous Member", age: 52, location: "New York, NY", rating: 4.9, image: "https://static01.nyt.com/images/2023/07/30/books/review/06paul-rudnick-author/06paul-rudnick-author-articleLarge.jpg?quality=75&auto=webp&disable=upscale", quote: "Vital Boost changed my energy levels.", description: "Daily supplement for better vitality.", category: "Testimonials" }
        ];

        // DOM elements
        const searchInput = document.getElementById('searchInput');
        const searchButton = document.getElementById('searchButton');
        const gridViewButton = document.getElementById('gridView');
        const listViewButton = document.getElementById('listView');
        const mobileFilterToggle = document.getElementById('mobileFilterToggle');
        const closeFilters = document.getElementById('closeFilters');
        const filtersSidebar = document.getElementById('filtersSidebar');
        const clearFiltersButton = document.getElementById('clearFilters');
        const clearFiltersTopButton = document.getElementById('clearFiltersTop');
        const sortSelect = document.getElementById('sortSelect');
        const sortSelectMobile = document.getElementById('sortSelectMobile');
        const contentView = document.getElementById('contentView');
        const resultsCount = document.getElementById('resultsCount');
        const filterTags = document.getElementById('filterTags');
        const paginationControls = document.getElementById('paginationControls');
        const pageStart = document.getElementById('pageStart');
        const pageEnd = document.getElementById('pageEnd');
        const totalItems = document.getElementById('totalItems');

        // State variables
        let currentView = localStorage.getItem('wellnessView') || 'grid'; // Load from localStorage or default to grid
        let activeFilters = {
            type: [],
            category: [],
            price: null,
            rating: null
        };

        // Pagination variables
        let currentPage = 1;
        let itemsPerPage = 12;
        let allItems = [...contentItems];
        let filteredItems = [...contentItems];
        let totalPages = Math.ceil(filteredItems.length / itemsPerPage);

        // Initialize the page
        function init() {
            // Set initial view based on localStorage
            switchView(currentView, true);

            renderContent();
            setupEventListeners();
            updateResultsCount();
            renderPagination();
        }

        // Set up event listeners
        function setupEventListeners() {
            // Search functionality - FIXED
            searchInput.addEventListener('input', handleSearch);
            searchButton.addEventListener('click', handleSearch);

            // View toggle
            gridViewButton.addEventListener('click', () => switchView('grid'));
            listViewButton.addEventListener('click', () => switchView('list'));

            // Mobile filter toggle
            mobileFilterToggle.addEventListener('click', () => {
                filtersSidebar.style.display = 'block';
                filtersSidebar.classList.add('fixed', 'inset-0', 'z-50', 'bg-white', 'p-6', 'overflow-y-auto');
                document.body.style.overflow = 'hidden';
            });

            closeFilters.addEventListener('click', () => {
                if (window.innerWidth < 768) {
                    filtersSidebar.style.display = 'none';
                    filtersSidebar.classList.remove('fixed', 'inset-0', 'z-50', 'bg-white', 'p-6', 'overflow-y-auto');
                }
                document.body.style.overflow = 'auto';
            });

            // Filter checkboxes and radios
            document.querySelectorAll('input[data-filter]').forEach(input => {
                input.addEventListener('change', handleFilterChange);
            });

            // Rating filter buttons
            document.querySelectorAll('.filter-rating').forEach(button => {
                button.addEventListener('click', () => handleRatingFilter(button.dataset.rating));
            });

            // Clear filters buttons (both)
            clearFiltersButton.addEventListener('click', clearFilters);
            clearFiltersTopButton.addEventListener('click', clearFilters);

            // Sort select
            sortSelect.addEventListener('change', handleSortChange);
            sortSelectMobile.addEventListener('change', handleSortChange);

            // Close filters when clicking outside on mobile
            document.addEventListener('click', (e) => {
                if (window.innerWidth < 768 &&
                    !filtersSidebar.contains(e.target) &&
                    !mobileFilterToggle.contains(e.target) &&
                    filtersSidebar.style.display === 'block') {
                    filtersSidebar.style.display = 'none';
                    filtersSidebar.classList.remove('fixed', 'inset-0', 'z-50', 'bg-white', 'p-6', 'overflow-y-auto');
                    document.body.style.overflow = 'auto';
                }
            });

            // Handle window resize
            window.addEventListener('resize', handleResize);

            // Initialize search functionality
            if (searchInput.value) {
                handleSearch();
            }
        }

        // Handle window resize
        function handleResize() {
            if (window.innerWidth >= 768) {
                // On desktop, ensure filters are visible
                filtersSidebar.style.display = 'block';
                filtersSidebar.classList.remove('fixed', 'inset-0', 'z-50', 'bg-white', 'p-6', 'overflow-y-auto');
                document.body.style.overflow = 'auto';
            } else {
                // On mobile, hide filters by default
                if (!filtersSidebar.classList.contains('fixed')) {
                    filtersSidebar.style.display = 'none';
                }
            }
        }

        // Handle search - FIXED VERSION
        function handleSearch() {
            const searchTerm = searchInput.value.trim().toLowerCase();

            if (searchTerm === '') {
                // If search is cleared, reset to all items
                filteredItems = [...allItems];
            } else {
                filteredItems = allItems.filter(item => {
                    if (item.type === 'video') {
                        return (
                            item.title.toLowerCase().includes(searchTerm) ||
                            item.presenter.toLowerCase().includes(searchTerm) ||
                            item.description.toLowerCase().includes(searchTerm) ||
                            item.category.toLowerCase().includes(searchTerm)
                        );
                    } else if (item.type === 'product') {
                        return (
                            item.name.toLowerCase().includes(searchTerm) ||
                            item.description.toLowerCase().includes(searchTerm) ||
                            (item.ingredients && item.ingredients.some(ing => ing.toLowerCase().includes(searchTerm))) ||
                            item.category.toLowerCase().includes(searchTerm)
                        );
                    } else if (item.type === 'book') {
                        return (
                            item.title.toLowerCase().includes(searchTerm) ||
                            item.author.toLowerCase().includes(searchTerm) ||
                            item.description.toLowerCase().includes(searchTerm) ||
                            item.category.toLowerCase().includes(searchTerm)
                        );
                    } else if (item.type === 'testimonial') {
                        return (
                            item.name.toLowerCase().includes(searchTerm) ||
                            item.quote.toLowerCase().includes(searchTerm) ||
                            item.description.toLowerCase().includes(searchTerm) ||
                            item.location.toLowerCase().includes(searchTerm)
                        );
                    }
                    return false;
                });
            }

            // Reset to first page when searching
            currentPage = 1;
            totalPages = Math.ceil(filteredItems.length / itemsPerPage);

            renderContent();
            updateResultsCount();
            renderPagination();
            updateActiveFiltersDisplay();
        }

        // Handle filter change
        function handleFilterChange(e) {
            const filterType = e.target.dataset.filter;
            const value = e.target.value;

            if (filterType === 'type' || filterType === 'category') {
                if (e.target.checked) {
                    activeFilters[filterType].push(value);
                } else {
                    activeFilters[filterType] = activeFilters[filterType].filter(item => item !== value);
                }
            } else if (filterType === 'price') {
                activeFilters.price = e.target.checked ? value : null;
            }

            // Reset to first page when filtering
            currentPage = 1;
            applyFilters();
            updateActiveFiltersDisplay();
        }

        // Handle rating filter
        function handleRatingFilter(rating) {
            // Toggle rating filter
            if (activeFilters.rating === rating) {
                activeFilters.rating = null;
            } else {
                activeFilters.rating = rating;
            }

            // Reset to first page when filtering
            currentPage = 1;

            // Update button styles
            document.querySelectorAll('.filter-rating').forEach(button => {
                if (button.dataset.rating === rating && activeFilters.rating === rating) {
                    button.classList.add('bg-blue-100', 'text-primary');
                    button.classList.remove('bg-gray-100', 'text-gray-700');
                } else {
                    button.classList.remove('bg-blue-100', 'text-primary');
                    button.classList.add('bg-gray-100', 'text-gray-700');
                }
            });

            applyFilters();
            updateActiveFiltersDisplay();
        }

        // Apply all active filters
        function applyFilters() {
            let results = [...allItems];

            // Apply search filter if there's a search term
            const searchTerm = searchInput.value.trim().toLowerCase();
            if (searchTerm) {
                results = results.filter(item => {
                    if (item.type === 'video') {
                        return (
                            item.title.toLowerCase().includes(searchTerm) ||
                            item.presenter.toLowerCase().includes(searchTerm) ||
                            item.description.toLowerCase().includes(searchTerm) ||
                            item.category.toLowerCase().includes(searchTerm)
                        );
                    } else if (item.type === 'product') {
                        return (
                            item.name.toLowerCase().includes(searchTerm) ||
                            item.description.toLowerCase().includes(searchTerm) ||
                            (item.ingredients && item.ingredients.some(ing => ing.toLowerCase().includes(searchTerm))) ||
                            item.category.toLowerCase().includes(searchTerm)
                        );
                    } else if (item.type === 'book') {
                        return (
                            item.title.toLowerCase().includes(searchTerm) ||
                            item.author.toLowerCase().includes(searchTerm) ||
                            item.description.toLowerCase().includes(searchTerm) ||
                            item.category.toLowerCase().includes(searchTerm)
                        );
                    } else if (item.type === 'testimonial') {
                        return (
                            item.name.toLowerCase().includes(searchTerm) ||
                            item.quote.toLowerCase().includes(searchTerm) ||
                            item.description.toLowerCase().includes(searchTerm) ||
                            item.location.toLowerCase().includes(searchTerm)
                        );
                    }
                    return false;
                });
            }

            // Apply type filter
            if (activeFilters.type.length > 0) {
                results = results.filter(item => activeFilters.type.includes(item.type));
            }

            // Apply category filter
            if (activeFilters.category.length > 0) {
                results = results.filter(item => activeFilters.category.includes(item.category));
            }

            // Apply price filter
            if (activeFilters.price) {
                results = results.filter(item => {
                    const [min, max] = activeFilters.price.split('-').map(val => val === '+' ? Infinity : parseInt(val));

                    if (activeFilters.price === '60+') {
                        return item.price >= 60;
                    } else {
                        return item.price >= min && item.price <= max;
                    }
                });
            }

            // Apply rating filter
            if (activeFilters.rating) {
                const minRating = parseFloat(activeFilters.rating);
                results = results.filter(item => item.rating >= minRating);
            }

            filteredItems = results;
            totalPages = Math.ceil(filteredItems.length / itemsPerPage);

            // Ensure current page is valid
            if (currentPage > totalPages && totalPages > 0) {
                currentPage = totalPages;
            } else if (totalPages === 0) {
                currentPage = 1;
            }

            renderContent();
            updateResultsCount();
            renderPagination();
        }

        // Clear all filters
        function clearFilters() {
            // Reset active filters
            activeFilters = {
                type: [],
                category: [],
                price: null,
                rating: null
            };

            // Uncheck all checkboxes and radios
            document.querySelectorAll('input[data-filter]').forEach(input => {
                input.checked = false;
            });

            // Reset rating buttons
            document.querySelectorAll('.filter-rating').forEach(button => {
                button.classList.remove('bg-blue-100', 'text-primary');
                button.classList.add('bg-gray-100', 'text-gray-700');
            });

            // Clear search
            searchInput.value = '';

            // Reset to first page
            currentPage = 1;

            // Reset items
            filteredItems = [...allItems];
            totalPages = Math.ceil(filteredItems.length / itemsPerPage);

            // Re-render
            renderContent();
            updateResultsCount();
            updateActiveFiltersDisplay();
            renderPagination();
        }

        // Handle sort change
        function handleSortChange() {
            const sortBy = sortSelect.value || sortSelectMobile.value;

            switch(sortBy) {
                case 'rating':
                    filteredItems.sort((a, b) => b.rating - a.rating);
                    break;
                case 'price-low':
                    filteredItems.sort((a, b) => a.price - b.price);
                    break;
                case 'price-high':
                    filteredItems.sort((a, b) => b.price - a.price);
                    break;
                case 'name':
                    filteredItems.sort((a, b) => {
                        const aName = a.title || a.name || '';
                        const bName = b.title || b.name || '';
                        return aName.localeCompare(bName);
                    });
                    break;
                case 'views':
                    filteredItems.sort((a, b) => (b.views || 0) - (a.views || 0));
                    break;
            }

            // Reset to first page when sorting
            currentPage = 1;
            renderContent();
            renderPagination();
        }

        // Switch between grid and list view with persistence
        function switchView(view, initialLoad = false) {
            currentView = view;

            // Save to localStorage
            localStorage.setItem('wellnessView', view);

            if (view === 'grid') {
                contentView.className = 'grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3  gap-6';
                gridViewButton.classList.add('bg-blue-100', 'text-primary');
                listViewButton.classList.remove('bg-blue-100', 'text-primary');
                listViewButton.classList.add('text-gray-500', 'hover:bg-gray-100');
            } else {
                contentView.className = 'flex flex-col gap-6';
                listViewButton.classList.add('bg-blue-100', 'text-primary');
                gridViewButton.classList.remove('bg-blue-100', 'text-primary');
                gridViewButton.classList.add('text-gray-500', 'hover:bg-gray-100');
            }

            if (!initialLoad) {
                renderContent();
            }

            // filter hidden
        }

        // Update results count display
        function updateResultsCount() {
            const start = (currentPage - 1) * itemsPerPage + 1;
            const end = Math.min(currentPage * itemsPerPage, filteredItems.length);
            const total = filteredItems.length;

            pageStart.textContent = start;
            pageEnd.textContent = end;
            totalItems.textContent = total;

            resultsCount.textContent = `Showing ${start}-${end} of ${total} results`;
        }

        // Update active filters display
        function updateActiveFiltersDisplay() {
            // Clear current filter tags
            filterTags.innerHTML = '';

            // Add type filters
            activeFilters.type.forEach(type => {
                const tag = document.createElement('div');
                tag.className = 'flex items-center bg-blue-50 text-primary px-3 py-1 rounded-full text-sm';
                tag.innerHTML = `
                    ${getTypeName(type)}
                    <button class="ml-2 text-primary hover:text-green-900" data-filter="type" data-value="${type}">
                        <i class="fas fa-times"></i>
                    </button>
                `;
                filterTags.appendChild(tag);
            });

            // Add category filters
            activeFilters.category.forEach(category => {
                const tag = document.createElement('div');
                tag.className = 'flex items-center bg-green-50 text-green-700 px-3 py-1 rounded-full text-sm';
                tag.innerHTML = `
                    ${getCategoryName(category)}
                    <button class="ml-2 text-green-700 hover:text-green-900" data-filter="category" data-value="${category}">
                        <i class="fas fa-times"></i>
                    </button>
                `;
                filterTags.appendChild(tag);
            });

            // Add price filter
            if (activeFilters.price) {
                const tag = document.createElement('div');
                tag.className = 'flex items-center bg-yellow-50 text-yellow-700 px-3 py-1 rounded-full text-sm';
                tag.innerHTML = `
                    Price: ${getPriceRangeName(activeFilters.price)}
                    <button class="ml-2 text-yellow-700 hover:text-yellow-900" data-filter="price">
                        <i class="fas fa-times"></i>
                    </button>
                `;
                filterTags.appendChild(tag);
            }

            // Add rating filter
            if (activeFilters.rating) {
                const tag = document.createElement('div');
                tag.className = 'flex items-center bg-purple-50 text-purple-700 px-3 py-1 rounded-full text-sm';
                tag.innerHTML = `
                    Rating: ${activeFilters.rating}+ <i class="fas fa-star text-yellow-500 ml-1"></i>
                    <button class="ml-2 text-purple-700 hover:text-purple-900" data-filter="rating">
                        <i class="fas fa-times"></i>
                    </button>
                `;
                filterTags.appendChild(tag);
            }

            // Add event listeners to remove filter buttons
            filterTags.querySelectorAll('button').forEach(button => {
                button.addEventListener('click', (e) => {
                    const filterType = e.target.closest('button').dataset.filter;

                    if (filterType === 'type' || filterType === 'category') {
                        const value = e.target.closest('button').dataset.value;
                        activeFilters[filterType] = activeFilters[filterType].filter(item => item !== value);

                        // Uncheck the corresponding checkbox
                        const checkbox = document.querySelector(`input[data-filter="${filterType}"][value="${value}"]`);
                        if (checkbox) checkbox.checked = false;
                    } else if (filterType === 'price') {
                        activeFilters.price = null;

                        // Uncheck the corresponding radio
                        document.querySelectorAll('input[data-filter="price"]').forEach(radio => {
                            radio.checked = false;
                        });
                    } else if (filterType === 'rating') {
                        activeFilters.rating = null;

                        // Reset rating buttons
                        document.querySelectorAll('.filter-rating').forEach(btn => {
                            btn.classList.remove('bg-blue-100', 'text-primary');
                            btn.classList.add('bg-gray-100', 'text-gray-700');
                        });
                    }

                    // Reset to first page when removing filters
                    currentPage = 1;
                    applyFilters();
                    updateActiveFiltersDisplay();
                });
            });

            // Show/hide active filters container
            const activeFiltersContainer = document.getElementById('activeFilters');
            if (activeFilters.type.length > 0 || activeFilters.category.length > 0 || activeFilters.price || activeFilters.rating) {
                activeFiltersContainer.classList.remove('hidden');
            } else {
                activeFiltersContainer.classList.add('hidden');
            }
        }

        // Render pagination controls
        function renderPagination() {
            paginationControls.innerHTML = '';

            if (totalPages <= 1) return;

            // Previous button
            const prevButton = document.createElement('button');
            prevButton.className = `page-item px-3 py-2 border rounded-l-lg ${currentPage === 1 ? 'text-gray-400 cursor-not-allowed' : 'text-gray-700 hover:bg-gray-100'}`;
            prevButton.innerHTML = '<i class="fas fa-chevron-left"></i>';
            prevButton.disabled = currentPage === 1;
            prevButton.addEventListener('click', () => {
                if (currentPage > 1) {
                    currentPage--;
                    renderContent();
                    updateResultsCount();
                    renderPagination();
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }
            });
            paginationControls.appendChild(prevButton);

            // Page numbers
            const maxVisiblePages = window.innerWidth < 640 ? 3 : 5;
            let startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
            let endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);

            // Adjust if we're near the end
            if (endPage - startPage + 1 < maxVisiblePages) {
                startPage = Math.max(1, endPage - maxVisiblePages + 1);
            }

            // First page with ellipsis if needed
            if (startPage > 1) {
                const firstPageButton = document.createElement('button');
                firstPageButton.className = 'page-item px-3 py-2 border text-gray-700 hover:bg-gray-100';
                firstPageButton.textContent = '1';
                firstPageButton.addEventListener('click', () => {
                    currentPage = 1;
                    renderContent();
                    updateResultsCount();
                    renderPagination();
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                });
                paginationControls.appendChild(firstPageButton);

                if (startPage > 2) {
                    const ellipsis = document.createElement('span');
                    ellipsis.className = 'px-3 py-2 border text-gray-500';
                    ellipsis.textContent = '...';
                    paginationControls.appendChild(ellipsis);
                }
            }

            // Page number buttons
            for (let i = startPage; i <= endPage; i++) {
                const pageButton = document.createElement('button');
                pageButton.className = `page-item px-3 py-2 border ${currentPage === i ? 'active bg-primary text-white' : 'text-gray-700 hover:bg-gray-100'}`;
                pageButton.textContent = i;
                pageButton.addEventListener('click', () => {
                    currentPage = i;
                    renderContent();
                    updateResultsCount();
                    renderPagination();
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                });
                paginationControls.appendChild(pageButton);
            }

            // Last page with ellipsis if needed
            if (endPage < totalPages) {
                if (endPage < totalPages - 1) {
                    const ellipsis = document.createElement('span');
                    ellipsis.className = 'px-3 py-2 border text-gray-500';
                    ellipsis.textContent = '...';
                    paginationControls.appendChild(ellipsis);
                }

                const lastPageButton = document.createElement('button');
                lastPageButton.className = 'page-item px-3 py-2 border text-gray-700 hover:bg-gray-100';
                lastPageButton.textContent = totalPages;
                lastPageButton.addEventListener('click', () => {
                    currentPage = totalPages;
                    renderContent();
                    updateResultsCount();
                    renderPagination();
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                });
                paginationControls.appendChild(lastPageButton);
            }

            // Next button
            const nextButton = document.createElement('button');
            nextButton.className = `page-item px-3 py-2 border rounded-r-lg ${currentPage === totalPages ? 'text-gray-400 cursor-not-allowed' : 'text-gray-700 hover:bg-gray-100'}`;
            nextButton.innerHTML = '<i class="fas fa-chevron-right"></i>';
            nextButton.disabled = currentPage === totalPages;
            nextButton.addEventListener('click', () => {
                if (currentPage < totalPages) {
                    currentPage++;
                    renderContent();
                    updateResultsCount();
                    renderPagination();
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }
            });
            paginationControls.appendChild(nextButton);
        }

        // Helper function to get type name from value
        function getTypeName(value) {
            const typeMap = {
                'video': 'Video',
                'product': 'Product',
                'book': 'Book',
                'testimonial': 'Testimonial'
            };
            return typeMap[value] || value;
        }

        // Helper function to get category name from value
        function getCategoryName(value) {
            const categoryMap = {
                'introduction': 'Introduction',
                'science': 'Science',
                'nutrition': 'Nutrition',
                'exercise': 'Exercise',
                'mental-health': 'Mental Health',
                'sleep': 'Sleep',
                'supplement': 'Supplement',
                'holistic-health': 'Holistic Health',
                'longevity': 'Longevity',
                'Testimonials': 'Testimonials'
            };
            return categoryMap[value] || value;
        }

        // Helper function to get price range name from value
        function getPriceRangeName(value) {
            const priceMap = {
                '0-20': 'Under $20',
                '20-40': '$20-$40',
                '40-60': '$40-$60',
                '60+': 'Over $60'
            };
            return priceMap[value] || value;
        }

        // Get type color class
        function getTypeColor(type) {
            const colorMap = {
                'video': 'video-type',
                'product': 'product-type',
                'book': 'book-type',
                'testimonial': 'testimonial-type'
            };
            return colorMap[type] || 'video-type';
        }

        // Get type icon
        function getTypeIcon(type) {
            const iconMap = {
                'video': 'fa-play-circle',
                'product': 'fa-capsules',
                'book': 'fa-book',
                'testimonial': 'fa-quote-right'
            };
            return iconMap[type] || 'fa-play-circle';
        }

        // Render content based on current view
        function renderContent() {
            contentView.innerHTML = '';

            // Calculate items for current page
            const startIndex = (currentPage - 1) * itemsPerPage;
            const endIndex = Math.min(startIndex + itemsPerPage, filteredItems.length);
            const itemsToShow = filteredItems.slice(startIndex, endIndex);

            if (itemsToShow.length === 0) {
                contentView.innerHTML = `
                    <div class="col-span-full text-center py-12">
                        <i class="fas fa-search text-5xl text-gray-300 mb-4"></i>
                        <h3 class="text-xl font-medium text-gray-700 mb-2">No results found</h3>
                        <p class="text-gray-500">Try adjusting your filters or search terms</p>
                        <button id="clearFiltersFromEmpty" class="mt-4 px-4 py-2 bg-primary text-white rounded-lg font-medium hover:bg-primary transition-colors">
                            Clear All Filters
                        </button>
                    </div>
                `;

                document.getElementById('clearFiltersFromEmpty')?.addEventListener('click', clearFilters);
                return;
            }

            itemsToShow.forEach(item => {
                const itemElement = document.createElement('div');
                itemElement.className = `bg-white rounded-xl shadow-sm overflow-hidden card-hover ${currentView === 'list' ? 'flex flex-col md:flex-row' : ''}`;

                if (item.type === 'video') {
                    itemElement.innerHTML = `
                        <div class="${currentView === 'list' ? 'md:w-1/3 lg:w-1/4' : ''}">
                            <div class="relative h-48 ${currentView === 'list' ? 'md:h-full' : 'md:h-48 lg:h-56 xl:h-48'} overflow-hidden">
                                <img src="${item.thumbnail}" alt="${item.title}" class="w-full h-full object-cover">
                                <div class="${getTypeColor(item.type)} type-indicator">
                                    <i class="${getTypeIcon(item.type)} mr-1"></i> Video
                                </div>
                                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4">
                                    <div class="text-white font-medium">${item.duration}</div>
                                </div>
                                <div class="absolute top-12 left-4 bg-black/70 text-white px-2 py-1 rounded text-sm">
                                    <i class="fas fa-eye mr-1"></i> ${item.views.toLocaleString()}
                                </div>
                            </div>
                        </div>
                        <div class="p-6 ${currentView === 'list' ? 'md:w-2/3 lg:w-3/4' : ''}">
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <h3 class="text-xl font-bold text-gray-800">${item.title}</h3>
                                    <p class="text-gray-600">Presented by ${item.presenter}</p>
                                </div>
                                <div class="flex items-center bg-blue-50 text-primary px-3 py-1 rounded-full">
                                    <span class="font-bold mr-1">${item.rating}</span>
                                    <i class="fas fa-star text-yellow-500"></i>
                                </div>
                            </div>

                            <p class="text-gray-700 mb-4">${item.description}</p>

                            <div class="mb-6">
                                <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm mr-2">
                                    ${getCategoryName(item.category)}
                                </span>
                                <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm">
                                    <i class="fas fa-clock mr-1"></i>${item.duration}
                                </span>
                            </div>

                            <div class="flex justify-between items-center">
                                <div class="text-gray-600">
                                    <i class="fas fa-user mr-1"></i>
                                    <span>${item.presenter}</span>
                                </div>
                                <div class="flex space-x-3">
                                    <button class="px-4 py-2 border border-primary text-primary rounded-lg font-medium hover:bg-blue-50 transition-colors">
                                        <i class="fas fa-play mr-2"></i>Watch
                                    </button>
                                    <button class="px-4 py-2 bg-primary text-white rounded-lg font-medium hover:bg-green-700 transition-colors">
                                        Details
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;
                } else if (item.type === 'product') {
                    itemElement.innerHTML = `
                        <div class="${currentView === 'list' ? 'md:w-1/3 lg:w-1/4' : ''}">
                            <div class="relative h-48 ${currentView === 'list' ? 'md:h-full' : 'md:h-48 lg:h-56 xl:h-48'} overflow-hidden">
                                <img src="${item.image}" alt="${item.name}" class="w-full h-full object-cover">
                                <div class="${getTypeColor(item.type)} type-indicator">
                                    <i class="${getTypeIcon(item.type)} mr-1"></i> Product
                                </div>
                                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4">
                                    <div class="text-white font-bold text-xl">$${item.price}</div>
                                </div>
                            </div>
                        </div>
                        <div class="p-6 ${currentView === 'list' ? 'md:w-2/3 lg:w-3/4' : ''}">
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <h3 class="text-xl font-bold text-gray-800">${item.name}</h3>
                                    <p class="text-gray-600">${getCategoryName(item.category)}</p>
                                </div>
                                <div class="flex items-center bg-blue-50 text-primary px-3 py-1 rounded-full">
                                    <span class="font-bold mr-1">${item.rating}</span>
                                    <i class="fas fa-star text-yellow-500"></i>
                                </div>
                            </div>

                            <p class="text-gray-700 mb-4">${item.description}</p>

                            <div class="mb-6">
                                <h4 class="font-medium text-gray-800 mb-2">Key Ingredients:</h4>
                                <div class="flex flex-wrap gap-2">
                                    ${item.ingredients.map(ing => `<span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm">${ing}</span>`).join('')}
                                </div>
                            </div>

                            <div class="flex justify-between items-center">
                                <div class="text-gray-600">
                                    <i class="fas fa-box mr-1"></i>
                                    <span>${item.stock} in stock</span>
                                </div>
                                <div class="flex space-x-3">
                                    <button class="px-4 py-2 border border-primary text-primary rounded-lg font-medium hover:bg-blue-50 transition-colors">
                                        <i class="fas fa-info-circle mr-2"></i>Details
                                    </button>
                                    <button class="px-4 py-2 bg-green-600 text-white rounded-lg font-medium hover:bg-green-700 transition-colors">
                                        <i class="fas fa-cart-plus mr-2"></i>Add to Cart
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;
                } else if (item.type === 'book') {
                    itemElement.innerHTML = `
                        <div class="${currentView === 'list' ? 'md:w-1/3 lg:w-1/4' : ''}">
                            <div class="relative h-48 ${currentView === 'list' ? 'md:h-full' : 'md:h-48 lg:h-56 xl:h-48'} overflow-hidden">
                                <img src="${item.image}" alt="${item.title}" class="w-full h-full object-cover">
                                <div class="${getTypeColor(item.type)} type-indicator">
                                    <i class="${getTypeIcon(item.type)} mr-1"></i> Book
                                </div>
                                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4">
                                    <div class="text-white font-bold text-xl">$${item.price}</div>
                                </div>
                            </div>
                        </div>
                        <div class="p-6 ${currentView === 'list' ? 'md:w-2/3 lg:w-3/4' : ''}">
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <h3 class="text-xl font-bold text-gray-800">${item.title}</h3>
                                    <p class="text-gray-600">By ${item.author}</p>
                                </div>
                                <div class="flex items-center bg-blue-50 text-primary px-3 py-1 rounded-full">
                                    <span class="font-bold mr-1">${item.rating}</span>
                                    <i class="fas fa-star text-yellow-500"></i>
                                </div>
                            </div>

                            <p class="text-gray-700 mb-4">${item.description}</p>

                            <div class="mb-6">
                                <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm mr-2">
                                    ${getCategoryName(item.category)}
                                </span>
                                <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm">
                                    <i class="fas fa-book-open mr-1"></i>${item.pages} pages
                                </span>
                            </div>

                            <div class="flex justify-between items-center">
                                <div class="text-gray-600">
                                    <i class="fas fa-user-edit mr-1"></i>
                                    <span>${item.author}</span>
                                </div>
                                <div class="flex space-x-3">
                                    <button class="px-4 py-2 border border-primary text-primary rounded-lg font-medium hover:bg-blue-50 transition-colors">
                                        <i class="fas fa-eye mr-2"></i>Preview
                                    </button>
                                    <button class="px-4 py-2 bg-primary text-white rounded-lg font-medium hover:bg-green-700 transition-colors">
                                        <i class="fas fa-shopping-cart mr-2"></i>Buy Now
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;
                } else if (item.type === 'testimonial') {
                    itemElement.innerHTML = `
                        <div class="${currentView === 'list' ? 'md:w-1/3 lg:w-1/4' : ''}">
                            <div class="relative h-48 ${currentView === 'list' ? 'md:h-full' : 'md:h-48 lg:h-56 xl:h-48'} overflow-hidden">
                                <img src="${item.image}" alt="${item.name}" class="w-full h-full object-cover">
                                <div class="${getTypeColor(item.type)} type-indicator">
                                    <i class="${getTypeIcon(item.type)} mr-1"></i> Testimonial
                                </div>
                                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4">
                                    <div class="text-white font-medium">${item.age} years old</div>
                                </div>
                            </div>
                        </div>
                        <div class="p-6 ${currentView === 'list' ? 'md:w-2/3 lg:w-3/4' : ''}">
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <h3 class="text-xl font-bold text-gray-800">${item.name}</h3>
                                    <p class="text-gray-600">${item.location}</p>
                                </div>
                                <div class="flex items-center bg-blue-50 text-primary px-3 py-1 rounded-full">
                                    <span class="font-bold mr-1">${item.rating}</span>
                                    <i class="fas fa-star text-yellow-500"></i>
                                </div>
                            </div>

                            <div class="mb-4 p-4 bg-blue-50 rounded-lg border-l-4 border-primary">
                                <i class="fas fa-quote-left text-blue-400 text-xl mb-2"></i>
                                <p class="text-gray-700 italic">"${item.quote}"</p>
                            </div>

                            <p class="text-gray-700 mb-6">${item.description}</p>

                            <div class="flex justify-between items-center">
                                <div class="text-gray-600">
                                    <i class="fas fa-map-marker-alt mr-1"></i>
                                    <span>${item.location}</span>
                                </div>
                                <div class="flex space-x-3">
                                    <button class="px-4 py-2 border border-primary text-primary rounded-lg font-medium hover:bg-blue-50 transition-colors">
                                        <i class="fas fa-share mr-2"></i>Share
                                    </button>
                                    <button class="px-4 py-2 bg-primary text-white rounded-lg font-medium hover:bg-primary transition-colors">
                                        Full Story
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;
                }

                contentView.appendChild(itemElement);
            });
        }

        // Initialize the page
        window.addEventListener('DOMContentLoaded', init);
    </script>






@endsection
