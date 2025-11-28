 @extends('front.layouts.app')  


@section('content')
<div class="min-h-screen flex flex-col">
   
  <main class="flex-1">
    {{-- Hero Section --}}
    <section class="gradient-subtle py-20">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
          <div>
            <h1 class="text-4xl lg:text-6xl font-bold text-foreground mb-6">
              Membership Plans
            </h1>
            <p class="text-xl text-muted-foreground mb-8">
              Choose the membership level that best supports your health and wellness goals.
              All plans include access to our comprehensive video library and supportive community.
            </p>

            <div class="aspect-video rounded-2xl overflow-hidden shadow-strong">
              <img src="./assets/expert-guidance.jpg" alt="Professional wellness expert providing personalized guidance" class="w-full h-full object-cover" />
            </div>
          </div>

          <div class="relative">
            <div class="aspect-video rounded-2xl overflow-hidden shadow-strong">
              <img src="./assets/membership-benefits.jpg" alt="Comprehensive membership benefits for holistic wellness" class="w-full h-full object-cover" />
            </div>
          </div>
        </div>
      </div>
    </section>

    {{-- Membership Cards --}}

        @php
                $plans = [
                            [
                                'name' => 'Essential Membership',
                                'price' => '$29',
                                'period' => '/Month',
                                
                                'description' => 'Perfect for those starting their wellness journey',
                                'features' => [
                                    'Access to all foundational video lessons',
                                    'Monthly live Q&A sessions with Dr. Zeines',
                                    'Community forum access',
                                    '10% discount on all store products',
                                    'Monthly wellness newsletter',
                                    'Mobile app access'
                                ],
                                'benefits' => [
                                    'Cancel anytime',
                                    'Instant access upon signup',
                                    'New content added monthly'
                                ]
                            ],
                            [
                                'name' => 'Premium Membership',
                                'price' => '$79',
                                'period' => '/Month',
                                
                                'description' => 'Our most popular plan for dedicated health enthusiasts',
                                'popular' => true,
                                'features' => [
                                    'Everything in Essential',
                                    'Access to exclusive collaborator content',
                                    'All courses from partner doctors',
                                    '20% discount on all store products',
                                    'Priority customer support',
                                    'Early access to new courses and products',
                                    'Quarterly personalized health check-ins',
                                    'Advanced nutrition guides'
                                ],
                                'benefits' => [
                                    'Best value for money',
                                    'Access to premium collaborator stores',
                                    'VIP community status'
                                ]
                            ],
                            [
                                'name' => 'Elite Membership',
                                'price' => '$149',
                                'period' => '/Month',
                                
                                'description' => 'Complete wellness transformation with personalized care',
                                'features' => [
                                    'Everything in Premium',
                                    'One-on-one monthly consultation with Dr. Zeines or collaborators',
                                    '30% discount on all store products',
                                    'VIP access to all live events and workshops',
                                    'Personalized wellness and nutrition plan',
                                    'Direct messaging with health experts',
                                    'Custom supplement recommendations',
                                    'Annual comprehensive health assessment'
                                ],
                                'benefits' => [
                                    'Highest level of personalized care',
                                    'Direct expert access',
                                    'Priority event registration'
                                ]
                            ]
                        ];
        @endphp

    <section class="py-20 bg-background">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-3 gap-8">


            @foreach($plans as $plan)
                <x-membership-card :plan="$plan" />
            @endforeach

           
              
        </div>
 
        <div class="mt-20 text-center">
          <div class="max-w-4xl mx-auto shadow-medium bg-card rounded-2xl">
            <div class="p-8">
              <h3 class="text-2xl font-bold text-foreground mb-8">
                All Memberships Include
              </h3>
              <div class="grid md:grid-cols-2 gap-4 text-left justify-self-center mt-12">
                @php
                $items = [
                    ['Secure online member portal'],
                    ['Mobile and desktop access'],
                    ['Downloadable resources and guides'],
                    ['Community forum and support']
                ];
                @endphp

                @foreach($items as [$text])
                <div class="flex items-start">
                  <i data-lucide="check-circle" class="w-5 h-5 text-primary flex-shrink-0 mr-2 "></i>
                  <span class="text-muted-foreground">{{ $text }}</span>
                </div>
                @endforeach
              </div>

              <p class="text-sm text-muted-foreground mt-6">
                All plans are billed monthly. You can upgrade, downgrade, or cancel at any time.
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

 
</div>

 

@endsection

 
 

 
