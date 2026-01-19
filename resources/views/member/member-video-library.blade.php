@extends('member.member')

@section('member-content')

<main class="bg-white text-foreground p-6">

            @php
                    $featuredVideos = [
                        [
                            "id" => 1,
                            "title" => "Foundations of Holistic Dentistry",
                            "instructor" => "Dr. Victor Zeines",
                            "duration" => "45 min",
                            "thumbnail" => "/images/dr-zeines.jpg",
                            "category" => "Dental Health",
                            "featured" => true
                        ],
                        [
                            "id" => 2,
                            "title" => "Natural Approaches to Gum Health",
                            "instructor" => "Dr. Victor Zeines",
                            "duration" => "32 min",
                            "thumbnail" => "/images/dr-zeines.jpg",
                            "category" => "Dental Health",
                            "featured" => true
                        ],
                        [
                            "id" => 3,
                            "title" => "Mercury-Free Dentistry Explained",
                            "instructor" => "Dr. Victor Zeines",
                            "duration" => "28 min",
                            "thumbnail" => "/images/dr-zeines.jpg",
                            "category" => "Dental Health",
                            "featured" => true
                        ],
                    ];

                    $categoryVideos = [
                        "Dental Health" => [
                            ["id" => 4, "title" => "Understanding Tooth Decay Naturally", "instructor" => "Dr. Sarah Mitchell", "duration" => "25 min"],
                            ["id" => 5, "title" => "Oral Microbiome Basics", "instructor" => "Dr. James Chen", "duration" => "30 min"],
                            ["id" => 14, "title" => "Understanding Tooth Decay Naturally", "instructor" => "Dr. Sarah Mitchell", "duration" => "25 min"],
                            ["id" => 15, "title" => "Oral Microbiome Basics", "instructor" => "Dr. James Chen", "duration" => "30 min"],
                        ],
                        "Nutrition" => [
                            ["id" => 6, "title" => "Anti-Inflammatory Diet Essentials", "instructor" => "Lisa Thompson, RD", "duration" => "40 min"],
                            ["id" => 7, "title" => "Supplements for Longevity", "instructor" => "Dr. Michael Ross", "duration" => "35 min"],
                            ["id" => 16, "title" => "Anti-Inflammatory Diet Essentials", "instructor" => "Lisa Thompson, RD", "duration" => "40 min"],
                            ["id" => 17, "title" => "Supplements for Longevity", "instructor" => "Dr. Michael Ross", "duration" => "35 min"],
                        ],
                        "Wellness" => [
                            ["id" => 8, "title" => "Stress Management Techniques", "instructor" => "Dr. Emily Carter", "duration" => "22 min"],
                            ["id" => 9, "title" => "Sleep Optimization Guide", "instructor" => "Dr. Robert Lee", "duration" => "28 min"],
                            ["id" => 18, "title" => "Stress Management Techniques", "instructor" => "Dr. Emily Carter", "duration" => "22 min"],
                            ["id" => 19, "title" => "Sleep Optimization Guide", "instructor" => "Dr. Robert Lee", "duration" => "28 min"],
                        ],
                        "Mind-Body" => [
                            ["id" => 10, "title" => "Meditation for Beginners", "instructor" => "Anna Williams", "duration" => "20 min"],
                            ["id" => 11, "title" => "Breathing Exercises for Health", "instructor" => "Mark Johnson", "duration" => "18 min"],
                            ["id" => 20, "title" => "Meditation for Beginners", "instructor" => "Anna Williams", "duration" => "20 min"],
                            ["id" => 21, "title" => "Breathing Exercises for Health", "instructor" => "Mark Johnson", "duration" => "18 min"],
                        ],
                    ];

                    $collaborators = [
                        ["name" => "Dr. Sarah Mitchell", "specialty" => "Holistic Dentistry", "videoCount" => 8],
                        ["name" => "Lisa Thompson, RD", "specialty" => "Nutrition", "videoCount" => 12],
                        ["name" => "Dr. Michael Ross", "specialty" => "Integrative Medicine", "videoCount" => 6],
                        ["name" => "Dr. Emily Carter", "specialty" => "Wellness", "videoCount" => 9],
                    ];
            @endphp


            <div class="space-y-8" x-data="{ tab: 'category' }">

                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Video Library</h1>
                    <p class="text-gray-500 mt-2">Access all educational videos and wellness content</p>
                </div>

                {{-- Featured Section --}}
                <section>
                    <div class="flex items-center gap-2 mb-4">
                        
                        <i data-lucide="star" class="h-5 w-5 text-primary fill-primary"></i>
                        <h2 class="text-xl font-semibold">Featured: Dr. Victor Zeines</h2>
                    </div>

                    <div class="grid md:grid-cols-3 gap-6">
                        @foreach ($featuredVideos as $video)
                            <div class="border rounded-lg overflow-hidden hover:shadow-lg transition-shadow">
                                <div class="relative aspect-video bg-gray-200">
                                    <img src="{{ $video['thumbnail'] }}" class="w-full h-full object-cover" />
                                    
                                    <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity">
                                        <button class="bg-white px-4 py-2 rounded-full text-sm">▶</button>
                                    </div>

                                    <div class="absolute top-2 right-2 bg-primary text-white text-xs px-2 py-1 rounded">
                                        Featured
                                    </div>
                                </div>

                                <div class="p-4">
                                    <h3 class="font-semibold">{{ $video['title'] }}</h3>
                                    <div class="flex items-center gap-4 mt-2 text-xs text-gray-500">
                                        <span>{{ $video['instructor'] }}</span>
                                        <span>{{ $video['duration'] }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>


                {{-- Tabs --}}
                <div>
                    <div class="grid w-full max-w-sm grid-cols-2 bg-gray-100 rounded-md p-1">
                        <button @click="tab='category'" :class="tab=='category' ? 'bg-white shadow font-semibold' : ''" class="px-3 py-2 text-sm rounded-md">
                            By Category
                        </button>
                        <button @click="tab='collaborator'" :class="tab=='collaborator' ? 'bg-white shadow font-semibold' : ''" class="px-3 py-2 text-sm rounded-md">
                            By Collaborator
                        </button>
                    </div>

                    {{-- Category View --}}
                    <div x-show="tab=='category'" class="mt-6 space-y-8">
                        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($categoryVideos as $category => $videos)
                            <section>
                                <h3 class="text-lg font-semibold mb-4">{{ $category }}</h3>

                                {{-- <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-4"> --}}
                                    @foreach ($videos as $video)
                                        <div class="border rounded-lg p-4 hover:shadow-md cursor-pointer transition-shadow">
                                            <div class="aspect-video bg-gray-200 rounded-lg flex items-center justify-center mb-3">▶</div>

                                            <h4 class="font-medium text-sm">{{ $video['title'] }}</h4>

                                            <div class="flex items-center justify-between mt-2 text-xs text-gray-500">
                                                <span>{{ $video['instructor'] }}</span>
                                                <span>{{ $video['duration'] }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                {{-- </div> --}}
                            </section>
                        @endforeach
                        </div>
                    </div>
                    {{-- copy from intro video --}}
                    {{-- <section class="py-12 bg-background">
                            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                                <h2 class="text-3xl font-bold text-foreground mb-8">More Introduction Videos</h2>

                                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                                    @foreach ($videos as $video)
                                    
                                            <x-card class="">
                                                <x-card-header class="pb-4 ">
                                                    <div class="aspect-video bg-gradient-to-tr  from-green-50 to-amber-100  rounded-lg mb-4 flex items-center justify-center relative">
                                                        <div class="w-16 h-16 rounded-full gradient-primary flex items-center justify-center cursor-pointer hover:scale-110 transition-transform">
                                                            <i data-lucide="play" class="h-8 w-8 text-primary-foreground ml-1"></i>
                                                        </div>

                                                        <x-badge class="absolute top-3 right-3 bg-background/80 backdrop-blur-sm flex items-center">
                                                            <i data-lucide="clock" class="h-3 w-3 mr-1"></i>
                                                            {{ $video['duration'] }}
                                                        </x-badge>
                                                    </div>
                                                </x-card-header>

                                                <x-card-content class="space-y-3">

                                                    <div>
                                                        <h3 class="text-xl  font-bold text-teal-950   text-foreground mb-2 line-clamp-2">
                                                            {{ $video['title'] }}
                                                        </h3>

                                                    

                                                        <div class="flex items-center text-sm text-muted-foreground text-neutral-500">
                                                            <i data-lucide="user" class="h-3 w-3 mr-1"></i>
                                                            {{ $video['instructor']}}
                                                            
                                                            <span class="bg-gray-200 px-3 py-1 rounded-full text-sm font-semibold  text-teal-950">{{ $video ['category'] }}</span>
                                                        </div>

                                                        
                                                    </div>

                                                    <p class="text-sm text-muted-foreground line-clamp-2">
                                                        {{ $video['description'] }}
                                                    </p>

                                                    
                                                    <button class="  w-full   font-semibold  px-2 py-3 rounded-md  bg-emerald-500 hover:bg-orange-600 text-white  flex items-center justify-center">
                                                                <i data-lucide="play" class="h-5 w-5   mr-2"></i>
                                                                <span class="ml-2">Watch Now </span>
                                                            </button>

                                                </x-card-content>

                                            </x-card>   

                                    @endforeach
                                </div>
                            </div>
                    </section> --}}

                    {{-- Collaborator View --}}
                    <div x-show="tab=='collaborator'" class="mt-6">
                        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                            @foreach ($collaborators as $c)
                                <div class="border rounded-lg p-5 hover:shadow-md cursor-pointer text-center transition-shadow">
                                    <div class="w-16 h-16 bg-blue-100 rounded-full mx-auto flex items-center justify-center mb-3 text-primary text-2xl">
                                        👤
                                    </div>
                                    <div class="font-semibold text-base">{{ $c['name'] }}</div>
                                    <div class="text-gray-500 text-sm">{{ $c['specialty'] }}</div>
                                    <p class="text-sm text-gray-500 mt-2">{{ $c['videoCount'] }} videos</p>
                                    <button class="mt-3 border px-3 py-1 rounded text-sm">View Videos</button>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>

            </div>
</main>

@endsection
 
