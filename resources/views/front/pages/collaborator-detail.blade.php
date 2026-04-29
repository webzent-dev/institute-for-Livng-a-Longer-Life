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
                                @if(!empty($collaboratorDetail->profile_image) && file_exists(public_path('user_images/' . $collaboratorDetail->profile_image)))
                                    <img src="{{ asset('user_images/' . $collaboratorDetail->profile_image) }}" alt="{{ ucfirst($collaboratorDetail->first_name) }} {{ ucfirst($collaboratorDetail->last_name) }}" class="w-full h-full object-cover rounded-full">
                                @else
                                    <!--<img src="{{ asset('images/default-avatar.png') }}" alt="{{ ucfirst($collaboratorDetail->first_name) }} {{ ucfirst($collaboratorDetail->last_name) }}" class="w-full h-full object-cover rounded-full">-->
                                    <span class="text-5xl font-bold text-primary-foreground">{{ \Illuminate\Support\Str::ucfirst(substr($collaboratorDetail->first_name, 0, 1)) }}{{ \Illuminate\Support\Str::ucfirst(substr($collaboratorDetail->last_name, 0, 1))}}</span>
                                @endif
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
                        <!--<button class="gradient-primary text-primary-foreground shadow-medium font-semibold h-10 px-4 py-2 w-full rounded-md">Book Consultation</button>-->
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
                <!-- <div>
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
                </div> -->
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
                                <a href="{{$course->video_url}}" target="_blank">
                                    <div class="aspect-video rounded-lg mb-4 relative overflow-hidden
                                        @if(!empty($course->thumbnail) && file_exists(public_path('course_images/' . $course->thumbnail)))
                                            bg-cover bg-center
                                        @else
                                            bg-gradient-to-br from-primary/20 to-accent/20 flex items-center justify-center
                                        @endif">
                                        @if(!empty($course->thumbnail) && file_exists(public_path('course_images/' . $course->thumbnail)))
                                            <img src="{{ asset('course_images/' . $course->thumbnail) }}" alt="{{$course->title}}" class="w-full h-full object-cover
                                            ">
                                            <!-- Play overlay -->
                                            <div class="absolute inset-0 bg-black/30 flex items-center justify-center">
                                                <svg class="w-16 h-16 text-white" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M8 5v14l11-7z"/>
                                                </svg>
                                            </div>
                                        @else
                                            <svg class="w-16 h-16 text-primary" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M8 5v14l11-7z"/>
                                            </svg>
                                        @endif
                                    </div>
                                </a>
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
                        <div class="group rounded-xl bg-white border border-border/50 hover:border-primary/50 shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden">
                            <!-- PRODUCT IMAGE AREA -->
                            <div class="relative aspect-square overflow-hidden">
                                @if(!empty($product->image) && file_exists(public_path('product_images/'.$product->image)))
                                    <div class="absolute inset-0 bg-gradient-to-br from-primary/5 to-accent/5">
                                        <img src="{{ asset('product_images/'.$product->image) }}" alt="{{$product->name}}" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500">
                                    </div>
                                    <!-- Hover Overlay -->
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-primary/10 via-accent/10 to-primary/20 flex items-center justify-center">
                                        <div class="text-center">
                                            <div class="bg-white/10 backdrop-blur-sm rounded-full p-6 mb-3">
                                                <svg class="w-12 h-12 text-primary" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                                                    <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                                    <line x1="12" y1="22.08" x2="12" y2="12"></line>
                                                </svg>
                                            </div>
                                            <p class="text-primary/80 text-sm font-medium">Product Image</p>
                                        </div>
                                    </div>
                                @endif
                                <!-- Quick View Badge -->
                               
                            </div>
                            
                            <!-- PRODUCT INFO -->
                            <div class="p-6 space-y-4">
                                <!-- Product Title & Author -->
                                <div class="space-y-2">
                                    <h3 class="text-lg font-bold text-foreground group-hover:text-primary transition-colors duration-200 line-clamp-2">{{$product->name}}</h3>
                                    <p class="text-sm text-muted-foreground">by {{ucfirst($product->user->first_name)}} {{ucfirst($product->user->last_name)}}</p>
                                </div>
                                
                                <!-- Product Description -->
                                @if(!empty($product->description))
                                    <p class="text-muted-foreground text-sm line-clamp-2 leading-relaxed">{{$product->description}}</p>
                                @endif
                                
                                <!-- Rating & Reviews -->
                                
                                
                                <!-- Price Section -->
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <span class="text-2xl font-bold text-foreground">${{ number_format($product->price, 2)}}</span>
                                        @if(!empty($product->originalPrice) && $product->originalPrice > $product->price)
                                            <span class="text-sm text-muted-foreground line-through">${{ number_format($product->originalPrice, 2)}}</span>
                                        @endif
                                    </div>
                                    <!-- Discount Badge -->
                                    @if(!empty($product->originalPrice) && $product->originalPrice > $product->price)
                                        <div class="bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded-full">
                                            {{ round((($product->originalPrice - $product->price) / $product->originalPrice) * 100) }}% OFF
                                        </div>
                                    @endif
                                </div>
                                
                                <!-- ADD TO CART BUTTON -->
                                <button onclick="addToCart({{$product->id}})" class="w-full gradient-primary text-primary-foreground font-semibold h-11 px-6 rounded-lg shadow-medium hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200 flex items-center justify-center gap-2">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="8" cy="21" r="1"></circle>
                                        <circle cx="19" cy="21" r="1"></circle>
                                        <path d="M2.05 2.05h2l2.66 13.32a1 1 0 0 0 1 .78h10.68a1 1 0 0 0 1-.78L20.05 7.05H5.05"></path>
                                    </svg>
                                    Add to Cart
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