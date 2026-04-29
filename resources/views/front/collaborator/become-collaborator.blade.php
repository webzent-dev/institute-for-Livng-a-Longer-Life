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
<main class="flex-1">
    <section class="gradient-subtle py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl lg:text-6xl font-bold text-foreground mb-6">Become a Collaborator</h1>
            <p class="text-xl text-muted-foreground max-w-3xl mx-auto">
                Join our network of distinguished health professionals and help us empower individuals on their journey to optimal health and longevity.
            </p>
        </div>
    </section>

    <section class="py-10 bg-background">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl lg:text-5xl font-bold text-foreground text-center mb-4">Why Join Our Network?</h2>
            <p class="text-xl text-muted-foreground text-center mb-16 max-w-3xl mx-auto">As a collaborator, you'll gain access to a vibrant community and powerful platform</p>
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($benefits as $b)
                <div class="card hover:border-primary">
                    <div class="p-6 space-y-4">
                        <div class="iconbg w-14 h-14">
                            <i data-lucide="{{$b['icon']}}" class="h-7 w-7 text-primary-foreground" ></i>
                        </div>
                        <h3 class="text-xl font-semibold text-foreground ">{{ $b['title'] }}</h3>
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
                <div class="rounded-lg border bg-card text-card-foreground shadow-sm max-w-4xl mx-auto  ">
                    <x-card-header>
                        <x-card-title class="font-semibold tracking-tight text-3xl">Collaborator Application</x-card-title>
                            <p class="text-muted-foreground">Fill out the form below and we'll review your application within 3-5 business days</p>
                        </x-card-header>
                        @php
                            $user = auth()->user();
                        @endphp

                        <form id="collabForm" method="POST" action="{{ route('become.collaborator.store') }}" class="p-6 pt-0">
                            @csrf
                            <!-- First & Last Name -->
                            <div class="grid md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="font-medium">First Name <span class="required">*</span></label>
                                    <x-form.input name="first_name" id="first_name" placeholder="Enter First Name*" :value="old('first_name', $user?->first_name)" autocomplete="off" required />
                                </div>
                                <div class="space-y-2">
                                    <label class="font-medium">Last Name <span class="required">*</span></label>
                                    <x-form.input name="last_name" id="last_name" placeholder="Enter Last Name*" :value="old('last_name', $user?->last_name)" autocomplete="off" required/>
                                </div>
                            </div>

                            <!-- Email & Phone -->
                            <div class="grid md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="font-medium">Email Address <span class="required">*</span></label>
                                    <x-form.input type="email" name="email" id="email" placeholder="Enter email*" :value="old('email', $user?->email)" autocomplete="off"  required/>
                                </div>
                                <div class="space-y-2">
                                    <label class="font-medium">Phone Number <span class="required">*</span></label>
                                    <x-form.input type="tel" name="phone" id="phone" placeholder="Enter Phone*" :value="old('phone', $user?->phone)" autocomplete="off" required/>
                                </div>
                            </div>

                            <div class="grid md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="font-medium">Password <span class="required">*</span></label>
                                    <x-form.input type="password" name="password" placeholder="Enter your password*" autocomplete="off" required/>
                                </div>
                                <div class="space-y-2">
                                    <label class="font-medium">Confirm Password <span class="required">*</span></label>
                                    <x-form.input type="password" name="password_confirmation" placeholder="Enter Confirm your password*" autocomplete="off" required/>
                                </div>
                            </div>

                            <!-- Specialty -->
                            <div class="space-y-2">
                                <label class="font-medium">Specialty / Area of Expertise <span class="required">*</span></label>
                                <x-form.input name="speciality" :value="old('speciality')" placeholder="Enter speciality(e.g.: Nutrition, Fitness, Mental Health)*" autocomplete="off" required/>
                            </div>

                            <!-- Credentials & Experience -->
                            <div class="grid md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="font-medium">Professional Credentials <span class="required">*</span></label>
                                    <x-form.input name="professional_credentials" :value="old('professional_credentials')" placeholder="Enter Professional Credentials(e.g.: MD, RD, CPT)*" autocomplete="off" required/>
                                </div>
                                <div class="space-y-2">
                                    <label class="font-medium">Years of Experience <span class="required">*</span></label>
                                    <x-form.input type="number" name="experience" :value="old('experience')" placeholder="Enter year of experience*" min="0" autocomplete="off" required/>
                                </div>
                            </div>

                            <!-- Organization & Website -->
                            <div class="grid md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="font-medium">Practice / Organization <span class="required">*</span></label>
                                    <x-form.input name="organization" :value="old('organization')" placeholder="Enter Organization(e.g.: Wellness Clinic)*" autocomplete="off" required/>
                                </div>
                                <div class="space-y-2">
                                    <label class="font-medium">Website (Optional)</label>
                                    <x-form.input type="url" name="website" :value="old('website')" placeholder="Enter your website URL" autocomplete="off"/>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="space-y-2">
                                <label class="font-medium">Why do you want to become a collaborator? <span class="required">*</span></label>
                                <x-form.textarea name="collaborator_message" rows="4" :value="old('collaborator_message')" placeholder="Describe your motivation and goals..." autocomplete="off" required/>
                            </div>

                            <!-- Submit -->
                            <x-button-use type="submit" full="true" class="btn-hero py-3 w-full mt-6">Submit Application</x-button-use>
                        </form>
                        <div id="successMsg" class="hidden mb-4 p-3 bg-green-100 text-green-700 rounded"></div>
                        <div id="errorList" class="mb-4 text-red-700 text-sm"></div>
                    </div>
                </div>
            </div>
        </section>
<!--<script>
   $('#collabForm').on('submit', function(e) {
       e.preventDefault();
       console.log('Form submission prevented (jQuery).');
   });
   
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
   </script>-->
<script>
$('#fld_phone').on('input', function() {
    let value = $(this).val();
    // Remove any non-digit characters
    value = value.replace(/[^0-9]/g, '');
    // Limit to 10 characters
    value = value.substring(0, 10);
    $(this).val(value);
});
</script>
<style>
.required{
   color: red;
 }
</style>
<!-- <script src="{{asset('js/collaborator.js')}}"></script> -->
@endsection