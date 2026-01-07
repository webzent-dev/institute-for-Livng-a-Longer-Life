@extends('front.layouts.app')

@section('content')
<div class="min-h-screen flex flex-col">
    

    <main class="flex-1">

        {{-- Hero Section --}}
        <section class="gradient-subtle py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-4xl lg:text-6xl font-bold text-foreground mb-6">
                    Get in Touch
                </h1>
                <p class="text-xl text-muted-foreground max-w-3xl mx-auto">
                    Have questions about our programs, membership, or collaborations? 
                    We're here to help you on your wellness journey.
                </p>
            </div>
        </section>
   


       
        <section class=" py-20 bg-background">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid lg:grid-cols-3 gap-8">

                     
                    <div class="lg:col-span-1 space-y-6">

                        <x-card class="shadow-medium">
                            <x-card-header>
                                <x-card-title>Contact Information</x-card-title>
                            </x-card-header>

                            <x-card-content class="space-y-6">
                                
                             
                                
                                <div class="flex items-start space-x-4">
                                    <div class="w-12 h-12 rounded-lg gradient-primary flex items-center justify-center flex-shrink-0">
                                        <i data-lucide="mail" class="h-6 w-6 text-primary-foreground"></i>
                                    </div>
                                    {{-- Email --}}
                                    <div>
                                        <h3 class="font-semibold text-foreground mb-1">Email</h3>
                                        <a href="mailto:info@instituteforlivinglonger.com" class="text-muted-foreground hover:text-primary transition-colors block">
                                            info@instituteforlivinglonger.com
                                        </a>
                                    </div>
                                </div>

                             
                                <div class="flex items-start space-x-4">
                                    <div class="w-12 h-12 rounded-lg gradient-primary flex items-center justify-center flex-shrink-0">
                                       
                                        <i data-lucide="map-pin" class="h-6 w-6 text-primary-foreground"></i>
                                    </div>

                                    <div>
                                        <h3 class="font-semibold text-foreground mb-1">Locations</h3>
                                        <a href="https://maps.app.goo.gl/1cXGaXLE86aCyT2p7" target="_blank" rel="noopener noreferrer" class="  ">
                                        <p class="text-muted-foreground mb-3 hover:text-primary transition-colors block">
                                            580 Park Avenue Suite 1E<br>
                                            New York, NY 10065
                                        </p>
                                        </a>
                                         <a href="https://maps.app.goo.gl/BtRX2FRtfRZTyxdY6" target="_blank" rel="noopener noreferrer" class=" ">
                                        <p class="text-muted-foreground hover:text-primary transition-colors block">
                                            3103 Route 28<br>
                                            Shokan, NY 12481
                                        </p>
                                        </a>
                                    </div>
                                </div>

                            </x-card-content>
                        </x-card>

                        
                        <x-card class="shadow-medium bg-gradient-to-br from-primary/10 to-accent/10 border-2 border-primary/20">
                            <x-card-content class="p-6">
                                <h3 class="font-semibold text-foreground mb-2">
                                    Interested in Collaborating?
                                </h3>
                                <p class="text-muted-foreground text-sm mb-4">
                                    If you're a health professional interested in joining our network 
                                    of collaborators, please mention it in your message.
                                </p>
                            </x-card-content>
                        </x-card>

                    </div>

                    
                    <div class="lg:col-span-2">
                        <x-card class="shadow-medium">
                            
                            <x-card-header>
                                <x-card-title class="text-2xl">Send Us a Message</x-card-title>
                                <p class="text-muted-foreground">
                                    Fill out the form below and we'll get back to you within 24 hours
                                </p>
                            </x-card-header>

                            <x-card-content>

   <form method="POST" action="{{ route('contact.store') }}" class="space-y-6">
    @csrf

    {{-- GLOBAL SUCCESS MESSAGE --}}
   @if (session('success'))
    <p class="text-green-600 text-center text-xl font-semibold">
        {{ session('success') }}
    </p>
@endif
    <div class="grid md:grid-cols-2 gap-6">
        <div class="space-y-2">
            <label class="font-medium">First Name *</label>
            <x-form.input
                type="text"
                name="first_name"
                placeholder="John"
                value="{{ old('first_name') }}"
                required
            />
            @error('first_name')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-2">
            <label class="font-medium">Last Name *</label>
            <x-form.input
                type="text"
                name="last_name"
                placeholder="Doe"
                value="{{ old('last_name') }}"
                required
            />
            @error('last_name')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="space-y-2">
        <label class="font-medium">Email Address *</label>
        <x-form.input
            type="email"
            name="email"
            placeholder="john@example.com"
            value="{{ old('email') }}"
            required
        />
        @error('email')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror
    </div>

    <div class="space-y-2">
    <label class="font-medium" for="phone">Phone Number</label>
    <input
        type="tel"
        id="phone"
        name="phone"
        value="{{ old('phone') }}"
        class="w-full rounded-md border border-gray-300 px-3 py-2 focus:border-primary focus:ring focus:ring-primary/30"
        placeholder="(555) 123-4567"
    />
    @error('phone')
        <p class="text-red-500 text-sm">{{ $message }}</p>
    @enderror
</div>

    <div class="space-y-2">
        <label class="font-medium">Subject *</label>
        <x-form.input
            type="text"
            name="subject"
            value="{{ old('subject') }}"
            required
        />
        @error('subject')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror
    </div>

  <div class="space-y-2">
    <label class="font-medium" for="description">Message *</label>
    
    <textarea 
        id="description" 
        name="description" 
        rows="4" 
        class="w-full rounded-md border border-gray-300 px-3 py-2 focus:border-primary focus:ring focus:ring-primary/30" 
        
    >{{ old('description') }}</textarea>

    @error('description')
        <p class="text-red-500 text-sm">{{ $message }}</p>
    @enderror
</div>

    <div class="grid grid-cols-1 gap-2">
        <x-button-use
            type="submit"
            full="true"
            class="btn-hero lg py-3 flex items-center justify-center gap-2">
            <i data-lucide="send" class="w-5 h-5"></i>
            Send Message
        </x-button-use>
    </div>
</form>




    </div>
</x-card-content>


                        </x-card>
                    </div>

                </div>
            </div>
        </section>
 
         
                
                <x-maps-grid />

            {{-- FAQ Section k --}}

            <x-ui.cta-section 
                icon="view"
                align="center"
                title="Looking for Quick Answers?"
                subtitle="Check out our frequently asked questions or explore our resources"
                
                :buttons="[
                    ['route' => 'faq.index',   'label' => 'View FAQs', 'variant' => 'outline', 'icon' => 'badge-question-mark'],
                    ['href' => '/help-center', 'label' => 'Visit Help Center', 'variant' => 'outline', 'icon' => 'headset'],
                ]"
            /> 

 


    </main>
 

</div>



@endsection



