<x-guest-layout>
    <div class="max-w-md mx-auto mt-12 p-6 bg-white shadow rounded-lg">
        <h1 class="text-2xl font-bold mb-4">Forgot Password</h1>

        @if (session('status'))
            <div class="text-green-600 mb-3">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <label class="block font-medium mb-2">Email</label>
            <input type="email" name="email" 
                class="w-full border-gray-300 rounded-lg shadow-sm" value="{{ old('email') }}">

            @error('email')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror

            <button 
                class="w-full mt-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Send Reset Link
            </button>
        </form>
    </div>
</x-guest-layout>
