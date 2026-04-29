@extends('member.member')
@section('member-content')
<div x-data="{ activeTab: 'products' }" class="space-y-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-900 text-left">Member Store</h1>
        <p class="text-gray-600 mt-2">Exclusive products and free resources for members only</p>
    </div>
    <!-- Tabs Navigation -->
    <div class="">
        <div class="grid w-full max-w-sm grid-cols-3 bg-gray-100 rounded-md p-1">
            <button @click="activeTab = 'products'" :class="activeTab === 'products' ? 'bg-white shadow font-semibold rounded-md' : 'px-3 py-2 text-sm rounded-md'">Products</button>
            <button @click="activeTab = 'guides'" :class="activeTab === 'guides' ? 'bg-white shadow font-semibold rounded-md' : 'px-3 py-2 text-sm rounded-md'">Free Guides</button>
            <button @click="activeTab = 'books'" :class="activeTab === 'books' ? 'bg-white shadow font-semibold rounded-md' : 'px-3 py-2 text-sm rounded-md'">Free Books</button>
        </div>
    </div>
    <!-- Products Tab -->
    <div x-show="activeTab === 'products'" x-cloak>
        <div class="bg-primary/10 rounded-lg p-4 mb-6 flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-percent h-6 w-6 text-primary">
                <line x1="19" x2="5" y1="5" y2="19"></line>
                <circle cx="6.5" cy="6.5" r="2.5"></circle>
                <circle cx="17.5" cy="17.5" r="2.5"></circle>
            </svg>
            <div>
                <p class="font-semibold mt-0 text-lg">Exclusive Member Pricing</p>
                <p class="text-sm text-muted-foreground mt-0 pt-0">Enjoy up to 30% off on all VitalBoost products</p>
            </div>
        </div>
        <div class="grid md:grid-cols-3 gap-6">
            @if(count($products) > 0)
                @foreach($products as $product)
                <div class="bg-white rounded-lg overflow-hidden hover:shadow-lg transition-shadow">
                    <div class="relative aspect-square bg-gray-100">
                        @if(!empty($product->image) && file_exists(public_path('product_images/'.$product->image)))
                            <img src="{{asset('product_images/'.$product->image)}}" alt="{{$product->name}}" class="w-full h-full object-cover" />
                        @else
                            <img src="{{asset('/assets/placeholder.svg')}}" alt="{{$product->name}}" class="w-full h-full object-cover" />
                        @endif
                        <div class="absolute top-2 right-2 bg-[#e53939fc] hover:bg-primary/80 text-white text-xs font-bold px-2 py-1 rounded">
                            {{$product->discount}}% OFF
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold text-gray-900">{{ $product->name }}</h3>
                        <p class="text-sm text-gray-600 mt-1">{{ $product->description }}</p>
                        <div class="flex items-center gap-2 mt-3">
                            <span class="text-lg font-bold text-primary">${{ $product->price }}</span>
                            <span class="text-sm text-gray-500 line-through">${{ $product->originalPrice }}</span>
                        </div>
                        <button onclick="addToCart({{ $product->id }})" class="w-full mt-4 bg-primary text-white py-2 px-4 rounded-lg hover:bg-accent transition flex items-center justify-center">
                            <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                            Add to Cart
                        </button>
                    </div>
                </div>
                @endforeach
            @else
                No products available.
            @endif
        </div>
    </div>

    <!-- Free Guides Tab -->
    <div x-show="activeTab === 'guides'" x-cloak>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
            @if(count($guides) > 0)
                @foreach($guides as $guide)
              
                <div class="rounded-lg border bg-card text-card-foreground shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex flex-col space-y-1.5 p-6 pb-2">
                        <div class="flex items-start justify-between">
                            <h3 class="font-semibold tracking-tight text-base">{{$guide->name}}</h3>
                            <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-transparent bg-secondary text-secondary-foreground hover:bg-secondary/80">PDF</div>
                        </div>
                        <p class="text-sm text-muted-foreground">{{$guide->user->first_name}} {{$guide->user->last_name}}</p>
                    </div>
                    <div class="p-6 pt-0">
                        <p class="text-sm text-muted-foreground mb-3"></p>
                        <form action="{{ route('member.download', $guide->id) }}" method="GET" style="display: inline;">
                            <button type="submit" class="inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 border-2 border-primary bg-background text-primary hover:bg-primary hover:text-primary-foreground h-9 rounded-md px-3 w-full">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-download h-4 w-4 mr-2">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                    <polyline points="7 10 12 15 17 10"></polyline>
                                    <line x1="12" x2="12" y1="15" y2="3"></line>
                                </svg>
                                Download Free
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            @else
                No free guides available.
            @endif
        </div>
    </div>

    <!-- Free Books Tab -->
    <div x-show="activeTab === 'books'" x-cloak>
        <div class="bg-blue-50 dark:bg-blue-950/20 rounded-lg p-4 mb-6 flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-star h-6 w-6 text-blue-600">
                <path d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z"></path>
            </svg>
            <div>
                <p class="font-semibold text-blue-800 dark:text-blue-200">Member Exclusive eBooks</p>
                <p class="text-sm text-blue-700 dark:text-blue-300">Full-length books available only for members</p>
            </div>
        </div>
        <div class="grid md:grid-cols-3 gap-6">
            @if(count($books) > 0)
                @foreach($books as $book)
                <div class="rounded-lg border bg-card text-card-foreground shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex flex-col space-y-1.5 p-6">
                        <div class="w-full h-40 bg-gradient-to-br from-primary/20 to-primary/5 rounded-lg flex items-center justify-center mb-2">
                            <div class="text-center">
                                <div class="w-16 h-20 bg-card border rounded shadow-sm mx-auto flex items-center justify-center">
                                    <span class="text-xs text-muted-foreground">eBook</span>
                                </div>
                            </div>
                        </div>
                        <h3 class="font-semibold tracking-tight text-base">{{$book->name}}</h3>
                        <p class="text-sm text-muted-foreground">Dr. Victor Zeines • 180 pages</p>
                    </div>
                    <div class="p-6 pt-0">
                        <button onclick="window.location.href='{{ route('member.download', $book->id) }}'" class="inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 border-2 border-primary bg-background text-primary hover:bg-primary hover:text-primary-foreground h-9 rounded-md px-3 w-full">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-download h-4 w-4 mr-2">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                <polyline points="7 10 12 15 17 10"></polyline>
                                <line x1="12" x2="12" y1="15" y2="3"></line>
                            </svg>
                            Download eBook
                        </button>
                    </div>
                </div>
                @endforeach
            @else
                No free books available.
            @endif
        </div>
    </div>
</div>
<!-- Free Books Tab -->
<!-- <div x-show="activeTab === 'books'" x-cloak>
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
</div> -->
<style>
   [x-cloak] { display: none !important; }
</style>
<script src="{{ asset('js/cart.js') }}"></script>
@endsection