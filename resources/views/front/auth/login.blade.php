@extends('front.layouts.app')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <main class="flex-1 flex items-center justify-center py-12 px-4">
        <div class="rounded-lg border bg-card text-card-foreground shadow-sm w-full max-w-md p-4">
            <div class="flex flex-col space-y-1.5 p-6">
                <h3 class="text-2xl font-semibold leading-none tracking-tight text-center">Member Login</h3>
                <p class="text-sm text-muted-foreground">Sign in to your member account or join our community</p>
            </div>

            <!-- Tabs -->
            <div x-data="{ tab: 'signin' }">
                <!-- Tab Buttons -->
                <!-- <div class="grid grid-cols-2 mb-4 bg-gray-100 rounded-lg">
                    <button class="py-2 flex items-center justify-center" :class="tab === 'signin' ? 'input-base' : ''" @click="tab = 'signin'">
                        <i data-lucide="log-in" class="mr-2 h-5 w-5"></i>Sign In
                    </button>
                    <button class="py-2 flex items-center justify-center" :class="tab === 'signup' ? 'input-base' : ''" @click="tab = 'signup'">
                        <i data-lucide="user-plus" class="mr-2 h-5 w-5"></i>Sign Up
                    </button>
                </div> -->

                <!-- Sign In Form -->
                <div x-show="tab === 'signin'">
                    <div x-data="login()" @submit.prevent="submitForm">
                        <p x-show="generalError" x-transition x-text="generalError" class="text-red-700 font-semibold"></p>
                        <form method="POST" action="" class="space-y-4">
                            @csrf
                            <div>
                                <label class="mb-3">Email <span class="text-red-600">*</span></label>
                                <x-form.input model="email" type="email" name="email" placeholder="Enter Email*" value="{{ old('email') }}" autocomplete="off" required/>
                            </div>

                            <div>
                                <label class="mb-3">Password <span class="text-red-600">*</span></label>
                                <x-form.password model="password" name="password" placeholder="Enter Password*" value="{{ old('password') }}" required/>
                            </div>

                            <a href="{{ route('password.request') }}" class="text-sm text-green-600 hover:underline">
                                Forgot your password?
                            </a>

                            <button type="submit" id="loginBtn" class="bg-primary text-primary-foreground hover:bg-primary/90 shadow-soft h-10 px-4 py-2 w-full rounded-md">
                                Sign In
                            </button>

                            <p x-show="successMsg" x-transition x-text="successMsg" class="text-green-600 font-semibold"></p>
                        </form>
                    </div>

                    <!-- Social Login -->
                    {{-- <div>
                        <a href="#" class="w-full flex items-center justify-center my-2 py-2 px-4 border rounded-lg bg-green-300 text-gray-800 shadow hover:bg-orange-400">
                            <img src="/assets/google.png" class="h-6 mr-2">
                            Continue with Google
                        </a>

                        <a href="#" class="w-full flex items-center justify-center my-2 py-2 px-4 border rounded-lg bg-green-300 text-gray-800 shadow hover:bg-orange-400">
                            <img src="/assets/facebook.png" class="h-6 mr-2">
                            Continue with Facebook
                        </a>

                        <a href="#" class="w-full flex items-center justify-center my-2 py-2 px-4 border rounded-lg bg-green-300 text-gray-800 shadow hover:bg-orange-400">
                            <img src="/assets/instagram.png" class="h-6 mr-2">
                            Continue with Instagram
                        </a>
                    </div> --}}
                </div>

                <!-- Sign Up -->
                {{--<div x-show="tab === 'signup'">
                    <x-form.membership-form />
                </div>--}}
            </div>
        </div>
    </main>
    <!-- <script src="js/login.js"></script> -->
@endsection