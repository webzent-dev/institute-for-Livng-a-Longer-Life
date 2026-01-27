
@extends('front.layouts.app')
@section('content')
<main class="flex-1  font-jakarta">
          <section class="section-base relative overflow-hidden mb-0">
              <div class="container-base ">

                          <div class="flex flex-col sm:flex-row justify-center gap-4 ">
                              <div class="left-0 -mt-16">
                                  <img src="{{asset('assets/leaf-1.webp')}}"
                                      class="absolute left-6   w-20 opacity-80 hidden md:block" />
                                  <img src="{{asset('assets/leaf-2.webp')}}"
                                      class="absolute left-6   w-20 opacity-80 hidden md:block" />
                              </div>

                              <div class="right-0 -mt-16 ">
                                  <img src="{{asset('assets/leaf-1.webp')}}"
                                      class="absolute right-6 w-20 opacity-80 hidden md:block mt-2" />
                                  <img src="{{asset('assets/leaf-2.webp')}}"
                                      class="absolute right-6 w-20 opacity-80 hidden md:block" />
                              </div>
                          </div>
                      <div class="max-w-6xl mx-auto px-6 text-center  pb-12">

                          <!-- Heading -->

                          <x-badge>WELCOME TO</x-badge>
                          <h1 class=" text-3xl md:text-4xl lg:text-5xl font-semibold tracking-wide">
                          <br class="hidden sm:block">
                          <span class="font-bold">THE INSTITUTE FOR LIVING A LONGER LIFE</span>
                          </h1>

                          <p class="mt-4 text-gray-600 max-w-2xl mx-auto">
                          Congratulations! This is your first step to living a longer healthier life.
                          </p>

                          <!-- CTA -->

                          <div class="flex flex-col sm:flex-row justify-center gap-4 mt-8">

                              <x-button-use href="{{ route('membership') }}" label="Join The Community" variant="primary" icon="send" />
                              <x-button-use href="{{ route('intro-videos') }}" label="View Intro Videos" variant="outline" icon="video" />

                          </div>

                          <!-- Main Illustration -->
                          <div class="relative mt-12 flex justify-center mx-0 px-0">
                                <div class="left-0 mt-10">
                                  <img src="{{asset('assets/ingredients_shape1.png')}}"
                                      class="absolute left-6 w-20 opacity-80 hidden md:block mt-2" />
                                  <img src="{{asset('assets/ingredients_shape1.png')}}"
                                      class="absolute left-16 w-20 opacity-80 hidden md:block" />
                              </div>
                                <div class="right-0 mt-10">
                                  <img src="{{asset('assets/ingredients_shape1.png')}}"
                                      class="absolute right-6 w-20 opacity-80 hidden md:block mt-2" />
                                  <img src="{{asset('assets/ingredients_shape1.png')}}"
                                      class="absolute right-16 w-20 opacity-80 hidden md:block" />
                              </div>

                          <img src="{{asset('assets/wellness.webp')}}"
                              alt="Wellness Illustration"
                              class="max-w-full w-[720px]  " />

                          <!-- Left Bowl -->
                          <img src="{{asset('assets/ingredients_shap.webp')}}"
                              class="absolute left-10 bottom-10 w-28 hidden md:block" />

                          <!-- Right Bowl -->
                          <img src="{{asset('assets/ingredients_shap.webp')}}"
                              class="absolute right-10 bottom-10 w-28 hidden md:block" />
                          </div>

                      </div>
              </div>


          </section>

      <!-- ================= WELLNESS INFO SECTION ================= -->
      <section class="py-12 bg-[#f8faf8]">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="heading-2">
              Your Personalized Journey to Wellness
            </h2>
              @php
                    $arr = [
                        [
                            'icon' => 'circle-check-big',
                            'title' => 'Bite Sized Lessons',
                        ],
                        [
                            'icon' => 'circle-check-big',
                            'title' => 'Live Q&A',
                        ],
                        [
                            'icon' => 'circle-check-big',
                            'title' => 'Pre-Recorded Video Lectures',
                        ],
                        [
                            'icon' => 'circle-check-big',
                            'title' => 'Monthly Zoom Classes With Cutting Edge Speakers',
                        ],
                    ];
              @endphp

              <div class="grid md:grid-cols-2 gap-8 max-w-3xl mx-auto my-8">
                    <!-- Card -->
                  @foreach ($arr as $item)
                    <div class="flex flex-col items-center  gap-3 card p-4">
                      <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center shrink-0">
                        <i data-lucide="{{ $item['icon'] }}" class="w-5 h-5 text-primary"></i>
                      </div>

                      <h3 class=" font-semibold text-foreground self-center ">
                        {{ $item['title'] }}
                      </h3>
                    </div>
                  @endforeach
              </div>
              <div class="flex justify-center">
                   <x-button-use href="{{ route('about-dr-zeines') }}" label="Learn More" variant="outline" icon="arrow-right" class=" " />
              </div>



         </div>


        </section>


    <!-- Hero Section -->
    <section class="section-base relative gradient-subtle py-20  overflow-hidden bg-stone-50">
      <div class="container-base max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class=" grid lg:grid-cols-2 gap-12 items-center">
        <div class="space-y-8 ">
          <span class="text-sm font-semibold tracking-wide uppercase text-primary text-emerald-500">
            Welcome to the Institute for Living Longer
          </span>
          <h1 class="text-4xl lg:text-6xl font-bold leading-tight text-teal-950">
            Your First Step to a Longer, Healthier Life
          </h1>
          <p class="text-xl text-muted-foreground text-neutral-500">
            Congratulations! Join our community and discover evidence-based practices,
            expert guidance, and a supportive network dedicated to your wellness journey.
          </p>
          <div class="flex flex-col sm:flex-row gap-4">
            <a href="/membership" class="btn-hero w-full sm:w-auto font-semibold  px-5 py-3 rounded-md  flex items-center justify-center bg-emerald-500 hover:bg-orange-600 text-white">
              Join The Community
              <i data-lucide="arrow-right" class="ml-2 w-5 h-5"></i>
            </a>
            <a href="/intro-videos" class="btn-outline w-full sm:w-auto flex items-center justify-center font-semibold px-5 py-3 rounded-md border-emerald-500 border-2 hover:bg-orange-600  hover:text-white hover:border-orange-600 ">
              <i data-lucide="play" class="mr-2 w-5 h-5"></i>
              Watch Intro Videos
            </a>
          </div>
        </div>

        <div class="aspect-video rounded-lg overflow-hidden shadow-strong">
          <img src="./assets/community-wellness.jpg" alt="Wellness and longevity" class="w-full h-full object-cover" />
        </div>
      </div>
      </div>


    </section>

    <!-- Benefits Section -->
    <section class="section-base py-20 bg-card bg-white ">
      <div class="container-base max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8">
          <h2 class="text-3xl lg:text-5xl font-bold text-foreground mb-4">
            Your Personalized Journey to Wellness
          </h2>
          <p class="text-xl text-muted-foreground max-w-3xl mx-auto">
            Experience a comprehensive approach to health and longevity
          </p>
        </div>

        <div class="grid lg:grid-cols-2 gap-12 items-center mb-16">
           <div className="space-y-8">
              <div class="grid sm:grid-cols-2 gap-6">
            <!-- Benefit Card -->
            @php
            $benefits = [
              [
                'icon' => 'Play',
                'title' => 'Bite-Sized Lessons',
                'description' => 'Pre-recorded video lectures designed to fit your schedule',
              ],
              [
                'icon' => 'Users',
                'title' => 'Live Q&A Sessions',
                'description' => 'Monthly Zoom classes with cutting-edge speakers',
              ],
              [
                'icon' => 'Award',
                'title' => 'Expert Guidance',
                'description' => 'Learn from Dr. Zeines and our network of collaborators',
              ],
              [
                'icon' => 'Heart',
                'title' => 'Community Support',
                'description' => 'Connect with like-minded members on your wellness journey',
              ],
            ];
            @endphp

            @foreach($benefits as $benefit)
              <div class="card-benefit  bg-white  transition-all duration-300 p-6 rounded-xl shadow hover:border-emerald-500 hover:border-[1px]">
                <div class="w-14 h-14 rounded-md gradient-primary flex items-center justify-center mb-4  bg-emerald-500 hover:bg-orange-600">
                  <i data-lucide="{{ $benefit['icon'] }}" class="w-7 h-7 text-white"></i>
                </div>
                <h3 class="text-xl font-semibold mb-2">{{ $benefit['title'] }}</h3>
                <p class="text-muted-foreground">{{ $benefit['description'] }}</p>
              </div>
            @endforeach
          </div>

          </div>



          <div class="aspect-[4/3] rounded-lg overflow-hidden shadow-strong">
            <img src="./assets/healthy-lifestyle.jpg" alt="Healthy active lifestyle" class="w-full h-full object-cover" />
          </div>


        </div>
      </div>
    </section>



      <!-- Membership Section -->
    <section class="section-base py-20 gradient-subtle bg-stone-50">
      <div class="contatiner-base max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
          <h2 class="text-3xl lg:text-5xl font-bold mb-4">Choose Your Membership</h2>
          <p class="text-xl text-muted-foreground  max-w-3xl mx-auto">
            Select the plan that best fits your wellness goals
          </p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">

        @php
          $plans = [
            [
              'name' => 'Standard Membership',
              'price' => '$183',
              'period' => '/Year',
              'url' => '/membership',
              'description' => 'Access to all video lessons',
              'features' => [
                'Access to 1 pre-recorded lecture a month',
                '$10 Discount on Vital Boost',
                'Monthly Live Zoom Session',
                '3 free guides',
              ],
            ],
            [
              'name' => 'Premium Membership',
              'price' => '$387',
              'period' => '/Year',
              'url' => '/membership',
              'popular' => true,
              'description' => 'Everything in Essential',
              'features' => [
                'Access to all pre-recorded lectures for a year',
                '$15 Discount on Vital Boost',
                'Monthly Live Zoom Session',
                '3 free books',
                '10 free guides',
              ],
            ],
            [
              'name' => 'Lifetime Membership',
              'price' => '$799',
              'period' => 'Lifetime',
              'url' => '/membership',
              'description' => 'Everything in Premium',
              'features' => [
                'Access to all pre-recorded lectures for lifetime',
                '$20 Discount on Vital Boost',
                'Monthly Live Zoom Session',
                '3 free books, 10 free guides',
                '50% off on consultations',
              ],
            ],
          ];
        @endphp
           @foreach($plans as $plan)
                <x-membership-card :plan="$plan" />
            @endforeach


        </div>
      </div>
    </section>
      {{-- Intro Videos --}}
      @php
          $features =
                      [
                        [
                          'icon' => 'message-Circle',
                          'title' => 'Interactive Live Q&A',
                          'description' => 'Each month, gain exclusive access to our live Q&A sessions. It\'s your opportunity to ask questions and get direct answers about the course.',
                        ],
                        [
                          'icon' => 'sparkles',
                          'title' => 'Special Guest Insights',
                          'description' => 'Enjoy special guest speakers who bring fresh, expert perspective to each session, enhancing your learning experience.',
                        ],
                        [
                          'icon' => 'users',
                          'title' => 'Fun & Community',
                          'description' => 'These sessions aren\'t just educational - they\'re fun! Connect with like-minded members and share in a journey of health and learning.',
                        ],
                      ];
           $lectureTopics =
                            [
                                  "Understanding Periodontal Disease",
                                  "The Basics of Herbology",
                                  "The Truth about Root Canal Toxicity",
                                  "Cancer Awareness and Prevention",
                                  "Benefits of Acupuncture",
                                  "Immunology Explained",
                                  "The Science of Kinesiology",
                                  "Dealing with Mercury Toxicity",
                                  "The Power of Magnets and Essential Oils",
                                  "The Impact of Fluoride Toxicity",
                                  "Nutrition for Life",
                                  "TMJ Disorders",
                                  "Exploring Color Therapy",
                                  "The Future of STEM Cells",
                            ];
            $benefits1 =
                            [
                              [
                                'icon' => 'leaf',
                                'title' => 'A Superfood Symphony',
                                'description' => 'Packed with organic spirulina, barley grass, wheat grass, spinach, and more, Vital Boost is a symphony of superfoods.',
                              ],
                              [
                                'icon' => 'sparkles',
                                'title' => 'Easy to Use',
                                'description' => 'Just mix it into your smoothie or juice for a tasty, nutritious start to your day.',
                              ],
                              [
                                'icon' => 'pill',
                                'title' => 'More Than a Multivitamin',
                                'description' => 'Say goodbye to your old multivitamins. Vital Boost offers a more complete and potent nutritional profile.',
                              ],
                              [
                                'icon' => 'award',
                                'title' => 'Doctor-Approved',
                                'description' => 'Developed with insights from years of medical experience and research.',
                              ],
                            ];

                          $testimonials1 =
                                          [
                                                [
                                                    'name' => 'Sarah M.',
                                                    'quote' => 'Videos really helped me a lot..',
                                                    'image' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=400&h=400&fit=crop',
                                                ],
                                                [
                                                    'name' => 'John D.',
                                                    'quote' => 'Loved the videos..',
                                                    'image' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=400&h=400&fit=crop',
                                                ],
                                                [
                                                    'name' => 'Emily R.',
                                                    'quote' => 'It changed my life..',
                                                    'image' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=400&h=400&fit=crop',
                                                ],
                                          ];
      @endphp
        <section class="section-base py-20 bg-primary relative overflow-hidden">

                {{-- Background pattern --}}
                <div class="container-base absolute inset-0 opacity-10">
                    <div class="absolute top-0 left-0 w-96 h-96 bg-background rounded-full -translate-x-1/2 -translate-y-1/2"></div>
                    <div class="absolute bottom-0 right-0 w-96 h-96 bg-background rounded-full translate-x-1/2 translate-y-1/2"></div>
                </div>

                <div class="container mx-auto px-4 lg:px-8 relative z-10">
                    <h2 class="font-display text-3xl md:text-4xl font-bold text-primary-foreground text-center mb-12">
                        Have a look at our intro video
                    </h2>

                    {{-- Video placeholder --}}
                    <div class="max-w-3xl mx-auto mb-16">
                        {{-- <div class="relative aspect-video bg-foreground/20 rounded-2xl overflow-hidden group cursor-pointer shadow-glow"> --}}
                          <a href="https://player.vimeo.com/video/817940268?h=5e53563" target="_blank" class="relative aspect-video bg-foreground/20 rounded-2xl overflow-hidden group cursor-pointer shadow-strong">
                          <div class="relative aspect-video bg-cover bg-center rounded-2xl overflow-hidden group" style="background-image: url('{{ asset('assets/home-bg.png') }}');">
                            <div class="absolute inset-0 bg-gradient-to-br from-primary-dark/80 to-primary/80 flex items-center justify-center">
                                <div class="w-20 h-20 rounded-full bg-primary-foreground flex items-center justify-center group-hover:scale-110 transition-transform shadow-lg">
                                    <i data-lucide="play" class="h-8 w-8 text-primary ml-1"></i>
                                </div>
                            </div>
                            <div class="absolute bottom-4 left-4 right-4 text-primary-foreground ">
                                <p class="text-sm font-medium">DR. VICTOR ZEINES</p>
                                <p class="text-lg font-display">HEALTHY LIFE VIDEO</p>
                            </div>
                        </div>
                      </a>

                    </div>

                    {{-- Features --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        @foreach ($features as $feature)
                            <div class="text-center">
                                <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-primary-foreground/10 flex items-center justify-center">
                                    {{-- dynamic icon blade component --}}
                                    <i data-lucide="{{ $feature['icon'] }}" class="h-8 w-8 text-primary-foreground" > </i>
                                </div>
                                <h3 class="font-display text-xl font-semibold text-primary-foreground mb-3">
                                    {{ $feature['title'] }}
                                </h3>
                                <p class="text-primary-foreground/80 text-sm leading-relaxed">
                                    {{ $feature['description'] }}
                                </p>
                            </div>
                        @endforeach
                    </div>

                    {{-- Signature --}}
                    <div class="text-center mt-16">
                        <p class="text-primary-foreground/70 uppercase tracking-wider text-sm mb-2">
                            LOOKING FORWARD TO SEEING YOU THERE
                        </p>
                        <p class="font-display text-2xl text-primary-foreground italic">
                            In health and happiness, Victor Zeines
                        </p>
                    </div>
                </div>
        </section>

        {{-- Join Our Community Section --}}
        <section class="section-base py-20 bg-background">
            <div class="container-base mx-auto px-4 lg:px-8">

                {{-- Main Heading --}}
                <h2 class="heading-1 mb-4 ">
                    Join Our Community for <span class="text-accent">Longer <br>Healthier Life</span>
                </h2>

                <div class="max-w-4xl mx-auto">

                    {{-- Exclusive Insights --}}
                    <div class="text-center my-12">
                        <h3 class="text-primary text-xl font-semibold uppercase tracking-wider mb-2">
                            EXCLUSIVE INSIGHTS
                        </h3>
                        <p class="text-muted-foreground">
                            Explore unique content about different body functions and health topics.
                        </p>
                    </div>

                    {{-- Learn at Your Own Pace --}}
                    <div class="text-center mb-8">
                        <h3 class="text-primary font-semibold text-xl uppercase tracking-wider mb-2">
                            LEARN AT YOUR OWN PACE
                        </h3>
                        <p class="text-muted-foreground">
                            Our series of lectures are divided into easy-to-understand segments, allowing you to learn on your schedule.
                        </p>
                    </div>

                    {{-- Always Updated --}}
                    <div class="text-center mb-10">
                        <h3 class="text-primary text-xl font-semibold uppercase tracking-wider mb-2">
                            ALWAYS UPDATED
                        </h3>
                        <p class="text-muted-foreground mb-6">
                            We regularly update our content with new lectures, featuring guest experts, to keep you up-to-date with the latest health trends. Our engaging lecture topics include:
                        </p>
                    </div>

                    {{-- Topics Grid --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-12">
                        @foreach ($lectureTopics as $topic)
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full gradient-primary flex items-center justify-center flex-shrink-0">

                                    <i data-lucide="circle-check-big" class="h-5 w-5 text-primary-foreground"></i>
                                </div>
                                <span class="text-foreground">{{ $topic }}</span>
                            </div>
                        @endforeach
                    </div>

                    {{-- Description --}}
                    <p class="text-center text-muted-foreground mb-10">
                        Ready to learn more? Join our community to access our full range of comprehensive videos and resources, all designed to guide you to a healthier lifestyle.
                    </p>

                    {{-- CTAs --}}
                    <div class="flex flex-col sm:flex-row justify-center gap-4">
                        <x-button-use href="{{ route('membership') }}" label="Join The Community" variant="outline" icon="send" />
                        <x-button-use href="{{ route('intro-videos') }}" label="View Intro Videos" variant="outline" icon="tv-minimal" />

                    </div>

                </div>
            </div>
      </section>


      {{-- vital boost --}}
      <section class="section-base bg-gray-100 bg-background relative overflow-hidden" style="background-image: url('{{ asset('assets/features_product_dots.png')}}')">
            <div class="container-base  ">
              <div class="flex justify-center -mt-16">
                    <span class="text-primary  bg-gray-100 hover:shadow-md px-4 py-2 rounded-full  text-sm font-semibold uppercase tracking-wider">
                          ** Unlock the Power of Vital Boost **
                      </span>

              </div>





              <div class=" mx-auto px-4 lg:px-8" >
                  <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center py-10">

                      {{-- Image --}}
                      <div class="relative" >
                          <img
                              src="{{ asset('product_images/'.$product->image) }}"
                              alt="Vital Boost superfood supplement"
                              class="w-full max-w-md mx-auto"
                          />
                      </div>

                      {{-- Content --}}
                      <div>


                          <h2 class="font-display text-3xl md:text-4xl lg:text-5xl font-bold text-foreground mt-2 mb-6">
                              {{ $product->name}}
                          </h2>

                          <p class="text-muted-foreground mb-8 leading-relaxed">
                                {{ $product->description }}
                          </p>

                          {{-- Benefits list --}}
                          <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-8">
                              @foreach ($benefits1 as $benefit)
                                  <div class="flex items-start gap-3">
                                      <div class="w-10 h-10 rounded-full gradient-primary flex items-center justify-center flex-shrink-0">


                                          <i data-lucide="{{$benefit['icon']}}" class="h-5 w-5 text-primary-foreground" ></i>
                                      </div>

                                      <div>
                                          <h3 class="heading-4 font-semibold text-foreground mb-1">{{ $benefit['title'] }}</h3>
                                          <p class="text-sm text-muted-foreground">{{ $benefit['description'] }}</p>
                                      </div>
                                  </div>
                              @endforeach
                          </div>

                          {{-- Button --}}
                          <div class="flex justify-center ">
                              <x-button-use href="/vital-boost" label="Learn More" variant="primary" icon="arrow-right" class="w-2/3 self-center" />
                          </div>


                      </div>

                  </div>
              </div>

          </div>
      </section>

      {{-- testimonials --}}
        <section class="section-base py-10 bg-gray-200 min">
          <div class="container-base mx-auto px-4 lg:px-8">
                <div class="text-primary text-center mb-16">
                  <h1 class="heading-2">What Members Say</h1>
                </div>
              <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                  @foreach ($testimonials1 as $testimonial)
                      <div class="relative group cursor-pointer">
                          <div class="aspect-video rounded-2xl overflow-hidden bg-foreground/10 relative">

                              {{-- Image --}}
                              <img
                                  src="{{ asset($testimonial['image']) }}"
                                  alt="{{ $testimonial['name'] }}"
                                  class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                              />

                              {{-- Gradient overlay --}}
                              <div class="absolute inset-0 bg-gradient-to-t from-foreground/80 to-transparent"></div>

                              {{-- Play icon on hover --}}
                              <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                  <div class="w-16 h-16 rounded-full bg-primary-foreground flex items-center justify-center shadow-lg">
                                      <i data-lucide="play" class="h-6 w-6 text-primary ml-1"></i>
                                  </div>
                              </div>

                              {{-- Quote text --}}
                              <div class="absolute bottom-4 left-4 right-4">
                                  <p class="text-primary-foreground font-display text-lg uppercase">
                                      {{ $testimonial['quote'] }}
                                  </p>
                              </div>

                          </div>
                      </div>
                  @endforeach

              </div>
          </div>
        </section>

        {{-- newsletter section --}}
        <section class="py-20 bg-primary relative overflow-hidden">

            <img
                src="{{ asset('assets/leaf-1.webp') }}"
                alt=""
                class="absolute top-10 left-10 w-32 opacity-20 animate-float"
            />
            <img
                src="{{ asset('assets/leaf-1.webp') }}"
                alt=""
                class="absolute bottom-10 right-10 w-32 opacity-20 scale-x-[-1] animate-float-delayed"
            />

            <div class="container mx-auto px-4 lg:px-8 relative z-10">
                <div class="max-w-4xl mx-auto text-center">
                    <span class="text-primary-foreground/70 text-sm uppercase tracking-wider">
                        .. Subscription ..
                    </span>
                    <h2 class="heading-2 text-white my-5">
                        Subscribe to Our Newsletter
                    </h2>
                    <div class="w-full flex justify-center">



                    <p class="text-primary-foreground/80 mb-8 leading-relaxed px-2">
                        <strong class="heading-4">Exclusive Content:<br></strong> Get access to insightful articles, breakthroughs, and expert advice not found anywhere else.
                    </p>

                    <p class="text-primary-foreground/80 mb-8 leading-relaxed px-2">
                        <strong class="heading-4">Personalized Tips:<br></strong> Receive tailor-made wellness tips that cater uniquely to your health journey.
                    </p>

                    <p class="text-primary-foreground/80 mb-8 leading-relaxed px-2">
                        <strong class="heading-4">Community Support:<br></strong> Be part of a community that uplifts and motivates each other towards a healthier, happier life.
                    </p>
                    </div>
                    @if(session('success'))
                    <div class="bg-green-100 text-green-700 px-4 py-3 rounded mb-4 text-center">
                        {{ session('success') }}
                    </div>
                @endif
                    <form action="{{ route('newsletter.subscribe') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <x-form.input name="firstName" placeholder="First Name" />
                            {{-- @error('firstName')
                                <p class="text-red-800 text-sm mt-1">{{ $message }}</p>
                            @enderror --}}
                        </div>

                        <div>
                            <x-form.input name="lastName" placeholder="Last Name" />
                            {{-- @error('lastName')
                                <p class="text-red-800 text-sm mt-1">{{ $message }}</p>
                            @enderror --}}
                        </div>
                    </div>

                    <div>
                        <x-form.input name="email" placeholder="Email..." />
                        {{-- @error('email')
                            <p class="text-red-800 text-sm mt-1">{{ $message }}</p>
                        @enderror --}}
                    </div>

                    <div>
                        <x-form.select
                            name="gender"
                            :options="[
                                ['value'=>'not','label'=>'Not specified'],
                                ['value'=>'woman','label'=>'Woman'],
                                ['value'=>'man','label'=>'Man'],
                            ]"
                        />
                        @error('gender')
                            <p class="text-red-800 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-center mt-12">
                        <x-button-use type="submit" variant="outline" size="lg"
                            class="bg-accent hover:bg-gray-600 shadow-md text-white">
                            Subscribe
                        </x-button-use>
                    </div>
                </form>


                </div>
            </div>
        </section>
    <!-- CTA Section -->
    <section class="section-base py-10   text-center bg-white">
          <div class="container-base max-w-4xl mx-auto px-4 py-12 sm:px-6 lg:px-8 bg-gray-50 ">
            <h2 class="text-3xl lg:text-5xl font-bold mb-6">
              Looking Forward to Seeing You There
            </h2>
            <p class="text-2xl  mb-4">In health and happiness,</p>
            <p class="text-2xl font-semibold text-emerald-500  mb-8 ">Victor Zeines</p>
              <div class="max-w-64 mx-auto">
                  <a href="/membership" class=" sm:w-auto flex items-center justify-center font-semibold px-5 py-3 rounded-md bg-emerald-500 border-2 hover:bg-orange-600  text-white  ">
              Join Our Community
              <i data-lucide="arrow-right" class="ml-2 w-5 h-5"></i>
            </a>
              </div>
          </div>
      </section>
</main>
@endsection

