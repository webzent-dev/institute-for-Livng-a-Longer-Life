@extends('front.layouts.app')
@section('content')
<main class="flex-1 flex items-center justify-center py-12 px-4">
    <div class="rounded-lg border bg-card text-card-foreground shadow-sm w-full max-w-md p-4">
        <div class="flex flex-col space-y-1.5 p-6">
            <h3 class="text-2xl font-semibold leading-none tracking-tight">Reset Password</h3>
        </div>
        <div>
            <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div>
                    <label class="mb-3">Email <span class="text-red-600">*</span></label>
                    <x-form.input model="email" type="email" name="email" placeholder="Enter Email*" value="{{ old('email', $email ?? '') }}" autocomplete="off" required/>
                </div>

                <div>
                    <label class="mb-3">New Password <span class="text-red-600">*</span></label>
                    <x-form.input model="password" type="password" name="password" placeholder="Enter Password*" required/>
                </div>

                <div>
                    <label class="mb-3">Confirm Password <span class="text-red-600">*</span></label>
                    <x-form.input model="confirm password" type="password" name="password_confirmation" placeholder="Enter confirm Password*" required/>
                </div>

                <button type="submit" class="bg-primary text-primary-foreground hover:bg-primary/90 shadow-soft h-10 px-4 py-2 w-full rounded-md">
                    Reset Password
                </button>
            </form>
        </div>
    </div>
</main>
@endsection
