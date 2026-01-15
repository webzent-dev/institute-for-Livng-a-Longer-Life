
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
                    {{-- <div class="border-2 hover:border-primary transition-all shadow-soft hover:shadow-medium rounded-xl"> --}}
                    <div class="card hover:border-primary">
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

  
   @php
    $user = auth()->user();
@endphp
@if(session('success'))
    <div 
        id="toast-success"
        class="fixed top-5 right-5 bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg z-50"
    >
        {{ session('success') }}
    </div>

    <script>
        setTimeout(() => {
            document.getElementById('toast-success').remove();
        }, 3000);
    </script>
@endif

@if(session('error'))
    <div class="fixed top-5 right-5 bg-red-600 text-white px-6 py-3 rounded-lg shadow-lg z-50">
        {{ session('error') }}
    </div>
@endif
<form id="collabForm" method="POST" action="{{ route('become.collaborator.store') }}" class="space-y-6">
    @csrf

    <!-- First & Last Name -->
    <div class="grid md:grid-cols-2 gap-6">
        <div class="space-y-2">
            <label class="font-medium">First Name *</label>
            <x-form.input
                name="first_name"
                placeholder="John"
                :value="old('first_name', $user?->first_name)"
            />
        </div>

        <div class="space-y-2">
            <label class="font-medium">Last Name *</label>
            <x-form.input
                name="last_name"
                placeholder="Doe"
                :value="old('last_name', $user?->last_name)"
            />
        </div>
    </div>

    <!-- Email & Phone -->
    <div class="grid md:grid-cols-2 gap-6">
        <div class="space-y-2">
            <label class="font-medium">Email Address *</label>
            <x-form.input
                type="email"
                name="email"
                placeholder="john@example.com"
                :value="old('email', $user?->email)"
                
            />
        </div>

        <div class="space-y-2">
            <label class="font-medium">Phone Number</label>
            <x-form.input
                type="tel"
                name="phone"
                placeholder="+1-555-123-4567"
                :value="old('phone', $user?->phone)"
            />
        </div>
    </div>

      <div class="grid md:grid-cols-2 gap-6">
        <div class="space-y-2">
            <label class="font-medium">Password *</label>
            <x-form.input
                type="password"
                name="password"
                placeholder="Enter your password"
            />
        </div>

        <div class="space-y-2">
            <label class="font-medium">Confirm Password *</label>
            <x-form.input
                type="password"
                name="password_confirmation"
                placeholder="Confirm your password"
            />
        </div>
    </div>

    <!-- Specialty -->
    <div class="space-y-2">
        <label class="font-medium">Specialty / Area of Expertise *</label>
        <x-form.input
            name="Specialty"
            :value="old('Specialty')"
        />
    </div>

    <!-- Credentials & Experience -->
    <div class="grid md:grid-cols-2 gap-6">
        <div class="space-y-2">
            <label class="font-medium">Professional Credentials *</label>
            <x-form.input
                name="professional_credentials"
                :value="old('professional_credentials')"
            />
        </div>

        <div class="space-y-2">
            <label class="font-medium">Years of Experience *</label>
            <x-form.input
                type="number"
                name="experience"
                :value="old('experience')"
            />
        </div>
    </div>

    <!-- Organization & Website -->
    <div class="grid md:grid-cols-2 gap-6">
        <div class="space-y-2">
            <label class="font-medium">Practice / Organization *</label>
            <x-form.input
                name="organization"
                :value="old('organization')"
            />
        </div>

        <div class="space-y-2">
            <label class="font-medium">Website (Optional)</label>
            <x-form.input
                type="url"
                name="website"
                :value="old('website')"
            />
        </div>
    </div>

    <!-- Description -->
    <div class="space-y-2">
        <label class="font-medium">Why do you want to become a collaborator? *</label>
        <x-form.textarea
            name="collaborator_massge"
            rows="4"
            placeholder="Describe your motivation and goals..."
            :value="old('collaborator_massge')"
        />
    </div>

    <!-- Submit -->
    <x-button-use type="submit" full="true" class="btn-hero py-3">
        Submit Application
    </x-button-use>
</form>


{{-- Success & Error --}}
<div id="successMsg" class="hidden mb-4 p-3 bg-green-100 text-green-700 rounded"></div>
<div id="errorList" class="mb-4 text-red-700 text-sm"></div>




            </x-card>
        </div>
    </div>
</section>

    <script>
$('#collabForm').on('submit', function(e) {
    e.preventDefault();
    console.log('Form submission prevented (jQuery).');
});
<script>
document.getElementById('collabForm').addEventListener('submit', async function (event) {
    event.preventDefault(); // Stop normal submit

    let form = event.target;
    let formData = new FormData(form);

    // UI Reset
    document.getElementById('successMsg').classList.add('hidden');
    document.getElementById('errorList').innerHTML = '';

    // Send AJAX
    const response = await fetch(form.action, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        },
        body: formData
    });

    const result = await response.json();

    if (response.ok) {
        // success
        document.getElementById('successMsg').textContent = result.message;
        document.getElementById('successMsg').classList.remove('hidden');
        form.reset();
    } else {
        // validation errors
        if (result.errors) {
            Object.values(result.errors).forEach(error => {
                let p = document.createElement('p');
                p.textContent = error;
                document.getElementById('errorList').appendChild(p);
            });
        }
    }
});
</script>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
$(function () {
    $('#collabForm').on('submit', function (e) {

        let password = $('input[name="password"]').val();
        let confirmPassword = $('input[name="password_confirmation"]').val();
        let valid = true;

        $('.password-error').remove();

        if (!password) {
            valid = false;
            $('input[name="password"]').after(
                '<span class="password-error text-red-500 text-sm">Password is required</span>'
            );
        } else if (password.length < 8) {
            valid = false;
            $('input[name="password"]').after(
                '<span class="password-error text-red-500 text-sm">Minimum 8 characters required</span>'
            );
        }

        if (!confirmPassword) {
            valid = false;
            $('input[name="password_confirmation"]').after(
                '<span class="password-error text-red-500 text-sm">Confirm password is required</span>'
            );
        } else if (password !== confirmPassword) {
            valid = false;
            $('input[name="password_confirmation"]').after(
                '<span class="password-error text-red-500 text-sm">Passwords do not match</span>'
            );
        }

        if (!valid) {
            e.preventDefault();
        }
    });
});
</script>

      
@endsection  


 