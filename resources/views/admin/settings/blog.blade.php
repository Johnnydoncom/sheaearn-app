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
                                <div class="">
                                    <div class="col-span-3 sm:col-span-2">
                                        <x-label for="site_name" value="Site Name" class="" />
                                        <div class="mt-1 rounded-md shadow-sm">
                                            <x-input type="text" name="site_name" id="site_name" value="{{setting('site_name')}}" placeholder="Site Name" />
                                        </div>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-6">
                                    <div class="form-control">
                                        <x-label for="site_email" value="Site Email" class="" />
                                        <div class="mt-1 rounded-md shadow-sm">
                                            <x-input type="email" name="site_name" id="site_email" value="{{setting('site_email')}}" placeholder="example@example.com"/>
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
                                        <label for="referral_bonus" class="block text-sm font-medium text-gray-700">Affiliate Signup Fee (₦)</label>
                                        <input type="text" v-model="form.affiliate_fee" id="affiliate_fee" class="mt-1  focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                                    </div>
                                </div>

                                <div class="grid grid-cols-6 gap-6">
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="referral_bonus" class="block text-sm font-medium text-gray-700">Referral Bonus (₦)</label>
                                        <input type="text" v-model="form.referral_bonus" id="referral_bonus" class="mt-1  focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <div class="form-control">
                                            <label>Origin State</label>
                                            <keep-alive>
                                                <multiselect
                                                    v-model="form.origin_state_id"
                                                    placeholder="Choose your State"
                                                    :searchable="true"
                                                    :options="states"
                                                />
                                            </keep-alive>
                                        </div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-6 gap-6">
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="minimum_withdrawal" class="block text-sm font-medium text-gray-700">Minimum Withdrawal (₦)</label>
                                        <input type="text" v-model="form.minimum_withdrawal" id="minimum_withdrawal" class="mt-1  focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="maximum_withdrawal" class="block text-sm font-medium text-gray-700">Maximum Withdrawal (₦)</label>
                                        <input type="text" v-model="form.maximum_withdrawal" id="maximum_withdrawal" class="mt-1  focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                                    </div>
                                </div>


                                <div class="grid grid-cols-6 gap-6">
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="order_method" class="block text-sm font-medium text-gray-700">Product Order Method</label>
                                        <select v-model="form.order_method" class="select select-bordered w-full">
                                            <option value="cart">Cart/Checkout</option>
                                            <option value="call">Call to Order</option>
                                        </select>
                                    </div>

                                    <!--                                    <div class="col-span-6 sm:col-span-3">-->
                                    <!--                                        <label for="maximum_withdrawal" class="block text-sm font-medium text-gray-700">Maximum Withdrawal (₦)</label>-->
                                    <!--                                        <input type="text" v-model="form.maximum_withdrawal" id="maximum_withdrawal" class="mt-1  focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />-->
                                    <!--                                    </div>-->
                                </div>

                                <div>
                                    <label for="site_description" class="block text-sm font-medium text-gray-700">
                                        Site Description
                                    </label>
                                    <div class="mt-1">
                                        <textarea id="site_description" v-model="form.site_description" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md" />
                                    </div>
                                    <p class="mt-2 text-sm text-gray-500">
                                        Brief description for your site.
                                    </p>
                                </div>

                                <h3>Shipping</h3>
                                <div class="divider my-1"></div>
                                <div class="grid grid-cols-6 gap-6">
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="intra_state_shipping" class="block text-sm font-medium text-gray-700">Intra State Shipping (₦)</label>
                                        <input type="text" v-model="form.intra_state_shipping_fee" id="intra_state_shipping" class="mt-1  focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="inter_state_shipping" class="block text-sm font-medium text-gray-700">Inter State Shipping (₦)</label>
                                        <input type="text" v-model="form.inter_state_shipping_fee" id="inter_state_shipping" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                                    </div>
                                </div>

                                <h3>PayStack Settings</h3>
                                <div class="divider my-0 py-0"></div>
                                <div class="grid grid-cols-6 gap-6">
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="paystack_secret" class="block text-sm font-medium text-gray-700">Secret Key</label>
                                        <input type="text" v-model="form.paystack_secret" id="paystack_secret" class="mt-1  focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="paystack_key" class="block text-sm font-medium text-gray-700">Publishable Key</label>
                                        <input type="text" v-model="form.paystack_key" id="paystack_key" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                                    </div>
                                    <div class="col-span-6 sm:col-span-3">
                                        <label class="block text-sm font-medium text-gray-700">Mode</label>
                                        <select v-model="form.paystack_mode" class="select select-bordered w-full">
                                            <option value="test">Test</option>
                                            <option value="live">Live</option>
                                        </select>
                                    </div>
                                    <div class="col-span-6 sm:col-span-3">
                                        <label class="block text-sm font-medium text-gray-700">Status</label>
                                        <select v-model="form.paystack_active" class="select select-bordered w-full">
                                            <option value="0">Disabled</option>
                                            <option value="1">Active</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Save
                                </button>
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
