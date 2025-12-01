@extends('front.layouts.app')
@section('content')
    <div class="min-h-screen flex flex-col pt-20" >
       

        <main class="flex-1 flex items-center justify-center py-12 px-4">
            <div class="w-full max-w-md bg-white shadow-lg rounded-lg p-6">

                <h2 class="text-2xl font-bold text-center mb-2">Welcome</h2>
                <p class="text-gray-500 text-center mb-6">
                    Sign in to your account or create a new one
                </p>

                <!-- Tabs -->
                <div x-data="{ tab: 'signin' }">
                    <div class="grid grid-cols-2 mb-4 bg-gray-100 rounded-lg">
                        <button class="py-2 flex items-center justify-center"
                            :class="tab === 'signin' ? 'input-base ' : ''"
                            @click="tab = 'signin'">
                            <i data-lucide="log-in" class="mr-2 h-5 w-5"></i>Sign In
                        </button>
                    {{-- 'bg-white shadow font-semibold' : ''" --}}
                        <button class="py-2 flex items-center justify-center"
                            :class="tab === 'signup' ? 'input-base' : ''"
                            @click="tab = 'signup'">
                           <i data-lucide="user-plus" class="mr-2 h-5 w-5"></i> Sign Up
                        </button>
                    </div>

                    <!-- Sign In or Login form -->
                    <div x-show="tab === 'signin'"> 
                        
                        <div x-data="login()" @submit.prevent="submitForm">
                               
                                <form method="POST"  action=""  class="space-y-4">
                            @csrf

                            <div>
                                <label class="mb-3">Email</label>
                                 <x-form.input model="email" placeholder="Email" type="email" />
                                
                            </div>

                            <div>
                                <label class="mb-3">Password</label>
                                 <x-form.password model="password" placeholder="Password" />
                                
                            </div>
                           
                                   
                                    <a href="{{ route('password.request') }}" class="text-sm text-green-600 hover:underline ">
                                            Forgot your password?
                                    </a>
                                     <button type="submit relative " 
                                        class="w-full bg-green-600 text-white py-2 rounded mt-3">
                                        Sign In
                                    </button>
                             
                            



                            </form>
                        </div>
                      
                        <div class="">
                                <a href="#"
                                    class="w-full flex items-center justify-center my-2 py-2 px-4 border rounded-lg bg-green-300 text-gray-800 shadow hover:bg-orange-400">
                                        <img src="/assets/google.png" class="h-6 mr-2"> Continue with Google
                                    </a>

                                    <a href="#"
                                    class="w-full flex items-center justify-center my-2 py-2 px-4 border rounded-lg bg-green-300 text-gray-800 shadow hover:bg-orange-400">
                                        <img src="/assets/facebook.png" class="h-6 mr-2"> Continue with Facebook
                                    </a>

                                    <a href="#"
                                    class="w-full flex items-center justify-center my-2 py-2 px-4 border rounded-lg bg-green-300 text-gray-800 shadow hover:bg-orange-400">
                                        <img src="/assets/instagram.png" class="h-6 mr-2"> Continue with Instagram
                                </a>
                        </div>
                        
                    </div>

                   
                    <div x-show="tab === 'signup'">
                        
                        <x-form.membership-form />

                    </div>

                </div>

            </div>
        </main>

         
    </div>
@endsection
<script src="/js/login.js"></script>