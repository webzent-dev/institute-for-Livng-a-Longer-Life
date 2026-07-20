@extends('front.layouts.app')

@section('content')
    <!-- Main Product Section -->
    <main class="container-base max-w-7xl  mx-auto px-4 py-6">
        <!-- Breadcrumbs -->
        <!-- <div class="mb-6">
            <nav class="text-sm text-gray-600">
                <ol class="flex items-center space-x-2">
                    <li><a href="#" class="hover:text-green-600">Store</a></li>
                    <li><i class="fas fa-chevron-right text-xs"></i></li>
                    <li><a href="#" class="hover:text-green-600">Supplements</a></li>
                    <li><i class="fas fa-chevron-right text-xs"></i></li>
                    <li><a href="#" class="hover:text-green-600">Wellness</a></li>
                    <li><i class="fas fa-chevron-right text-xs"></i></li>
                    <li class="text-gray-800 font-medium">Vital Boost - Premium Longevity Formula</li>
                </ol>
            </nav>
        </div> -->
 
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Left Column: Product Images -->
            <div class="lg:w-1/2">
                <!-- Main Image -->
                <div class="product-image-container bg-white p-4 mb-4 shadow-md">
                    <div class="relative h-96 flex items-center justify-center">
                        <!-- <img id="mainImage" src="{{ asset('product_images/' . $product->image) }}" alt="{{ $product->name }}" class="max-h-full max-w-full zoom-image"> -->
                        @if(!empty($product->image) && file_exists(public_path('product_images/' . $product->image)))
                            <img src="{{ asset('product_images/' . $product->image) }}" alt="{{ $product->name }}" class="max-h-full max-w-full zoom-image"/>
                        @else
                            <img src="{{ asset('/assets/placeholder.svg') }}" alt="{{ $product->name }}" class="max-h-full max-w-full zoom-image"/>
                        @endif
                        <!-- <span class="absolute top-4 left-4 bg-amber-600 text-white text-xs font-semibold px-2 py-1 rounded">12% OFF</span>
                        <button id="zoomBtn" class="absolute bottom-4 right-4 bg-white p-2 rounded-full shadow-md hover:bg-gray-100">
                            <i class="fas fa-search-plus text-gray-600"></i>
                        </button> -->
                    </div>
                </div>
                
                <!-- Image Thumbnails -->
                <!-- <div class="flex space-x-4 overflow-x-auto pb-2">
                    <div class="thumbnail flex-shrink-0 w-20 h-20 border-2 border-gray-200 rounded-md overflow-hidden cursor-pointer active" data-image="{{ asset('assets/vitalboost.webp') }}">
                        <img src="{{ asset('assets/vitalboost.webp') }}" alt="Vital Boost - Premium Longevity Formula" class="w-full h-full object-cover">
                    </div>
                    <div class="thumbnail flex-shrink-0 w-20 h-20 border-2 border-gray-200 rounded-md overflow-hidden cursor-pointer" data-image="{{ asset('assets/vitalboost.webp') }}">
                        <img src="{{ asset('assets/vitalboost.webp') }}" alt="Vital Boost - Premium Longevity Formula" class="w-full h-full object-cover">
                    </div>
                    <div class="thumbnail flex-shrink-0 w-20 h-20 border-2 border-gray-200 rounded-md overflow-hidden cursor-pointer" data-image="{{ asset('assets/vitalboost.webp') }}">
                        <img src="{{ asset('assets/vitalboost.webp') }}" alt="Vital Boost - Premium Longevity Formula" class="w-full h-full object-cover">
                    </div>
                    <div class="thumbnail flex-shrink-0 w-20 h-20 border-2 border-gray-200 rounded-md overflow-hidden cursor-pointer" data-image="{{ asset('assets/vitalboost.webp') }}">
                        <img src="{{ asset('assets/vitalboost.webp') }}" alt="Vital Boost - Premium Longevity Formula" class="w-full h-full object-cover">
                    </div>
                    <div class="thumbnail flex-shrink-0 w-20 h-20 border-2 border-gray-200 rounded-md overflow-hidden cursor-pointer" data-image="{{ asset('assets/vitalboost.webp') }}">
                        <img src="{{ asset('assets/vitalboost.webp') }}" alt="Vital Boost - Premium Longevity Formula" class="w-full h-full object-cover">
                    </div>
                </div> -->
                
                <!-- Share & Wishlist -->
                <!-- <div class="mt-6 flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <button class="flex items-center text-gray-700 hover:text-green-600">
                            <i class="far fa-heart text-lg mr-2"></i>
                            <span>Add to Wishlist</span>
                        </button>
                        <button class="flex items-center text-gray-700 hover:text-green-600">
                            <i class="fas fa-share-alt text-lg mr-2"></i>
                            <span>Share</span>
                        </button>
                    </div>
                    <div>
                        <button class="text-gray-700 hover:text-red-600">
                            <i class="fas fa-flag text-lg"></i>
                        </button>
                    </div>
                </div> -->

                <!-- RELATED PRODUCTS SECTION -->
                <!-- <div class="mt-12 mb-16">
                    <div class="flex items-center justify-between mb-8">
                        <h2 class="text-2xl font-bold text-gray-900">Related Products</h2>
                        <a href="#" class="text-green-600 font-medium hover:text-green-800 hover:underline flex items-center">
                            View All <i class="fas fa-chevron-right ml-1 text-sm"></i>
                        </a>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        <div class="related-product-card bg-white rounded-lg border border-gray-200 p-4 relative">
                            <div class="relative overflow-hidden rounded-md mb-4 h-48">
                                <img src="{{ asset('assets/vitalboost.webp') }}" 
                                     alt="Vital Boost - Premium Longevity Formula" 
                                     class="w-full h-full object-cover related-product-image">
                                <div class="absolute top-2 left-2 bg-red-600 text-white text-xs font-semibold px-2 py-1 rounded">
                                    15% OFF
                                </div>
                                <button class="quick-add-btn absolute bottom-2 right-2 bg-green-600 text-white p-2 rounded-full shadow-lg hover:bg-green-700">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            <h3 class="font-medium text-gray-900 mb-1 truncate">Vital Boost - Premium Longevity Formula</h3>
                            <div class="flex items-center mb-2">
                                <div class="flex text-amber-500 text-sm mr-2">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </div>
                                <span class="text-gray-500 text-sm">(2,541)</span>
                            </div>
                            <div class="flex items-center">
                                <span class="text-lg font-bold text-gray-900">₹64,999</span>
                                <span class="text-gray-500 line-through text-sm ml-2">₹76,499</span>
                            </div>
                            <p class="text-gray-600 text-sm mt-1">Intel Core i5, 16GB RAM, 512GB SSD</p>
                            <button class="mt-4 w-full bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-2 px-4 rounded-md transition duration-200">
                                Add to Cart
                            </button>
                        </div>
                        
                        <div class="related-product-card bg-white rounded-lg border border-gray-200 p-4 relative">
                            <div class="relative overflow-hidden rounded-md mb-4 h-48">
                                <img src="{{ asset('assets/gaminglaptop.webp') }}" 
                                     alt="Gaming Laptop Pro" 
                                     class="w-full h-full object-cover related-product-image">
                                <div class="absolute top-2 left-2 bg-red-600 text-white text-xs font-semibold px-2 py-1 rounded">
                                    10% OFF
                                </div>
                                <button class="quick-add-btn absolute bottom-2 right-2 bg-green-600 text-white p-2 rounded-full shadow-lg hover:bg-green-700">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            <h3 class="font-medium text-gray-900 mb-1 truncate">Gaming Laptop Pro</h3>
                            <div class="flex items-center mb-2">
                                <div class="flex text-amber-500 text-sm mr-2">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                </div>
                                <span class="text-gray-500 text-sm">(3,214)</span>
                            </div>
                            <div class="flex items-center">
                                <span class="text-lg font-bold text-gray-900">₹1,12,999</span>
                                <span class="text-gray-500 line-through text-sm ml-2">₹1,25,999</span>
                            </div>
                            <p class="text-gray-600 text-sm mt-1">RTX 4070, 32GB RAM, 1TB SSD, 17" Display</p>
                            <button class="mt-4 w-full bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-2 px-4 rounded-md transition duration-200">
                                Add to Cart
                            </button>
                        </div>
                        
                        <div class="related-product-card bg-white rounded-lg border border-gray-200 p-4 relative">
                            <div class="relative overflow-hidden rounded-md mb-4 h-48">
                                <img src="{{ asset('assets/tabletpro.webp') }}" 
                                     alt="TechPro Tablet Pro" 
                                     class="w-full h-full object-cover related-product-image">
                                <div class="absolute top-2 left-2 bg-green-600 text-white text-xs font-semibold px-2 py-1 rounded">
                                    NEW
                                </div>
                                <button class="quick-add-btn absolute bottom-2 right-2 bg-green-600 text-white p-2 rounded-full shadow-lg hover:bg-green-700">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            <h3 class="font-medium text-gray-900 mb-1 truncate">TechPro Tablet Pro 12.9"</h3>
                            <div class="flex items-center mb-2">
                                <div class="flex text-amber-500 text-sm mr-2">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <span class="text-gray-500 text-sm">(1,842)</span>
                            </div>
                            <div class="flex items-center">
                                <span class="text-lg font-bold text-gray-900">₹89,999</span>
                                <span class="text-gray-500 line-through text-sm ml-2">₹95,999</span>
                            </div>
                            <p class="text-gray-600 text-sm mt-1">M2 Chip, 256GB, Stylus Included</p>
                            <button class="mt-4 w-full bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-2 px-4 rounded-md transition duration-200">
                                Add to Cart
                            </button>
                        </div>
                        
                        <div class="related-product-card bg-white rounded-lg border border-gray-200 p-4 relative">
                            <div class="relative overflow-hidden rounded-md mb-4 h-48">
                                <img src="{{ asset('assets/ultrabook.webp') }}" 
                                     alt="Ultrabook Slim" 
                                     class="w-full h-full object-cover related-product-image">
                                <div class="absolute top-2 left-2 bg-red-600 text-white text-xs font-semibold px-2 py-1 rounded">
                                    18% OFF
                                </div>
                                <button class="quick-add-btn absolute bottom-2 right-2 bg-green-600 text-white p-2 rounded-full shadow-lg hover:bg-green-700">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            <h3 class="font-medium text-gray-900 mb-1 truncate">Ultrabook Slim 14"</h3>
                            <div class="flex items-center mb-2">
                                <div class="flex text-amber-500 text-sm mr-2">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </div>
                                <span class="text-gray-500 text-sm">(3,027)</span>
                            </div>
                            <div class="flex items-center">
                                <span class="text-lg font-bold text-gray-900">₹72,499</span>
                                <span class="text-gray-500 line-through text-sm ml-2">₹88,499</span>
                            </div>
                            <p class="text-gray-600 text-sm mt-1">Intel i7, 16GB RAM, 1TB SSD, 2.2 lbs</p>
                            <button class="mt-4 w-full bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-2 px-4 rounded-md transition duration-200">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div> -->
                <!-- END RELATED PRODUCTS SECTION -->
            </div>
            
            <!-- Right Column: Product Details -->
            <div class="lg:w-1/2">
                <!-- Product Title & Brand -->
                <div class="mb-4">
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 text-left">{{$product->name}}</h1>
                    
                    <!-- Ratings & Reviews -->
                    <div class="flex items-center mt-3 mb-4">
                        <div class="flex text-yellow-400">
                            <i data-lucide="star" class="h-5 w-5 fill-current"></i>
                            <i data-lucide="star" class="h-5 w-5 fill-current"></i>
                            <i data-lucide="star" class="h-5 w-5 fill-current"></i>
                            <i data-lucide="star" class="h-5 w-5 fill-current"></i>
                            <i data-lucide="star" class="h-5 w-5 fill-current"></i>
                        </div>
                        <span class="ml-2 text-gray-600">(1 review)</span>
                    </div>
                </div>
                
                <!-- Price Section -->
                <div class="mb-6">
                    <div class="flex items-center mb-4">
                        @if($product->compare_price || $product->originalPrice)
                            <span class="text-gray-500 line-through text-xl mr-3">${{ number_format($product->compare_price ?? $product->originalPrice, 2) }}</span>
                        @endif
                        <span class="text-3xl font-bold text-gray-900">${{ number_format($product->price, 2) }}</span>
                        @if($product->compare_price || $product->originalPrice)
                            <span class="ml-3 bg-primary text-primary-foreground text-sm font-semibold px-2 py-1 rounded">Save {{ round((($product->compare_price ?? $product->originalPrice - $product->price) / ($product->compare_price ?? $product->originalPrice)) * 100) }}%</span>
                        @endif
                    </div>

                    <!-- Stock Status & View Count -->
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center text-sm text-gray-600">
                            <i data-lucide="eye" class="h-4 w-4 mr-1"></i>
                            <span data-viewing-count data-current-count="20">20 people are viewing this right now</span>
                        </div>
                        {{-- Hidden while a subscription plan is selected: a recurring plan
                             ships on a schedule, so today's shelf count says nothing useful
                             and reads as urgency that does not apply. --}}
                        <div id="stock_status" class="flex items-center text-sm text-primary font-medium">
                            <i data-lucide="check-circle" class="h-4 w-4 mr-1"></i> {{ $product->stock_quantity ?? 20 }} left in stock
                        </div>
                    </div>
                    
                    <!-- Vendor Information -->
                    @if($product->user)
                    <div class="flex items-center text-sm text-gray-600">
                        <span class="font-medium">Vendor:</span>
                        <span class="ml-2 font-semibold text-primary">{{ $product->user->first_name }} {{ $product->user->last_name }}</span>
                    </div>
                    @endif
                </div>
                
                <!-- Offers -->
                <!-- <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-3">Available offers</h3>
                    <ul class="space-y-2 text-sm">
                        <li class="flex items-start">
                            <i class="fas fa-tag text-green-600 mt-1 mr-2"></i>
                            <span><span class="font-semibold">Bank Offer</span> 10% off on Axis Bank Credit Card, up to $1,500 on orders of $7,500 and above <span class="text-green-600 font-medium hover:underline cursor-pointer">T&C</span></span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-tag text-green-600 mt-1 mr-2"></i>
                            <span><span class="font-semibold">Bank Offer</span> 5% Cashback on ILL Axis Bank Card <span class="text-green-600 font-medium hover:underline cursor-pointer">T&C</span></span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-tag text-green-600 mt-1 mr-2"></i>
                            <span><span class="font-semibold">Special Price</span> Get extra $8,000 off (price inclusive of discount) <span class="text-green-600 font-medium hover:underline cursor-pointer">T&C</span></span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-tag text-green-600 mt-1 mr-2"></i>
                            <span><span class="font-semibold">Partner Offer</span> Sign up for TechPro Pay Later and get $100 gift card <span class="text-green-600 font-medium hover:underline cursor-pointer">Know More</span></span>
                        </li>
                    </ul>
                </div> -->
                
                <!-- Color Selection -->
                <!-- <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-3">Color</h3>
                    <div class="flex space-x-4">
                        <div class="color-option border-2 border-green-500 rounded-lg p-1 cursor-pointer">
                            <div class="w-14 h-14 bg-gray-800 rounded-md"></div>
                            <p class="text-center text-xs mt-1 font-medium">Space Gray</p>
                        </div>
                        <div class="color-option border-2 border-gray-200 rounded-lg p-1 cursor-pointer hover:border-gray-400">
                            <div class="w-14 h-14 bg-slate-300 rounded-md"></div>
                            <p class="text-center text-xs mt-1">Silver</p>
                        </div>
                        <div class="color-option border-2 border-gray-200 rounded-lg p-1 cursor-pointer hover:border-gray-400">
                            <div class="w-14 h-14 bg-amber-100 rounded-md"></div>
                            <p class="text-center text-xs mt-1">Rose Gold</p>
                        </div>
                    </div>
                </div> -->
                
                <!-- Storage Selection -->
                <!-- <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-3">Dietary Supplement</h3>
                    <div class="flex flex-wrap gap-3">
                        <div class="storage-option border-2 border-green-500 bg-green-50 rounded-lg px-4 py-3 cursor-pointer">
                            <p class="font-medium">Superfood Formula</p>
                            <p class="text-sm text-gray-600">+ $5,000</p>
                        </div>
                        <div class="storage-option border-2 border-gray-300 rounded-lg px-4 py-3 cursor-pointer hover:border-gray-400">
                            <p class="font-medium">ILL</p>
                            <p class="text-sm text-gray-600">+ $10,000</p>
                        </div>
                        <div class="storage-option border-2 border-gray-300 rounded-lg px-4 py-3 cursor-pointer hover:border-gray-400">
                            <p class="font-medium">ILL</p>
                            <p class="text-sm text-gray-600">+ $18,000</p>
                        </div>
                    </div>
                </div> -->
                
                <!-- Warranty -->
                <!-- <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-3">Support Service</h3>
                    <div class="flex flex-wrap gap-3">
                        <div class="warranty-option border-2 border-green-500 bg-green-50 rounded-lg px-4 py-3 cursor-pointer">
                            <p class="font-medium">1 Year</p>
                            <p class="text-sm text-gray-600">Vital Boost - Premium Formula</p>
                        </div>
                        <div class="warranty-option border-2 border-gray-300 rounded-lg px-4 py-3 cursor-pointer hover:border-gray-400">
                            <p class="font-medium">2 Years</p>
                            <p class="text-sm text-gray-600">+ $2,499</p>
                        </div>
                        <div class="warranty-option border-2 border-gray-300 rounded-lg px-4 py-3 cursor-pointer hover:border-gray-400">
                            <p class="font-medium">3 Years</p>
                            <p class="text-sm text-gray-600">+ $4,499</p>
                        </div>
                    </div>
                </div> -->
                
                <!-- Quantity & Delivery -->
                <!-- <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <h3 class="text-lg font-semibold mb-3">Quantity</h3>
                        <div class="flex items-center border border-gray-300 rounded-lg w-32">
                            <button id="decreaseQty" class="px-3 py-2 text-gray-600 hover:text-gray-800">
                                <i class="fas fa-minus"></i>
                            </button>
                            <span id="quantity" class="flex-1 text-center font-semibold">1</span>
                            <button id="increaseQty" class="px-3 py-2 text-gray-600 hover:text-gray-800">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div>
                        <h3 class="text-lg font-semibold mb-3">Delivery</h3>
                        <div class="flex items-start">
                            <i class="fas fa-map-marker-alt text-green-600 mt-1 mr-2"></i>
                            <div>
                                <p class="font-medium">Deliver to <span class="text-green-600 cursor-pointer">New Delhi 110001</span></p>
                                <p class="text-sm text-gray-600">Delivery by <span class="font-medium">Tomorrow, 10 AM</span> | Free</p>
                                <p class="text-sm text-gray-600">If ordered within <span class="text-green-600 font-medium">2 hrs 14 mins</span></p>
                            </div>
                        </div>
                    </div>
                </div> -->
                
                <!-- Quantity Selection -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Quantity</label>
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center border-2 border-gray-200 rounded-lg overflow-hidden">
                            <button type="button" onclick="decreaseQuantity()" aria-label="Decrease quantity" class="px-3 py-2 text-gray-600 hover:text-primary hover:bg-primary/5 transition-colors">
                                <i data-lucide="minus" class="h-4 w-4"></i>
                            </button>
                            <input type="number" id="quantity" value="1" min="1" max="{{ $product->stock_quantity ?? 99 }}" class="w-16 text-center border-0 focus:ring-0 font-semibold">
                            <button type="button" onclick="increaseQuantity()" aria-label="Increase quantity" class="px-3 py-2 text-gray-600 hover:text-primary hover:bg-primary/5 transition-colors">
                                <i data-lucide="plus" class="h-4 w-4"></i>
                            </button>
                        </div>
                        <span class="text-sm text-muted-foreground">Max: {{ $product->stock_quantity ?? 99 }} items</span>
                    </div>
                </div>
                
                @php ($cartVal = Session::get('cart', [])) @endphp

                @php
                    // Vital Boost sells on three plans. The priced options come from the
                    // same service the shop grid uses, so both pages quote the same
                    // figures and the same perk wording.
                    $vbPricing = ($vitalBoostPricing ?? [])[$product->id] ?? null;
                    $vbOptions = [
                        'one_time' => ['label' => 'One Time',  'cta' => 'Add to Cart'],
                        'monthly'  => ['label' => 'Monthly',   'cta' => 'Subscribe Monthly'],
                        'yearly'   => ['label' => 'Yearly',    'cta' => 'Subscribe Yearly'],
                    ];
                @endphp

                @php
                    // The cart icon and button styling mirror the shop grid so a product
                    // looks the same wherever it is bought from.
                    $cartIconSvg = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 mr-2"><circle cx="8" cy="21" r="1"></circle><circle cx="19" cy="21" r="1"></circle><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"></path></svg>';
                    $ctaClasses = 'rounded-md flex items-center justify-center font-semibold gap-2 transition-all duration-150 select-none px-8 py-3 text-base gradient-primary text-primary-foreground hover:opacity-90 shadow-medium';
                @endphp

                @if($vbPricing)
                    <!-- Vital Boost purchase options -->
                    <div class="mb-12 max-w-md" id="vb_details_{{ $product->id }}">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Purchase option</label>
                        <div class="grid grid-cols-3 gap-3 mb-3">
                            @foreach($vbOptions as $key => $option)
                                @php $breakdown = $vbPricing[$key] ?? null; @endphp
                                @if($breakdown)
                                    <button type="button"
                                            data-vb-option="{{ $key }}"
                                            data-vb-cta="{{ $option['cta'] }}"
                                            data-vb-perk="{{ $breakdown['perk_label'] ?? '' }}"
                                            class="vb-option rounded-lg border-2 px-2 py-3 text-center transition-all {{ $key === 'one_time' ? 'border-primary bg-primary/5' : 'border-gray-200 hover:border-primary/50' }}">
                                        <span class="block text-xs font-semibold text-muted-foreground">{{ $option['label'] }}</span>
                                        <span class="block text-base font-bold text-gray-900">
                                            ${{ number_format($breakdown['subtotal_after_discounts'] ?? 0, 2) }}
                                        </span>
                                    </button>
                                @endif
                            @endforeach
                        </div>

                        {{-- Reserved height so switching plans does not shift the button. --}}
                        <p id="vb_perk_note" class="text-sm text-primary font-medium mb-4"
                           style="min-height:1.25rem;line-height:1.25rem;">{{ $vbPricing['one_time']['perk_label'] ?? '' }}</p>

                        <button id="add_to_cart_button_{{$product->id}}"
                                onclick="vbDetailsAdd({{ $product->id }})"
                                class="{{ $ctaClasses }} w-full">
                            {!! $cartIconSvg !!}
                            <span id="vb_cta_label">Add to Cart</span>
                        </button>
                    </div>
                @else
                    <!-- Action Buttons -->
                    <div class="flex mb-12 max-w-md">
                        <button id="add_to_cart_button_{{$product->id}}"
                                onclick="detailsAddToCart({{$product->id}})"
                                class="{{ $ctaClasses }} w-full">
                            {!! $cartIconSvg !!}
                            @if(array_key_exists($product->id, $cartVal))
                                {{ $cartVal[$product->id] }} {{ Str::plural('item', $cartVal[$product->id]) }} in Cart
                            @else
                                Add to Cart
                            @endif
                        </button>
                    </div>
                @endif
            </div>
        </div>
        <!-- <div class="mt-10">
            <div class="">
                <h3 class="text-xl font-bold text-gray-900 mb-6">Recently Viewed</h3>
                <div class="grid grid-cols-2 md:grid-cols-8 gap-4">
                    <div class="bg-white border border-gray-200 rounded-lg p-3 hover:shadow-md transition duration-200">
                        <div class="h-32 mb-2 overflow-hidden rounded">
                            <img src="{{ asset('assets/vitalboost.webp') }}" 
                                    alt="Vital Boost - Premium Longevity Formula" class="w-full h-full object-cover">
                        </div>
                        <h4 class="font-medium text-sm text-gray-900 truncate">Vital Boost - Premium Longevity Formula</h4>
                        <p class="text-gray-900 font-bold mt-1">$8,499</p>
                    </div>
                    <div class="bg-white border border-gray-200 rounded-lg p-3 hover:shadow-md transition duration-200">
                        <div class="h-32 mb-2 overflow-hidden rounded">
                            <img src="{{ asset('assets/vitalboost.webp') }}" 
                                    alt="4K Monitor" class="w-full h-full object-cover">
                        </div>
                        <h4 class="font-medium text-sm text-gray-900 truncate">Daily Superfood Nutrition</h4>
                        <p class="text-gray-900 font-bold mt-1">$32,999</p>
                    </div>
                    <div class="bg-white border border-gray-200 rounded-lg p-3 hover:shadow-md transition duration-200">
                        <div class="h-32 mb-2 overflow-hidden rounded">
                            <img src="{{ asset('assets/smartwatch.webp') }}" 
                                    alt="Smart Watch" class="w-full h-full object-cover">
                        </div>
                        <h4 class="font-medium text-sm text-gray-900 truncate">Daily Superfood Nutrition</h4>
                        <p class="text-gray-900 font-bold mt-1">$12,999</p>
                    </div>
                    <div class="bg-white border border-gray-200 rounded-lg p-3 hover:shadow-md transition duration-200">
                        <div class="h-32 mb-2 overflow-hidden rounded">
                            <img src="{{ asset('assets/speaker.webp') }}" 
                                    alt="greentooth Speaker" class="w-full h-full object-cover">
                        </div>
                        <h4 class="font-medium text-sm text-gray-900 truncate">Daily Superfood Nutrition</h4>
                        <p class="text-gray-900 font-bold mt-1">$3,499</p>
                    </div>
                    <div class="bg-white border border-gray-200 rounded-lg p-3 hover:shadow-md transition duration-200">
                        <div class="h-32 mb-2 overflow-hidden rounded">
                            <img src="{{ asset('assets/vitalboost.webp') }}" 
                                    alt="Vital Boost - Premium Longevity Formula" class="w-full h-full object-cover">
                        </div>
                        <h4 class="font-medium text-sm text-gray-900 truncate">Vital Boost - Premium Longevity Formula</h4>
                        <p class="text-gray-900 font-bold mt-1">$8,499</p>
                    </div>
                    <div class="bg-white border border-gray-200 rounded-lg p-3 hover:shadow-md transition duration-200">
                        <div class="h-32 mb-2 overflow-hidden rounded">
                            <img src="{{ asset('assets/vitalboost.webp') }}" 
                                    alt="4K Monitor" class="w-full h-full object-cover">
                        </div>
                        <h4 class="font-medium text-sm text-gray-900 truncate">Daily Superfood Nutrition</h4>
                        <p class="text-gray-900 font-bold mt-1">$32,999</p>
                    </div>
                    <div class="bg-white border border-gray-200 rounded-lg p-3 hover:shadow-md transition duration-200">
                        <div class="h-32 mb-2 overflow-hidden rounded">
                            <img src="{{ asset('assets/vitalboost.webp') }}" 
                                    alt="Smart Watch" class="w-full h-full object-cover">
                        </div>
                        <h4 class="font-medium text-sm text-gray-900 truncate">Anti-Inflammatory Formula</h4>
                        <p class="text-gray-900 font-bold mt-1">$12,999</p>
                    </div>
                    <div class="bg-white border border-gray-200 rounded-lg p-3 hover:shadow-md transition duration-200">
                        <div class="h-32 mb-2 overflow-hidden rounded">
                            <img src="{{ asset('assets/vitalboost.webp') }}" 
                                    alt="greentooth Speaker" class="w-full h-full object-cover">
                        </div>
                        <h4 class="font-medium text-sm text-gray-900 truncate">Anti-Inflammatory Formula</h4>
                        <p class="text-gray-900 font-bold mt-1">$3,499</p>
                    </div>
                </div>
            </div>
        </div> -->
        <!-- Product Description & Specifications -->
        <div class="mt-12">
            <div class="border-b border-gray-200">
                <nav class="flex space-x-8 overflow-x-auto">
                    <button class="tab-button py-4 font-medium border-b-2 border-green-600 text-green-600">Description</button>
                    <!-- <button class="tab-button py-4 font-medium text-gray-500 hover:text-gray-700">Specifications</button>
                    <button class="tab-button py-4 font-medium text-gray-500 hover:text-gray-700">Reviews (4,231)</button>
                    <button class="tab-button py-4 font-medium text-gray-500 hover:text-gray-700">FAQs</button> -->
                </nav>
            </div>
            
            <div class="mt-8 p-6 bg-white rounded-lg shadow-sm">
                <h2 class="text-xl font-bold mb-4">About this item</h2>
                <div class="w-full">
                    <div class="mb-4">
                        <p class="text-gray-700 leading-relaxed">
                            {{ $product->description }}
                        </p>
                    </div>
                    
                    @if($product->features)
                    <div class="mt-6">
                        <h3 class="text-lg font-semibold mb-4">Key Features</h3>
                        <div class="space-y-3">
                            @if(is_array($product->features))
                                @foreach($product->features as $feature)
                                <div class="flex items-start">
                                    <i class="fas fa-check text-green-500 mt-1 mr-3"></i>
                                    <span class="text-gray-700">{{ $feature }}</span>
                                </div>
                                @endforeach
                            @else
                                <div class="flex items-start">
                                    <i class="fas fa-check text-green-500 mt-1 mr-3"></i>
                                    <span class="text-gray-700">{{ $product->features }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                    @endif
                    
                    <!-- Product Specifications -->
                    @if($product->specifications)
                    <div class="mt-8">
                        <h3 class="text-lg font-semibold mb-4">Specifications</h3>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            @if(is_array($product->specifications))
                                @foreach($product->specifications as $key => $value)
                                <div class="flex justify-between py-2 border-b border-gray-200 last:border-0">
                                    <span class="font-medium text-gray-600">{{ $key }}:</span>
                                    <span class="text-gray-800">{{ $value }}</span>
                                </div>
                                @endforeach
                            @else
                                <p class="text-gray-700">{{ $product->specifications }}</p>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>
                    
                    <!-- <div>
                        <h3 class="text-lg font-semibold mb-3">Key Features</h3>
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <div class="bg-green-100 p-2 rounded-lg mr-3">
                                    <i class="fas fa-bolt text-green-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium">Daily Superfood Nutrition</h4>
                                    <p class="text-sm text-gray-600">Originally formulated to protect patients from harmful effects of dental radiation, it now provides daily protection against environmental stressors and modern electromagnetic exposure.</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="bg-green-100 p-2 rounded-lg mr-3">
                                    <i class="fas fa-eye text-green-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium">Supports Longevity & Vitality</h4>
                                    <p class="text-sm text-gray-600">Originally formulated to protect patients from harmful effects of dental radiation, it now provides daily protection against environmental stressors and modern electromagnetic exposure.</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="bg-green-100 p-2 rounded-lg mr-3">
                                    <i class="fas fa-heartbeat text-green-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium">Immune System Support</h4>
                                    <p class="text-sm text-gray-600">Originally formulated to protect patients from harmful effects of dental radiation, it now provides daily protection against environmental stressors and modern electromagnetic exposure.</p>
                                </div>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </main>
    <script src="{{ asset('js/cart.js') }}"></script>
    <script>
        // Product Image Gallery
        document.addEventListener('DOMContentLoaded', function() {
            const mainImage = document.getElementById('mainImage');
            const thumbnails = document.querySelectorAll('.thumbnail');
            const zoomBtn = document.getElementById('zoomBtn');
            
            // Thumbnail click event
            thumbnails.forEach(thumb => {
                thumb.addEventListener('click', function() {
                    // Update main image
                    const newImageSrc = this.getAttribute('data-image');
                    mainImage.src = newImageSrc;
                    
                    // Update active thumbnail
                    thumbnails.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');
                });
            });
            
            // Zoom functionality
            let zoomed = false;
            zoomBtn.addEventListener('click', function() {
                if (!zoomed) {
                    mainImage.style.transform = 'scale(1.8)';
                    mainImage.style.cursor = 'zoom-out';
                    zoomed = true;
                    zoomBtn.innerHTML = '<i class="fas fa-search-minus text-gray-600"></i>';
                } else {
                    mainImage.style.transform = 'scale(1)';
                    mainImage.style.cursor = 'zoom-in';
                    zoomed = false;
                    zoomBtn.innerHTML = '<i class="fas fa-search-plus text-gray-600"></i>';
                }
            });
            
            // Quantity selector
            const quantityElement = document.getElementById('quantity');
            const decreaseBtn = document.getElementById('decreaseQty');
            const increaseBtn = document.getElementById('increaseQty');
            
            let quantity = 1;
            
            decreaseBtn.addEventListener('click', function() {
                if (quantity > 1) {
                    quantity--;
                    quantityElement.textContent = quantity;
                }
            });
            
            increaseBtn.addEventListener('click', function() {
                if (quantity < 5) {
                    quantity++;
                    quantityElement.textContent = quantity;
                }
            });
            
            // Color selection
            const colorOptions = document.querySelectorAll('.color-option');
            colorOptions.forEach(option => {
                option.addEventListener('click', function() {
                    colorOptions.forEach(opt => {
                        opt.classList.remove('border-green-500');
                        opt.classList.add('border-gray-200');
                    });
                    this.classList.remove('border-gray-200');
                    this.classList.add('border-green-500');
                });
            });
            
            // Storage selection
            const storageOptions = document.querySelectorAll('.storage-option');
            storageOptions.forEach(option => {
                option.addEventListener('click', function() {
                    storageOptions.forEach(opt => {
                        opt.classList.remove('border-green-500', 'bg-green-50');
                        opt.classList.add('border-gray-300');
                    });
                    this.classList.remove('border-gray-300');
                    this.classList.add('border-green-500', 'bg-green-50');
                });
            });
            
            // Warranty selection
            const warrantyOptions = document.querySelectorAll('.warranty-option');
            warrantyOptions.forEach(option => {
                option.addEventListener('click', function() {
                    warrantyOptions.forEach(opt => {
                        opt.classList.remove('border-green-500', 'bg-green-50');
                        opt.classList.add('border-gray-300');
                    });
                    this.classList.remove('border-gray-300');
                    this.classList.add('border-green-500', 'bg-green-50');
                });
            });
            
            // Add to cart button
            const addToCartBtn = document.getElementById('addToCartBtn');
            const buyNowBtn = document.getElementById('buyNowBtn');
            
            addToCartBtn.addEventListener('click', function() {
                // Show confirmation
                this.innerHTML = '<i class="fas fa-check mr-2"></i> Added to Cart';
                this.classList.remove('bg-amber-500', 'hover:bg-amber-600');
                this.classList.add('bg-green-500', 'hover:bg-green-600');
                
                // Reset after 2 seconds
                setTimeout(() => {
                    this.innerHTML = '<i class="fas fa-shopping-cart mr-2"></i> Add to Cart';
                    this.classList.remove('bg-green-500', 'hover:bg-green-600');
                    this.classList.add('bg-amber-500', 'hover:bg-amber-600');
                }, 2000);
            });
            
            buyNowBtn.addEventListener('click', function() {
                alert(`Redirecting to checkout for ${quantity} item(s) of TechPro X9 Ultrabook Laptop.`);
            });
            
            // Tab switching
            const tabButtons = document.querySelectorAll('.tab-button');
            tabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    tabButtons.forEach(btn => {
                        btn.classList.remove('border-green-600', 'text-green-600');
                        btn.classList.add('text-gray-500');
                    });
                    this.classList.remove('text-gray-500');
                    this.classList.add('border-green-600', 'text-green-600');
                });
            });
            
            // Sticky add to cart on scroll
            const stickyCart = document.getElementById('stickyCart');
            window.addEventListener('scroll', function() {
                if (window.scrollY > 500) {
                    stickyCart.classList.add('active');
                } else {
                    stickyCart.classList.remove('active');
                }
            });
            
            // Mobile sticky cart buttons
            const mobileAddToCart = stickyCart.querySelector('button:nth-child(1)');
            const mobileBuyNow = stickyCart.querySelector('button:nth-child(2)');
            
            mobileAddToCart.addEventListener('click', function() {
                addToCartBtn.click();
            });
            
            mobileBuyNow.addEventListener('click', function() {
                buyNowBtn.click();
            });
            
            // RELATED PRODUCTS FUNCTIONALITY
            
            // Quick add buttons in related products
            const quickAddButtons = document.querySelectorAll('.quick-add-btn');
            quickAddButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const productCard = this.closest('.related-product-card');
                    const productName = productCard.querySelector('h3').textContent;
                    const productPrice = productCard.querySelector('.text-lg.font-bold').textContent;
                    
                    // Show confirmation
                    const originalHTML = this.innerHTML;
                    this.innerHTML = '<i class="fas fa-check"></i>';
                    this.classList.remove('bg-green-600');
                    this.classList.add('bg-green-600');
                    
                    // Show alert
                    alert(`Added "${productName}" to cart for ${productPrice}`);
                    
                    // Reset after 1.5 seconds
                    setTimeout(() => {
                        this.innerHTML = originalHTML;
                        this.classList.remove('bg-green-600');
                        this.classList.add('bg-green-600');
                    }, 1500);
                });
            });
            
            // Add to cart buttons in related products
            const relatedAddToCartButtons = document.querySelectorAll('.related-product-card button.bg-gray-100');
            relatedAddToCartButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const productCard = this.closest('.related-product-card');
                    const productName = productCard.querySelector('h3').textContent;
                    const productPrice = productCard.querySelector('.text-lg.font-bold').textContent;
                    
                    // Show confirmation
                    const originalText = this.textContent;
                    this.textContent = 'Added to Cart';
                    this.classList.remove('bg-gray-100', 'hover:bg-gray-200');
                    this.classList.add('bg-green-500', 'text-white', 'hover:bg-green-600');
                    
                    // Show alert
                    alert(`Added "${productName}" to cart for ${productPrice}`);
                    
                    // Reset after 2 seconds
                    setTimeout(() => {
                        this.textContent = originalText;
                        this.classList.remove('bg-green-500', 'text-white', 'hover:bg-green-600');
                        this.classList.add('bg-gray-100', 'hover:bg-gray-200');
                    }, 2000);
                });
            });
            
            // Related product card click (go to product page)
            const relatedProductCards = document.querySelectorAll('.related-product-card');
            relatedProductCards.forEach(card => {
                card.addEventListener('click', function(e) {
                    // Don't trigger if clicked on button or link
                    if (e.target.tagName === 'BUTTON' || e.target.tagName === 'A' || 
                        e.target.closest('button') || e.target.closest('a')) {
                        return;
                    }
                    
                    // Get product name
                    const productName = this.querySelector('h3').textContent;
                    alert(`Redirecting to "${productName}" product page...`);
                    // In a real application, you would navigate to the product page
                    // window.location.href = `/products/${productSlug}`;
                });
            });
            
            // Recently viewed product click
            const recentlyViewedItems = document.querySelectorAll('.bg-white.border');
            recentlyViewedItems.forEach(item => {
                item.addEventListener('click', function() {
                    const productName = this.querySelector('h4').textContent;
                    alert(`Redirecting to "${productName}" product page...`);
                });
            });
        });
        
        // Quantity selection functions
        function increaseQuantity() {
            const input = document.getElementById('quantity');
            const max = parseInt(input.getAttribute('max'));
            const current = parseInt(input.value);
            if (current < max) {
                input.value = current + 1;
            }
        }
        
        function decreaseQuantity() {
            const input = document.getElementById('quantity');
            const min = parseInt(input.getAttribute('min'));
            const current = parseInt(input.value);
            if (current > min) {
                input.value = current - 1;
            }
        }
        
        // Adding from this page goes through the shared addToCart in cart.js.
        // A local copy used to live here, but it took only a product id, so the
        // Vital Boost plan was silently dropped and a subscription was added as a
        // one-time purchase. This wrapper only supplies the page's quantity.
        function detailsAddToCart(productId, purchaseType, plan) {
            const input = document.getElementById('quantity');
            const quantity = input ? parseInt(input.value, 10) : 1;

            addToCart(productId, purchaseType || 'one_time', plan || '', quantity);
        }
        // Auto update viewing count
        function updateViewingCount() {
            const viewingElement = document.querySelector('[data-viewing-count]');
            if (!viewingElement) return;
            
            let currentCount = parseInt(viewingElement.getAttribute('data-current-count'));
            const change = Math.random() > 0.5 ? 1 : -1;
            const newCount = Math.max(1, currentCount + change);
            
            viewingElement.setAttribute('data-current-count', newCount);
            viewingElement.textContent = `${newCount} people are viewing this right now`;
        }
        
        // Initialize viewing count updates
        document.addEventListener('DOMContentLoaded', function() {
            // Start automatic count updates every 3-7 seconds
            setInterval(updateViewingCount, Math.random() * 4000 + 3000);
        });
    </script>

    {{-- Vital Boost purchase options. The prices and perk captions are rendered
         server-side; this only tracks which option is selected and hands the
         choice to the shared addToCart(id, purchase_type, plan). --}}
    <script>
    (function () {
        var options = document.querySelectorAll('.vb-option');
        if (!options.length) {
            return;
        }

        var note = document.getElementById('vb_perk_note');
        var ctaLabel = document.getElementById('vb_cta_label');
        var stockStatus = document.getElementById('stock_status');
        var selected = 'one_time';

        function select(button) {
            selected = button.dataset.vbOption;

            options.forEach(function (other) {
                var isActive = other === button;
                other.classList.toggle('border-primary', isActive);
                other.classList.toggle('bg-primary/5', isActive);
                other.classList.toggle('border-gray-200', !isActive);
                other.classList.toggle('hover:border-primary/50', !isActive);
            });

            if (note) {
                note.textContent = button.dataset.vbPerk || '';
            }
            if (ctaLabel) {
                ctaLabel.textContent = button.dataset.vbCta;
            }

            // A subscription ships on a schedule, so the current shelf count is
            // not what the shopper is buying against.
            if (stockStatus) {
                stockStatus.style.visibility = selected === 'one_time' ? '' : 'hidden';
            }
        }

        options.forEach(function (button) {
            button.addEventListener('click', function () {
                select(button);
            });
        });

        // Named on window because the button uses an inline onclick, matching the
        // rest of this page. Goes through detailsAddToCart so the chosen quantity
        // travels with the plan.
        window.vbDetailsAdd = function (productId) {
            if (selected === 'one_time') {
                detailsAddToCart(productId, 'one_time', '');
            } else {
                detailsAddToCart(productId, 'subscription', selected);
            }
        };
    })();
    </script>
 @endsection