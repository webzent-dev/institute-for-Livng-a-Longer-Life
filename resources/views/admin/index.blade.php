@extends('front.layouts.app')
@section('title', 'Admin Login')
@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-slate-50 to-slate-100 px-4 py-12 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div class="text-center">
            <div class="mx-auto h-12 w-12 sm:h-16 sm:w-16 bg-green-600 rounded-full flex items-center justify-center">
                <i data-lucide="lock-keyhole" class="w-10 h-10 sm:w-8 sm:h-8 text-white"></i>
            </div>
            <h2 class="mt-4 sm:mt-6 text-2xl sm:text-3xl font-bold ">Admin Login</h2>
        </div>

        <form method="POST" action="{{ route('admin.login') }}" class="mt-8 space-y-6 bg-white py-6 sm:py-8 px-4 sm:px-6 shadow-lg rounded-xl border border-gray-200">
            @csrf
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address<span class="text-red-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                        </svg>
                    </div>
                    <input id="email" name="email" type="email" required autocomplete="email" value="{{ old('email') }}" class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition duration-200 @error('email') border-red-500 @enderror" placeholder="Enter your email">
                </div>
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password<span class="text-red-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <input id="password" name="password" type="password" required autocomplete="current-password" class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition duration-200 @error('password') border-red-500 @enderror" placeholder="Enter your password">
                </div>
            </div>

            {{-- Remember Me & Forgot Password --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-3 sm:space-y-0">
                <!-- <div class="flex items-center">
                    <input
                        id="remember_me"
                        name="remember"
                        type="checkbox"
                        class="h-4 w-4 text-blue-600 focus:ring-primary border-gray-300 rounded"
                    >
                    <label for="remember_me" class="ml-2 block text-sm text-gray-700">Remember me</label>
                </div> -->

                <div class="text-sm">
                    <a href="{{ route('password.request') }}" class="font-medium text-primary hover:text-primary transition duration-150">Forgot your password?</a>
                    <!-- <a href="#" class="font-medium text-blue-600 hover:text-blue-500 transition duration-150">Forgot your password?</a> -->
                </div>
            </div>

            {{-- Submit Button --}}
            <div>
                {{-- <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                    Sign In
                </button> --}}
                <div class="grid grid-cols-1 gap-2">
                    <x-button-use type="submit" full="true" class="btn-hero lg py-3 flex items-center justify-center gap-2">
                        <i data-lucide="send" class="w-5 h-5"></i>
                        Sign In
                    </x-button-use>
                    <p x-show="success" class="text-green-500 text-sm" x-text="success"></p>
                    <p x-show="error" class="text-red-500 text-sm" x-text="error"></p>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection