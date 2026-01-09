@extends('front.layouts.app')

@section('content')
<div class="min-h-screen flex flex-col font-jakarta">

   

    <main class="flex-1">

        {{-- Hero Section --}}
        <section class="gradient-subtle py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-4xl lg:text-6xl font-bold text-foreground mb-6">
                    Our Expert <span class="text-amber-500    ">Collaborators</span>
                </h1>
                <p class="text-xl text-muted-foreground max-w-3xl mx-auto">
                    Learn from a network of world-class physicians and health practitioners, each bringing 
                    specialized expertise to your wellness journey. Access their exclusive courses and recommended products.
                </p>
            </div>
        </section>
        

        {{-- PHP collaborators array --}}
        @php
            $collaborators = [
                [
                    'id' => 1,
                    'name' => "Dr. Sarah Chen",
                    'specialty' => "Functional Nutrition",
                    'credentials' => "PhD, CNS, IFMCP",
                    'description' => "Specializes in personalized nutrition strategies for optimal health and longevity. Over 15 years of experience in metabolic health.",
                    'coursesAvailable' => 12,
                    'productsAvailable' => 8,
                    'featured' => true
                ],
                [
                    'id' => 2,
                    'name' => "Dr. Michael Rodriguez",
                    'specialty' => "Exercise Physiology",
                    'credentials' => "MD, CSCS",
                    'description' => "Expert in age-defying fitness protocols and movement optimization for enhanced vitality and strength.",
                    'coursesAvailable' => 18,
                    'productsAvailable' => 15,
                    'featured' => true
                ],
                [
                    'id' => 3,
                    'name' => "Dr. Jennifer Park",
                    'specialty' => "Mind-Body Medicine",
                    'credentials' => "PsyD, CIMHP",
                    'description' => "Focuses on stress reduction, meditation, and the powerful connection between mental and physical health.",
                    'coursesAvailable' => 10,
                    'productsAvailable' => 5,
                    'featured' => false
                ],
                [
                    'id' => 4,
                    'name' => "Dr. James Wilson",
                    'specialty' => "Integrative Cardiology",
                    'credentials' => "MD, FACC, ABOIM",
                    'description' => "Pioneering approaches to heart health through lifestyle medicine and evidence-based natural therapies.",
                    'coursesAvailable' => 14,
                    'productsAvailable' => 12,
                    'featured' => false
                ],
                [
                    'id' => 5,
                    'name' => "Dr. Emily Thompson",
                    'specialty' => "Sleep Medicine",
                    'credentials' => "MD, DABSM",
                    'description' => "Dedicated to optimizing sleep quality for enhanced recovery, cognitive function, and longevity.",
                    'coursesAvailable' => 8,
                    'productsAvailable' => 10,
                    'featured' => false
                ],
                [
                    'id' => 6,
                    'name' => "Dr. David Kim",
                    'specialty' => "Hormone Optimization",
                    'credentials' => "MD, ABAARM",
                    'description' => "Expert in bio-identical hormone therapy and metabolic optimization for vitality at any age.",
                    'coursesAvailable' => 16,
                    'productsAvailable' => 7,
                    'featured' => true
                ]
            ];
        @endphp

        {{-- Grid Products View  --}}
        @php
            $specialties = collect($collaborators)->pluck('specialty')->unique()->values();
        @endphp

        <section class="py-20 bg-background bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">

                    @foreach ($collaborators as $c)
                        <div class="flex flex-col card border-2  rounded-2xl {{ $c['featured'] ? 'border-primary shadow-medium' : 'shadow-soft' }} hover:border-primary py-4 px-6 ">
                            <div class="card-header  py-4">
                                <div class="flex justify-between items-start mb-4">
                                     
                                    <x-ui.avatar name="{{ $c['name'] }}"  size="4" />
 

                                    @if ($c['featured'])
                                        <x-badge class="">
                                            Featured
                                        </x-badge>
                                    @endif
                                </div>

                                <h2 class="text-2xl mb-2">{{ $c['name'] }}</h2>

                                <div class="space-y-1">
                                    <p class="text-emerald-600 font-bold">{{ $c['specialty'] }}</p>
                                    <p class="text-sm text-muted-foreground">{{ $c['credentials'] }}</p>
                                </div>
                            </div>
                             <div class="space-y-1 px-6 ">
                                <p class="text-muted-foreground mb-2 flex-1">
                                        {{ $c['description'] }}
                                    </p>  
                            </div>   
                            <div class="card-content  pb-3 flex-1 flex flex-col">

                                <div class="grid sm:grid-cols-2 gap-4  mb-2">
                                    {{-- <div class="space-y-3 mb-6"> --}}

                                            <div class="sm:col-span-1 flex items-center justify-between  bg-secondary rounded-lg bg-teal-50">
                                                <div class="flex items-center">
                                                   
                                                    <i data-lucide="video" class="h-5 w-5 text-primary mr-2"></i>
                                                    
                                                    <span class="font-medium text-foreground">Courses</span>
                                                </div>
                                                 
                                                <x-badge class="bg-emerald-500 text-black">
                                                    {{ $c['coursesAvailable'] }}
                                                </x-badge>
                                            </div>

                                            <div class=" sm:col-span-1 flex items-center justify-between p-3 bg-secondary rounded-lg bg-teal-50 gap-2">
                                                <div class="flex items-center">
                                                    <i data-lucide="store" class="h-5 w-5 text-primary mr-2"></i>
                                                    
                                                    <span class="font-medium text-foreground">Products</span>
                                                </div>
                                                
                                                <x-badge class="bg-emerald-500 text-black">
                                                    {{ $c['productsAvailable'] }}
                                                </x-badge>
                                            </div>

                                    {{-- </div> --}}
                                </div>
 

                                <div class="grid sm:grid-cols-2 gap-4 py-4">
                                    <div class="sm:col-span-1">
                                        <a href="{{ url('/collaborator/'.$c['id']) }}" class=" btn btn-outline  w-full sm:w-auto flex items-center justify-center font-semibold px-2 py-3 rounded-md  ">
                                           <button class="  w-full flex items-center justify-center">
                                                <i data-lucide="award" class="h-5 w-5  hover:text-white mr-1"></i>
                                                <span class="ml-1">View Profile</span>
                                            </button>
                                        </a>
                                    </div>
                                    <div class="sm:col-span-1">
                                        <a href="{{ url('/shop?vendor='.$c['id']) }}" class=" w-full sm:w-auto font-semibold  px-2 py-3 rounded-md  flex items-center justify-center bg-emerald-500 hover:bg-orange-600 text-white">
                                            <button class="  w-full flex items-center justify-center">
                                                <i data-lucide="store" class="h-5 w-5 text-white mr-2"></i>
                                                <span class="ml-2">Visit Store </span>
                                            </button>
                                        </a>
                                    </div>
                                   

                                </div>

                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </section>

        {{-- CTA --}}
            <x-ui.cta-section 
                icon="user-star"
                align="center"
                title=" Interested in Becoming a Collaborator?"
                subtitle="Join our network of expert practitioners and share your knowledge with our growing community. 
                        Manage your own store, create courses, and make a meaningful impact on people's lives."
                
                :buttons="[
                    ['route' => 'become-collaborator',   'label' => 'Apply to Collaborate', 'variant' => 'outline', 'icon' => 'external-link'],
                     
                ]"
            /> 

 

    </main>

 

</div>
@endsection
