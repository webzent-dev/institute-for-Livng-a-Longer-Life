@extends('front.layouts.app')
@section('content')
<main class="flex-1 flex items-center justify-center py-12 px-4">
    <div class="rounded-lg border bg-card text-card-foreground shadow-sm w-full max-w-md p-4">
        <div class="flex flex-col space-y-1.5 p-6">
            <h3 class="text-2xl font-semibold leading-none tracking-tight">Forgot Password</h3>
        </div>

        <!-- Tabs -->
        <div>
            @if (session('status'))
                <div class="text-green-600 mb-3">{{ session('status') }}</div>
            @endif
            <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="mb-3">Email <span class="text-red-600">*</span></label>
                    <x-form.input model="email" name="email" placeholder="Enter Email*" value="{{ old('email') }}" type="email" autocomplete="off" required/>
                </div>

                <button type="submit" class="bg-primary text-primary-foreground hover:bg-primary/90 shadow-soft h-10 px-4 py-2 w-full rounded-md">
                    Send Reset Link
                </button>
            </form>
        </div>
    </div>
</main>
@endsection