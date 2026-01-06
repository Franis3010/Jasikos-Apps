<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        Forgot the password for your <strong>Jasikos</strong> account? Enter your registered email address.
        We’ll send you a link to reset your password.
    </div>

    <!-- Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="'Email registered with Jasikos'" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-4">
            <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-gray-900 underline">
                Back to Login
            </a>
            <x-primary-button>
                Send Reset Link
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
