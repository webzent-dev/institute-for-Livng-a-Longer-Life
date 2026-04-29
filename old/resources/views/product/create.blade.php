<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/alpinejs" defer></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

@if (session('success'))
    <div x-data="{ show: true }"
        x-init="setTimeout(() => show = false, 3000)"
        x-show="show"
        x-transition
        class="fixed top-5 right-5 bg-green-600 text-white px-5 py-3 rounded-lg shadow-lg z-50">
        {{ session('success') }}
    </div>
@endif

<body x-data="{ sidebarOpen: true, mobileSidebar: false }" class="bg-slate-50 antialiased">
<div class="flex min-h-screen">
    <!-- Sidebar -->
    <x-dashboard.sidebar.sidebar />
    <div class="flex-1 flex flex-col">
        <!-- Header -->
        <x-dashboard.sidebar.header />
        <!-- MAIN CONTENT -->
        <main class="flex-1 p-4 md:p-6 overflow-y-auto">
            <!-- Page Header -->
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-xl font-semibold">Add Product</h1>
                <!-- Back Button (TOP RIGHT) -->
                <a href="{{ url()->previous() }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border bg-white text-gray-700 hover:bg-gray-100 font-medium">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    Back
                </a>
            </div>

            @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- Add Product Form (FULL WIDTH) -->
            <div class="w-full bg-white rounded-xl shadow-sm p-6">
                @if(Auth::user()->role === 'collaborator')
                    <form method="POST" action="{{ isset($product) ? route('products.update', $product->id) : route('products.store') }}" enctype="multipart/form-data">
                @else
                    <form method="POST" action="{{ isset($product) ? route('admin.products.update', $product->id) : route('admin.products.store') }}" enctype="multipart/form-data">
                @endif
                    @csrf
                    @if(isset($product))
                        @method('PUT')
                    @endif

                    <!-- Grid Layout -->
                    <div class="grid grid-cols-12 gap-6">
                        <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                        <div class="col-span-12 md:col-span-6">
                            <label class="block text-sm font-medium mb-1">Product Category *</label>
                            <select name="category" class="w-full border rounded-lg px-3 py-2" required>
                                <option value="">Select Category</option>
                                <option value="institute_product" {{ old('category', $product->product_category ?? '') == 'institute_product' ? 'selected' : '' }}>Institute Product</option>
                                <option value="collaborator_product" {{ old('category', $product->product_category ?? '') == 'collaborator_product' ? 'selected' : '' }}>Collaborator Product</option>
                                <option value="member_exclusive"  {{ old('category', $product->product_category ?? '') == 'member_exclusive' ? 'selected' : '' }}>Member Excluesive</option>
                            </select>
                        </div>

                        <div class="col-span-12 md:col-span-6">
                            <label class="block text-sm font-medium mb-1">Product Type *</label>
                            <select name="product_type" class="w-full border rounded-lg px-3 py-2" required>
                                <option value="">Select Type</option>
                                <option value="supplement" {{ old('product_type', $product->product_type ?? '') == 'supplement' ? 'selected' : '' }}>Supplement</option>
                                <option value="vital_boost" {{ old('product_type', $product->product_type ?? '') == 'vital_boost' ? 'selected' : '' }}>Vital Boost</option>
                                <option value="guide"  {{ old('product_type', $product->product_type ?? '') == 'guide' ? 'selected' : '' }}>Guide</option>
                                <option value="book"  {{ old('product_type', $product->product_type ?? '') == 'book' ? 'selected' : '' }}>Book</option>
                            </select>
                        </div>

                        <!-- Product Name -->
                        <div class="col-span-12 md:col-span-6">
                            <label class="block text-sm font-medium mb-1">Product Name *</label>
                            <input type="text" name="name" value="{{ old('name', $product->name ?? '') }}" class="w-full border rounded-lg px-3 py-2" placeholder="Enter product name*" autocomplete="off" required>
                        </div>

                        <!-- Description -->
                        <div class="col-span-12 md:col-span-6">
                            <label class="block text-sm font-medium mb-1">Description *</label>
                            <textarea name="description" class="w-full border rounded-lg px-3 py-2">{{ old('description', $product->description ?? '') }}</textarea>
                        </div>
                    
                        <!-- Price -->
                        <div class="col-span-12 md:col-span-6">
                            <label class="block text-sm font-medium mb-1">Price ($) *</label>
                            <input type="number" name="price" value="{{ old('price', $product->price ?? '') }}" class="w-full border rounded-lg px-3 py-2" placeholder="Enter product price" step="0.01" autocomplete="off" required>
                        </div>

                        <!-- Stock Quantity -->
                        <div class="col-span-12 md:col-span-6">
                            <label class="block text-sm font-medium mb-1">Stock Quantity *</label>
                            <input type="number" name="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity ?? '') }}" class="w-full border rounded-lg px-3 py-2" placeholder="Enter stock quantity*"  autocomplete="off" required>
                        </div>

                        <!-- <div class="col-span-12 md:col-span-6">
                            <label class="block text-sm font-medium mb-1">Discounted Price</label>
                            <input type="number" name="discounted_price" value="{{ old('discounted_price', $product->discount ?? '') }}" class="w-full border rounded-lg px-3 py-2" placeholder="Enter discounted price" step="0.01">
                        </div>

                        <div class="col-span-12 md:col-span-6">
                            <label class="block text-sm font-medium mb-1">Original Price</label>
                            <input type="number" name="original_price" value="{{ old('original_price', $product->originalPrice ?? '') }}" class="w-full border rounded-lg px-3 py-2" placeholder="Enter original price" step="0.01">
                        </div>

                        <div class="col-span-12 md:col-span-6">
                            <label class="block text-sm font-medium mb-1">Category</label>
                            <input type="text" name="category" value="{{ old('category', $product->category ?? '') }}" class="w-full border rounded-lg px-3 py-2"
                            placeholder="Enter category">
                        </div>

                        <div class="col-span-12 md:col-span-6">
                            <label class="block text-sm font-medium mb-1">Rating</label>
                            <input type="text" name="rating" value="{{ old('rating', $product->rating ?? '') }}" class="w-full border rounded-lg px-3 py-2" placeholder="Enter rating">
                        </div>

                        <div class="col-span-12 md:col-span-6">
                            <label class="block text-sm font-medium mb-1">Reviews</label>
                            <input type="text" name="reviews" value="{{ old('reviews', $product->reviews ?? '') }}" class="w-full border rounded-lg px-3 py-2" placeholder="Enter reviews*" autocomplete="off" required>
                        </div> -->

                        <!-- Image -->
                        <div class="col-span-12">
                            <label class="block text-sm font-medium mb-1">Product Image</label>
                            <input type="file" name="product_images[]" class="w-full border rounded-lg px-3 py-2" multiple>
                            @if(isset($product) && $product->image)
                                <img src="{{ asset('product_images/'.$product->image) }}" alt="Product Image" class="h-20 mt-2 rounded">
                            @endif
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-end gap-3 mt-6">
                        <button type="reset" class="px-4 py-2 rounded-lg border text-gray-600 hover:bg-gray-100">Reset</button>
                        <button type="submit" class="px-6 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-semibold">
                            {{ isset($product) ? 'Update Product' : 'Save Product' }}
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>

<!-- Mobile Sidebar -->
<x-dashboard.sidebar.mobile-sidebar />
<script>lucide.createIcons()</script>
</body>
</html>