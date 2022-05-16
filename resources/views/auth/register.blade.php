<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <h2 class="font-semibold text-xl sm:text-2xl mb-6">Create Account</h2>
{{--        <div class="divider my-0"></div>--}}
        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}" class="">
            @csrf
            <x-floating-input id="last_name" :label="__('Last Name')" name="last_name" wrapperClass="mb-8" type="text" placeholder="__('Last Name')" :value="old('last_name')" required autofocus />

            <x-floating-input id="first_name" :label="__('First Name')" name="first_name" wrapperClass="mb-8" type="text" placeholder="__('First Name')" :value="old('first_name')" required autofocus />

            <!-- Email Address -->
            <x-floating-input id="email" label="Email" name="email" wrapperClass="mb-8" type="email" placeholder="Email" :value="old('email')" required autofocus />

            <x-floating-input id="phone" :label="__('Phone Number')" name="phone" wrapperClass="mb-8" type="text" placeholder="__('Phone Number')" :value="old('phone')" required />

            <!-- Password -->
            <x-floating-input id="password" wrapperClass="mb-8" name="password" label="Password" type="password" placeholder="Password" required autocomplete="new-password" />

            <x-button class="btn btn-secondary btn-block">{{ __('Register') }}</x-button>
            <div class="flex items-center justify-center mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
