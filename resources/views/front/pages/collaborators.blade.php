@extends('front.layouts.app')

@section('content')
<div class="min-h-screen flex flex-col font-jakarta">



    <main class="flex-1">

        {{-- Hero Section --}}
        <section class="gradient-subtle py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-4xl lg:text-6xl font-bold text-foreground mb-6">
                    Our Expert <span class="text-amber-500    ">Collaborators</span>
                </h1>
                <p class="text-xl text-muted-foreground max-w-3xl mx-auto">
                    Learn from a network of world-class physicians and health practitioners, each bringing
                    specialized expertise to your wellness journey. Access their exclusive courses and recommended products.
                </p>
            </div>
        </section>


        {{-- PHP collaborators array --}}
     {{-- PHP collaborators array --}}
@php
$collaborators = [
    [
        'id' => 1,
        'name' => "Dr. Sarah Chen",
        'specialty' => "Functional Nutrition",
        'credentials' => "PhD, CNS, IFMCP",
        'description' => "Specializes in personalized nutrition strategies for optimal health and longevity. Over 15 years of experience in metabolic health.",
        'coursesAvailable' => 12,
        'productsAvailable' => 8,
        'featured' => true
    ],
    [
        'id' => 2,
        'name' => "Dr. Michael Rodriguez",
        'specialty' => "Exercise Physiology",
        'credentials' => "MD, CSCS",
        'description' => "Expert in age-defying fitness protocols and movement optimization for enhanced vitality and strength.",
        'coursesAvailable' => 18,
        'productsAvailable' => 15,
        'featured' => true
    ],
    [
        'id' => 3,
        'name' => "Dr. Jennifer Park",
        'specialty' => "Mind-Body Medicine",
        'credentials' => "PsyD, CIMHP",
        'description' => "Focuses on stress reduction, meditation, and the powerful connection between mental and physical health.",
        'coursesAvailable' => 10,
        'productsAvailable' => 5,
        'featured' => false
    ],
    [
        'id' => 4,
        'name' => "Dr. James Wilson",
        'specialty' => "Integrative Cardiology",
        'credentials' => "MD, FACC, ABOIM",
        'description' => "Pioneering approaches to heart health through lifestyle medicine and evidence-based natural therapies.",
        'coursesAvailable' => 14,
        'productsAvailable' => 12,
        'featured' => false
    ],
    [
        'id' => 5,
        'name' => "Dr. Emily Thompson",
        'specialty' => "Sleep Medicine",
        'credentials' => "MD, DABSM",
        'description' => "Dedicated to optimizing sleep quality for enhanced recovery, cognitive function, and longevity.",
        'coursesAvailable' => 8,
        'productsAvailable' => 10,
        'featured' => false
    ],
    [
        'id' => 6,
        'name' => "Dr. David Kim",
        'specialty' => "Hormone Optimization",
        'credentials' => "MD, ABAARM",
        'description' => "Expert in bio-identical hormone therapy and metabolic optimization for vitality at any age.",
        'coursesAvailable' => 16,
        'productsAvailable' => 7,
        'featured' => true
    ]
];
@endphp

{{-- Search and Filter Section --}}
<section class="py-20 bg-background bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Filter Controls --}}
        <div class="mb-10 bg-white p-6 rounded-2xl shadow-soft border border-gray-200">
            <div class="flex flex-col md:flex-row items-center justify-center gap-4 mb-6">
                <div>
                    <h2 class="text-2xl font-bold ">Our <span class="text-primary">Collaborators</span></h2>
                    <p class="text-muted-foreground mt-1">Find experts by name, specialty, or status</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                {{-- Search Input filter --}}
                <div class="  place-self-center">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Search by Name</label>
                    <div class="relative">
                        <input type="text"
                               id="nameSearch"
                               placeholder="Search collaborators..."
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                        <div class="absolute right-3 top-1/2 transform -translate-y-1/2">
                            <i data-lucide="search" class="h-4 w-4 text-gray-400"></i>
                        </div>
                    </div>
                </div>

                {{-- Specialty Filter  here --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Specialty</label>
                    <div class="relative">
                        <select id="specialtyFilter"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none appearance-none bg-white">
                            <option value="">All Specialties</option>
                            @php
                                $specialties = array_unique(array_column($collaborators, 'specialty'));
                                sort($specialties);
                            @endphp
                            @foreach($specialties as $specialty)
                                <option value="{{ $specialty }}">{{ $specialty }}</option>
                            @endforeach
                        </select>
                        <div class="absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none">
                            <i data-lucide="chevron-down" class="h-4 w-4 text-gray-400"></i>
                        </div>
                    </div>
                </div>

                {{-- Featured Filter --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Featured Status</label>
                    <div class="relative">
                        <select id="featuredFilter"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none appearance-none bg-white">
                            <option value="">All Status</option>
                            <option value="featured">Featured Only</option>
                            <option value="not-featured">Not Featured</option>
                        </select>
                        <div class="absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none">
                            <i data-lucide="chevron-down" class="h-4 w-4 text-gray-400"></i>
                        </div>
                    </div>
                </div>

                {{-- Clear Button --}}
                <div class="flex items-end">
                    <button id="clearFilters"
                            class="w-full px-4 py-2 border border-gray-300 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 flex items-center justify-center gap-2 opacity-50 cursor-not-allowed"
                            disabled>
                        <i data-lucide="x" class="h-4 w-4"></i>
                        Clear Filters
                    </button>
                </div>
            </div>

            {{-- Active Filters Display --}}
            <div id="activeFilters" class="mt-4 hidden">
                <div class="flex items-center gap-2">
                    <span class="text-sm text-muted-foreground">Active filters:</span>
                    <div id="filterChips" class="flex flex-wrap gap-2"></div>
                </div>
            </div>
        </div>

        {{--Clear Filter  --}}
        <div id="resultsCount" class="mb-6 text-muted-foreground">
            {{-- Showing {{ count($collaborators) }} of {{ count($collaborators) }} collaborators --}}
        </div>

        {{-- Grid Products View --}}
        <div id="collaboratorsGrid" class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($collaborators as $c)
                <div class="flex flex-col card border-2 rounded-2xl {{ $c['featured'] ? 'border-primary shadow-medium' : 'shadow-soft' }} hover:border-primary py-4 px-6 collaborator-card"
                     data-name="{{ strtolower($c['name']) }}"
                     data-specialty="{{ $c['specialty'] }}"
                     data-featured="{{ $c['featured'] ? 'featured' : 'not-featured' }}">
                    <div class="card-header py-4">
                        <div class="flex justify-between items-start mb-4">
                            <x-ui.avatar name="{{ $c['name'] }}" size="4" />
                            @if ($c['featured'])
                                <x-badge class=""> Featured </x-badge>
                            @endif
                        </div>
                        <h2 class="text-2xl mb-2">{{ $c['name'] }}</h2>
                        <div class="space-y-1">
                            <p class="text-emerald-600 font-bold">{{ $c['specialty'] }}</p>
                            <p class="text-sm text-muted-foreground">{{ $c['credentials'] }}</p>
                        </div>
                    </div>
                    <div class="space-y-1 px-6 ">
                        <p class="text-muted-foreground mb-2 flex-1">
                            {{ $c['description'] }}
                        </p>
                    </div>
                    <div class="card-content pb-3 flex-1 flex flex-col">
                        <div class="grid sm:grid-cols-2 gap-4 mb-2">
                            <div class="sm:col-span-1 flex items-center justify-between bg-secondary rounded-lg bg-teal-50">
                                <div class="flex items-center">
                                    <i data-lucide="video" class="h-5 w-5 text-primary mr-2"></i>
                                    <span class="font-medium text-foreground">Courses</span>
                                </div>
                                <x-badge class="bg-emerald-500 text-black">
                                    {{ $c['coursesAvailable'] }}
                                </x-badge>
                            </div>
                            <div class="sm:col-span-1 flex items-center justify-between p-3 bg-secondary rounded-lg bg-teal-50 gap-2">
                                <div class="flex items-center">
                                    <i data-lucide="store" class="h-5 w-5 text-primary mr-2"></i>
                                    <span class="font-medium text-foreground">Products</span>
                                </div>
                                <x-badge class="bg-emerald-500 text-black">
                                    {{ $c['productsAvailable'] }}
                                </x-badge>
                            </div>
                        </div>
                        <div class="grid sm:grid-cols-2 gap-4 py-4">
                            <div class="sm:col-span-1">
                                <a href="{{ url('/collaborator/profile-details') }}" class="btn btn-outline w-full sm:w-auto flex items-center justify-center font-semibold px-2 py-3 rounded-md">
                                    <button class="w-full flex items-center justify-center">
                                        <i data-lucide="award" class="h-5 w-5 hover:text-white mr-1"></i>
                                        <span class="ml-1">View Profile</span>
                                    </button>

                                </a>
                            </div>
                            <div class="sm:col-span-1">
                                <a href="{{ url('/shop?vendor='.$c['id']) }}" class="btn btn-outline w-full sm:w-auto flex items-center justify-center font-semibold px-2 py-3 rounded-md">
                                    <button class="w-full flex items-center justify-center">
                                        <i data-lucide="store" class="h-5 w-5 hover:text-white mr-2"></i>
                                        <span class="ml-2">Visit Store</span>
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- No Results Message --}}
        <div id="noResults" class="hidden text-center py-12">
            <div class="mb-4">
                <i data-lucide="search" class="h-16 w-16 text-gray-300 mx-auto"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-700 mb-2">No collaborators found</h3>
            <p class="text-gray-500 mb-4">Try adjusting your search or filter criteria</p>
            <button id="resetAllFilters" class="px-4 py-2 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 flex items-center gap-2 mx-auto">
                <i data-lucide="refresh-cw" class="h-4 w-4"></i>
                Reset All Filters
            </button>
        </div>
    </div>
</section>

{{-- JavaScript for Filtering --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get DOM elements
    const nameSearch = document.getElementById('nameSearch');
    const specialtyFilter = document.getElementById('specialtyFilter');
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
        specialty: '',
        featured: ''
    };

    // Update select values based on filter state
    function updateSelectValues() {
        specialtyFilter.value = filters.specialty || '';
        featuredFilter.value = filters.featured || '';
        nameSearch.value = filters.name || '';
    }

    // Event listeners for filters
    nameSearch.addEventListener('input', function() {
        filters.name = this.value.toLowerCase().trim();
        applyFilters();
        updateClearButton();
    });

    specialtyFilter.addEventListener('change', function() {
        filters.specialty = this.value;
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
            specialty: '',
            featured: ''
        };

        updateSelectValues();
        updateClearButton();
        updateActiveFiltersDisplay();
    }

    // Update clear button state
    function updateClearButton() {
        const hasFilters = filters.name || filters.specialty || filters.featured;

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

        if (filters.specialty) {
            activeFilters.push({
                type: 'specialty',
                label: `Specialty: ${filters.specialty}`,
                value: filters.specialty
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
            case 'specialty':
                filters.specialty = '';
                specialtyFilter.value = '';
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
            const specialty = card.getAttribute('data-specialty');
            const featured = card.getAttribute('data-featured');

            let matches = true;

            // Name filter
            if (filters.name && !name.includes(filters.name.toLowerCase())) {
                matches = false;
            }

            // Specialty filter
            if (filters.specialty && filters.specialty !== specialty) {
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



        {{-- CTA --}}
            <x-ui.cta-section
                icon="user-star"
                align="center"
                title=" Interested in Becoming a Collaborator?"
                subtitle="Join our network of expert practitioners and share your knowledge with our growing community.
                        Manage your own store, create courses, and make a meaningful impact on people's lives."

                :buttons="[
                    ['route' => 'become-collaborator',   'label' => 'Apply to Collaborate', 'variant' => 'outline', 'icon' => 'external-link'],

                ]"
            />



    </main>



</div>


@endsection
