@extends('member.member')

@section('member-content')
<div x-data="{ activeTab: 'products' }" class="space-y-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Member Store</h1>
        <p class="text-gray-600 mt-2">Exclusive products and free resources for members only</p>
    </div>

    <!-- Tabs Navigation -->
    <div class="border-b border-gray-200">
        <nav class="-mb-px flex space-x-8">
            <button @click="activeTab = 'products'" 
                    :class="activeTab === 'products' 
                        ? 'border-primary text-primary' 
                        : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                    class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                Products
            </button>
            <button @click="activeTab = 'guides'" 
                    :class="activeTab === 'guides' 
                        ? 'border-primary text-primary' 
                        : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                    class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                Free Guides
            </button>
            <button @click="activeTab = 'books'" 
                    :class="activeTab === 'books' 
                        ? 'border-primary text-primary' 
                        : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                    class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                Free Books
            </button>
        </nav>
    </div>

    <!-- Products Tab -->
    <div x-show="activeTab === 'products'" x-cloak>
        <div class="bg-blue-50 rounded-lg p-4 mb-6 flex items-center gap-3">
            <svg class="h-6 w-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2zM10 8.5a.5.5 0 11-1 0 .5.5 0 011 0zm5 5a.5.5 0 11-1 0 .5.5 0 011 0z"/>
            </svg>
            <div>
                <p class="font-semibold text-primary">Exclusive Member Pricing</p>
                <p class="text-sm text-accent">Enjoy up to 30% off on all VitalBoost products</p>
            </div>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            @foreach([
                ['id' => 1, 'name' => 'VitalBoost Supplement', 'desc' => 'Premium natural supplement for holistic wellness and longevity support.', 'original' => 89.99, 'member' => 62.99, 'discount' => 30],
                ['id' => 2, 'name' => 'VitalBoost - 3 Month Supply', 'desc' => 'Save more with our 3-month supply bundle.', 'original' => 249.99, 'member' => 174.99, 'discount' => 30],
                ['id' => 3, 'name' => 'VitalBoost - 6 Month Supply', 'desc' => 'Best value! 6-month supply for continuous wellness.', 'original' => 479.99, 'member' => 335.99, 'discount' => 30],
            ] as $product)
                <div class="bg-white rounded-lg overflow-hidden hover:shadow-lg transition-shadow">
                    <div class="relative aspect-square bg-gray-100">
                        <div class="absolute top-2 right-2 bg-accent text-white text-xs font-bold px-2 py-1 rounded">
                            {{ $product['discount'] }}% OFF
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold text-gray-900">{{ $product['name'] }}</h3>
                        <p class="text-sm text-gray-600 mt-1">{{ $product['desc'] }}</p>
                        <div class="flex items-center gap-2 mt-3">
                            <span class="text-lg font-bold text-primary">${{ $product['member'] }}</span>
                            <span class="text-sm text-gray-500 line-through">${{ $product['original'] }}</span>
                        </div>
                        <button class="w-full mt-4 bg-primary text-white py-2 px-4 rounded-lg hover:bg-accent transition flex items-center justify-center">
                            <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>

                            Add to Cart
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Free Guides Tab -->
    <div x-show="activeTab === 'guides'" x-cloak>
        <div class="bg-green-50 rounded-lg p-4 mb-6 flex items-center gap-3">
            <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <div>
                <p class="font-semibold text-green-800">Free Downloads</p>
                <p class="text-sm text-green-700">All guides are free for members to download</p>
            </div>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach([
                ['id' => 1, 'title' => 'Complete Guide to Holistic Dentistry', 'author' => 'Dr. Victor Zeines', 'pages' => 45],
                ['id' => 2, 'title' => 'Natural Remedies for Gum Health', 'author' => 'Dr. Victor Zeines', 'pages' => 28],
                ['id' => 3, 'title' => 'Mercury-Free Living Handbook', 'author' => 'Dr. Victor Zeines', 'pages' => 36],
                ['id' => 4, 'title' => 'Anti-Inflammatory Diet Recipes', 'author' => 'Institute Team', 'pages' => 52],
                ['id' => 5, 'title' => 'Stress Management Workbook', 'author' => 'Institute Team', 'pages' => 40],
                ['id' => 6, 'title' => 'Sleep Optimization Guide', 'author' => 'Institute Team', 'pages' => 24],
            ] as $guide)
                <div class="bg-white rounded-lg hover:shadow-md transition-shadow">
                    <div class="p-4">
                        <div class="flex items-start justify-between mb-2">
                            <h4 class="font-semibold text-gray-900">{{ $guide['title'] }}</h4>
                            <span class="bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded">PDF</span>
                        </div>
                        <p class="text-gray-600 text-sm mb-3">{{ $guide['author'] }}</p>
                        <p class="text-gray-500 text-sm mb-4">{{ $guide['pages'] }} pages</p>
                        <button class="w-full border border-gray-300 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-50 transition flex items-center justify-center">
                            <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Download Free
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Free Books Tab -->
    <div x-show="activeTab === 'books'" x-cloak>
        <div class="bg-blue-50 rounded-lg p-4 mb-6 flex items-center gap-3">
            <svg class="h-6 w-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
            </svg>
            <div>
                <p class="font-semibold text-primary">Member Exclusive eBooks</p>
                <p class="text-sm text-accent">Full-length books available only for members</p>
            </div>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            @foreach([
                ['id' => 1, 'title' => 'Living Longer: A Holistic Approach', 'author' => 'Dr. Victor Zeines', 'pages' => 180],
                ['id' => 2, 'title' => 'Natural Dental Care', 'author' => 'Dr. Victor Zeines', 'pages' => 145],
                ['id' => 3, 'title' => 'The Wellness Journey', 'author' => 'Institute Team', 'pages' => 120],
            ] as $book)
                <div class="bg-white rounded-lg hover:shadow-md transition-shadow">
                    <div class="p-4">
                        <div class="w-full h-40 bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg flex items-center justify-center mb-4">
                            <div class="text-center">
                                <div class="w-16 h-20 bg-white border border-gray-200 rounded shadow-sm mx-auto flex items-center justify-center">
                                    <span class="text-xs text-gray-500">eBook</span>
                                </div>
                            </div>
                        </div>
                        <h4 class="font-semibold text-gray-900 mb-1">{{ $book['title'] }}</h4>
                        <p class="text-gray-600 text-sm mb-4">{{ $book['author'] }} • {{ $book['pages'] }} pages</p>
                        <button class="w-full border border-gray-300 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-50 transition flex items-center justify-center">
                            <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Download eBook
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<style>
    [x-cloak] { display: none !important; }
</style>
@endsection