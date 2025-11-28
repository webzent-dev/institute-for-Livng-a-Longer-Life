<x-guest-layout>
    <div class="max-w-md mx-auto mt-12 p-6 bg-white shadow rounded-lg">
        <h1 class="text-2xl font-bold mb-4">Reset Password</h1>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <label class="block font-medium mb-2">Email</label>
            <input type="email" name="email" class="w-full border rounded-lg" value="{{ old('email') }}">
            @error('email') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror

            <label class="block font-medium mt-4 mb-2">New Password</label>
            <input type="password" name="password" class="w-full border rounded-lg">
            @error('password') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror

            <label class="block font-medium mt-4 mb-2">Confirm Password</label>
            <input type="password" name="password_confirmation" class="w-full border rounded-lg">

            <button 
                class="w-full mt-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Reset Password
            </button>
        </form>
    </div>
</x-guest-layout>
