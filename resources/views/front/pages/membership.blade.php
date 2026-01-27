 @extends('front.layouts.app')


@section('content')
<div class="min-h-screen flex flex-col">

  <main class="flex-1">
    {{-- Hero Section --}}
    <section class="gradient-subtle py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid items-center gap-12 lg:grid-cols-2">
            <div>
                <h1 class="mb-6 text-4xl font-bold text-foreground lg:text-6xl text-left">
                Membership Plans
                </h1>

                <p class="mb-8 text-xl text-muted-foreground">
                Choose the membership level that best supports your health and wellness
                goals. All plans include access to our comprehensive video library and
                supportive community.
                </p>

                <div class="aspect-video overflow-hidden rounded-2xl shadow-strong">
                <img
                    src="/assets/expert-guidance.jpg"
                    alt="Professional wellness expert providing personalized guidance"
                    class="h-full w-full object-cover"
                />
                </div>
            </div>

            <div class="relative">
                <div class="aspect-video overflow-hidden rounded-2xl shadow-strong">
                <img
                    src="/assets/membership-benefits.jpg"
                    alt="Comprehensive membership benefits for holistic wellness"
                    class="h-full w-full object-cover"
                />
                </div>
            </div>
            </div>
        </div>
    </section>




    {{-- Membership Card Arrays --}}

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

    <section class="py-20 bg-background">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-3 gap-8">


            @foreach($plans as $plan)
                <x-membership-card :plan="$plan" />
            @endforeach



        </div>

        <div class="mt-16 text-center">
            <div
                class="max-w-4xl mx-auto rounded-lg border bg-card text-card-foreground shadow-sm shadow-medium"
            >
                <div class="p-8">
                        <h3 class="mb-4 text-2xl font-bold text-foreground">
                            All Memberships Include
                        </h3>

                        <div class="grid gap-4 text-left md:grid-cols-2">

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
                                    <i data-lucide="circle-check" class="w-5 h-5 text-primary flex-shrink-0 mr-2 "></i>
                                    <span class="text-muted-foreground">{{ $text }}</span>
                                    </div>
                                @endforeach

                        </div>


                </div>

                <p class="mt-6 text-sm text-muted-foreground">
                    All plans are billed monthly. You can upgrade, downgrade, or cancel at any
                    time.
                </p>
                </div>
            </div>
        </div>


        {{-- <div class="mt-20 text-center">
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
        </div> --}}

      </div>
    </section>
  </main>

</div>



@endsection





