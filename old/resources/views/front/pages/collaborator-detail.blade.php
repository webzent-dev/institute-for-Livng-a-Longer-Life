@extends('front.layouts.app')
@section('content')
<main class="flex-1"> 
    <!-- ================= PROFILE SECTION ================= -->
    <section class="gradient-subtle py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-3 gap-12 items-start">
                <!-- LEFT PROFILE CARD -->
                <div class="lg:col-span-1">
                    <div class="rounded-lg bg-card text-card-foreground shadow-sm shadow-strong border-2 border-primary/20">
                        <div class="p-8">
                        <!-- PROFILE HEADER -->
                        <div class="text-center mb-6">
                            <div class="w-32 h-32 rounded-full gradient-primary mx-auto mb-4 flex items-center justify-center">
                                <span class="text-5xl font-bold text-primary-foreground">{{ \Illuminate\Support\Str::ucfirst(substr($collaboratorDetail->first_name, 0, 1)) }}{{ \Illuminate\Support\Str::ucfirst(substr($collaboratorDetail->last_name, 0, 1))}}</span>
                            </div>
                            <h1 class="text-3xl font-bold text-foreground mb-2">{{ucfirst($collaboratorDetail->first_name)}} {{ucfirst($collaboratorDetail->last_name)}}</h1>
                            <p class="text-xl text-primary font-semibold mb-1">{{$collaboratorDetail->speciality}}</p>
                            <p class="text-muted-foreground">{{ $collaboratorDetail->professional_credentials }}</p>
                        </div>

                        <!-- STATS -->
                        <div class="space-y-4 mb-6">
                            <!-- COURSES -->
                            <div class="flex items-center justify-between p-3 bg-secondary rounded-lg">
                                <div class="flex items-center">
                                    <svg class="lucide lucide-video h-5 w-5 text-primary mr-2">
                                        <path d="m16 13 5.223 3.482a.5.5 0 0 0 .777-.416V7.87a.5.5 0 0 0-.752-.432L16 10.5"></path>
                                        <rect x="2" y="6" width="14" height="12" rx="2"></rect>
                                    </svg>
                                    <span class="font-medium text-foreground">Courses</span>
                                </div>
                                <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold text-foreground">{{ $collaboratorDetail->courses_count }}</div>
                            </div>
                            <!-- PRODUCTS -->
                            <div class="flex items-center justify-between p-3 bg-secondary rounded-lg">
                                <div class="flex items-center">
                                    <svg class="lucide lucide-store h-5 w-5 text-primary mr-2">
                                        <path d="m2 7 4.41-4.41A2 2 0 0 1 7.83 2h8.34a2 2 0 0 1 1.42.59L22 7"></path>
                                        <path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"></path>
                                        <path d="M15 22v-4a2 2 0 0 0-2-2h-2a2 2 0 0 0-2 2v4"></path>
                                        <path d="M2 7h20"></path>
                                    </svg>
                                    <span class="font-medium text-foreground">Products</span>
                                </div>
                                <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold text-foreground">{{ $collaboratorDetail->products_count }}</div>
                            </div>
                        </div>
        
                        <!-- CONSULT BUTTON -->
                        <button class="gradient-primary text-primary-foreground shadow-medium font-semibold h-10 px-4 py-2 w-full rounded-md">Book Consultation</button>
                    </div>
                </div>
            </div>
    
            <!-- RIGHT CONTENT -->
            <div class="lg:col-span-2 space-y-8">
                <!-- ABOUT -->
                <div>
                    <h2 class="text-3xl font-bold text-foreground mb-4">About {{$collaboratorDetail->first_name}} {{ $collaboratorDetail->last_name }}</h2>
                    <p class="text-lg text-muted-foreground leading-relaxed">{{ $collaboratorDetail->collaborator_message }}</p>
                </div>
                <!-- EXPERTISE -->
                @php
                $area_of_expertise = [];
                if(!empty($collaboratorDetail->speciality))
                    $area_of_expertise = explode(',', $collaboratorDetail->speciality);
                @endphp

                @if(count($area_of_expertise) > 0)
                <div>
                    <h3 class="text-2xl font-bold text-foreground mb-4">Areas of Expertise</h3>
                    <div class="grid md:grid-cols-2 gap-3">
                        @foreach ($area_of_expertise as $expertise)
                        <div class="flex items-center p-3 bg-secondary rounded-lg">
                            <div class="w-2 h-2 rounded-full bg-primary mr-3"></div>
                            <span class="text-foreground">{{ $expertise }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
                <!-- ACHIEVEMENTS -->
                <!--<div>
                    <h3 class="text-2xl font-bold text-foreground mb-4">Notable Achievements</h3>
                    <div class="space-y-3">
                        <div class="flex items-start p-4 bg-primary/5 rounded-lg border border-primary/20">
                            <span class="text-foreground">Published researcher in nutritional biochemistry</span>
                        </div>
                        <div class="flex items-start p-4 bg-primary/5 rounded-lg border border-primary/20">
                            <span class="text-foreground">Speaker at international wellness conferences</span>
                        </div>
                        <div class="flex items-start p-4 bg-primary/5 rounded-lg border border-primary/20">
                            <span class="text-foreground">Developed personalized nutrition protocols</span>
                        </div>
                        <div class="flex items-start p-4 bg-primary/5 rounded-lg border border-primary/20">
                            <span class="text-foreground">Trained over 500 health practitioners</span>
                        </div>
                    </div>
                </div>-->
            </div>
        </div>
    </section>
    
    <!-- ================= COURSES SECTION ================= -->
    <section class="py-20 bg-background">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- TABS -->
            <div class="w-full">
                <div role="tablist" class="grid w-full max-w-md mx-auto grid-cols-2 mb-12 h-10 items-center rounded-md bg-muted p-1 text-muted-foreground">
                    <button class="tab-btn active inline-flex items-center justify-center px-3 py-1.5 text-lg" data-tab="courses">Courses</button>
                    <button class="tab-btn inline-flex items-center justify-center px-3 py-1.5 text-lg" data-tab="store">Store</button>
                </div>
                <!-- COURSES CONTENT -->
                <div id="courses" class="tab-content">
                    <div class="mb-8 text-center">
                        <h2 class="text-3xl lg:text-5xl font-bold text-foreground mb-4">Exclusive Courses</h2>
                        <p class="text-xl text-muted-foreground max-w-3xl mx-auto">
                        Access {{$collaboratorDetail->first_name}} {{ $collaboratorDetail->last_name }} comprehensive video courses available exclusively to Premium and Elite members
                        </p>
                    </div>
                    <!-- COURSE GRID -->
                    @if(count($courses) > 0)
                    <div class="grid md:grid-cols-2 gap-8">
                        @foreach ($courses as $course)
                        <!-- COURSE CARD -->
                        <div class="rounded-lg bg-card border-2 hover:border-primary shadow-soft hover:shadow-medium">
                            <div class="p-6">
                                <div class="aspect-video bg-gradient-to-br from-primary/20 to-accent/20 rounded-lg mb-4 flex items-center justify-center">▶</div>
                                <h3 class="text-2xl font-semibold mb-2">{{$course->title}}</h3>
                                <p class="text-muted-foreground mb-4">{{$course->description}}</p>
                                <a href="{{$course->video_url}}" target="_blank"><button class="gradient-primary text-primary-foreground font-semibold h-10 px-4 py-2 w-full rounded-md">Start Course</button></a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                    <!-- MEMBERSHIP CTA -->
                    <div class="mt-12 text-center">
                        <div class="rounded-lg border bg-card shadow-medium max-w-2xl mx-auto">
                            <div class="p-8">
                                <h3 class="text-2xl font-bold text-foreground mb-4">Access All Courses</h3>
                                <p class="text-muted-foreground mb-6">Upgrade to Premium or Elite membership to unlock all courses</p>
                                <a href="{{url('/membership')}}">
                                    <button class="gradient-primary text-primary-foreground font-semibold h-11 px-8 rounded-md">View Membership Plans</button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- STORE CONTENT -->
                <div id="store" class="tab-content hidden">
                    <div class="mb-10 text-center">
                        <h2 class="text-3xl lg:text-5xl font-bold text-foreground mb-4">{{ucfirst($collaboratorDetail->first_name)}} {{ucfirst($collaboratorDetail->last_name)}} Store</h2>
                        <p class="text-xl text-muted-foreground max-w-3xl mx-auto">
                            Premium products personally selected and recommended by {{ucfirst($collaboratorDetail->first_name)}} {{ucfirst($collaboratorDetail->last_name)}}
                        </p>
                    </div>

                    @if(count($products) > 0)
                    <!-- PRODUCT GRID -->
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                        <!-- PRODUCT CARD -->
                        @foreach($products as $product)
                        <div class="rounded-xl overflow-hidden bg-card border shadow-soft hover:shadow-medium transition">
                            <!-- PRODUCT IMAGE AREA -->
                            <div class="relative bg-gradient-to-br from-primary/10 to-accent/10 h-64 flex items-center justify-center">
                                <!-- CART ICON -->
                                <div class="w-20 h-20 rounded-full bg-primary flex items-center justify-center text-white text-3xl">🛒</div>
                                <!-- DISCOUNT BADGE -->
                                <span class="absolute bottom-4 bg-yellow-400 text-black text-sm font-semibold px-4 py-1 rounded-full">{{$product->discount}}% OFF</span>
                            </div>
                            <!-- PRODUCT INFO -->
                            <div class="p-6">
                                <h3 class="text-xl font-semibold mb-1">{{$product->name}}</h3>
                                <p class="text-primary text-sm mb-2">by {{ucfirst($product->user->first_name)}} {{ucfirst($product->user->last_name)}}</p>
                                <p class="text-muted-foreground text-sm mb-4">
                                    {{$product->description}}
                                </p>
                                <!-- RATING -->
                                <!-- <div class="flex items-center text-sm text-muted-foreground mb-3">
                                    <span class="text-yellow-400 mr-1">★</span>
                                    <span class="font-medium text-foreground mr-1">4.8</span>
                                    <span>(234)</span>
                                </div> -->
                                <!-- PRICE -->
                                <div class="flex items-center gap-3 mb-5">
                                    <span class="text-2xl font-bold text-foreground">${{ number_format($product->price, 2)}}</span>
                                    <span class="line-through text-muted-foreground">${{ number_format($product->originalPrice, 2)}}</span>
                                </div>
                                <!-- ADD TO CART -->
                                <button onclick="addToCart({{$product->id}})" class="w-full flex items-center justify-center gap-2 gradient-primary text-primary-foreground font-semibold h-11 rounded-md">
                                    🛒 Add to Cart
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</main>
<script>
const tabs = document.querySelectorAll(".tab-btn");
const contents = document.querySelectorAll(".tab-content");
tabs.forEach(tab => {
    tab.addEventListener("click", () => {
        const target = tab.dataset.tab;
        // remove active class
        tabs.forEach(t => t.classList.remove("active"));
        // hide all content
        contents.forEach(c => c.classList.add("hidden"));
        // activate tab
        tab.classList.add("active");
        // show content
        document.getElementById(target).classList.remove("hidden");
    });
});
</script>
<script src="{{ asset('js/cart.js') }}"></script> 
@endsection