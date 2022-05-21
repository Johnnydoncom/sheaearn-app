<x-admin-layout>
    <div>
        <h3 class="text-2xl font-medium text-gray-700">General Settings</h3>

        <div>
            <p class="my-2 text-sm text-gray-600">
                This information is used to configure your app so be careful with it.
            </p>
            <div class="md:grid md:grid-cols-3 md:gap-6">

                <div class="mt-5 md:mt-0 md:col-span-2">
                    <form action="{{ route('admin.settings.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="shadow sm:rounded-md sm:overflow-hidden">
                            <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                                <div class="grid grid-cols-2 gap-6">
                                    <div class="form-control">
                                        <x-label for="site_name" value="Site Name" class="" />
                                        <div class="mt-1 rounded-md shadow-sm">
                                            <x-input type="text" name="site_name" id="site_name" value="{{setting('site_name')}}" placeholder="Site Name" />
                                        </div>
                                    </div>
                                    <div class="form-control">
                                        <x-label for="signup_bonus" value="Signup Bonus" class="" />
                                        <div class="mt-1 rounded-md shadow-sm">
                                            <x-input type="text" name="signup_bonus" id="signup_bonus" value="{{setting('signup_bonus')}}"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-6">
                                    <div class="form-control">
                                        <x-label for="site_email" value="Site Email" class="" />
                                        <div class="mt-1 rounded-md shadow-sm">
                                            <x-input type="email" name="site_email" id="site_email" value="{{setting('site_email')}}" placeholder="example@example.com"/>
                                        </div>
                                    </div>
                                    <div class="form-control">
                                        <x-label for="site_phone" value="Site Phone" class="" />
                                        <div class="mt-1 rounded-md shadow-sm">
                                            <x-input type="tel" name="site_phone" id="site_phone" value="{{setting('site_phone')}}" placeholder="+12055759344"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-6">
                                    <div class="form-control">
                                        <x-label for="site_currency_name" value="Site Currency Name" class="" />
                                        <div class="mt-1 rounded-md shadow-sm">
                                            <x-input type="text" name="site_currency_name" id="site_currency_name" value="{{setting('site_currency_name')}}" placeholder="USD"/>
                                        </div>
                                    </div>
                                    <div class="form-control">
                                        <x-label for="site_currency_code" value="Site Currency Code" class="" />
                                        <div class="mt-1 rounded-md shadow-sm">
                                            <x-input type="text" name="site_currency_code" id="site_currency_code" value="{{setting('site_currency_code')}}" placeholder="$"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <x-label for="site_logo" value="Site Logo" class="" />

                                        <div class="mt-1 flex items-center">
                                          <span class="inline-block h-12 overflow-hidden bg-gray-100">
                                              <img class="h-full w-full text-gray-300" src="{{ site_logo() }}" alt="Site Logo">
                                          </span>
                                            <label class="ml-5 bg-white py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500  tracking-wide cursor-pointer">Change
                                                <input type="file" class="hidden" name="logoUpload" />
                                            </label>
                                        </div>
                                    </div>
                                    <div class="">
                                        <x-label for="site_logo_white" value="Site Logo (Light)" class="" />
                                        <div class="mt-1 flex items-center">
                                          <span class="inline-block h-12 overflow-hidden bg-black">
                                              <img class="h-full w-full text-gray-300" src="{{ site_logo_white() }}" alt="Site Light Logo">
                                          </span>
                                            <label class="ml-5 bg-white py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500  tracking-wide cursor-pointer">Change
                                                <input type="file" class="hidden" name="lightLogoUpload" />
                                            </label>
                                        </div>
                                    </div>
                                </div>



                                <div>
                                    <x-label for="site_description" value="Site Description" class="" />
                                    <div class="mt-1">
                                        <x-textarea id="site_description" name="site_description" rows="3">{!! setting('site_description') !!}</x-textarea>
                                    </div>
                                    <p class="mt-2 text-sm text-gray-500">
                                        Brief description for your site.
                                    </p>
                                </div>


                                <h3 class="font-semibold text-xl">PayStack Settings</h3>
                                <div class="divider mt-1"></div>
                                <div class="grid grid-cols-6 gap-6">
                                    <div class="col-span-6 sm:col-span-3">
                                        <x-label for="paystack_secret" value="Secret Key" class="" />
                                        <x-input type="text" name="paystack_secret" id="paystack_secret" value="{{setting('paystack_secret')}}" placeholder=""/>
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <x-label for="paystack_key" value="Publishable Key" class="" />
                                        <x-input type="text" name="paystack_key" id="paystack_key" value="{{setting('paystack_key')}}" placeholder=""/>
                                    </div>
                                    <div class="col-span-6 sm:col-span-3">
                                        <x-label for="paystack_mode" value="Mode" class="" />
                                        <x-select name="paystack_mode" class="w-full">
                                            <option value="test" @if(setting('paystack_mode')=='test') selected @endif>Test</option>
                                            <option value="live" @if(setting('paystack_mode')=='live') selected @endif>Live</option>
                                        </x-select>
                                    </div>
                                    <div class="col-span-6 sm:col-span-3">
                                        <x-label for="paystack_active" value="Status" class="" />
                                        <x-select name="paystack_active" class="w-full">
                                            <option value="0" @if(setting('paystack_active')==0) selected @endif>Disabled</option>
                                            <option value="1" @if(setting('paystack_active')==1) selected @endif>Active</option>
                                        </x-select>
                                    </div>
                                </div>

                            </div>
                            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                <x-button type="submit" class="btn btn-secondary">
                                    Save
                                </x-button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="md:col-span-1">
                    <div class="px-4 sm:px-0">
                        <!--                        <h3 class="text-lg font-medium leading-6 text-gray-900">Site Settings</h3>-->
                        <!--                        <p class="mt-1 text-sm text-gray-600">-->
                        <!--                            This information will be displayed publicly so be careful what you share.-->
                        <!--                        </p>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
