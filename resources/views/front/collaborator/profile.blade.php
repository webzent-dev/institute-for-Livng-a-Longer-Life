
@extends('front.layouts.app')
@section('content') 


<div class="max-w-7xl mx-auto">




    <main class="bg-gray-100">

            <!-- PROFILE HEADER -->
            <div class="bg-white shadow">
            <div class="max-w-6xl mx-auto px-6 py-8 flex flex-col lg:flex-row items-center lg:items-start gap-6">

                <img src="https://i.pravatar.cc/200?img=12"
                class="w-40 h-40 object-cover rounded-full border-4 border-gray-200 shadow" />

                <div class="flex-1">
                <h1 class="text-2xl font-bold">Rohit Sharma</h1>
                <p class="text-gray-600 text-sm mt-1">Fitness Coach • Strength Training & Cardio Specialist</p>

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
            <aside class="w-full lg:w-80 bg-white p-5 rounded-xl shadow">
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
                    <span class="px-3 py-1 bg-blue-100 text-blue-600 rounded-full text-xs">Online</span>
                    <span class="px-3 py-1 bg-green-100 text-green-600 rounded-full text-xs">Offline</span>
                    <span class="px-3 py-1 bg-orange-100 text-orange-600 rounded-full text-xs">Workshops</span>
                </div>
                </div>
            </aside>

            <!-- RIGHT CONTENT -->
            <main class="flex-1 space-y-8">

                <!-- ABOUT SECTION -->
                <section class="bg-white p-6 rounded-xl shadow">
                <h2 class="text-xl font-semibold mb-3">About</h2>
                <p class="text-sm text-gray-700 leading-relaxed">
                    I am a certified fitness coach helping people improve physical strength, stamina, and
                    overall lifestyle. I specialize in personalized training plans designed for weight loss,
                    bodybuilding, and general health improvement. My goal is to help individuals build a
                    healthy routine through structured workouts and balanced nutrition.
                </p>
                </section>

                <!-- SERVICES SECTION -->
                <section class="bg-white p-6 rounded-xl shadow">
                <h2 class="text-xl font-semibold mb-3">Services Offered</h2>
                <ul class="list-disc ml-6 text-sm text-gray-700 space-y-1">
                    <li>1-on-1 Personal Training</li>
                    <li>Online Training Sessions</li>
                    <li>Custom Workout Plans</li>
                    <li>Diet & Nutrition Planning</li>
                </ul>
                </section>

                <!-- WORKSHOPS SECTION -->
                <section class="bg-white p-6 rounded-xl shadow">
                <h2 class="text-xl font-semibold mb-3">Workshops & Events</h2>

                <div class="space-y-4">
                    <div class="border rounded-lg p-4 flex justify-between items-center">
                    <div>
                        <p class="font-medium">Weight Loss Bootcamp</p>
                        <p class="text-xs text-gray-500">Starts: 15th Feb 2026 • 6 Sessions</p>
                    </div>
                    <button class="px-4 py-2 text-sm bg-blue-600 text-white rounded-md">Join</button>
                    </div>

                    <div class="border rounded-lg p-4 flex justify-between items-center">
                    <div>
                        <p class="font-medium">Cardio & Endurance Masterclass</p>
                        <p class="text-xs text-gray-500">Starts: 20th Feb 2026 • 4 Sessions</p>
                    </div>
                    <button class="px-4 py-2 text-sm bg-blue-600 text-white rounded-md">Join</button>
                    </div>
                </div>
                </section>

                <!-- REVIEWS SECTION -->
                <section class="bg-white p-6 rounded-xl shadow">
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

            </main>
            </div>

    </main>

    <main class="bg-gray-50">
        <div class="container mx-auto px-4 py-6">
            <!-- Header with search -->
            <header class="mb-8">
                <div class="flex flex-col md:flex-row justify-between items-center mb-6">
                    <h1 class="text-3xl font-bold text-gray-800 mb-4 md:mb-0">
                        <span class="text-primary">Collaborator</span> Marketplace
                    </h1>
                    
                    <div class="relative w-full md:w-1/3">
                        <input 
                            type="text" 
                            id="searchInput" 
                            placeholder="Search collaborators, services, or skills..."
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
                    <p class="text-gray-600">Find and connect with talented collaborators for your projects</p>
                    <div class="hidden md:flex items-center space-x-4">
                        <span class="text-gray-600">View:</span>
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
                <button id="mobileFilterToggle" class="w-full p-3 bg-primary text-white rounded-lg font-medium flex items-center justify-center">
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
                        
                        <!-- Category filter -->
                        <div class="mb-8">
                            <h3 class="font-bold text-lg text-gray-800 mb-4">Category</h3>
                            <div class="space-y-3">
                                <label class="flex items-center cursor-pointer">
                                    <div class="relative">
                                        <input type="checkbox" class="checkbox-custom appearance-none w-5 h-5 border border-gray-300 rounded checked:border-primary focus:outline-none" data-filter="category" value="web-dev">
                                        <span class="ml-3 text-gray-700">Web Development</span>
                                    </div>
                                    <span class="ml-auto text-gray-500">(12)</span>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <div class="relative">
                                        <input type="checkbox" class="checkbox-custom appearance-none w-5 h-5 border border-gray-300 rounded checked:border-primary focus:outline-none" data-filter="category" value="design">
                                        <span class="ml-3 text-gray-700">UI/UX Design</span>
                                    </div>
                                    <span class="ml-auto text-gray-500">(8)</span>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <div class="relative">
                                        <input type="checkbox" class="checkbox-custom appearance-none w-5 h-5 border border-gray-300 rounded checked:border-primary focus:outline-none" data-filter="category" value="marketing">
                                        <span class="ml-3 text-gray-700">Digital Marketing</span>
                                    </div>
                                    <span class="ml-auto text-gray-500">(15)</span>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <div class="relative">
                                        <input type="checkbox" class="checkbox-custom appearance-none w-5 h-5 border border-gray-300 rounded checked:border-primary focus:outline-none" data-filter="category" value="content">
                                        <span class="ml-3 text-gray-700">Content Creation</span>
                                    </div>
                                    <span class="ml-auto text-gray-500">(6)</span>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <div class="relative">
                                        <input type="checkbox" class="checkbox-custom appearance-none w-5 h-5 border border-gray-300 rounded checked:border-primary focus:outline-none" data-filter="category" value="mobile">
                                        <span class="ml-3 text-gray-700">Mobile Development</span>
                                    </div>
                                    <span class="ml-auto text-gray-500">(9)</span>
                                </label>
                            </div>
                        </div>
                        
                        <!-- Price filter -->
                        <div class="mb-8">
                            <h3 class="font-bold text-lg text-gray-800 mb-4">Price Range</h3>
                            <div class="space-y-3">
                                <label class="flex items-center cursor-pointer">
                                    <div class="relative">
                                        <input type="radio" name="price" class="appearance-none w-5 h-5 border border-gray-300 rounded-full checked:border-primary focus:outline-none checked:before:content-[''] checked:before:block  checked:before:bg-primary checked:before:rounded-full checkbox-custom " data-filter="price" value="0-50">
                                        <span class="ml-3 text-gray-700">Under $50/hr</span>
                                    </div>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <div class="relative">
                                        <input type="radio" name="price" class="appearance-none w-5 h-5 border border-gray-300 rounded-full checked:border-primary focus:outline-none checked:before:content-[''] checked:before:block  checked:before:bg-primary checked:before:rounded-full checkbox-custom" data-filter="price" value="50-100">
                                        <span class="ml-3 text-gray-700">$50 - $100/hr</span>
                                    </div>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <div class="relative">
                                        <input type="radio" name="price" class="appearance-none w-5 h-5 border border-gray-300 rounded-full checked:border-primary focus:outline-none checked:before:content-[''] checked:before:block  checked:before:bg-primary checked:before:rounded-full checkbox-custom" data-filter="price" value="100-200">
                                        <span class="ml-3 text-gray-700">$100 - $200/hr</span>
                                    </div>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <div class="relative">
                                        <input type="radio" name="price" class="appearance-none w-5 h-5 border border-gray-300 rounded-full checked:border-primary focus:outline-none checked:before:content-[''] checked:before:block  checked:before:bg-primary checked:before:rounded-full checkbox-custom" data-filter="price" value="200+">
                                        <span class="ml-3 text-gray-700">Over $200/hr</span>
                                    </div>
                                </label>
                            </div>
                        </div>
                        
                        <!-- Rating filter -->
                        <div class="mb-8">
                            <h3 class="font-bold text-lg text-gray-800 mb-4">Rating</h3>
                            <div class="flex space-x-2">
                                <button class="filter-rating px-3 py-1 bg-gray-100 rounded-full text-gray-700 hover:bg-blue-100 hover:text-primary" data-rating="5">
                                    5 <i class="fas fa-star text-yellow-500 ml-1"></i>
                                </button>
                                <button class="filter-rating px-3 py-1 bg-gray-100 rounded-full text-gray-700 hover:bg-blue-100 hover:text-primary" data-rating="4">
                                    4+ <i class="fas fa-star text-yellow-500 ml-1"></i>
                                </button>
                                <button class="filter-rating px-3 py-1 bg-gray-100 rounded-full text-gray-700 hover:bg-blue-100 hover:text-primary" data-rating="3">
                                    3+ <i class="fas fa-star text-yellow-500 ml-1"></i>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Clear filters button -->
                        <button id="clearFilters" class="w-full py-3 bg-gray-100 text-gray-700 rounded-lg font-medium hover:bg-gray-200 transition-colors">
                            Clear All Filters
                        </button>
                    </div>
                    
                    <!-- Active filters display -->
                    <div id="activeFilters" class="bg-white rounded-xl p-4 shadow-sm mb-6">
                        <h3 class="font-bold text-gray-800 mb-3">Active Filters</h3>
                        <div id="filterTags" class="flex flex-wrap gap-2">
                            <!-- Filter tags will appear here -->
                        </div>
                    </div>
                </aside>

                <!-- Collaborator profiles view -->
                <main class="w-full md:w-3/4 lg:w-4/5">
                    <div class="mb-6 flex justify-between items-center">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800">Collaborators</h2>
                            <p id="resultsCount" class="text-gray-600">Showing 12 of 50 results</p>
                        </div>
                        
                        <div class="hidden md:flex items-center space-x-4">
                            <span class="text-gray-600">Sort by:</span>
                            <select id="sortSelect" class="p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                                <option value="rating">Highest Rated</option>
                                <option value="price-low">Price: Low to High</option>
                                <option value="price-high">Price: High to Low</option>
                                <option value="name">Name: A to Z</option>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Collaborator profiles grid/list -->
                    <div id="collaboratorView" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        <!-- Collaborator cards will be dynamically loaded here -->
                    </div>
                    
                    <!-- Load more button -->
                    <div class="mt-10 text-center">
                        <button id="loadMore" class="px-8 py-3 bg-primary text-white rounded-lg font-medium hover:bg-accent transition-colors">
                            Load More Collaborators
                        </button>
                    </div>
                </main>
            </div>
            
            <!-- Footer -->
            <footer class="mt-12 pt-8 border-t border-gray-200 text-center text-gray-600">
                <p>Collaborator Marketplace &copy; 2023. All rights reserved.</p>
                <p class="mt-2 text-sm">Find the perfect collaborator for your next project</p>
            </footer>
        </div>
    </main>
</div>
    <script>
        // Sample collaborator data
        const collaborators = [
            { id: 1, name: "Alex Johnson", role: "Full Stack Developer", category: "web-dev", price: 85, rating: 4.8, projects: 42, image: "https://randomuser.me/api/portraits/men/32.jpg", skills: ["React", "Node.js", "MongoDB"], description: "Experienced full-stack developer with 8+ years in web application development." },
            { id: 2, name: "Sophia Williams", role: "UI/UX Designer", category: "design", price: 75, rating: 4.9, projects: 28, image: "https://randomuser.me/api/portraits/women/44.jpg", skills: ["Figma", "Adobe XD", "Prototyping"], description: "Award-winning designer focused on creating intuitive user experiences." },
            { id: 3, name: "Michael Chen", role: "Digital Marketing Expert", category: "marketing", price: 65, rating: 4.7, projects: 56, image: "https://randomuser.me/api/portraits/men/22.jpg", skills: ["SEO", "Google Ads", "Social Media"], description: "Helping businesses grow through strategic digital marketing campaigns." },
            { id: 4, name: "Emma Davis", role: "Content Strategist", category: "content", price: 55, rating: 4.6, projects: 34, image: "https://randomuser.me/api/portraits/women/68.jpg", skills: ["Copywriting", "SEO", "Content Planning"], description: "Creating compelling content that drives engagement and conversions." },
            { id: 5, name: "David Wilson", role: "Mobile App Developer", category: "mobile", price: 95, rating: 4.8, projects: 39, image: "https://randomuser.me/api/portraits/men/54.jpg", skills: ["Flutter", "React Native", "iOS"], description: "Building cross-platform mobile applications with focus on performance." },
            { id: 6, name: "Olivia Martinez", role: "Frontend Developer", category: "web-dev", price: 70, rating: 4.5, projects: 31, image: "https://randomuser.me/api/portraits/women/26.jpg", skills: ["Vue.js", "CSS3", "JavaScript"], description: "Passionate about creating responsive and accessible web interfaces." },
            { id: 7, name: "James Taylor", role: "SEO Specialist", category: "marketing", price: 60, rating: 4.4, projects: 47, image: "https://randomuser.me/api/portraits/men/76.jpg", skills: ["Technical SEO", "Analytics", "Keyword Research"], description: "Driving organic traffic through comprehensive SEO strategies." },
            { id: 8, name: "Isabella Brown", role: "Product Designer", category: "design", price: 80, rating: 4.9, projects: 22, image: "https://randomuser.me/api/portraits/women/65.jpg", skills: ["User Research", "Wireframing", "Design Systems"], description: "Designing products that solve real user problems effectively." },
            { id: 9, name: "William Lee", role: "Backend Developer", category: "web-dev", price: 90, rating: 4.7, projects: 38, image: "https://randomuser.me/api/portraits/men/45.jpg", skills: ["Python", "Django", "PostgreSQL"], description: "Building robust and scalable backend systems for web applications." },
            { id: 10, name: "Ava Anderson", role: "Social Media Manager", category: "marketing", price: 50, rating: 4.6, projects: 29, image: "https://randomuser.me/api/portraits/women/33.jpg", skills: ["Instagram", "TikTok", "Community Management"], description: "Growing brand presence through strategic social media engagement." },
            { id: 11, name: "Benjamin Clark", role: "iOS Developer", category: "mobile", price: 110, rating: 4.8, projects: 24, image: "https://randomuser.me/api/portraits/men/67.jpg", skills: ["Swift", "UIKit", "Core Data"], description: "Crafting beautiful and functional iOS applications with Swift." },
            { id: 12, name: "Mia Lewis", role: "Technical Writer", category: "content", price: 45, rating: 4.5, projects: 41, image: "https://randomuser.me/api/portraits/women/50.jpg", skills: ["Documentation", "API Guides", "Tutorials"], description: "Creating clear and comprehensive technical documentation for developers." }
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
        const sortSelect = document.getElementById('sortSelect');
        const loadMoreButton = document.getElementById('loadMore');
        const collaboratorView = document.getElementById('collaboratorView');
        const resultsCount = document.getElementById('resultsCount');
        const filterTags = document.getElementById('filterTags');
        
        // State variables
        let currentView = 'grid'; // 'grid' or 'list'
        let activeFilters = {
            category: [],
            price: null,
            rating: null
        };
        let displayedCount = 8;
        let allCollaborators = [...collaborators];
        let filteredCollaborators = [...collaborators];

        // Initialize the page
        function init() {
            renderCollaborators();
            setupEventListeners();
            updateResultsCount();
        }

        // Set up event listeners
        function setupEventListeners() {
            // Search functionality
            searchInput.addEventListener('input', handleSearch);
            searchButton.addEventListener('click', handleSearch);
            
            // View toggle
            gridViewButton.addEventListener('click', () => switchView('grid'));
            listViewButton.addEventListener('click', () => switchView('list'));
            
            // Mobile filter toggle
            mobileFilterToggle.addEventListener('click', () => {
                filtersSidebar.classList.remove('hidden');
                filtersSidebar.classList.add('fixed', 'inset-0', 'z-50', 'bg-white', 'p-6', 'overflow-y-auto');
                document.body.style.overflow = 'hidden';
            });
            
            closeFilters.addEventListener('click', () => {
                filtersSidebar.classList.add('hidden');
                filtersSidebar.classList.remove('fixed', 'inset-0', 'z-50', 'bg-white', 'p-6', 'overflow-y-auto');
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
            
            // Clear filters
            clearFiltersButton.addEventListener('click', clearFilters);
            
            // Sort select
            sortSelect.addEventListener('change', handleSortChange);
            
            // Load more button
            loadMoreButton.addEventListener('click', loadMore);
        }

        // Handle search
        function handleSearch() {
            const searchTerm = searchInput.value.toLowerCase();
            
            filteredCollaborators = allCollaborators.filter(collaborator => {
                return (
                    collaborator.name.toLowerCase().includes(searchTerm) ||
                    collaborator.role.toLowerCase().includes(searchTerm) ||
                    collaborator.skills.some(skill => skill.toLowerCase().includes(searchTerm)) ||
                    collaborator.description.toLowerCase().includes(searchTerm)
                );
            });
            
            applyFilters();
        }

        // Handle filter change
        function handleFilterChange(e) {
            const filterType = e.target.dataset.filter;
            const value = e.target.value;
            
            if (filterType === 'category') {
                if (e.target.checked) {
                    activeFilters.category.push(value);
                } else {
                    activeFilters.category = activeFilters.category.filter(cat => cat !== value);
                }
            } else if (filterType === 'price') {
                activeFilters.price = e.target.checked ? value : null;
            }
            
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
            let results = [...allCollaborators];
            
            // Apply search filter if there's a search term
            const searchTerm = searchInput.value.toLowerCase();
            if (searchTerm) {
                results = results.filter(collaborator => {
                    return (
                        collaborator.name.toLowerCase().includes(searchTerm) ||
                        collaborator.role.toLowerCase().includes(searchTerm) ||
                        collaborator.skills.some(skill => skill.toLowerCase().includes(searchTerm)) ||
                        collaborator.description.toLowerCase().includes(searchTerm)
                    );
                });
            }
            
            // Apply category filter
            if (activeFilters.category.length > 0) {
                results = results.filter(collaborator => 
                    activeFilters.category.includes(collaborator.category)
                );
            }
            
            // Apply price filter
            if (activeFilters.price) {
                results = results.filter(collaborator => {
                    const [min, max] = activeFilters.price.split('-').map(val => val === '+' ? Infinity : parseInt(val));
                    
                    if (activeFilters.price === '200+') {
                        return collaborator.price >= 200;
                    } else {
                        return collaborator.price >= min && collaborator.price <= max;
                    }
                });
            }
            
            // Apply rating filter
            if (activeFilters.rating) {
                const minRating = parseInt(activeFilters.rating);
                results = results.filter(collaborator => collaborator.rating >= minRating);
            }
            
            filteredCollaborators = results;
            displayedCount = Math.min(8, filteredCollaborators.length);
            renderCollaborators();
            updateResultsCount();
        }

        // Clear all filters
        function clearFilters() {
            // Reset active filters
            activeFilters = {
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
            
            // Reset collaborators
            filteredCollaborators = [...allCollaborators];
            displayedCount = Math.min(8, filteredCollaborators.length);
            
            // Re-render
            renderCollaborators();
            updateResultsCount();
            updateActiveFiltersDisplay();
        }

        // Handle sort change
        function handleSortChange() {
            const sortBy = sortSelect.value;
            
            switch(sortBy) {
                case 'rating':
                    filteredCollaborators.sort((a, b) => b.rating - a.rating);
                    break;
                case 'price-low':
                    filteredCollaborators.sort((a, b) => a.price - b.price);
                    break;
                case 'price-high':
                    filteredCollaborators.sort((a, b) => b.price - a.price);
                    break;
                case 'name':
                    filteredCollaborators.sort((a, b) => a.name.localeCompare(b.name));
                    break;
            }
            
            renderCollaborators();
        }

        // Switch between grid and list view
        function switchView(view) {
            currentView = view;
            
            if (view === 'grid') {
                collaboratorView.className = 'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6';
                gridViewButton.classList.add('bg-blue-100', 'text-primary');
                listViewButton.classList.remove('bg-blue-100', 'text-primary');
                listViewButton.classList.add('text-gray-500', 'hover:bg-gray-100');
            } else {
                collaboratorView.className = 'flex flex-col gap-6';
                listViewButton.classList.add('bg-blue-100', 'text-primary');
                gridViewButton.classList.remove('bg-blue-100', 'text-primary');
                gridViewButton.classList.add('text-gray-500', 'hover:bg-gray-100');
            }
            
            renderCollaborators();
        }

        // Load more collaborators
        function loadMore() {
            displayedCount = Math.min(displayedCount + 4, filteredCollaborators.length);
            renderCollaborators();
            updateResultsCount();
            
            // Hide load more button if all collaborators are displayed
            if (displayedCount >= filteredCollaborators.length) {
                loadMoreButton.style.display = 'none';
            }
        }

        // Update results count display
        function updateResultsCount() {
            resultsCount.textContent = `Showing ${Math.min(displayedCount, filteredCollaborators.length)} of ${filteredCollaborators.length} results`;
            
            // Show/hide load more button
            if (displayedCount >= filteredCollaborators.length) {
                loadMoreButton.style.display = 'none';
            } else {
                loadMoreButton.style.display = 'inline-block';
            }
        }

        // Update active filters display
        function updateActiveFiltersDisplay() {
            // Clear current filter tags
            filterTags.innerHTML = '';
            
            // Add category filters
            activeFilters.category.forEach(category => {
                const tag = document.createElement('div');
                tag.className = 'flex items-center bg-blue-50 text-green-700 px-3 py-1 rounded-full text-sm';
                tag.innerHTML = `
                    ${getCategoryName(category)}
                    <button class="ml-2 text-primary hover:text-green-900" data-filter="category" data-value="${category}">
                        <i class="fas fa-times"></i>
                    </button>
                `;
                filterTags.appendChild(tag);
            });
            
            // Add price filter
            if (activeFilters.price) {
                const tag = document.createElement('div');
                tag.className = 'flex items-center bg-blue-50 text-primary px-3 py-1 rounded-full text-sm';
                tag.innerHTML = `
                    Price: ${getPriceRangeName(activeFilters.price)}
                    <button class="ml-2 text-primary hover:text-green-900" data-filter="price">
                        <i class="fas fa-times"></i>
                    </button>
                `;
                filterTags.appendChild(tag);
            }
            
            // Add rating filter
            if (activeFilters.rating) {
                const tag = document.createElement('div');
                tag.className = 'flex items-center bg-blue-50 text-primary px-3 py-1 rounded-full text-sm';
                tag.innerHTML = `
                    Rating: ${activeFilters.rating}+ <i class="fas fa-star text-yellow-500 ml-1"></i>
                    <button class="ml-2 text-primary hover:text-green-900" data-filter="rating">
                        <i class="fas fa-times"></i>
                    </button>
                `;
                filterTags.appendChild(tag);
            }
            
            // Add event listeners to remove filter buttons
            filterTags.querySelectorAll('button').forEach(button => {
                button.addEventListener('click', (e) => {
                    const filterType = e.target.closest('button').dataset.filter;
                    
                    if (filterType === 'category') {
                        const value = e.target.closest('button').dataset.value;
                        activeFilters.category = activeFilters.category.filter(cat => cat !== value);
                        
                        // Uncheck the corresponding checkbox
                        const checkbox = document.querySelector(`input[data-filter="category"][value="${value}"]`);
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
                    
                    applyFilters();
                    updateActiveFiltersDisplay();
                });
            });
            
            // Show/hide active filters container
            const activeFiltersContainer = document.getElementById('activeFilters');
            if (activeFilters.category.length > 0 || activeFilters.price || activeFilters.rating) {
                activeFiltersContainer.classList.remove('hidden');
            } else {
                activeFiltersContainer.classList.add('hidden');
            }
        }

        // Helper function to get category name from value
        function getCategoryName(value) {
            const categoryMap = {
                'web-dev': 'Web Development',
                'design': 'UI/UX Design',
                'marketing': 'Digital Marketing',
                'content': 'Content Creation',
                'mobile': 'Mobile Development'
            };
            return categoryMap[value] || value;
        }

        // Helper function to get price range name from value
        function getPriceRangeName(value) {
            const priceMap = {
                '0-50': 'Under $50/hr',
                '50-100': '$50-$100/hr',
                '100-200': '$100-$200/hr',
                '200+': 'Over $200/hr'
            };
            return priceMap[value] || value;
        }

        // Render collaborators based on current view
        function renderCollaborators() {
            collaboratorView.innerHTML = '';
            
            const collaboratorsToShow = filteredCollaborators.slice(0, displayedCount);
            
            collaboratorsToShow.forEach(collaborator => {
                const collaboratorElement = document.createElement('div');
                collaboratorElement.className = `bg-white rounded-xl shadow-sm overflow-hidden card-hover ${currentView === 'list' ? 'flex flex-col md:flex-row' : ''}`;
                
                collaboratorElement.innerHTML = `
                    <div class="${currentView === 'list' ? 'md:w-1/4' : ''}">
                        <div class="relative h-48 ${currentView === 'list' ? 'md:h-full' : ''} overflow-hidden">
                            <img src="${collaborator.image}" alt="${collaborator.name}" class="w-full h-full object-cover">
                            <div class="absolute top-4 right-4 bg-white px-2 py-1 rounded-full text-sm font-medium text-gray-800">
                                $${collaborator.price}/hr
                            </div>
                        </div>
                    </div>
                    <div class="p-6 ${currentView === 'list' ? 'md:w-3/4' : ''}">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <h3 class="text-xl font-bold text-gray-800">${collaborator.name}</h3>
                                <p class="text-gray-600">${collaborator.role}</p>
                            </div>
                            <div class="flex items-center bg-blue-50 text-primary px-3 py-1 rounded-full">
                                <span class="font-bold mr-1">${collaborator.rating}</span>
                                <i class="fas fa-star text-yellow-500"></i>
                            </div>
                        </div>
                        
                        <p class="text-gray-700 mb-4">${collaborator.description}</p>
                        
                        <div class="mb-6">
                            <h4 class="font-medium text-gray-800 mb-2">Skills:</h4>
                            <div class="flex flex-wrap gap-2">
                                ${collaborator.skills.map(skill => `<span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm">${skill}</span>`).join('')}
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <div class="text-gray-600">
                                <i class="fas fa-briefcase mr-1"></i>
                                <span>${collaborator.projects} projects</span>
                            </div>
                            <div class="flex space-x-3">
                                <button class="px-4 py-2 border border-primary text-primary rounded-lg font-medium hover:bg-blue-50 transition-colors">
                                    <i class="far fa-envelope mr-2"></i>Contact
                                </button>
                                <button class="px-4 py-2 bg-primary text-white rounded-lg font-medium hover:bg-primary transition-colors">
                                    View Profile
                                </button>
                            </div>
                        </div>
                    </div>
                `;
                
                collaboratorView.appendChild(collaboratorElement);
            });
        }

        // Initialize the page
        window.addEventListener('DOMContentLoaded', init);
    </script>
@endsection