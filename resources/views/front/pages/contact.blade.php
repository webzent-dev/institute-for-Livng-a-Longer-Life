@extends('front.layouts.app')
@section('content')
<div class="min-h-screen flex flex-col">
    <main class="flex-1 ">
        {{-- Hero Section --}}
        <section class="gradient-subtle py-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-4xl lg:text-4xl font-bold text-foreground mb-6">Get in Touch</h1>
                <p class="text-xl text-muted-foreground max-w-3xl mx-auto">
                    Have questions about our programs, membership, or collaborations?
                    We're here to help you on your wellness journey.
                </p>
            </div>
        </section>

        {{-- Contact Information --}}
        <section class="py-5 bg-background ">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="grid md:grid-cols-3 gap-8">
                        <div class="md:col-span-1 space-y-6 ">
                            <x-card class="shadow-medium hover:border-muted-foreground/20">
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
                                            @if(!empty($siteSettingData->contact_email))
                                                <a href="mailto:{{$siteSettingData->contact_email}}" class="text-muted-foreground hover:text-primary transition-colors block">{{$siteSettingData->contact_email}}</a>
                                            @else
                                                <a href="mailto:info@instituteforlivinglonger.com" class="text-muted-foreground hover:text-primary transition-colors block">info@instituteforlivinglonger.com</a>
                                            @endif    
                                        </div>
                                    </div>
                                    @if(count($locations)>0)
                                    <div class="flex items-start space-x-4">
                                        <div class="w-12 h-12 rounded-lg gradient-primary flex items-center justify-center flex-shrink-0">
                                            <i data-lucide="map-pin" class="h-6 w-6 text-primary-foreground"></i>
                                        </div>
                                        <div>
                                            <h3 class="font-semibold text-foreground mb-1">Locations</h3>
                                            @foreach($locations as $index => $location)
                                                <a href="https://maps.google.com/?q={{ $location->latitude }},{{ $location->longitude }}" target="_blank" rel="noopener noreferrer" class="  ">
                                                    <p class="text-muted-foreground mb-3 hover:text-primary transition-colors block">
                                                        {{ $location->address }}<br>
                                                        {{ $location->city }}, {{ $location->state }} {{ $location->zip }}
                                                    </p>
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endif
                                </x-card-content>
                            </x-card>
                            <x-card class="ml-0 mr-4 shadow-medium bg-gradient-to-br from-primary/10 to-accent/10 border-2 border-primary/20 hover:border-muted-foreground/20">
                                <x-card-content class="p-6">
                                    <h3 class="font-semibold text-foreground mb-2">Interested in Collaborating?</h3>
                                    <p class="text-muted-foreground text-sm mb-4">
                                        If you're a health professional interested in joining our network
                                        of collaborators, please mention it in your message.
                                    </p>
                                </x-card-content>
                            </x-card>
                        </div>

                        <div class="md:col-span-2">
                            <x-card class="shadow-medium hover:border-muted-foreground/20 ">
                                <x-card-header>
                                    <x-card-title class="text-2xl">Ask Anything You Want To Know</x-card-title>
                                    <p class="text-muted-foreground text-[16px]">
                                        Fill out the form below and we'll get back to you within 24 hours
                                    </p>
                                </x-card-header>
                                <x-card-content>
                                    <form method="POST" action="{{ route('contact.store') }}" class="space-y-6">
                                        @csrf
                                        {{-- GLOBAL SUCCESS MESSAGE --}}
                                        <!-- @if (session('success'))
                                            <p class="text-green-600 text-center text-xl font-semibold">
                                                {{ session('success') }}
                                            </p>
                                        @endif -->
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
                                                class="w-full rounded-md border border-gray-300 px-3 py-2 focus:border-primary focus:ring focus:ring-primary/30 phone_number"
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
                                            <textarea id="description" name="description" rows="4" class="w-full rounded-md border border-gray-300 px-3 py-2 focus:border-primary focus:ring focus:ring-primary/30">{{ old('description') }}</textarea>
                                            @error('description')
                                                <p class="text-red-500 text-sm">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="grid grid-cols-1 gap-2">
                                            <x-button-use type="submit" full="true" class="btn-hero lg py-3 flex items-center justify-center gap-2">
                                                <i data-lucide="send" class="w-5 h-5"></i>
                                                Send Message
                                            </x-button-use>
                                        </div>
                                    </form>
                                </x-card-content>
                            </x-card>
                        </div>
                    </div>
                </div>
        </section>

        {{-- Dynamic Locations Map Section   --}}
        <x-maps-grid />

        {{-- FAQ Section k --}}
        <section class="py-20 gradient-subtle">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="rounded-lg border bg-card text-card-foreground shadow-sm shadow-strong">
                    <div class="p-8 text-center">
                        <h2 class="text-3xl font-bold text-foreground mb-4">Looking for Quick Answers?</h2>
                        <p class="text-muted-foreground mb-6">Check out our frequently asked questions or explore our resources</p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <a href="{{ url('/faq') }}">
                                <button class="inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 border-2 border-primary bg-background text-primary hover:bg-primary hover:text-primary-foreground h-11 rounded-md px-8">View FAQ</button>
                            </a>
                            <a href="{{ url('/help-center') }}">
                                <button class="inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 border-2 border-primary bg-background text-primary hover:bg-primary hover:text-primary-foreground h-11 rounded-md px-8">Help Center</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</div>
<script>
//Add validation for phone number input to allow only digits and maximum lengeth of 10 characters
$('.phone_number').on('input', function() {
    let value = $(this).val();
    // Remove any non-digit characters
    value = value.replace(/[^0-9]/g, '');
    // Limit to 10 characters
    value = value.substring(0, 10);
    $(this).val(value);
});
</script>
@endsection