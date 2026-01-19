@extends('front.layouts.app')
@section('content')
<div class="min-h-screen flex flex-col">
    <section class="gradient-subtle pt-16">
        <div class="max-w-7xl mx-auto py-10 px-4 place-self-center">
            <div class="text-center mb-16">
                <h1 class="text-4xl lg:text-6xl font-bold text-foreground mb-4">
                      {{ $collaborator->first_name }} {{ $collaborator->last_name }} Store
                </h1>
                <p class="text-xl text-muted-foreground max-w-3xl mx-auto">
                    Premium products curated by our expert collaborators.
                    Members enjoy exclusive discounts on all items.
                </p>
            </div>
        </div>
    </section>

    <!-- Main Content Area -->
    <section class="gradient-subtle pb-5">
        <div class="max-w-7xl mx-auto px-4">
            <!-- Active Filter Chips -->
            <div id="activeFilters" class="mb-4 flex flex-wrap gap-2"></div>
            
            <!-- Results Count and Clear Button -->
            <div class="flex justify-between items-center mb-6">
                {{-- <p id="resultsCount" class="text-lg font-medium text-gray-700"></p>  for result --}}
                <!-- Clear All Button - Initially Hidden -->
                <button id="clearAllFilters" class="text-sm text-red-600 font-bold hidden">
                    Clear All Filters
                </button>
            </div>
            
            <div class="flex  lg:flex-row gap-8">
                <!-- Left Sidebar - Filters (25% width) -->
                <div class="lg:w-1/4">
                    <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-xl font-bold text-gray-900">Filters</h3>
                        </div>
                        
                        <!-- Search Input inside Filter Card -->
                        <div class="mb-8">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Search Products</label>
                            <div class="relative">
                                <input
                                    type="text"
                                    id="searchInput"
                                    placeholder="Search by name, category, or description..."
                                    class="w-full px-4 py-3 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none text-base"
                                />
                                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500"></i>
                                <button id="clearSearch" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700 text-lg hidden">
                                    <i class="fas fa-times-circle"></i>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Category Filter (Select Dropdown) -->
                        <div class="mb-8">
                            <h4 class="font-semibold text-gray-800 mb-3 text-lg">Category</h4>
                            <div class="relative">
                                <select id="categoryFilter" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none appearance-none bg-white">
                                    <option value="">All Categories</option>
                                    <!-- Categories will be populated by JavaScript -->
                                </select>
                                <div class="absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none">
                                    <i class="fas fa-chevron-down text-gray-400"></i>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Price Filter -->
                        <div class="mb-8">
                            <h4 class="font-semibold text-gray-800 mb-3 text-lg">Price Range</h4>
                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <input 
                                        type="number" 
                                        id="minPrice" 
                                        placeholder="Min $" 
                                        min="0"
                                        class="w-28 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none"
                                    >
                                    <span class="text-gray-500">to</span>
                                    <input 
                                        type="number" 
                                        id="maxPrice" 
                                        placeholder="Max $" 
                                        min="0"
                                        class="w-28 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none"
                                    >
                                </div>
                                <button id="applyPriceFilter" class="w-full bg-primary text-white py-2 rounded-lg hover:bg-amber-500 transition text-sm font-medium">
                                    Apply Price
                                </button>
                            </div>
                        </div>

                            <!-- Rating Filter -->
                        {{-- <div class="mb-8">
                            <h4 class="font-semibold text-gray-800 mb-3 text-lg">Customer Rating</h4>
                            <div class="space-y-2">
                                <div class="flex items-center">
                                    <input type="radio" name="rating" id="rating-any" value="" checked class="rating-radio h-4 w-4 text-primary focus:ring-primary">
                                    <label for="rating-any" class="ml-2 text-gray-700 cursor-pointer hover:text-gray-900">
                                        Any Rating
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input type="radio" name="rating" id="rating-4.5" value="4.5" class="rating-radio h-4 w-4 text-primary focus:ring-primary">
                                    <label for="rating-4.5" class="ml-2 text-gray-700 cursor-pointer hover:text-gray-900 flex items-center">
                                        <span class="flex">
                                            <i class="fas fa-star text-yellow-400"></i>
                                            <i class="fas fa-star text-yellow-400"></i>
                                            <i class="fas fa-star text-yellow-400"></i>
                                            <i class="fas fa-star text-yellow-400"></i>
                                            <i class="fas fa-star-half-alt text-yellow-400"></i>
                                        </span>
                                        <span class="ml-1">& above</span>
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input type="radio" name="rating" id="rating-4.0" value="4.0" class="rating-radio h-4 w-4 text-primary focus:ring-primary">
                                    <label for="rating-4.0" class="ml-2 text-gray-700 cursor-pointer hover:text-gray-900 flex items-center">
                                        <span class="flex">
                                            <i class="fas fa-star text-yellow-400"></i>
                                            <i class="fas fa-star text-yellow-400"></i>
                                            <i class="fas fa-star text-yellow-400"></i>
                                            <i class="fas fa-star text-yellow-400"></i>
                                            <i class="far fa-star text-yellow-400"></i>
                                        </span>
                                        <span class="ml-1">& above</span>
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input type="radio" name="rating" id="rating-3.5" value="3.5" class="rating-radio h-4 w-4 text-primary focus:ring-primary">
                                    <label for="rating-3.5" class="ml-2 text-gray-700 cursor-pointer hover:text-gray-900 flex items-center">
                                        <span class="flex">
                                            <i class="fas fa-star text-yellow-400"></i>
                                            <i class="fas fa-star text-yellow-400"></i>
                                            <i class="fas fa-star text-yellow-400"></i>
                                            <i class="fas fa-star-half-alt text-yellow-400"></i>
                                            <i class="far fa-star text-yellow-400"></i>
                                        </span>
                                        <span class="ml-1">& above</span>
                                    </label>
                                </div>
                            </div>
                        </div> --}}
                        
                            <!-- Vendor Filter -->
                        {{-- <div class="mb-8">
                            <h4 class="font-semibold text-gray-800 mb-3 text-lg">Vendor</h4>
                            <div class="relative">
                                <select id="vendorFilter" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none appearance-none bg-white">
                                    <option value="">All Vendors</option>
                                    <!-- Vendors will be populated by JavaScript -->
                                </select>
                                <div class="absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none">
                                    <i class="fas fa-chevron-down text-gray-400"></i>
                                </div>
                            </div>
                        </div> --}}
                        
                    </div>
                </div>
                
                <!-- Right Content - Products Grid (75% width) -->
                <div class="lg:w-3/4">
                    <!-- Products Grid -->
                    <div id="productsGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                        <!-- Products will be loaded here -->
                    </div>
                    
                    <!-- No Results Message -->
                    <div id="noResults" class="hidden text-center py-12">
                        <div class="mb-4">
                            <i class="fas fa-search text-gray-300 text-6xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-700 mb-2">No products found</h3>
                        <p class="text-gray-500 mb-4">Try adjusting your search or filter criteria</p>
                        <button id="resetAllFromEmpty" class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-amber-600 transition">
                            Reset All Filters
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    {{-- Member Benefits --}}
    <section class="py-20 gradient-subtle">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="shadow-strong bg-white rounded-lg">
                <div class="p-8">
                    <h2 class="text-3xl font-bold text-foreground mb-4">
                        Members Save More
                    </h2>
                    <p class="text-muted-foreground mb-6">
                        Join our membership program and enjoy exclusive discounts on all products
                    </p>
                    <div class="grid md:grid-cols-3 gap-4 mb-6">
                        @php
                        $discounts = [
                            ['title' => '10%', 'class' => 'Essential Members'],
                            ['title' => '20%', 'class' => 'Premium Members'],
                            ['title' => '30%', 'class' => 'Elite Members'],
                        ];
                        @endphp
                        
                        @foreach($discounts as $discount)
                            <div class="p-4 bg-secondary rounded-lg">
                                <div class="text-3xl font-bold text-primary bg-clip-text mb-2">{{ $discount['title'] }} </div>
                                <div class="text-sm text-muted-foreground">{{ $discount['class'] }}</div>
                            </div>
                        @endforeach
                    </div>
                    <a href="{{ route('membership') }}">
                        <button class="btn btn-primary btn-lg">
                            <i data-lucide="house-plus" class="mr-2 h-6 w-6"></i>
                            Become a Member
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- ===================== JS ===================== -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Laravel products → JS
    const products = @json($products);
    
    // Log products to console for debugging
    console.log('Products:', products);
    
    // DOM elements
    const searchInput = document.getElementById('searchInput');
    const clearSearchBtn = document.getElementById('clearSearch');
    const clearAllFiltersBtn = document.getElementById('clearAllFilters');
    const resetAllFromEmptyBtn = document.getElementById('resetAllFromEmpty');
    const applyPriceFilterBtn = document.getElementById('applyPriceFilter');
    const productsGrid = document.getElementById('productsGrid');
    const resultsCount = document.getElementById('resultsCount');
    const activeFilters = document.getElementById('activeFilters');
    const noResults = document.getElementById('noResults');
    
    // Filter elements
    const minPriceInput = document.getElementById('minPrice');
    const maxPriceInput = document.getElementById('maxPrice');
    const categoryFilter = document.getElementById('categoryFilter');
    // const vendorFilter = document.getElementById('vendorFilter');
    const ratingRadios = document.querySelectorAll('input[name="rating"]');
    
    // Filter state
    let filters = {
        search: '',
        category: '',
        minPrice: null,
        maxPrice: null,
        minRating: null,
        vendor: ''
    };
    
    // Initialize filters
    function initializeFilters() {
        console.log('Initializing filters...');
        
        // Get unique categories and vendors
        const uniqueCategories = [...new Set(products.map(p => p.category))].sort();
        const uniqueVendors = [...new Set(products.map(p => p.vendor))].sort();
        
        console.log('Unique categories:', uniqueCategories);
        console.log('Unique vendors:', uniqueVendors);
        
        // Populate category dropdown
        categoryFilter.innerHTML = '<option value="">All Categories</option>';
        uniqueCategories.forEach(category => {
            const option = document.createElement('option');
            option.value = category;
            option.textContent = category;
            categoryFilter.appendChild(option);
        });
        
        // Populate vendor dropdown
        // vendorFilter.innerHTML = '<option value="">All Vendors</option>';
        // uniqueVendors.forEach(vendor => {
        //     const option = document.createElement('option');
        //     option.value = vendor;
        //     option.textContent = vendor;
        //     vendorFilter.appendChild(option);
        // });
        
        // Add event listeners
        categoryFilter.addEventListener('change', () => {
            console.log('Category changed to:', categoryFilter.value);
            filters.category = categoryFilter.value;
            filterProducts();
            updateClearButton();
            updateActiveFilters();
        });
        
        // vendorFilter.addEventListener('change', () => {
        //     console.log('Vendor changed to:', vendorFilter.value);
        //     filters.vendor = vendorFilter.value;
        //     filterProducts();
        //     updateClearButton();
        //     updateActiveFilters();
        // });
        
        ratingRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                console.log('Rating changed to:', this.value);
                if (this.value === '') {
                    filters.minRating = null;
                } else {
                    filters.minRating = parseFloat(this.value);
                }
                filterProducts();
                updateClearButton();
                updateActiveFilters();
            });
        });
    }
    
    // Show/hide clear search button
    searchInput.addEventListener('input', () => {
        clearSearchBtn.classList.toggle('hidden', searchInput.value.length === 0);
        filters.search = searchInput.value.trim();
        console.log('Search input:', filters.search);
        filterProducts();
        updateClearButton();
        updateActiveFilters();
    });
    
    // Clear search
    clearSearchBtn.addEventListener('click', () => {
        searchInput.value = "";
        filters.search = '';
        clearSearchBtn.classList.add('hidden');
        filterProducts();
        updateClearButton();
        updateActiveFilters();
    });
    
    // Apply price filter
    applyPriceFilterBtn.addEventListener('click', () => {
        const minPrice = minPriceInput.value ? parseFloat(minPriceInput.value) : null;
        const maxPrice = maxPriceInput.value ? parseFloat(maxPriceInput.value) : null;
        
        console.log('Price filter applied:', minPrice, maxPrice);
        
        // Validate price range
        if (minPrice !== null && maxPrice !== null && minPrice > maxPrice) {
            alert('Minimum price cannot be greater than maximum price');
            return;
        }
        
        filters.minPrice = minPrice;
        filters.maxPrice = maxPrice;
        filterProducts();
        updateClearButton();
        updateActiveFilters();
    });
    
    // Clear all filters
    clearAllFiltersBtn.addEventListener('click', resetAllFilters);
    resetAllFromEmptyBtn.addEventListener('click', resetAllFilters);
    
    function resetAllFilters() {
        console.log('Resetting all filters...');
        
        // Reset filter state
        filters = {
            search: '',
            category: '',
            minPrice: null,
            maxPrice: null,
            minRating: null,
            vendor: ''
        };
        
        // Reset UI
        searchInput.value = '';
        clearSearchBtn.classList.add('hidden');
        minPriceInput.value = '';
        maxPriceInput.value = '';
        categoryFilter.value = '';
        // vendorFilter.value = '';
        document.querySelector('#rating-any').checked = true;
        
        // Hide no results message
        noResults.classList.add('hidden');
        
        filterProducts();
        updateClearButton();
        updateActiveFilters();
    }
    
    // Update clear button state (show/hide based on filters)
    function updateClearButton() {
        const hasFilters = filters.search || 
                          filters.category || 
                          filters.minPrice !== null || 
                          filters.maxPrice !== null || 
                          filters.minRating !== null || 
                          filters.vendor;
        
        console.log('Has filters:', hasFilters);
        
        if (hasFilters) {
            clearAllFiltersBtn.classList.remove('hidden');
        } else {
            clearAllFiltersBtn.classList.add('hidden');
        }
    }
    
    // Main filter function
    function filterProducts() {
        console.log('Filtering products with:', filters);
        
        let filtered = products;
        
        // Apply search filter
        if (filters.search) {
            const searchLower = filters.search.toLowerCase();
            filtered = filtered.filter(p => {
                return (
                    (p.name && p.name.toLowerCase().includes(searchLower)) ||
                    (p.category && p.category.toLowerCase().includes(searchLower)) ||
                    (p.description && p.description.toLowerCase().includes(searchLower)) ||
                    (p.vendor && p.vendor.toLowerCase().includes(searchLower))
                );
            });
        }
        
        // Apply category filter
        if (filters.category) {
            filtered = filtered.filter(p => p.category === filters.category);
        }
        
        // Apply price filter
        if (filters.minPrice !== null) {
            filtered = filtered.filter(p => parseFloat(p.price) >= filters.minPrice);
        }
        if (filters.maxPrice !== null) {
            filtered = filtered.filter(p => parseFloat(p.price) <= filters.maxPrice);
        }
        
        // Apply rating filter
        if (filters.minRating !== null) {
            filtered = filtered.filter(p => parseFloat(p.rating) >= filters.minRating);
        }
        
        // Apply vendor filter
        if (filters.vendor) {
            filtered = filtered.filter(p => p.vendor === filters.vendor);
        }
        
        console.log('Filtered products count:', filtered.length);
        
        renderProducts(filtered);
        updateResultsCount(filtered.length);
        
        // Show/hide no results message
        if (filtered.length === 0) {
            noResults.classList.remove('hidden');
            productsGrid.classList.add('hidden');
        } else {
            noResults.classList.add('hidden');
            productsGrid.classList.remove('hidden');
        }
    }
    
    // Update results count
    function updateResultsCount(count) {
        const total = products.length;
        resultsCount.textContent = `Showing ${count} of ${total} products`;
    }
    
    // Update active filters display
    function updateActiveFilters() {
        activeFilters.innerHTML = '';
        const chips = [];
        
        // Search chip
        if (filters.search) {
            chips.push(createFilterChip(`Search: "${filters.search}"`, 'clearSearchInput'));
        }
        
        // Category chip
        if (filters.category) {
            chips.push(createFilterChip(`Category: ${filters.category}`, 'clearCategory'));
        }
        
        // Price chip
        if (filters.minPrice !== null || filters.maxPrice !== null) {
            const min = filters.minPrice !== null ? `$${filters.minPrice}` : 'Min';
            const max = filters.maxPrice !== null ? `$${filters.maxPrice}` : 'Max';
            chips.push(createFilterChip(`Price: ${min} - ${max}`, 'clearPriceFilter'));
        }
        
        // Rating chip
        if (filters.minRating !== null) {
            chips.push(createFilterChip(`Rating: ${filters.minRating}+ stars`, 'clearRatingFilter'));
        }
        
        // Vendor chip
        if (filters.vendor) {
            chips.push(createFilterChip(`Vendor: ${filters.vendor}`, 'clearVendor'));
        }
        
        if (chips.length > 0) {
            chips.forEach(chip => {
                activeFilters.innerHTML += chip;
            });
            
            // Add event listeners to remove buttons
            document.querySelectorAll('.remove-filter').forEach(btn => {
                btn.addEventListener('click', function() {
                    const action = this.getAttribute('data-action');
                    
                    if (action === 'clearSearchInput') clearSearchInput();
                    else if (action === 'clearCategory') clearCategory();
                    else if (action === 'clearPriceFilter') clearPriceFilter();
                    else if (action === 'clearRatingFilter') clearRatingFilter();
                    else if (action === 'clearVendor') clearVendor();
                });
            });
        }
    }
    
    function createFilterChip(label, action) {
        return `
            <div class="inline-flex items-center gap-1 bg-gray-100 text-gray-700 px-3 py-2 rounded-full text-sm">
                <span>${label}</span>
                <button type="button" class="remove-filter text-gray-500 hover:text-gray-700 ml-1" 
                        data-action="${action}">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;
    }
    
    // Individual clear functions
    function clearSearchInput() {
        searchInput.value = '';
        filters.search = '';
        clearSearchBtn.classList.add('hidden');
        filterProducts();
        updateClearButton();
        updateActiveFilters();
    }
    
    function clearCategory() {
        categoryFilter.value = '';
        filters.category = '';
        filterProducts();
        updateClearButton();
        updateActiveFilters();
    }
    
    function clearPriceFilter() {
        minPriceInput.value = '';
        maxPriceInput.value = '';
        filters.minPrice = null;
        filters.maxPrice = null;
        filterProducts();
        updateClearButton();
        updateActiveFilters();
    }
    
    function clearRatingFilter() {
        document.querySelector('#rating-any').checked = true;
        filters.minRating = null;
        filterProducts();
        updateClearButton();
        updateActiveFilters();
    }
    
    function clearVendor() {
        // vendorFilter.value = '';
        filters.vendor = '';
        filterProducts();
        updateClearButton();
        updateActiveFilters();
    }
    
    // Render products
    function renderProducts(list) {
        console.log('Rendering products:', list.length);
        
        if (!list.length) {
            productsGrid.innerHTML = '';
            return;
        }
productsGrid.innerHTML = list.map(product => {

    console.log('Product data:', product);

    const imageUrl = product.image
        ? `/product_images/${product.image}`
        : '';

       const vendorName =
    product.user?.first_name && product.user?.last_name
        ? `${product.user.first_name} ${product.user.last_name}`
        : 'N/A';

        console.log(product.user);

    return `
        <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition transform hover:-translate-y-1">

            <div class="aspect-square bg-gradient-to-br from-primary/10 to-accent/10 flex items-center justify-center rounded-t-lg relative">
                <div class="text-center p-6 relative">

                    ${
                        product.image
                        ? `<img 
                                src="${imageUrl}" 
                                alt="${product.name ?? ''}"
                                class="max-h-48 mx-auto object-contain"
                                loading="lazy"
                          >`
                        : `<div class="text-gray-300">No Image Available</div>`
                    }

                    ${
                        product.discount
                        ? `<span class="absolute top-3 right-3 badge gradient-accent text-accent-foreground border-0">
                                ${product.discount}% OFF
                           </span>`
                        : ``
                    }

                </div>
            </div>

            <div class="p-5">
                <h3 class="text-lg font-semibold text-gray-800 mb-2 line-clamp-2">
                    ${product.name}
                </h3>

                <p class="text-sm text-primary mb-1">
                    by ${vendorName}
                </p>
                <p class="text-xs text-gray-500 mb-2">${product.category}</p>
                <p class="text-sm text-muted-foreground line-clamp-2 mb-3">
                    ${product.description}
                </p>

                <div class="flex items-center space-x-2 mb-3">
                    <div class="flex items-center">
                        ${generateStarRating(product.rating)}
                        <span class="ml-1 text-sm font-medium">${product.rating}</span>
                    </div>
                    <span class="text-sm text-muted-foreground">
                        (${product.reviews} reviews)
                    </span>
                </div>

                <div class="flex items-baseline space-x-2">
                    <span class="text-2xl font-bold">
                        $${Number(product.price).toFixed(2)}
                    </span>
                </div>
            </div>

            <div class="p-4 pt-0">
                <button class="btn btn-primary w-full">
                    Add to Cart
                </button>
            </div>

        </div>
    `;
}).join('');

        
        // Initialize Lucide icons
        if (window.lucide) {
            lucide.createIcons();
        }
    }
    
    // Generate star rating HTML
    function generateStarRating(rating) {
        let stars = '';
        const fullStars = Math.floor(rating);
        const hasHalfStar = rating % 1 >= 0.5;
        
        for (let i = 1; i <= 5; i++) {
            if (i <= fullStars) {
                stars += '<i class="fas fa-star text-yellow-400"></i>';
            } else if (i === fullStars + 1 && hasHalfStar) {
                stars += '<i class="fas fa-star-half-alt text-yellow-400"></i>';
            } else {
                stars += '<i class="far fa-star text-yellow-400"></i>';
            }
        }
        return `<span class="flex">${stars}</span>`;
    }
    
    // Initialize
    console.log('Initializing product filter...');
    initializeFilters();
    filterProducts();
    updateClearButton();
    updateActiveFilters();
});
</script>

<style>
/* Custom scrollbar for filter containers */
.sticky {
    position: sticky;
}

/* Smooth transitions */
.transition {
    transition: all 0.3s ease;
}

/* Line clamp for text */
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
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

/* Product card hover effect */
.hover\:-translate-y-1:hover {
    transform: translateY(-4px);
}

/* Ensure product cards have equal height */
.h-full {
    height: 100%;
}

.flex-col {
    display: flex;
    flex-direction: column;
}

.flex-grow {
    flex-grow: 1;
}

.mt-auto {
    margin-top: auto;
}

/* Hidden class for clear button */
.hidden {
    display: none;
}

/* Active filter chips */
#activeFilters .inline-flex {
    animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-5px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Clear all button animation */
#clearAllFilters:not(.hidden) {
    animation: slideIn 0.3s ease;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateX(10px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

/* Grid layout for products */
.grid {
    display: grid;
}

.grid-cols-1 {
    grid-template-columns: repeat(1, minmax(0, 1fr));
}

@media (min-width: 640px) {
    .sm\:grid-cols-2 {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}

@media (min-width: 1024px) {
    .lg\:grid-cols-3 {
        grid-template-columns: repeat(3, minmax(0, 1fr));
    }
}

.gap-8 {
    gap: 2rem;
}
</style>
@endsection