@extends('front.layouts.app')

@section('content')

<div class="min-h-screen flex flex-col">
 

    <main class="flex-1">

        {{-- HERO SECTION --}}
        <section class="py-16 bg-gradient-to-b from-purple-100 to-white">
            <div class="max-w-7xl mx-auto px-6 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-primary text-white mb-6">
                    <i data-lucide="help-circle" class="w-8 h-8" ></i>
                </div>

                <h1 class="text-4xl md:text-6xl font-bold mb-4">
                    Frequently Asked Questions
                </h1>

                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    Find answers to common questions about our membership, products, and services.
                </p>
            </div>
        </section>

        @php
          $faqs = [
            [
                'category' => 'Membership',
                'questions' => [
                    [
                        'q' => "What's included in the membership plans?",
                        'a' => "Our membership plans include access to pre-recorded video lectures, live monthly Zoom sessions with Dr. Zeines..."
                    ],
                    [
                        'q' => "Can I upgrade or downgrade my membership?",
                        'a' => "Yes, you can upgrade or downgrade your membership at any time..."
                    ],
                    [
                        'q' => "Is there a free trial available?",
                        'a' => "Intro videos are available for free so you can get a sense..."
                    ],
                    [
                        'q' => "What's the difference between the membership tiers?",
                        'a' => "Standard Membership includes 1 lecture per month..."
                    ],
                ]
            ],
            [
                'category' => 'Vital Boost',
                'questions' => [
                    [
                        'q' => "What is Vital Boost?",
                        'a' => "Vital Boost is a comprehensive powdered nutritional supplement..."
                    ],
                    [
                        'q' => "How do I take Vital Boost?",
                        'a' => "Simply mix one packet into your smoothie or water..."
                    ],
                    [
                        'q' => "Is Vital Boost safe with my current medications?",
                        'a' => "Consult your healthcare provider before starting any supplement..."
                    ],
                    [
                        'q' => "Will it fit my dietary needs?",
                        'a' => "Vital Boost is vegan, gluten-free, non-dairy and sugar-free..."
                    ]
                ]
            ],
            [
                'category' => 'Live Sessions',
                'questions' => [
                    [
                        'q' => "When are the live Zoom sessions held?",
                        'a' => "Live sessions are held monthly and recorded..."
                    ],
                    [
                        'q' => "Can I ask questions during live sessions?",
                        'a' => "Yes! Live Q&A is available for all members..."
                    ],
                    [
                        'q' => "What if I miss a live session?",
                        'a' => "All live sessions are recorded and uploaded within 24 hours..."
                    ]
                ]
            ],
            [
                'category' => 'Technical Support',
                'questions' => [
                    [
                        'q' => "I'm having trouble accessing my account. What should I do?",
                        'a' => "Try resetting your password or contact support@livinglonger.com..."
                    ],
                    [
                        'q' => "How do I access the member dashboard?",
                        'a' => "After login, you will be redirected to your dashboard..."
                    ],
                    [
                        'q' => "Can I access content on mobile devices?",
                        'a' => "Yes! The platform is fully responsive..."
                    ]
                ]
            ],
            [
                'category' => 'Collaborators',
                'questions' => [
                    [
                        'q' => "Who are the collaborators?",
                        'a' => "World-class health practitioners and physicians..."
                    ],
                    [
                        'q' => "Can I become a collaborator?",
                        'a' => "Visit the Contact page and submit your details..."
                    ]
                ]
            ],
        ];
        @endphp
        {{-- FAQ SECTION --}}
        <section class="py-20 bg-gray-50">
            <div class="max-w-4xl mx-auto px-6 space-y-10">

                @foreach ($faqs as $section)

                    <div class="bg-white shadow-md rounded-xl border " >
                        <div class="px-6 py-4 border-b flex items-center">
                            <div class="w-2 h-8 bg-gradient-to-b from-primary to-orange-500 rounded-full mr-3"></div>
                            <h3 class="text-xl font-bold">{{ $section['category'] }}</h3>
                        </div>

                        <div class="p-6">
                            <x-ui.accordion :items="$section['questions']" />
                           
                        </div>
                    </div>


                    {{-- <x-card :title="$section['category']">
                        <x-ui.accordion :items="$section['questions']" />
                    </x-card> --}}
                @endforeach

            </div>
        </section>


        {{-- CTA SECTION --}}
        <x-ui.cta-section 
                icon="mail"
                align="center"
                title="Still Have Questions?"
                subtitle="Can't find the answer you're looking for? Our support team is here to help."
                
                :buttons="[
                    ['route' => 'contact',   'label' => 'Contact Support', 'variant' => 'outline', 'icon' => 'send'],
                    ['href' => '/help-center', 'label' => 'Visit Help Center', 'variant' => 'outline', 'icon' => 'headset'],
                ]"
            /> 

    </main>
 
</div>

@endsection
