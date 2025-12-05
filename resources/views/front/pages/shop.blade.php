@extends('front.layouts.app')

@section('content')
<div class="min-h-screen flex flex-col">
 

    <main class="flex-1">
     
        {{-- Products Grid --}}
    
 

        {{-- Hero Section --}}
        <section class="gradient-subtle py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <div class="text-center mb-8">
                    <h1 class="text-4xl lg:text-6xl font-bold text-foreground mb-4">
                        Wellness Store
                    </h1>
                    <p class="text-xl text-muted-foreground max-w-3xl mx-auto">
                        Premium products curated by our expert collaborators.
                        Members enjoy exclusive discounts on all items.
                    </p>
                </div>

                {{-- Search & Filter --}}
                <div class="max-w-4xl mx-auto">
                    <form method="GET" class="flex flex-col sm:flex-row gap-4">

                        <div class="relative flex-1 "> 
                            <i data-lucide="search" class="absolute right-4 top-1/2 -translate-y-1/2 h-5 w-5 text-muted-foreground"></i>
                            
                            <x-form.input type="text" name="search" placeholder="Search products by category or name..."
                                value="{{ request('search') }}"
                                class=" pl-10  "
                                />
                            
                        </div>

                        {{-- Category Select --}}
                       <div class="relative inline-block text-left">
    <select class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none">
        <option value="">All Categories</option>
        @foreach ($products as $category)
            <option value="{{ $category->name }}">{{ $category->name}}</option>
        @endforeach
    </select>
</div>

                    </form>
                </div>

            </div>
        </section>

        {{-- Products Grid --}}
        <section class="py-20 bg-background">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                {{-- @if($products->isEmpty())
                    <div class="text-center py-12">
                        <p class="text-xl text-muted-foreground">
                            No products found matching your criteria.
                        </p>
                    </div>
                @else --}}
                    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">

                        @foreach($products as $product)
                        <div class="flex flex-col border-2 hover:border-primary transition-all shadow-soft hover:shadow-medium rounded-lg">

                            {{-- Product Image / Header --}}
                            <div class="p-0">
                                <div class="aspect-square bg-gradient-to-br from-primary/10 to-accent/10 flex items-center justify-center rounded-t-lg">
                                    <div class="text-center p-6">
                                        <div class="w-24 h-24 rounded-full gradient-primary mx-auto mb-3 flex items-center justify-center">
                                            {{-- <x-icons.cart class="h-12 w-12 text-primary-foreground"/> --}}
                                            <i data-lucide="cart"   class="h-12 w-12 text-primary-foreground"></i>
                                        </div>
                                        <span class="badge gradient-accent text-accent-foreground border-0">
                                            {{ $product['discount'] }}% OFF
                                        </span>
                                    </div>
                                </div>
                            </div>

                            {{-- Content --}}
                            <div class="flex-1 p-4 space-y-3">
                                <div>
                                    <h3 class="font-semibold text-foreground mb-1 line-clamp-1">
                                        {{ $product['name'] }}
                                    </h3>
                                    <p class="text-sm text-primary">by {{ $product['vendor'] }}</p>
                                </div>

                                <p class="text-sm text-muted-foreground line-clamp-2">
                                    {{ $product['description'] }}
                                </p>

                                <div class="flex items-center space-x-2">
                                    <div class="flex items-center"> 
                                        <i data-lucide="star" class="h-4 w-4 fill-accent text-accent"></i>
                                        <span class="ml-1 text-sm font-medium text-foreground">
                                            {{ $product['rating'] }}
                                        </span>
                                    </div>
                                    <span class="text-sm text-muted-foreground">
                                        ({{ $product['reviews'] }} reviews)
                                    </span>
                                </div>

                                <div class="flex items-baseline space-x-2">
                                    <span class="text-2xl font-bold text-foreground">
                                        ${{ $product['price'] }}
                                    </span>
                                    <span class="text-sm text-muted-foreground line-through">
                                        ${{ $product['originalPrice'] }}
                                    </span>
                                </div>
                            </div>

                            {{-- Button  action {{ route('cart.add', $product['id']) }}--}}
                            <div class="p-4 pt-0">
                                <form action="" method="POST">
                                    @csrf
                                    <button class="btn btn-primary w-full flex items-center justify-center">
                                         
                                        <i data-lucide="cart" class="mr-2 h-4 w-4"></i>
                                        Add to Cart
                                    </button>
                                </form>
                            </div>

                        </div>
                        @endforeach

                    </div>
                {{-- @endif --}}

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
                                    <div class="text-3xl font-bold text-primary  bg-clip-text mb-2">{{ $discount['title'] }}</div>
                                    <div class="text-sm text-muted-foreground">{{ $discount['class'] }}</div>
                                </div>
                            @endforeach
                                


                        </div>

                        <a href="{{ route('membership') }}">
                            <button class="btn btn-primary btn-lg">Become a Member</button>
                        </a>

                    </div>
                </div>

            </div>
        </section>

    </main>
 

</div>
@endsection

 
