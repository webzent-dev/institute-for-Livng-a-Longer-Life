@extends('front.layouts.app')
@section('content')
<div class="min-h-screen flex flex-col">
 
    <div class="max-w-7xl mx-auto py-10 px-4">

  <!-- Search + Category -->
  <div class="mb-8 flex flex-col md:flex-row gap-4">
    <div class="relative flex-1">
      <input
        type="text"
        id="searchInput"
        placeholder="Search products..."
        class="w-full pl-12 pr-12 py-4 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-yellow-400 text-lg"
      />
      <i class="fas fa-search absolute left-4 top-5 text-gray-500 text-xl"></i>

      <button id="clearSearch" class="absolute right-3 top-4 text-gray-500 hover:text-gray-700 text-2xl hidden">
        <i class="fas fa-times-circle"></i>
      </button>
    </div>

    <select
      id="categoryFilter"
      class="px-6 py-4 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-yellow-400 text-lg"
    >
      <option value="all">All Categories</option>

      {{-- Generate categories automatically (optional) --}}
      @foreach($products->pluck('category')->unique() as $cat)
          <option value="{{ $cat }}">{{ $cat }}</option>
      @endforeach
    </select>
  </div>

  <!-- Price, Rating, Clear -->
  <div class="mb-8 grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- Price -->
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-2">Price Range</label>
      <div class="flex items-center gap-3">
        <input type="number" id="minPrice" placeholder="Min" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-yellow-400"/>
        <span class="text-gray-500">—</span>
        <input type="number" id="maxPrice" placeholder="Max" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-yellow-400"/>
      </div>
    </div>

    <!-- Rating -->
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-2">Minimum Rating</label>
      <select id="ratingFilter" class="w-full px-4 py-4 border rounded-lg focus:ring-2 focus:ring-yellow-400">
        <option value="0">Any Rating</option>
        <option value="4">4★ & above</option>
        <option value="3">3★ & above</option>
        <option value="2">2★ & above</option>
        <option value="1">1★ & above</option>
      </select>
    </div>

    <!-- Clear All -->
    <div class="flex items-end">
      <button
        id="clearFilters"
        class="w-full bg-gray-600 text-white px-8 py-4 rounded-lg hover:bg-gray-700 transition"
      >
        Clear Filters
      </button>
    </div>
  </div>

  <!-- Active Filter Chips -->
  <div id="activeFilters" class="mb-6 flex flex-wrap gap-2"></div>

  <!-- Result Count -->
  <p id="resultsCount" class="text-lg font-medium text-gray-700 mb-6"></p>

  <!-- Products Grid -->
  <div id="productsGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8"></div>


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
                                    <div class="text-3xl font-bold text-primary  bg-clip-text mb-2">{{ $discount['title'] }} </div>
                                    <div class="text-sm text-muted-foreground">{{ $discount['class'] }}</div>
                                </div>
                            @endforeach
                               
 
 
                        </div>
 
                        <a href="{{ route('membership') }}">
                            <button class="btn btn-primary btn-lg">
                                <i data-lucide="house-plus" class="mr-2 h-6 w-6"></i>
                                Become a Member</button>
                        </a>
 
                    </div>
                </div>
 
            </div>
        </section>
 

</div>

<!-- ===================== JS ===================== -->
<script>
    // Laravel products → JS
    const products = @json($products);

    // DOM elements
    const searchInput = document.getElementById('searchInput');
    const clearSearchBtn = document.getElementById('clearSearch');
    const categoryFilter = document.getElementById('categoryFilter');
    const minPrice = document.getElementById('minPrice');
    const maxPrice = document.getElementById('maxPrice');
    const ratingFilter = document.getElementById('ratingFilter');
    const clearFiltersBtn = document.getElementById('clearFilters');
    const productsGrid = document.getElementById('productsGrid');
    const resultsCount = document.getElementById('resultsCount');
    const activeFilters = document.getElementById('activeFilters');

    // Show clear button
    searchInput.addEventListener('input', () => {
        clearSearchBtn.classList.toggle('hidden', searchInput.value.length === 0);
    });

    clearSearchBtn.addEventListener('click', () => {
        searchInput.value = "";
        clearSearchBtn.classList.add('hidden');
        filterProducts();
    });

    clearFiltersBtn.addEventListener('click', () => {
        searchInput.value = '';
        categoryFilter.value = 'all';
        minPrice.value = '';
        maxPrice.value = '';
        ratingFilter.value = '0';
        activeFilters.innerHTML = '';
        clearSearchBtn.classList.add('hidden');

        filterProducts();
    });

    function filterProducts() {
        let filtered = products;

        const query = searchInput.value.toLowerCase().trim();
        const category = categoryFilter.value;
        const min = minPrice.value ? Number(minPrice.value) : 0;
        const max = maxPrice.value ? Number(maxPrice.value) : Infinity;
        const minRating = Number(ratingFilter.value);

        if (query) filtered = filtered.filter(p => p.name.toLowerCase().includes(query));
        if (category !== 'all') filtered = filtered.filter(p => p.category === category);
        filtered = filtered.filter(p => p.price >= min && p.price <= max);
        filtered = filtered.filter(p => p.rating >= minRating);

        renderProducts(filtered);
        updateActiveFilters({ query, category, min, max, minRating });
    }

    function renderProducts(list) {
        if (!list.length) {
            productsGrid.innerHTML = `
                <p class="col-span-full text-center text-xl text-gray-500 py-12">
                    No products found.
                </p>`;
            resultsCount.textContent = "0 results";
            return;
        }

        resultsCount.textContent = `${list.length} results`;
 

        // Add event listeners to the product cards.......
        productsGrid.innerHTML = list.map(product => `
         

            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition transform hover:-translate-y-1">
               

                <div class="p-0">
                                  <div class="aspect-square bg-gradient-to-br from-primary/10 to-accent/10 flex items-center justify-center    rounded-t-lg">
                                        <div class="text-center p-6">
                                               <img src="${product.image}" class="" alt="Product">  
                                                <span class="badge gradient-accent text-accent-foreground border-0">
                                                     ${product.discount}% OFF
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                      <div class="p-5">
                            <h3 class="text-lg font-semibold text-gray-800 mb-2 line-clamp-2">
                                ${product.name}
                            </h3>
                          <p class="text-sm text-primary">by  ${product.vendor}</p>
                          <p class="text-sm text-muted-foreground line-clamp-2">  ${product.description} </p>
                          <div class="flex items-center space-x-2">
                                            <div class="flex items-center">
                                                <i data-lucide="star" class="h-4 w-4 fill-accent text-accent"></i>
                                                <span class="ml-1 text-sm font-medium text-foreground">${product.rating}</span>
                                            </div>
                                            <span class="text-sm text-muted-foreground"> (${product.reviews} reviews) </span>
                          </div>


                            <p class="text-xs text-gray-500 mb-2">${product.category}</p>
                    
                                        <div class="flex items-baseline space-x-2">
                                            <span class="text-2xl font-bold text-foreground">
                                                $${Number(product.price).toFixed(2)}
                                            </span>
                                            <span class="text-sm text-muted-foreground line-through">
                                                ${product.originalPrice}
                                            </span>
                                        </div>

                        
                    </div>

                                      

                                    <div class="p-4 pt-0">
                                        <form action="" method="POST">
                                            @csrf
                                            <button class="btn btn-primary w-full flex items-center justify-center">
                                                
                                                <i data-lucide="shopping-cart" class="mr-2 h-6 w-6"></i>
                                                Add to Cart
                                            </button>
                                        </form>
                                    </div>
                </div>
                                     
            </div>
        `).join('');
    }

    function updateActiveFilters({ query, category, min, max, minRating }) {
        activeFilters.innerHTML = '';

        if (query)
            activeFilters.innerHTML += chip(query, "clearSearchInput");

        if (category !== 'all')
            activeFilters.innerHTML += chip(category, "clearCategory");

        if (min > 0 || max < Infinity)
            activeFilters.innerHTML += chip(`$${min || 0} - ${max === Infinity ? 'Any' : '$' + max}`, "clearPrice");

        if (minRating > 0)
            activeFilters.innerHTML += chip(`${minRating}★ & up`, "clearRating");
    }

    const chip = (text, fn) =>
        `<span class="bg-yellow-100 text-yellow-800 px-4 py-2 rounded-full text-sm font-medium">
            ${text}
            <i class="fas fa-times ml-2 cursor-pointer" onclick="${fn}()"></i>
        </span>`;

    // individual clear functions
    function clearSearchInput() { searchInput.value = ''; clearSearchBtn.classList.add('hidden'); filterProducts(); }
    function clearCategory() { categoryFilter.value = 'all'; filterProducts(); }
    function clearPrice() { minPrice.value = ''; maxPrice.value = ''; filterProducts(); }
    function clearRating() { ratingFilter.value = '0'; filterProducts(); }

    // Events
    [searchInput, categoryFilter, minPrice, maxPrice, ratingFilter].forEach(e => {
        e.addEventListener('input', filterProducts);
        e.addEventListener('change', filterProducts);
    });

    // Initial load
    filterProducts();
</script>
 
 
</div>
 

@endsection

 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
 

 