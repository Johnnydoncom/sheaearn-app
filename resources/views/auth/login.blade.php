<x-guest-layout>
    <x-auth-card class="py-10">
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>
        <h2 class="font-semibold text-xl sm:text-2xl mb-6">Sign In</h2>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('login') }}" class="">
            @csrf

            <!-- Email Address -->
                <x-floating-input id="email" label="Email" name="email" wrapperClass="mb-8" type="email" placeholder="Email" :value="old('email')" required autofocus />

            <!-- Password -->
                <x-floating-input id="password" wrapperClass="mb-4" name="password" label="Password" type="password" placeholder="Password" required autocomplete="current-password" />


                <div class="flex justify-between gap-2 mb-8" >
                    <x-checkbox id="remember_me" label="{{ __('Remember me') }}" type="checkbox" name="remember" />
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif
                </div>

                <x-button class="ml-3 btn btn-block">
                    {{ __('Log in') }}
                </x-button>

                <div class="flex items-center justify-center mt-4">
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('register') }}">
                        {{ __("Don't have an account?") }}
                    </a>
                </div>
        </form>
    </x-auth-card>
</x-guest-layout>
