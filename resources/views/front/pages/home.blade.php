@extends('front.layouts.app')
@section('content')
    <main class="flex-1 font-jakarta">
        <section class="section-base relative overflow-hidden mb-0">
            <div class="container-base ">
                <div class="flex flex-col sm:flex-row justify-center gap-4 ">
                    <div class="left-0 -mt-16">
                        <img src="{{ asset('assets/leaf-1.webp') }}"
                            class="absolute left-6   w-20 opacity-80 hidden md:block" />
                        <img src="{{ asset('assets/leaf-2.webp') }}"
                            class="absolute left-6   w-20 opacity-80 hidden md:block" />
                    </div>
                    <div class="right-0 -mt-16 ">
                        <img src="{{ asset('assets/leaf-1.webp') }}"
                            class="absolute right-6 w-20 opacity-80 hidden md:block mt-2" />
                        <img src="{{ asset('assets/leaf-2.webp') }}"
                            class="absolute right-6 w-20 opacity-80 hidden md:block" />
                    </div>
                </div>


                @if (isset($homePageContent) && !empty($homePageContent->page_content))
                    {!! $homePageContent->page_content !!}
                @endif




                <!-- Membership Section -->
                @if (count($memberships) > 0)
                    <section class="section-base py-20 gradient-subtle bg-stone-50">
                        <div class="contatiner-base max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                            <div class="text-center mb-16">
                                <h2 class="text-3xl lg:text-5xl font-bold mb-4">Choose Your Membership</h2>
                                <p class="text-xl text-muted-foreground  max-w-3xl mx-auto">Select the plan that best fits
                                    your wellness goals</p>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 max-w-7xl mx-auto">
                                @foreach ($memberships as $plan)
                                    @php
                                        $isPopular = $plan->popular == 'yes' ? true : false;
                                        $isCurrentPlan = false;
                                        if (Auth::check()) {
                                            $isCurrentPlan = auth()->user()->plan_id == $plan->id ? true : false;
                                        }

                                        $membership_features = explode(',', $plan->membership_features);
                                        $membership_benefits = explode(',', $plan->membership_benefits);
                                    @endphp
                                    <div class="relative" x-data="{ selectedPlan: { name: '', price: '', period: '' } }">
                                        <div
                                            class="flex flex-col {{ $isPopular ? 'border-primary border-4 shadow-strong md:scale-105 bg-card' : 'border-2 shadow-medium bg-card' }} rounded-2xl  ">
                                            @if ($isPopular)
                                                <div class="relative">
                                                    <div class="absolute -top-4 left-1/2 -translate-x-1/2 z-10">
                                                        <span
                                                            class="gradient-accent px-6 py-2 rounded-full text-sm font-semibold text-accent-foreground shadow-medium inline-flex items-center">
                                                            <i data-lucide="star" class="w-4 h-4  flex-shrink-0 mr-2 "></i>
                                                            Most Popular
                                                        </span>
                                                    </div>

                                                    @if ($isCurrentPlan)
                                                        <div
                                                            class=" w-10 h-10 absolute -top-5 -right-6  -translate-x-1/2 z-10">
                                                            <span
                                                                class="w-10 h-10  gradient-accent px-6 py-2 rounded-full text-sm font-semibold text-accent-foreground shadow-medium inline-flex justify-center text-white items-center">
                                                                <i data-lucide="check-check"
                                                                    class="w-4 h-4 font-extrabold flex-shrink-0  "></i>
                                                                {{-- Current Plan --}}
                                                            </span>
                                                        </div>
                                                    @endif
                                                </div>
                                            @endif

                                            <div class="text-center pb-8 pt-12 px-6">
                                                <h3 class="text-2xl font-bold text-foreground mb-2">
                                                    {{ $plan->membership_name }}</h3>
                                                <p class="text-muted-foreground mb-6">{{ $plan->membership_description }}
                                                </p>
                                                <div class="flex items-baseline justify-center">
                                                    <span
                                                        class="text-3xl text-primary font-bold ">${{ $plan->membership_price }}</span>
                                                    <span
                                                        class="text-muted-foreground ml-2">/{{ $plan->membership_period }}</span>
                                                </div>
                                            </div>

                                            <div class=" border-gray-200 flex-1 flex flex-col px-6 pb-6">
                                                <div class="space-y-6 flex-1">
                                                    <div>
                                                        <h4 class="font-semibold text-foreground mb-3 mt-1">Features</h4>
                                                        <ul class="space-y-3">
                                                            @foreach ($membership_features as $feature)
                                                                <li class="flex items-start">
                                                                    <i data-lucide="check-circle"
                                                                        class="w-5 h-5 text-primary flex-shrink-0 mr-2 "></i>
                                                                    <span
                                                                        class="text-muted-foreground text-sm">{{ ltrim($feature) }}</span>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>

                                                    {{-- Benefits part --}}
                                                    @if (isset($membership_benefits) && is_array($membership_benefits))
                                                        <div>
                                                            <h4 class="font-semibold text-foreground mb-3">Benefits</h4>
                                                            <ul class="space-y-2">
                                                                @foreach ($membership_benefits as $benefit)
                                                                    <li class="flex items-center">
                                                                        <div
                                                                            class="w-1.5 h-1.5 rounded-full bg-primary mr-2">
                                                                        </div>
                                                                        <span
                                                                            class="text-muted-foreground text-sm">{{ ltrim($benefit) }}</span>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    @endif
                                                </div>
                                                <button type="button"
                                                    class="{{ $isPopular ? 'gradient-primary text-primary-foreground shadow-medium font-semibold' : 'border-2 border-primary text-primary' }} {{ $isCurrentPlan ? 'opacity-50 cursor-not-allowed' : 'hover:opacity-90' }} h-11 rounded-md px-8 w-full mt-8"
                                                    command="show-modal" commandfor="dialog"
                                                    data-plan-id="{{ $plan->id }}"
                                                    data-plan-name="{{ $plan->membership_name }}"
                                                    data-plan-price="{{ $plan->membership_price }}"
                                                    data-plan-period="{{ $plan->membership_period }}"
                                                    onclick="openPlanModal(this)"
                                                    @if ($isCurrentPlan) disabled @endif>
                                                    @if ($isCurrentPlan)
                                                        Current Plan
                                                    @else
                                                        Get Started
                                                    @endif
                                                </button>
                                                <x-membership-card :plan="$plan" />
                                @endforeach
                            </div>
                        </div>
                    </section>
                @endif

               
                <section class="section-base py-20 bg-primary relative overflow-hidden">
                    {{-- Background pattern --}}
                    <div class="container-base absolute inset-0 opacity-10">
                        <div
                            class="absolute top-0 left-0 w-96 h-96 bg-background rounded-full -translate-x-1/2 -translate-y-1/2">
                        </div>
                        <div
                            class="absolute bottom-0 right-0 w-96 h-96 bg-background rounded-full translate-x-1/2 translate-y-1/2">
                        </div>
                    </div>
                    <div class="container mx-auto px-4 lg:px-8 relative z-10">
                        <h2 class="font-display text-3xl md:text-4xl font-bold text-primary-foreground text-center mb-12">
                            Get a quick look inside</h2>
                        {{-- Video placeholder --}}
                        <div class="max-w-6xl mx-auto mb-16">
                            <a href="https://player.vimeo.com/video/817940268?h=5e53563" target="_blank"
                                class="relative aspect-video bg-foreground/20 rounded-2xl overflow-hidden group cursor-pointer shadow-strong">
                                <div class="relative aspect-video bg-cover bg-center rounded-2xl overflow-hidden group"
                                    style="background-image: url('{{ asset('assets/home-bg.png') }}');">
                                    <div
                                        class="absolute inset-0 bg-gradient-to-br from-primary-dark/80 to-primary/80 flex items-center justify-center">
                                        <div
                                            class="w-20 h-20 rounded-full bg-primary-foreground flex items-center justify-center group-hover:scale-110 transition-transform shadow-lg">
                                            <i data-lucide="play" class="h-8 w-8 text-primary ml-1"></i>
                                        </div>
                                    </div>
                                    <div class="absolute bottom-4 left-4 right-4 text-primary-foreground z-10">
                                        <p class="text-sm font-medium">DR. VICTOR ZEINES</p>
                                        <p class="text-lg font-display">HEALTHY LIFE VIDEO</p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        {{-- Features --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                            <div class="text-center">
                                <div
                                    class="w-16 h-16 mx-auto mb-4 rounded-full bg-primary-foreground/10 flex items-center justify-center">
                                    {{-- dynamic icon blade component --}}
                                    <i data-lucide="message-Circle" class="h-8 w-8 text-primary-foreground"> </i>
                                </div>
                                <h3 class="font-display text-xl font-semibold text-primary-foreground mb-3">
                                    Ask Us Anything
                                </h3>
                                <p class="text-primary-foreground/80 text-sm leading-relaxed">
                                    Take part in our exclusive monthly Q&A sessions, where you can ask your questions
                                    directly and receive clear, personal answers about the course.
                                </p>
                            </div>

                            <div class="text-center">
                                <div
                                    class="w-16 h-16 mx-auto mb-4 rounded-full bg-primary-foreground/10 flex items-center justify-center">
                                    {{-- dynamic icon blade component --}}
                                    <i data-lucide="sparkles" class="h-8 w-8 text-primary-foreground"> </i>
                                </div>
                                <h3 class="font-display text-xl font-semibold text-primary-foreground mb-3">
                                    Fresh Expert Perspectives
                                </h3>
                                <p class="text-primary-foreground/80 text-sm leading-relaxed">
                                    Each session welcomes a guest speaker who adds fresh, expert insight, making every class
                                    richer and more valuable.
                                </p>
                            </div>

                            <div class="text-center">
                                <div
                                    class="w-16 h-16 mx-auto mb-4 rounded-full bg-primary-foreground/10 flex items-center justify-center">
                                    {{-- dynamic icon blade component --}}
                                    <i data-lucide="users" class="h-8 w-8 text-primary-foreground"> </i>
                                </div>
                                <h3 class="font-display text-xl font-semibold text-primary-foreground mb-3">
                                    Connect & Grow Together
                                </h3>
                                <p class="text-primary-foreground/80 text-sm leading-relaxed">
                                    These sessions go beyond learning. They are a chance to connect with fellow members and
                                    enjoy the journey toward better health together.
                                </p>
                            </div>

                        </div>

                        {{-- Signature --}}
                        <div class="text-center mt-16">
                            <p class="text-primary-foreground/70 uppercase tracking-wider text-sm mb-2">
                                We hope to see you soon
                            </p>
                            <p class="font-display text-2xl text-primary-foreground italic">
                                Wishing you health and happiness, Victor Zeines
                            </p>
                        </div>
                    </div>
                </section>

                {{-- Join Our Community Section --}}
                <section class="section-base py-20 bg-background">
                    <div class="container-base mx-auto px-4 lg:px-8">
                        {{-- Main Heading --}}
                        <h2 class="heading-1 mb-4 ">
                            Join a Community Built for a <span class="text-accent">Longer, <br> Healthier Life</span>
                        </h2>
                        <div class="max-w-4xl mx-auto">
                            {{-- Exclusive Insights --}}
                            <div class="text-center my-12">
                                <h3 class="text-primary text-xl font-semibold uppercase tracking-wider mb-2">Comprehensive
                                    Health Information</h3>
                                <p class="text-muted-foreground">Get exclusive information about many different body
                                    functions and various health aspects.</p>
                            </div>

                            {{-- Learn at Your Own Pace --}}
                            <div class="text-center mb-8">
                                <h3 class="text-primary font-semibold text-xl uppercase tracking-wider mb-2">Flexible
                                    Learning</h3>
                                <p class="text-muted-foreground">
                                    The lectures are divided into small, manageable parts that make learning easy.
                                </p>
                            </div>

                            {{-- Always Updated --}}
                            <div class="text-center mb-10">
                                <h3 class="text-primary text-xl font-semibold uppercase tracking-wider mb-2">Regular
                                    Updates</h3>
                                <p class="text-muted-foreground mb-6">
                                    Our regularly updated lectures by guest speakers will keep you up-to-date about new
                                    health trends. Some of our lecture topics include:
                                </p>
                            </div>

                            {{-- Topics Grid --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-12">

                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 rounded-full gradient-primary flex items-center justify-center flex-shrink-0">
                                        <i data-lucide="circle-check-big" class="h-5 w-5 text-primary-foreground"></i>
                                    </div>
                                    <span class="text-foreground">Periodontal Disease Explained</span>
                                </div>

                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 rounded-full gradient-primary flex items-center justify-center flex-shrink-0">
                                        <i data-lucide="circle-check-big" class="h-5 w-5 text-primary-foreground"></i>
                                    </div>
                                    <span class="text-foreground">Herbology Basics</span>
                                </div>


                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 rounded-full gradient-primary flex items-center justify-center flex-shrink-0">
                                        <i data-lucide="circle-check-big" class="h-5 w-5 text-primary-foreground"></i>
                                    </div>
                                    <span class="text-foreground">Root Canal Safety Facts</span>
                                </div>

                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 rounded-full gradient-primary flex items-center justify-center flex-shrink-0">
                                        <i data-lucide="circle-check-big" class="h-5 w-5 text-primary-foreground"></i>
                                    </div>
                                    <span class="text-foreground">
                                        Preventing and Understanding Cancer</span>
                                </div>


                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 rounded-full gradient-primary flex items-center justify-center flex-shrink-0">
                                        <i data-lucide="circle-check-big" class="h-5 w-5 text-primary-foreground"></i>
                                    </div>
                                    <span class="text-foreground">Why Acupuncture Works</span>
                                </div>

                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 rounded-full gradient-primary flex items-center justify-center flex-shrink-0">
                                        <i data-lucide="circle-check-big" class="h-5 w-5 text-primary-foreground"></i>
                                    </div>
                                    <span class="text-foreground">Understanding Immunology</span>
                                </div>

                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 rounded-full gradient-primary flex items-center justify-center flex-shrink-0">
                                        <i data-lucide="circle-check-big" class="h-5 w-5 text-primary-foreground"></i>
                                    </div>
                                    <span class="text-foreground">Kinesiology Explained</span>
                                </div>

                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 rounded-full gradient-primary flex items-center justify-center flex-shrink-0">
                                        <i data-lucide="circle-check-big" class="h-5 w-5 text-primary-foreground"></i>
                                    </div>
                                    <span class="text-foreground">Managing Mercury Toxicity</span>
                                </div>

                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 rounded-full gradient-primary flex items-center justify-center flex-shrink-0">
                                        <i data-lucide="circle-check-big" class="h-5 w-5 text-primary-foreground"></i>
                                    </div>
                                    <span class="text-foreground">Magnet Therapy and Essential Oils</span>
                                </div>


                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 rounded-full gradient-primary flex items-center justify-center flex-shrink-0">
                                        <i data-lucide="circle-check-big" class="h-5 w-5 text-primary-foreground"></i>
                                    </div>
                                    <span class="text-foreground">Fluoride Exposure Awareness</span>
                                </div>

                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 rounded-full gradient-primary flex items-center justify-center flex-shrink-0">
                                        <i data-lucide="circle-check-big" class="h-5 w-5 text-primary-foreground"></i>
                                    </div>
                                    <span class="text-foreground">Lifelong Nutrition</span>
                                </div>

                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 rounded-full gradient-primary flex items-center justify-center flex-shrink-0">
                                        <i data-lucide="circle-check-big" class="h-5 w-5 text-primary-foreground"></i>
                                    </div>
                                    <span class="text-foreground">Understanding TMJ Disorders</span>
                                </div>

                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 rounded-full gradient-primary flex items-center justify-center flex-shrink-0">
                                        <i data-lucide="circle-check-big" class="h-5 w-5 text-primary-foreground"></i>
                                    </div>
                                    <span class="text-foreground">Color Therapy Explained</span>
                                </div>

                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 rounded-full gradient-primary flex items-center justify-center flex-shrink-0">
                                        <i data-lucide="circle-check-big" class="h-5 w-5 text-primary-foreground"></i>
                                    </div>
                                    <span class="text-foreground">Stem Cell Science and Possibilities</span>
                                </div>

                            </div>

                            {{-- Description --}}
                            <p class="text-center text-muted-foreground mb-10">
                                Curious to learn more? Join our community and get full access to our complete collection of videos and resources, all built to support your path to better health.
                            </p>

                            {{-- CTAs --}}
                            <div class="flex flex-col sm:flex-row justify-center gap-4">
                                <x-button-use href="{{ url('/membership') }}" label="Join Us Today"
                                    variant="outline" icon="send" />
                                <x-button-use href="{{ url('/intro-videos') }}" label="Preview Our Videos"
                                    variant="outline" icon="tv-minimal" />
                            </div>
                        </div>
                    </div>
                </section>


        {{-- newsletter section --}}
        <section class="py-10 bg-primary relative overflow-hidden">
            <img src="{{ asset('assets/leaf-1.webp') }}" alt=""
                class="absolute top-10 left-10 w-32 opacity-20 animate-float" />
            <img src="{{ asset('assets/leaf-1.webp') }}" alt=""
                class="absolute bottom-10 right-10 w-32 opacity-20 scale-x-[-1] animate-float-delayed" />
            <div class="container mx-auto px-4 lg:px-8 relative z-10">
                <div class="max-w-4xl mx-auto text-center">
                    <!-- <span class="text-primary-foreground/70 text-sm uppercase tracking-wider">.. Subscription ..</span> -->
                    <h2 class="heading-2 text-white my-5">Stay Connected With Us </h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div class="text-center">
                            <div class="w-12 h-12 mx-auto mb-3 rounded-full bg-white/20 flex items-center justify-center">
                                <i data-lucide="star" class="w-6 h-6 text-white"></i>
                            </div>
                            <h3 class="text-white font-semibold text-lg mb-2">Insider Access</h3>
                            <p class="text-primary-foreground/80 text-sm leading-relaxed px-2">Get Gain access to insightful articles, the latest breakthroughs, and expert advice you won't find anywhere else.</p>
                        </div>
                        <div class="text-center">
                            <div class="w-12 h-12 mx-auto mb-3 rounded-full bg-white/20 flex items-center justify-center">
                                <i data-lucide="heart" class="w-6 h-6 text-white"></i>
                            </div>
                            <h3 class="text-white font-semibold text-lg mb-2">Tips Made for You</h3>
                            <p class="text-primary-foreground/80 text-sm leading-relaxed px-2">Get wellness tips tailored specifically to your own health journey.</p>
                        </div>
                        <div class="text-center">
                            <div class="w-12 h-12 mx-auto mb-3 rounded-full bg-white/20 flex items-center justify-center">
                                <i data-lucide="users" class="w-6 h-6 text-white"></i>
                            </div>
                            <h3 class="text-white font-semibold text-lg mb-2">A Community That Cares</h3>
                            <p class="text-primary-foreground/80 text-sm leading-relaxed px-2">Join a community that encourages and motivates one another toward a healthier, happier life.</p>
                        </div>
                    </div>
                    <form action="{{ route('newsletter.subscribe') }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <x-form.input type="text" name="firstName" placeholder="Enter First Name*"
                                    autocomplete="off" required />
                                @error('firstName')
                                    <p class="text-red-800 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <x-form.input type="text" name="lastName" placeholder="Enter Last Name*"
                                    autocomplete="off" required />
                                @error('lastName')
                                    <p class="text-red-800 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div>
                            <x-form.input type="email" name="email" placeholder="Enter Email*" autocomplete="off"
                                required />
                        </div>
                        <div>
                            <x-form.select name="gender" :options="[
                                ['value' => 'not', 'label' => 'Not specified'],
                                ['value' => 'woman', 'label' => 'Woman'],
                                ['value' => 'man', 'label' => 'Man'],
                            ]" required />
                            @error('gender')
                                <p class="text-red-800 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex justify-center mt-12">
                            <x-button-use type="submit" variant="outline" size="lg"
                                class="bg-accent hover:bg-gray-600 shadow-md text-white">Subscribe</x-button-use>
                        </div>
                    </form>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="section-base py-10   text-center bg-white">
            <div class="container-base max-w-4xl mx-auto px-4 py-12 sm:px-6 lg:px-8 bg-gray-50 ">
                <h2 class="text-3xl lg:text-5xl font-bold mb-6">Excited To Have You With Us </h2>
                <p class="text-2xl  mb-4">With health and happiness,</p>
                <p class="text-2xl font-semibold text-emerald-500  mb-8 ">Victor Zeines</p>
                <div class="max-w-64 mx-auto">
                    <a href="{{ url('/membership') }}"
                        class=" sm:w-auto flex items-center justify-center font-semibold px-5 py-3 rounded-md bg-emerald-500 border-2 hover:bg-orange-600  text-white  ">
                        Become a Member <i data-lucide="arrow-right" class="ml-2 w-5 h-5"></i>
                    </a>
                </div>
            </div>
        </section>
    </main>
@endsection
