
@extends('front.layouts.app')
@section('content') 


        @php
                
                $benefits = [
                    [
                        'icon' => 'Users',
                        'title' => 'Expand Your Reach',
                        'description' => 'Connect with thousands of health-conscious members seeking expert guidance'
                    ],
                    [
                        'icon' => 'Heart',
                        'title' => 'Share Your Expertise',
                        'description' => 'Create educational content and host live sessions on your specialty topics'
                    ],
                    [
                        'icon' => 'trending-up',
                        'title' => 'Grow Your Practice',
                        'description' => 'Promote your services and products to our engaged community'
                    ],
                    [
                        'icon' => 'Award',
                        'title' => 'Join elite Network',
                        'description' => 'Collaborate with Dr. Zeines and other leading health professionals'
                    ]
                ];
        @endphp
{{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}
 <section class="section-base gradient-subtle py-20">
            <div class="container-base max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="  mb-12 w-20 h-20 rounded-full border-4 border-primary  mx-auto flex  items-center justify-center shadow-soft ">
                     <div class="   self-center mt-4">
                        <i data-lucide="slack" class="w-12 h-12 text-primary mb-4  "></i>
                    </div>
                </div>
                <div class="text-center mb-12">
                    <h2 class="heading-1"><span class="text-primary">Become a</span> Collaborator</h2>
                    <p class="text-lg text-muted-foreground ">
                        Join our network of distinguished health professionals and help us empower individuals on their journey to <br>optimal health and longevity.
                    </p>
                </div> 
            </div>
        </section>
   <section class="section-base gradient-subtle py-20">
            <div class="container-base max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                 <div class="text-center mb-12">
                    <h2 class="heading-2">Why Join <span class="text-primary">Our Network?</span></h2>
                    <p class="text-lg text-muted-foreground ">
                       As a collaborator, you'll gain access to a <span class="text-accent">vibrant community and powerful platform</span>
                    </p>
                </div> 
                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                    @foreach($benefits as $b)
                    <div class="border-2 hover:border-primary transition-all shadow-soft hover:shadow-medium rounded-xl">
                        <div class="p-6 space-y-4">
                            <div class="iconbg w-14 h-14">
                                 
                                <i data-lucide="{{$b['icon']}}" class="h-7 w-7 text-primary-foreground" ></i>
                            </div>
                            <h3 class="heading-3   ">{{ $b['title'] }}</h3>
                            <p class="text-muted-foreground">{{ $b['description'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>


                
            </div>
                 
    </section>
 

    <section class="section-base gradient-subtle py-20">
            <div class="container-base max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">   
                <div class="lg:col-span-2">
                        <x-card class="shadow-medium">
                            
                            <x-card-header>
                                <x-card-title class="text-3xl">Collaborator Application</x-card-title>
                                <p class="text-muted-foreground">
                                    Fill out the form below and we'll review your application within 3-5 business days
                                </p>
                            </x-card-header>

                            <x-card-content>
                                     
                               {{-- <div x-data="contactForm()" @submit.prevent="submitForm"> --}}
                               <div>
                                    <form class="space-y-6" method="POST" action="{{ url('become/collaborator') }}">
                                        @csrf

                                        <div class="grid md:grid-cols-2 gap-6">
                                            <div class="space-y-2">
                                                <label for="firstName" class="font-medium">First Name *</label>
                                                <x-form.input model="firstName" name="first_name" placeholder="John" filter="name" value="{{ old('first_name') }}" />
                                            </div>

                                            <div class="space-y-2">
                                                <label for="lastName" class="font-medium">Last Name *</label>
                                                <x-form.input model="lastName" name="last_name" placeholder="Doe" filter="name" value="{{ old('last_name') }}" />
                                            </div>
                                        </div>

                                        <div class="grid md:grid-cols-2 gap-6"> 
                                            <div class="space-y-2">
                                                <label for="email" class="font-medium">Email Address *</label>
                                                <x-form.input model="email" name="email" placeholder="john@example.com" type="email" filter="email" value="{{ old('email') }}" />
                                            </div>

                                            <div class="space-y-2">
                                                <label for="phone" class="font-medium">Phone Number</label>
                                                <x-form.input model="phone" name="phone" placeholder="+1-555-123-4567" type="tel" filter="phone" value="{{ old('phone') }}" />  
                                            </div>
                                        </div>       

                                        <div class="space-y-2">
                                            <label for="specialty_area_of_expertise" class="font-medium">Specialty/Area of Expertise *</label>
                                            <x-form.input model="specialty_area_of_expertise" name="specialty_area_of_expertise" placeholder="e.g., Functional Medicine, Nutrition, Integrative Health" filter="text" value="{{ old('specialty_area_of_expertise') }}" />
                                        </div>

                                        <div class="grid md:grid-cols-2 gap-6">
                                            <div class="space-y-2">
                                                <label for="professional_credentials" class="font-medium">Professional Credentials *</label>
                                                <x-form.input model="professional_credentials" name="professional_credentials" placeholder="e.g., MD, DO, ND, RD, PhD" filter="name" value="{{ old('professional_credentials') }}" />
                                            </div>
                                            <div class="space-y-2">
                                                <label for="experience" class="font-medium">Years of Experience *</label>
                                                <x-form.input type="number" model="experience" name="experience" placeholder="10" filter="number" value="{{ old('experience') }}" /> <!-- Removed 'e.g., 10+ years' for number input -->
                                            </div>
                                        </div>

                                        <div class="grid md:grid-cols-2 gap-6">
                                            <div class="space-y-2">
                                                <label for="practice_organization" class="font-medium">Practice/Organization *</label>
                                                <x-form.input model="practice_organization" name="practice_organization" placeholder="Your clinic, practice, or organization name" filter="name" value="{{ old('practice_organization') }}" />
                                            </div>
                                            <div class="space-y-2">
                                                <label for="website_url" class="font-medium">Website (Optional)</label>
                                                <x-form.input model="website_url" name="website_url" placeholder="https://your-website.com" type="url" filter="url" value="{{ old('website_url') }}" />
                                            </div>
                                        </div>

                                        <div class="space-y-2">
                                            <label for="subject" class="font-medium">Why do you want to become a collaborator? *</label>
                                            <x-form.textarea model="description" name="description" placeholder="Tell us about your interest in joining our network, what you hope to contribute, and what makes you a good fit..." filter="text" value="{{ old('description') }}" />
                                            <p class="text-sm text-muted-foreground" x-text="charCount.description + '/2000 characters'"></p>
                                        </div>

                                        <div class="grid grid-cols-1 gap-2">
                                            <x-button-use type="submit" full="true" class="btn-hero lg py-3 flex items-center justify-center gap-2">
                                                <i data-lucide="send" class="w-5 h-5"></i>
                                                Submit Application
                                            </x-button-use>
                                            <p x-show="success" class="text-green-500 text-sm" x-text="success"></p>
                                            <p x-show="error" class="text-red-500 text-sm" x-text="error"></p>
                                        </div>
                                    </form>
                                </div>

                            </x-card-content>

                        </x-card>
                </div>
            </div>
                 
    </section>


      
@endsection    

 