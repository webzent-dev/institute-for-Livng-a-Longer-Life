@extends('front.layouts.app')
@section('content')
<div class="py-10 min-h-screen flex flex-col font-jakarta">
    <main class="flex-1">
        {!! $collaboratorPageContent->page_content !!}
        
        {{-- Collaborators Filter Section --}}
        <section class="bg-white border border-gray-200 mb-6 md:mb-10 p-4 md:p-6 rounded-2xl shadow-soft">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col gap-4 items-center justify-center mb-6 md:flex-row">
                    <div>
                        <h2 class="font-bold text-2xl md:text-3xl">Our Collaborators</h2>
                        <p class="mt-1 text-md text-muted-foreground">Find experts by name, specialty, or status</p>
                    </div>
                </div>

                <div class="gap-4 grid grid-cols-1 md:grid-cols-3 lg:grid-cols-3">
                    <div class="w-full">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Search by Name</label>
                        <div class="relative">
                            <input 
                                type="text" 
                                id="nameSearch" 
                                placeholder="Search collaborators..." 
                                class="w-full px-4 py-2 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none appearance-none bg-white"
                            >
                            <div class="absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none">
                                <i data-lucide="search" class="h-4 w-4 text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Featured Status</label>
                        <div class="relative">
                            <select 
                                id="featuredFilter" 
                                class="w-full px-4 py-2 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none appearance-none bg-white"
                            >
                                <option value="">All Status</option>
                                <option value="featured">Featured Only</option>
                                <option value="not-featured">Not Featured</option>
                            </select>
                            <div class="absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none">
                                <i data-lucide="chevron-down" class="h-4 w-4 text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-end">
                        <button 
                            id="clearFilters" 
                            class="w-full px-4 py-2 bg-red-50 text-red-700 border border-red-300 rounded-lg hover:bg-red-100 transition-colors flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed"
                            disabled
                        >
                            <i data-lucide="x" class="h-4 w-4"></i>
                            Clear Filters
                        </button>
                    </div>
                </div>

                <div id="activeFilters" class="hidden mt-4">
                    <div class="flex gap-2 items-center">
                        <span class="text-sm font-medium text-gray-700">Active filters:</span>
                        <div id="filterChips" class="flex flex-wrap gap-2"></div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Collaborators Grid --}}
        <section class="bg-background my-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                {{-- Grid Products View --}}
                <div id="collaboratorsGrid" class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($collaborators as $c)
                        <div class="flex flex-col card border-2 rounded-2xl {{ $c['featured'] ? 'border-primary shadow-medium' : 'shadow-soft' }} hover:border-primary py-4  collaborator-card" data-name="{{ strtolower($c['first_name']) }}" data-specialty="{{ $c['speciality'] }}" data-featured="{{ $c['featured'] ? 'featured' : 'not-featured' }}">
                            <div class="card-header pt-1 p-6 pb-0 ">
                                <div class="flex justify-between items-start mb-4">
                                    <!-- <x-ui.avatar name="{{ ucfirst($c['first_name']) }}" size="4" /> -->
                                     @if(!empty($c['profile_image']) && file_exists(public_path('user_images/' . $c['profile_image'])))
                                        <div class="flex items-center justify-center bg-emerald-500 text-white rounded-full font-semibold" style="width: 4rem; height: 4rem; font-size: 2rem;">
                                            <img src="{{ asset('user_images/' . $c['profile_image']) }}" alt="{{ ucfirst($c['first_name']) }} {{ ucfirst($c['last_name']) }}" class="w-full h-full object-cover rounded-full">
                                        </div>
                                     @else
                                        <!-- <img src="{{ asset('images/default-avatar.png') }}" alt="{{ ucfirst($c['first_name']) }} {{ ucfirst($c['last_name']) }}" class="w-full h-full object-cover rounded-full"> -->
                                        <x-ui.avatar name="{{ ucfirst($c['first_name']) }}" size="4" />
                                    @endif
                                    <!-- <x-badge class=""> Featured </x-badge> -->
                                    <!-- @if ($c['featured'])
                                        <x-badge class=""> Featured </x-badge>
                                    @endif -->
                                </div>
                                <h2 class="font-semibold tracking-tight text-xl md:text-2xl text-left">{{ ucfirst($c['first_name']) }} {{ ucfirst($c['last_name']) }}</h2>
                            </div>
                            <div class="p-6 pt-0 flex-1 flex flex-col">
                                <!--add limit with message if no description-->
                                <p class="text-muted-foreground mb-6 flex-1 text-sm md:text-[16px]">{{ Str::limit($c['collaborator_message'], 100) }}</p>
                                <div class="grid sm:grid-cols-1 gap-4 mb-2">
                                    <div class="flex items-center justify-between p-3 bg-secondary rounded-lg">
                                        <div class="flex items-center">
                                            <i data-lucide="video" class="h-5 w-5 text-primary mr-2"></i>
                                            <span class="font-medium text-foreground">Courses</span>
                                        </div>
                                        <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 text-foreground">  {{ $c->courses_count ?? 0 }}</div>
                                    </div>
                                    <div class="flex items-center justify-between p-3 bg-secondary rounded-lg">
                                        <div class="flex items-center">
                                                <i data-lucide="store" class="h-5 w-5 text-primary mr-2"></i>
                                            <span class="font-medium text-foreground">Products</span>
                                        </div>
                                        <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 text-foreground">  {{ $c->products_count ?? 0 }}</div>
                                    </div>
                                </div>
                                <div class="flex flex-col sm:flex-row gap-3 justify-center pt-2">
                                    <x-button-use href="{{ url('/collaborator/'.encrypt($c->id)) }}" label="View Profile" variant="primary"  icon="award" size="md"/>
                                    <x-button-use href="{{ url('/collaborator/'.encrypt($c->id)) }}#store" label="Visit Store" variant="outline" icon="store" size="md"/>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>


        {{-- JavaScript for Filtering --}}
        <script>
            document.addEventListener('DOMContentLoaded', function() {
            // Get DOM elements
            const nameSearch = document.getElementById('nameSearch');
            const featuredFilter = document.getElementById('featuredFilter');
            const clearFiltersBtn = document.getElementById('clearFilters');
            const resetAllFiltersBtn = document.getElementById('resetAllFilters');
            const activeFiltersDiv = document.getElementById('activeFilters');
            const filterChipsDiv = document.getElementById('filterChips');
            const resultsCount = document.getElementById('resultsCount');
            const noResults = document.getElementById('noResults');
            const collaboratorsGrid = document.getElementById('collaboratorsGrid');
            const collaboratorCards = document.querySelectorAll('.collaborator-card');

            // Store the original state
            const originalCards = Array.from(collaboratorCards);

            // Filter state
            let filters = {
                name: '',
                featured: ''
            };

            // Update select values based on filter state
            function updateSelectValues() {
                featuredFilter.value = filters.featured || '';
                nameSearch.value = filters.name || '';
            }

            // Event listeners for filters
            nameSearch.addEventListener('input', function() {
                filters.name = this.value.toLowerCase().trim();
                applyFilters();
                updateClearButton();
            });

            featuredFilter.addEventListener('change', function() {
                filters.featured = this.value;
                applyFilters();
                updateClearButton();
            });

            // Clear filters button
            clearFiltersBtn.addEventListener('click', function() {
                resetFilters();
                applyFilters();
            });

            // Reset all filters button (in no results message)
            resetAllFiltersBtn.addEventListener('click', function() {
                resetFilters();
                applyFilters();
                // Hide no results message
                noResults.classList.add('hidden');
                collaboratorsGrid.classList.remove('hidden');
            });

            // Reset all filters
            function resetFilters() {
                filters = {
                    name: '',
                    featured: ''
                };

                updateSelectValues();
                updateClearButton();
                updateActiveFiltersDisplay();
            }

            // Update clear button state
            function updateClearButton() {
                const hasFilters = filters.name || filters.featured;

                if (hasFilters) {
                    clearFiltersBtn.disabled = false;
                    clearFiltersBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                    clearFiltersBtn.classList.add('bg-red-50', 'text-red-700', 'border-red-300', 'hover:bg-red-100');
                } else {
                    clearFiltersBtn.disabled = true;
                    clearFiltersBtn.classList.add('opacity-50', 'cursor-not-allowed');
                    clearFiltersBtn.classList.remove('bg-red-50', 'text-red-700', 'border-red-300', 'hover:bg-red-100');
                }
            }

            // Update active filters display
            function updateActiveFiltersDisplay() {
                const activeFilters = [];

                if (filters.name) {
                    activeFilters.push({
                        type: 'name',
                        label: `Name: "${filters.name}"`,
                        value: filters.name
                    });
                }

                if (filters.featured) {
                    const label = filters.featured === 'featured' ? 'Featured Only' : 'Not Featured';
                    activeFilters.push({
                        type: 'featured',
                        label: label,
                        value: filters.featured
                    });
                }

                // Update active filters display
                if (activeFilters.length > 0) {
                    activeFiltersDiv.classList.remove('hidden');
                    filterChipsDiv.innerHTML = '';

                    activeFilters.forEach(filter => {
                        const chip = document.createElement('div');
                        chip.className = 'inline-flex items-center gap-1 bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm';
                        chip.innerHTML = `
                            <span>${filter.label}</span>
                            <button type="button" class="text-gray-500 hover:text-gray-700 remove-filter" data-type="${filter.type}" data-value="${filter.value}">
                                <i data-lucide="x" class="h-3 w-3"></i>
                            </button>
                        `;
                        filterChipsDiv.appendChild(chip);
                    });

                    // Initialize Lucide icons
                    if (window.lucide) {
                        lucide.createIcons();
                    }

                    // Add event listeners to remove buttons
                    document.querySelectorAll('.remove-filter').forEach(btn => {
                        btn.addEventListener('click', function() {
                            const type = this.getAttribute('data-type');
                            const value = this.getAttribute('data-value');
                            removeFilter(type, value);
                        });
                    });
                } else {
                    activeFiltersDiv.classList.add('hidden');
                }
            }

            // Remove specific filter
            function removeFilter(type, value) {
                switch(type) {
                    case 'name':
                        filters.name = '';
                        nameSearch.value = '';
                        break;
                    case 'featured':
                        filters.featured = '';
                        featuredFilter.value = '';
                        break;
                }

                applyFilters();
                updateClearButton();
            }

            // Apply filters to cards
            function applyFilters() {
                let visibleCount = 0;
                const totalCount = originalCards.length;

                originalCards.forEach(card => {
                    const name = card.getAttribute('data-name');
                    const featured = card.getAttribute('data-featured');

                    let matches = true;

                    // Name filter
                    if (filters.name && !name.includes(filters.name.toLowerCase())) {
                        matches = false;
                    }

                    // Featured filter
                    if (filters.featured && featured !== filters.featured) {
                        matches = false;
                    }

                    if (matches) {
                        card.style.display = 'flex';
                        visibleCount++;
                    } else {
                        card.style.display = 'none';
                    }
                });

                // Update results count
                // resultsCount.textContent = `Showing ${visibleCount} of ${totalCount} collaborators`;

                // // Show/hide no results message
                // if (visibleCount === 0) {
                //     noResults.classList.remove('hidden');
                //     collaboratorsGrid.classList.add('hidden');
                // } else {
                //     noResults.classList.add('hidden');
                //     collaboratorsGrid.classList.remove('hidden');
                // }

                // Update active filters display
                updateActiveFiltersDisplay();
            }

            // Initialize
            updateClearButton();
            applyFilters();

            // Initialize Lucide icons if available
            if (window.lucide) {
                lucide.createIcons();
            }
        });
        </script>
        <style>
        /* Animation for no results */
        #noResults {
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Better select styling */
        select {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.5rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            padding-right: 2.5rem;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        </style>

        {{-- CTA icon="user-star" --}}
        <x-ui.cta-section 
        title=" Interested in Becoming a Collaborator?"
        subtitle="Join our network of expert practitioners and share your knowledge with our growing community. Manage your own store, create courses, and make a meaningful impact on people's lives."
        cardClass="hover:border-gray-200"
        :buttons="[
            ['route' => 'become-collaborator',   'label' => 'Apply to Collaborate', 'variant' => 'primary', 'icon' => 'external-link'],
        ]"
        />
    </main>
</div>
@endsection