<x-account-layout>
    <x-slot name="title">Account Settings</x-slot>

<div>
    <!-- start::Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6">
       <div class="col-span-2">
        <h3 class="font-bold text-lg sm:text-xl">Account Information</h3>
        <div class="divider mt-0"></div>
            <form method="POST" action="{{ route('account.settings.store') }}" class="">
                @csrf
                <x-floating-input id="last_name" :label="__('Last Name *')" name="last_name" wrapperClass="mb-8" type="text" placeholder="__('Last Name *')" :value="$user->last_name" required autofocus />

                <x-floating-input id="first_name" :label="__('First Name *')" name="first_name" wrapperClass="mb-8" type="text" placeholder="__('First Name')" :value="$user->first_name" required autofocus />

                <!-- Email Address -->
                <x-floating-input id="email" label="Email *" name="email" wrapperClass="mb-8" type="email" placeholder="Email" :value="$user->email" readonly autofocus />

                <x-floating-input id="phone" :label="__('Phone Number *')" name="phone" wrapperClass="mb-8" type="text" placeholder="__('Phone Number')" :value="$user->phone" required />

                <x-floating-select id="gender" :label="__('Gender')" name="gender" wrapperClass="mb-8" placeholder="__('Gender')" :value="$user->gender">
                    <option value="">Select</option>
                    <option value="Male" @if($user->gender=='Male') selected @endif>Male</option>
                    <option value="Female" @if($user->gender=='Female') selected @endif>Female</option>
                </x-floating-select>

                <x-floating-input id="address" :label="__('Address')" name="address" wrapperClass="mb-8" type="text" placeholder="__('Address')" :value="$user->address" />

                <x-floating-input id="city" :label="__('City')" name="city" wrapperClass="mb-8" type="text" placeholder="__('City')" :value="$user->city" />

                <x-floating-input id="zip" :label="__('Zipcode')" name="zip" wrapperClass="mb-8" type="text" placeholder="__('Zipcode')" :value="$user->zip" />

                <x-button class="btn btn-secondary btn-block">{{ __('Update Account') }}</x-button>

            </form>
       </div>
       <div>
           <h3 class="font-bold text-lg sm:text-xl mt-5 sm:mt-0">Bank Information</h3>
           <div class="divider mt-0"></div>
            <form method="POST" action="{{ route('account.bank.store') }}" class="">
                @csrf

                <x-floating-input id="bank_name" wrapperClass="mb-4" name="bank_name" label="Bank Name" type="text" placeholder="Bank Name" :value="$payment_information ? $payment_information->bank_name : ''" required />

                <x-floating-input id="bank_account_no" :value="$payment_information ? $payment_information->bank_account_no : ''" wrapperClass="mb-4" name="bank_account_no" label="Bank Account Number" type="text" placeholder="Bank Account Number" required />

                <x-floating-input id="bank_account_name" :value="$payment_information ? $payment_information->bank_account_name : ''" wrapperClass="mb-4" name="bank_account_name" label="Bank Account Name" type="text" placeholder="Bank Account Name" required />

                <x-floating-input id="bank_swift_code" :value="$payment_information ? $payment_information->bank_swift_code : ''" wrapperClass="mb-4" name="bank_swift_code" label="Bank Swift Code" type="text" placeholder="Bank Swift Code" />

                <x-floating-input id="bank_branch" :value="$payment_information ? $payment_information->bank_branch : ''" wrapperClass="mb-4" name="bank_branch" label="Bank Branch" type="text" placeholder="Bank Branch" required />

                <x-floating-select id="country_id" :label="__('Bank Country')" name="country_id" wrapperClass="mb-4" placeholder="__('Bank Country')" required>
                    <option value="">Select Country</option>
                    @foreach ($countries as $country)
                        <option value="{{ $country->id }}" @if($payment_information && $payment_information->country_id===$country->id) selected @endif>{{ $country->name }}</option>
                    @endforeach

                </x-floating-select>


                <x-button class="btn btn-secondary btn-block">{{ __('Update') }}</x-button>

            </form>

            <h3 class="font-bold text-lg sm:text-xl mt-8">Change Password</h3>
           <div class="divider mt-0"></div>
           {{-- <x-auth-validation-errors class="mb-4" :errors="$errors" /> --}}

            <form method="POST" action="{{ route('account.password.store') }}" class="">
                @csrf
                <!-- Old Password -->
                <x-floating-input id="oldpassword" wrapperClass="mb-4" name="oldpassword" label="Old Password" type="password" placeholder="Old Password" required autocomplete="old-password" />
                <!-- New Password -->
                <x-floating-input id="password" wrapperClass="mb-4" name="password" label="New Password" type="password" placeholder="New Password" required autocomplete="new-password" />
                <!-- New Password -->
                <x-floating-input id="password_confirmation" wrapperClass="mb-4" name="password_confirmation" label="Confirm New Password" type="password" placeholder="Confirm New Password" required />

                <x-button class="btn btn-secondary btn-block">{{ __('Change Password') }}</x-button>

            </form>
       </div>
    </div>
    <!-- end::Stats -->

</div>
</x-account-layout>
