<x-guest-layout>
    <div class="min-h-[70vh] flex items-center justify-center py-10 bg-neutral-50">
        <div class="w-full max-w-md">

            {{-- Small brand --}}
            <div class="mb-6 text-center">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-lg font-semibold text-gray-900">
                    <img src="{{ asset('logo.png') }}" alt="Jasikos" class="h-8" onerror="this.remove()">
                    <span>Jasikos</span>
                </a>
                <p class="mt-2 text-sm text-gray-500">Sign in to continue</p>
            </div>

            <div class="bg-white/80 backdrop-blur rounded-2xl shadow-lg border border-gray-100 p-6 md:p-8">
                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                            :value="old('email')" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div>
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                            autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember + Forgot -->
                    <div class="flex items-center justify-between">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" name="remember"
                                class="rounded border-gray-300 text-black shadow-sm focus:ring-black accent-black">
                            <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                                class="text-sm text-gray-600 hover:text-gray-900 underline">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif
                    </div>

                    <!-- Submit -->
                    <button type="submit" class="btn-black w-full">
                        {{ __('Log in') }}
                    </button>
                </form>
            </div>

            <p class="mt-6 text-center text-sm text-gray-600">
                Don't have an account?
                <a href="{{ route('register') }}" class="font-medium text-black hover:underline">Sign up</a>
            </p>
        </div>
    </div>

    {{-- Page-specific CSS --}}
    <style>
        .btn-black {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 12px 16px;
            border-radius: 12px;
            background: #000;
            color: #fff;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(0, 0, 0, .08);
            transition: transform .05s ease, filter .15s ease, box-shadow .2s ease;
        }

        .btn-black:hover {
            filter: brightness(0.95);
            box-shadow: 0 6px 16px rgba(0, 0, 0, .12);
        }

        .btn-black:active {
            transform: translateY(1px);
        }

        .btn-black:focus-visible {
            outline: 2px solid #000;
            outline-offset: 3px;
        }

        .btn-black:disabled {
            opacity: .6;
            cursor: not-allowed;
        }
    </style>
</x-guest-layout>
