
@extends('front.layouts.app')

@section('content')
<main class="flex-1  font-jakarta">
    <!-- Hero Section -->
    <section class="relative gradient-subtle py-20  overflow-hidden bg-stone-50">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
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
            <a href="#" class="btn-hero w-full sm:w-auto font-semibold  px-5 py-3 rounded-md  flex items-center justify-center bg-emerald-500 hover:bg-orange-600 text-white">
              Join The Community
              <i data-lucide="arrow-right" class="ml-2 w-5 h-5"></i>
            </a>
            <a href="#" class="btn-outline w-full sm:w-auto flex items-center justify-center font-semibold px-5 py-3 rounded-md border-emerald-500 border-2 hover:bg-orange-600  hover:text-white hover:border-orange-600 ">
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
    <section class="py-20 bg-card bg-white ">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
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
            <div class="card-benefit  bg-white  transition-all duration-300 p-6 rounded-xl shadow hover:border-emerald-500 hover:border-[1px]">
              <div class="w-14 h-14 rounded-md gradient-primary flex items-center justify-center mb-4 bg-emerald-500 hover:bg-orange-600">
                <i data-lucide="Play" class="w-7 h-7 text-white"></i>
              </div>
              <h3 class="text-xl font-semibold mb-2">Bite-Sized Lessons</h3>
              <p class="text-muted-foreground">Pre-recorded video lectures designed to fit your schedule</p>
            </div>

            <div class="card-benefit  bg-white  transition-all duration-300 p-6 rounded-xl shadow hover:border-emerald-500 hover:border-[1px]">
              <div class="w-14 h-14 rounded-md gradient-primary flex items-center justify-center mb-4  bg-emerald-500 hover:bg-orange-600">
                <i data-lucide="Users" class="w-7 h-7 text-white"></i>
              </div>
              <h3 class="text-xl font-semibold mb-2">Live Q&A Sessions</h3>
              <p class="text-muted-foreground">Monthly Zoom classes with cutting-edge speakers</p>
            </div>

            <div class="card-benefit  bg-white  transition-all duration-300 p-6 rounded-xl shadow hover:border-emerald-500 hover:border-[1px]">
              <div class="w-14 h-14 rounded-md gradient-primary flex items-center justify-center mb-4  bg-emerald-500 hover:bg-orange-600">
                <i data-lucide="Award" class="w-7 h-7 text-white"></i>
              </div>
              <h3 class="text-xl font-semibold mb-2">Expert Guidance</h3>
              <p class="text-muted-foreground">Learn from Dr. Zeines and our network of collaborators</p>
            </div>

            <div class="card-benefit  bg-white  transition-all duration-300 p-6 rounded-xl shadow hover:border-emerald-500 hover:border-[1px]">
              <div class="w-14 h-14 rounded-md gradient-primary flex items-center justify-center mb-4  bg-emerald-500 hover:bg-orange-600">
                <i data-lucide="Heart" class="w-7 h-7 text-white"></i>
              </div>
              <h3 class="text-xl font-semibold mb-2">Community Support</h3>
              <p class="text-muted-foreground">Connect with like-minded members on your wellness journey</p>
            </div>
          </div>  
          
          </div>
           
          

          <div class="aspect-[4/3] rounded-lg overflow-hidden shadow-strong">
            <img src="./assets/healthy-lifestyle.jpg" alt="Healthy active lifestyle" class="w-full h-full object-cover" />
          </div>


        </div>
      </div>
    </section>


{{--  --}}
   <!-- Membership Section -->
    <section class="py-20 gradient-subtle bg-stone-50">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
          <h2 class="text-3xl lg:text-5xl font-bold mb-4">Choose Your Membership</h2>
          <p class="text-xl  max-w-3xl mx-auto">
            Select the plan that best fits your wellness goals
          </p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
          <!-- Basic Plan -->
          <div class="border-2 shadow p-8 rounded-xl space-y-6 ">
            <h3 class="text-2xl font-bold">Essential</h3>
            <p class="text-5xl font-bold">$19<span class="text-gray-500 text-lg">/Month</span></p>
            

              <ul class="space-y-3">
                  <li class="flex items-start">
                       <i data-lucide="check-circle" class="w-5 h-5 text-emerald-500 mr-2"></i>
                      <span class="text-muted-foreground">Access to all video lessons</span>
                  </li>

                  <li class="flex items-start">
                     <i data-lucide="check-circle" class="w-5 h-5 text-emerald-500 mr-2"></i>
                      <span class="text-muted-foreground">Monthly live Q&A sessions</span>
                  </li>

                  <li class="flex items-start">
                     <i data-lucide="check-circle" class="w-5 h-5 text-emerald-500 mr-2"></i>
                      <span class="text-muted-foreground">Community forum access</span>
                  </li>

                  <li class="flex items-start">
                      <i data-lucide="check-circle" class="w-5 h-5 text-emerald-500 mr-2"></i>
                      <span class="text-muted-foreground">10% discount on store products</span>
                  </li>
              </ul> 
            <a href="#" class="btn-outline w-full sm:w-auto flex items-center justify-center font-semibold px-5 py-3 rounded-md border-emerald-500 border-2 hover:bg-orange-600  hover:text-white hover:border-orange-600 ">
              
              Get Started<i data-lucide="arrow-right" class="mr-2 w-5 h-5"></i>
            </a>
          </div>

          <!-- Popular Plan -->
          <div class="border-4 space-y-6 border-emerald-500 shadow-xl p-8 rounded-xl scale-105 relative ">
            <span class="absolute -top-4 left-1/2 -translate-x-1/2 bg-orange-500 text-white px-4 py-1 rounded-full text-sm font-semibold">
              Most Popular
            </span>
            <h3 class="text-2xl font-bold">Premium</h3>
            <p class="text-5xl font-bold">$39<span class="text-gray-500 text-lg">/Month</span></p>
             <ul class="space-y-3">
                  <li class="flex items-start">
                       <i data-lucide="check-circle" class="w-5 h-5 text-emerald-500 mr-2"></i>
                      <span class="text-muted-foreground">Everything in Essential</span>
                  </li>

                  <li class="flex items-start">
                     <i data-lucide="check-circle" class="w-5 h-5 text-emerald-500 mr-2"></i>
                      <span class="text-muted-foreground">Exclusive collaborator content</span>
                  </li>

                  <li class="flex items-start">
                     <i data-lucide="check-circle" class="w-5 h-5 text-emerald-500 mr-2"></i>
                      <span class="text-muted-foreground">20% discount on store products</span>
                  </li>

                  <li class="flex items-start">
                      <i data-lucide="check-circle" class="w-5 h-5 text-emerald-500 mr-2"></i>
                      <span class="text-muted-foreground">Priority support</span>
                  </li>
                  <li class="flex items-start">
                      <i data-lucide="check-circle" class="w-5 h-5 text-emerald-500 mr-2"></i>
                      <span class="text-muted-foreground">Early access to new content <span>
                  </li>
              </ul> 
            <a href="#" class="btn-outline w-full sm:w-auto flex items-center justify-center font-semibold px-5 py-3 rounded-md border-emerald-500 border-2 hover:bg-orange-600  hover:text-white hover:border-orange-600 ">
              
              Get Started<i data-lucide="arrow-right" class="mr-2 w-5 h-5"></i>

            </a>
          </div>

          <!-- Elite Plan -->
          <div class="border-2 shadow p-8 rounded-xl space-y-6 ">
            <h3 class="text-2xl font-bold">Elite</h3>
            <p class="text-5xl font-bold">$59<span class="text-gray-500 text-lg">/Month</span></p>
             <ul class="space-y-3">
                  <li class="flex items-start">
                       <i data-lucide="check-circle" class="w-5 h-5 text-emerald-500 mr-2"></i>
                      <span class="text-muted-foreground">Everything in Premium</span>
                  </li>

                  <li class="flex items-start">
                     <i data-lucide="check-circle" class="w-5 h-5 text-emerald-500 mr-2"></i>
                      <span class="text-muted-foreground">One-on-one consultation session</span>
                  </li>

                  <li class="flex items-start">
                     <i data-lucide="check-circle" class="w-5 h-5 text-emerald-500 mr-2"></i>
                      <span class="text-muted-foreground">30% discount on store products</span>
                  </li>

                  <li class="flex items-start">
                      <i data-lucide="check-circle" class="w-5 h-5 text-emerald-500 mr-2"></i>
                      <span class="text-muted-foreground">VIP access to events</span>
                  </li>
                  <li class="flex items-start">
                      <i data-lucide="check-circle" class="w-5 h-5 text-emerald-500 mr-2"></i>
                      <span class="text-muted-foreground">Personalized wellness plan <span>
                  </li>
              </ul> 
            <a href="#" class="btn-outline w-full sm:w-auto flex items-center justify-center font-semibold px-5 py-3 rounded-md border-emerald-500 border-2 hover:bg-emerald-600  hover:text-white ">
              
              Get Started<i data-lucide="arrow-right" class="mr-2 w-5 h-5"></i>

            </a>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20   text-center bg-white">
      <div class="max-w-4xl mx-auto px-4 py-12 sm:px-6 lg:px-8 bg-gray-50 ">
        <h2 class="text-3xl lg:text-5xl font-bold mb-6">
          Looking Forward to Seeing You There
        </h2>
        <p class="text-2xl  mb-4">In health and happiness,</p>
        <p class="text-2xl font-semibold text-emerald-500  mb-8 ">Victor Zeines</p>
        {{-- <a href="#" class="btn-hero inline-flex items-center justify-center"> --}}
          <div class="max-w-64 mx-auto">
              <a href="#" class=" sm:w-auto flex items-center justify-center font-semibold px-5 py-3 rounded-md bg-emerald-500 border-2 hover:bg-orange-600  text-white  ">
          Join Our Community
          <i data-lucide="arrow-right" class="ml-2 w-5 h-5"></i>
        </a>
          </div>

          
      </div>
    </section>


 
 
</main>
@endsection

