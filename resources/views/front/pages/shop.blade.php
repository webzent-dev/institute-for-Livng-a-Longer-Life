@extends('front.layouts.app')
@section('content')
<div class="min-h-screen flex flex-col">
    <section class="gradient-subtle pt-10 md:pt-14 lg:pt-16">
        <div class="max-w-7xl mx-auto py-8 px-4">
            <div class="text-center mb-6">
                <h1 class="text-4xl lg:text-5xl font-bold text-foreground mb-3">
                    Wellness Store
                </h1>
                <p class="text-lg text-muted-foreground max-w-2xl mx-auto">
                    Premium products curated by our expert collaborators.
                    Members enjoy exclusive discounts on all items.
                </p>
            </div>
        </div>
    </section>

    <!-- Main Content Area -->
    @php ($cartVal = Session::get('cart', [])) @endphp
    @if(count($products) > 0)
    <section class="gradient-subtle pb-5">
        <div class="max-w-7xl mx-auto px-4">
            <!-- Active Filter Chips -->
            <div id="activeFilters" class="mb-4 flex flex-wrap gap-2"></div>
            <!-- Results Count and Clear Button -->
            <div class="flex justify-between items-center mb-6">
                <!-- Clear All Button - Initially Hidden -->
                <button id="clearAllFilters" class="text-sm text-red-600 font-bold hidden">
                Clear All Filters
                </button>
            </div>

            <div class="items-start ">
                    <div class="w-full">
                        <div class="bg-white rounded-md shadow-sm p-4 md:p-5 lg:p-6 lg:sticky lg:top-4">
                            <div class="grid  lg:grid-cols-4 gap-4 items-center">
                                <!-- Search Input inside Filter Card -->
                                <div>
                                    <div class="relative">
                                        <input type="text" id="searchInput" placeholder="Search by name, category, or description..." class="w-full px-4 py-2 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none text-base"/><i data-lucide="search" class="h-5 w-5 absolute text-semibold left-4 text-xl top-1/2 transform -translate-y-1/2"></i>
                                        <button id="clearSearch" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700 text-lg hidden">
                                            <i class="fas fa-times-circle"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Category Filter (Select Dropdown) -->
                                <div>
                                    <div class="relative">
                                        <select id="categoryFilter" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none appearance-none bg-white">
                                            <option value="">Listed By</option>
                                            <!-- Categories will be populated by JavaScript -->
                                        </select>
                                        <div class="absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-funnel-icon lucide-funnel">
                                                <path d="M10 20a1 1 0 0 0 .553.895l2 1A1 1 0 0 0 14 21v-7a2 2 0 0 1 .517-1.341L21.74 4.67A1 1 0 0 0 21 3H3a1 1 0 0 0-.742 1.67l7.225 7.989A2 2 0 0 1 10 14z"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                <!-- Collaborator Filter (Hidden by default) -->
                                <div id="collaboratorFilterContainer" class="hidden">
                                    <div class="relative">
                                        <select id="collaboratorFilter" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none appearance-none bg-white">
                                            <option value="">Select Collaborator</option>
                                            <!-- Collaborators will be populated by JavaScript -->
                                        </select>
                                        <div class="absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users">
                                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                                                <circle cx="9" cy="7" r="4"/>
                                                <path d="m22 21-3.5-3.5a2.5 2.5 0 0 0-3.5 0L12 21"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                <div class="lg:ml-4">
                                    <button id="resetFilters" class="w-full px-4 py-2 bg-primary text-white rounded-lg transition">
                                        Reset Filter
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Content - Products Grid (75% width) -->
                    <div class="w-full my-8">
                        <!-- Products Grid -->
                        <div id="productsGrid" class="grid grid-cols-2 lg:grid-cols-4 gap-8">
                            <!-- Products will be loaded here -->
                        </div>
                        <div id="pagination" class="flex justify-center gap-2 mt-6"></div>
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
        </div>
    </section>
    @endif

    {{-- Member Benefits --}}
    <section class="py-20 gradient-subtle">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="rounded-lg border bg-card text-card-foreground shadow-sm shadow-strong">
                <div class="p-8">
                    <h2 class="text-3xl font-bold text-foreground mb-4">
                        Members Save More
                    </h2>
                    <p class="text-muted-foreground mb-6">Join our membership program and enjoy exclusive discounts on allproducts</p>
                    <div class="grid md:grid-cols-3 gap-4 mb-6">
                        <div class="p-4 bg-secondary rounded-lg">
                            <div class="text-3xl font-bold gradient-primary text-transparent bg-clip-text mb-2">10%</div>
                                <div class="text-sm text-muted-foreground">Essential Members</div>
                            </div>

                            <div class="p-4 bg-secondary rounded-lg">
                                <div class="text-3xl font-bold gradient-primary text-transparent bg-clip-text mb-2">20%</div>
                                    <div class="text-sm text-muted-foreground">
                                        Premium Members
                                    </div>
                                </div>

                                <div class="p-4 bg-secondary rounded-lg">
                                    <div class="text-3xl font-bold gradient-primary text-transparent bg-clip-text mb-2">30%</div>
                                    <div class="text-sm text-muted-foreground">
                                        Elite Members
                                    </div>
                                </div>
                            </div>

                            <a href="{{ url('/membership') }}">
                                <button class="inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 gradient-primary text-primary-foreground hover:opacity-90 shadow-medium font-semibold h-11 rounded-md px-8">
                                    Become a Member
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- ===================== JS ===================== -->
<script>
var baseurl = $('meta[name=base-url]').attr("content");
let currentPage = 1;
const perPage = 8;
let filteredProducts = [];
const cart = @json($cartVal);

document.addEventListener('DOMContentLoaded', function() {
    // Laravel products → JS
    const products = @json($products);
    const collaborators = @json($collaborators);

    // Log products to console for debugging
    //console.log('Products:', products);
    //console.log('Collaborators:', collaborators);

    // DOM elements
    const searchInput = document.getElementById('searchInput');
    const clearSearchBtn = document.getElementById('clearSearch');
    const clearAllFiltersBtn = document.getElementById('clearAllFilters');
    const resetAllFromEmptyBtn = document.getElementById('resetAllFromEmpty');
    const resetFiltersBtn = document.getElementById('resetFilters');
    const productsGrid = document.getElementById('productsGrid');
    const resultsCount = document.getElementById('resultsCount');
    const activeFilters = document.getElementById('activeFilters');
    const noResults = document.getElementById('noResults');
   
    // Filter elements
    const categoryFilter = document.getElementById('categoryFilter');
    const collaboratorFilterContainer = document.getElementById('collaboratorFilterContainer');
    const collaboratorFilter = document.getElementById('collaboratorFilter');
    // const vendorFilter = document.getElementById('vendorFilter');
    const ratingRadios = document.querySelectorAll('input[name="rating"]');
   
    // Filter state
    let filters = {
        search: '',
        category: '',
        collaborator: '',
        minRating: null,
        vendor: ''
    };
   
    // Initialize filters
    function initializeFilters() {
        //console.log('Initializing filters...');
        // Get unique categories and vendors
        const uniqueCategories = [...new Set(products.map(p => p.category))].sort();
        const uniqueVendors = [...new Set(products.map(p => p.vendor))].sort();
        //console.log('Unique categories:', uniqueCategories);
        //console.log('Unique vendors:', uniqueVendors);

        // Populate category dropdown
        categoryFilter.innerHTML = '<option value="">Listed By</option>';
        uniqueCategories.forEach(category => {
            const option = document.createElement('option');
            option.value = category;
            option.textContent = category.charAt(0).toUpperCase() + category.slice(1);
            categoryFilter.appendChild(option);
        });

        // Populate collaborator dropdown
        collaboratorFilter.innerHTML = '<option value="">Select Collaborator</option>';
        collaborators.forEach(collaborator => {
            const option = document.createElement('option');
            option.value = collaborator.id;
            option.textContent = `${collaborator.first_name} ${collaborator.last_name}`;
            collaboratorFilter.appendChild(option);
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
            //console.log('Category changed to:', categoryFilter.value);
            filters.category = categoryFilter.value;
            
            // Show/hide collaborator dropdown based on category selection
            if (categoryFilter.value === 'collaborator') {
                collaboratorFilterContainer.classList.remove('hidden');
            } else {
                collaboratorFilterContainer.classList.add('hidden');
                collaboratorFilter.value = '';
                filters.collaborator = '';
            }
            
            filterProducts();
            updateClearButton();
            updateActiveFilters();
        });

        // Collaborator filter event listener
        collaboratorFilter.addEventListener('change', () => {
            //console.log('Collaborator changed to:', collaboratorFilter.value);
            filters.collaborator = collaboratorFilter.value;
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
                //console.log('Rating changed to:', this.value);
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
        //console.log('Search input:', filters.search);
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
   
    // Reset filters button
    resetFiltersBtn.addEventListener('click', () => {
        // Refresh the page to clear all filter states
        window.location.href = window.location.pathname;
    });
   
    // Clear all filters
    clearAllFiltersBtn.addEventListener('click', resetAllFilters);
    resetAllFromEmptyBtn.addEventListener('click', resetAllFilters);
    function resetAllFilters() {
        //console.log('Resetting all filters...');
        // Reset filter state
        filters = {
            search: '',
            category: '',
            collaborator: '',
            minRating: null,
            vendor: ''
        };
        // Reset UI
        searchInput.value = '';
        clearSearchBtn.classList.add('hidden');
        categoryFilter.value = '';
        collaboratorFilter.value = '';
        collaboratorFilterContainer.classList.add('hidden');
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
                            filters.collaborator ||
                            filters.minRating !== null ||
                            filters.vendor;

        //console.log('Has filters:', hasFilters);

        if (hasFilters) {
            clearAllFiltersBtn.classList.remove('hidden');
        } else {
            clearAllFiltersBtn.classList.add('hidden');
        }
    }
   
    // Main filter function
    function filterProducts() {
        //console.log('Filtering products with:', filters);
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

        // Apply collaborator filter
        if (filters.collaborator) {
            filtered = filtered.filter(p => p.user_id == filters.collaborator);
        }

        // Apply rating filter
        if (filters.minRating !== null) {
            filtered = filtered.filter(p => parseFloat(p.rating) >= filters.minRating);
        }

        // Apply vendor filter
        if (filters.vendor) {
            filtered = filtered.filter(p => p.vendor === filters.vendor);
        }

        //console.log('Filtered products count:', filtered.length);
        //renderProducts(filtered);
        filteredProducts = filtered;
        currentPage = 1;
        renderPaginatedProducts();
        renderPagination();
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
    
    function renderPaginatedProducts() {
        const start = (currentPage - 1) * perPage;
        const end = start + perPage;
        const paginated = filteredProducts.slice(start, end);
        renderProducts(paginated);
    }
    
    function renderPagination() {
        const totalPages = Math.ceil(filteredProducts.length / perPage);
        let html = '';
        // Previous button
        html += `<button ${currentPage === 1 ? 'disabled' : ''} onclick="changePage(${currentPage - 1})">Prev</button>`;
        // Page numbers
        for (let i = 1; i <= totalPages; i++) {
            html += `<button 
                        class="${i === currentPage ? 'font-bold text-blue-600' : ''}" 
                        onclick="changePage(${i})">
                        ${i}
                     </button>`;
        }
    
        // Next button
        html += `<button ${currentPage === totalPages ? 'disabled' : ''} onclick="changePage(${currentPage + 1})">Next</button>`;
        document.getElementById('pagination').innerHTML = html;
    }
    
    function changePage(page) {
        currentPage = page;
        renderPaginatedProducts();
        renderPagination();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
    
    window.changePage = changePage;
    window.renderPagination = renderPagination;
    window.updateResultsCount = updateResultsCount;
   
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
            chips.push(createFilterChip(`Category: ${filters.category.charAt(0).toUpperCase() + filters.category.slice(1)}`, 'clearCategory'));
        }

        // Collaborator chip
        if (filters.collaborator) {
            const selectedCollaborator = collaborators.find(c => c.id == filters.collaborator);
            const collaboratorName = selectedCollaborator ? `${selectedCollaborator.first_name} ${selectedCollaborator.last_name}` : 'Collaborator';
            chips.push(createFilterChip(`Collaborator: ${collaboratorName}`, 'clearCollaborator'));
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
                    else if (action === 'clearCollaborator') clearCollaborator();
                    else if (action === 'clearRatingFilter') clearRatingFilter();
                    else if (action === 'clearVendor') clearVendor();
                });
            });
        }
    }
   
    function createFilterChip(label, action) {
        return `<div class="inline-flex items-center gap-1 bg-gray-100 text-gray-700 px-3 py-2 rounded-full text-sm">
                <span>${label}</span>
                <button type="button" class="remove-filter text-gray-500 hover:text-gray-700 ml-1"
                        data-action="${action}">
                    <i class="fas fa-times"></i>
                </button>
            </div>`;
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
        collaboratorFilterContainer.classList.add('hidden');
        collaboratorFilter.value = '';
        filters.collaborator = '';
        filterProducts();
        updateClearButton();
        updateActiveFilters();
    }
   
    function clearCollaborator() {
        collaboratorFilter.value = '';
        filters.collaborator = '';
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
        //console.log('Rendering products:', list.length);
        if (!list.length) {
            productsGrid.innerHTML = '';
            return;
        }
        productsGrid.innerHTML = list.map(product => {
            const qty = cart[product.id] ?? 0;
            const imageUrl = product.image
            ? baseurl + `/product_images/${product.image}`
            : '';

            const vendorName = product.user?.first_name && product.user?.last_name? `${product.user.first_name} ${product.user.last_name}`: 'N/A';
            const userRole = product.user?.role ?? 'N/A';

            return `<div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition transform hover:-translate-y-1">
                <a href="${baseurl}/products/${product.slug}">
                    <div class="aspect-square bg-gradient-to-br from-primary/10 to-accent/10 flex items-center justify-center rounded-t-lg relative">
                        <div class="text-center p-6 relative">
                                ${ product.image
                                    ? `<img src="${imageUrl}" alt="${product.name ?? ''}" class="max-h-48 mx-auto object-contain" loading="lazy">`
                                : `<div class="text-gray-300">No Image Available</div>`
                                }
                        </div>
                    </div>
                </a>

                ${
                    product.discount>0
                    ? `<span class="absolute top-0 right-0  badge gradient-accent text-accent-foreground border-0">
                            ${product.discount}% OFF
                        </span>`
                    : ``
                }

                <div class="p-5">
                    <a href="${baseurl}/products/${product.slug}">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2 line-clamp-2">${product.name}</h3>
                    </a>
                    <p class="text-sm text-primary mb-1">by ${userRole === 'collaborator' ? vendorName : 'Institute'}</p>
                    <p class="text-sm text-muted-foreground line-clamp-2 mb-3">${product.description}</p>
                    <div class="flex items-baseline space-x-2">
                        <span class="text-2xl font-bold">
                            $${Number(product.price).toFixed(2)}
                        </span>
                    </div>
                </div>
                <div class="py-4 pt-0 justify-self-center w-full px-4">
                    ${
                        qty > 0
                        ? `<button class="rounded-md flex items-center justify-center font-semibold gap-2 transition-all duration-150 select-none px-5 py-2 text-base h-10 gradient-primary text-primary-foreground hover:opacity-90 shadow-medium font-semibold h-10 px-4 py-2  w-full" onclick="addToCart(${product.id})">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="shopping-cart" aria-hidden="true" class="lucide lucide-shopping-cart w-5 h-5 mr-2"><circle cx="8" cy="21" r="1"></circle><circle cx="19" cy="21" r="1"></circle><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"></path></svg>
                                <span id="add_to_cart_button_${product.id}">${qty} ${qty == 1 ? 'item' : 'items'} in cart</span>
                           </button>`
                        : `<button class="rounded-md flex items-center justify-center font-semibold gap-2 transition-all duration-150 select-none px-5 py-2 text-base h-10 gradient-primary text-primary-foreground hover:opacity-90 shadow-medium font-semibold h-10 px-4 py-2  w-full"
                                onclick="addToCart(${product.id})">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="shopping-cart" aria-hidden="true" class="lucide lucide-shopping-cart w-5 h-5 mr-2"><circle cx="8" cy="21" r="1"></circle><circle cx="19" cy="21" r="1"></circle><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"></path></svg>
                                <span id="add_to_cart_button_${product.id}">Add to Cart</span>
                           </button>`
                    }
                </div>
            </div>`;
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
                stars += '<i data-lucide="star" class="w-4 h-4 fill-accent text-accent"></i>';
            } else if (i === fullStars + 1 && hasHalfStar) {
                stars += '<i data-lucide="star-half" class="w-4 h-4 fill-accent text-accent"></i>';
            } else {
                stars += '<i data-lucide="star" class="w-4 h-4 fill-accent text-accent"></i>';
            }
        }
        return `<span class="flex">${stars}</span>`;
    }

    // Initialize
    //console.log('Initializing product filter...');
    initializeFilters();
    filterProducts();
    updateClearButton();
    updateActiveFilters();
});
</script>
<style>
/* Custom scrollbar for filter containers */
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

#pagination button {
    padding: 6px 12px;
    border: 1px solid #ddd;
    border-radius: 6px;
}

#pagination button:hover {
    background: #f3f3f3;
}

#pagination button:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

/* Mobile-specific product card adjustments */
@media (max-width: 639px) {
    #productsGrid .bg-white {
        padding: 10px !important;
    }
    
    #productsGrid h3 {
        font-size: 12px !important;
        line-height: 1.2 !important;
        margin-bottom: 6px !important;
        height: 2.4em !important;
        overflow: hidden !important;
        display: -webkit-box !important;
        -webkit-line-clamp: 2 !important;
        -webkit-box-orient: vertical !important;
    }
    
    #productsGrid p.text-sm {
        font-size: 10px !important;
        line-height: 1.2 !important;
        margin-bottom: 6px !important;
        height: 2.4em !important;
        overflow: hidden !important;
        display: -webkit-box !important;
        -webkit-line-clamp: 2 !important;
        -webkit-box-orient: vertical !important;
    }
    
    #productsGrid .text-2xl {
        font-size: 14px !important;
        line-height: 1.2 !important;
    }
    
    #productsGrid button {
        font-size: 11px !important;
        padding: 6px 8px !important;
        height: auto !important;
        min-height: 32px !important;
    }
    
    #productsGrid .aspect-square {
        aspect-ratio: 1 !important;
        min-height: 100px !important;
    }
    
    #productsGrid img {
        max-height: 80px !important;
        width: auto !important;
    }
    
    #productsGrid .p-5 {
        padding: 8px !important;
    }
    
    #productsGrid .py-4 {
        padding-top: 6px !important;
        padding-bottom: 6px !important;
    }
    
    /* Members Save More section mobile adjustments */
    .py-20 {
        padding-top: 40px !important;
        padding-bottom: 40px !important;
    }
    
    .max-w-4xl {
        max-width: 100% !important;
    }
    
    .text-3xl {
        font-size: 24px !important;
    }
    
    .text-muted-foreground {
        font-size: 14px !important;
    }
    
    .grid.md\:grid-cols-3 {
        grid-template-columns: repeat(1, minmax(0, 1fr)) !important;
        gap: 12px !important;
    }
    
    .p-8 {
        padding: 20px !important;
    }
    
    .text-3xl.font-bold {
        font-size: 20px !important;
    }
    
    .text-sm.text-muted-foreground {
        font-size: 12px !important;
    }
}
</style>
<script src="{{ asset('js/cart.js') }}"></script> 
@endsection