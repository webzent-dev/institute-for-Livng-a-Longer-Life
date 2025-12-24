@extends('front.layouts.app')

@section('content')

<div class="min-h-screen flex flex-col">
   @php
    $helpTopics = [
      [
        'icon' => 'Book',
        'title' => "Getting Started",
        'description' => "Learn how to set up your account and navigate the platform",
        'articles' => [
          "Creating Your Account",
          "Navigating the Member Dashboard",
          "Accessing Your First Course",
          "Setting Up Your Profile"
        ]
      ],
      [
        'icon' => 'Video',
        'title' => "Video Content",
        'description' => "Everything about accessing and watching our educational content",
        'articles' => [
          "How to Access Pre-Recorded Lectures",
          "Viewing Live Zoom Sessions",
          "Downloading Content for Offline Viewing",
          "Video Playback Troubleshooting"
        ]
      ],
      [
        'icon' => 'credit-card',
        'title' => "Billing & Payments",
        'description' => "Manage your subscription and payment information",
        'articles' => [
          "Understanding Membership Plans",
          "Updating Payment Information",
          "Upgrading or Downgrading Membership",
          "Cancellation and Refund Policy"
        ]
      ],
      [
        'icon' => 'Users',
        'title' => "Community & Live Sessions",
        'description' => "Connect with other members and join live events",
        'articles' => [
          "Joining Live Zoom Sessions",
          "Asking Questions During Q&A",
          "Connecting with Other Members",
          "Upcoming Events Calendar"
        ]
      ],
      [
        'icon' => 'Settings',
        'title' => "Account Management",
        'description' => "Control your account settings and preferences",
        'articles' => [
          "Updating Personal Information",
          "Changing Password",
          "Email Notification Settings",
          "Privacy and Data Settings"
        ]
      ],
      [
        'icon' => 'life-buoy',
        'title' => "Troubleshooting",
        'description' => "Common issues and how to resolve them",
        'articles' => [
          "Login Problems",
          "Video Won't Play",
          "Payment Declined",
          "Email Not Received"
        ]
      ]
    ];

   $contactOptions = [
      [
        'type' => 'mail',
        'icon' => 'mail',
        'title' => "Email Support",
        'description' => "Get help via email",
        'contact' => "support@livinglonger.com",
        'note' => "Response within 24 hours"
      ],
      [
        'type' => 'phone',
        'icon' => 'phone',
        'title' => "Phone Support",
        'description' => "Speak with our team",
        'contact' => "(555) 123-4567",
        'note' => "Mon-Fri, 9am-5pm EST"
      ]
    ];

   @endphp

    <main class="flex-1">

        {{-- HERO SECTION --}}
        <section class="gradient-subtle py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">

                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full gradient-primary mb-6">
                    <i data-lucide="life-buoy"  class="h-8 w-8 text-primary-foreground" ></i>
                </div>

                <h1 class="text-4xl lg:text-6xl font-bold text-foreground mb-6">
                    Help Center
                </h1>

                <p class="text-xl text-muted-foreground max-w-3xl mx-auto">
                    Everything you need to know about using the Institute for Living Longer
                </p>

            </div>
        </section>

        {{-- HELP TOPICS GRID --}}
        <section class="py-20 bg-background">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">

                    @foreach ($helpTopics as $topic)
                        <x-card class="">

                            <x-card-header>
                                <div class="w-14 h-14 iconbg mb-4">
                                    <i data-lucide="{{ $topic['icon'] }}" class="h-7 w-7 text-primary-foreground" ></i>
                                </div>

                                <x-card-title class="heading-4 mb-2">
                                    {{ $topic['title'] }}
                                </x-card-title>

                                <p class="text-sm text-muted-foreground">
                                    {{ $topic['description'] }}
                                </p>
                            </x-card-header>

                            <x-card-content>
                                <ul class="space-y-2">
                                    @foreach ($topic['articles'] as $article)
                                        <li class="text-sm">
                                            <a href="#" class="text-primary hover:underline flex items-center">
                                                <span class="w-1.5 h-1.5 rounded-full bg-primary mr-2"></span>
                                                {{ $article }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </x-card-content>

                        </x-card>
                    @endforeach

                </div>

            </div>
        </section>

        {{-- QUICK START GUIDE --}}
        <section class="py-20 gradient-subtle">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

                <x-card class="shadow-strong">

                    <x-card-header class="text-center">
                        <x-card-title class="text-3xl  mb-4">Quick Start Guide</x-card-title>
                        <p class="text-muted-foreground">
                            New to the platform? Follow these simple steps to get started
                        </p>
                    </x-card-header>

                    <x-card-content class="space-y-6">
                        @foreach ([
                            ['1', 'Choose Your Membership', 'Select the plan that best fits your wellness goals and budget'],
                            ['2', 'Complete Registration', 'Fill out your profile information and set up your account'],
                            ['3', 'Access Your Dashboard', 'Log in to explore content and resources'],
                            ['4', 'Start Learning', 'Watch videos, join live sessions, begin your journey']
                        ] as $step)

                            <div class="flex items-start space-x-4">
                                <div class="w-12 h-12 rounded-full gradient-primary flex items-center justify-center flex-shrink-0">
                                    <span class="text-xl font-bold text-primary-foreground">{{ $step[0] }}</span>
                                </div>

                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-foreground mb-1">{{ $step[1] }}</h3>
                                    <p class="text-muted-foreground">{{ $step[2] }}</p>
                                </div>
                            </div>

                        @endforeach
                    </x-card-content>

                </x-card>

            </div>
        </section>

        {{-- CONTACT SECTION --}}
        <section class="py-20 bg-background">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-foreground mb-4">Need More Help<span class="text-primary">?</sapan></h2>
                    <p class="text-xl text-muted-foreground">Our support team is ready to assist you</p>
                </div>

                <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">

                        @foreach ($contactOptions as $option)
                            <x-card class="shadow-medium">
                                <x-card-content class="p-8 text-center">

                                    <div class="w-16 h-16 rounded-full gradient-primary flex items-center justify-center mx-auto mb-4">
                                        <i data-lucide="{{ $option['icon'] }}" class="h-8 w-8 text-primary-foreground" ></i>
                                    </div>

                                    <h3 class="text-xl font-semibold text-foreground mb-2">{{ $option['title'] }}</h3>
                                    <p class="text-muted-foreground mb-4">{{ $option['description'] }}</p>  

                                    {{-- <p class="text-lg font-semibold text-primary mb-2">{{ $option['contact'] }}</p> --}}
                                      <x-ui.contact-item 
                                        type="{{ $option['type'] }}"
                                        text="{{ $option['contact'] }}"
                                        value="{{ $option['contact'] }}"
                                     
                                        class="w-full text-green-600 hover:text-white justify-center"
                                    />  

                                    <p class="text-sm text-muted-foreground">{{ $option['note'] }}</p>

                                </x-card-content>
                            </x-card>
                        @endforeach
                        
                    
                        

                </div>
                 
                <div class="flex justify-center mt-12">
                    <x-button-use href="/faq" variant="outline" size="lg" icon="badge-question-mark">
                        View Frequently Asked Questions
                    </x-button-use>
                </div>

                

            </div>
        </section>

    </main>

    

</div>

@endsection
