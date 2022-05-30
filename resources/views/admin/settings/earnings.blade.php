<x-admin-layout>
    <div>
        <h3 class="text-2xl font-medium text-gray-700">Earning Settings</h3>

        <div>
            <p class="my-2 text-sm text-gray-600">
                This information is used to configure your site earnings, so be careful with it.
            </p>
            <div class="md:grid md:grid-cols-3 md:gap-6">

                <div class="mt-5 md:mt-0 md:col-span-2">
                    <form action="{{ route('admin.settings.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="shadow sm:rounded-md sm:overflow-hidden">
                            <div class="px-4 py-5 bg-white space-y-6 sm:p-6">

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                    <div class="form-control">
                                        <x-label value="Share Commission (₦)" class="" />
                                        <x-input type="text" name="share_commission" id="share_commission" value="{{setting('share_commission')}}" />
                                    </div>

                                    <div class="form-control">
                                        <x-label for="signup_bonus" value="Signup Bonus" class="" />
                                        <div class="mt-1 rounded-md shadow-sm">
                                            <x-input type="text" name="signup_bonus" id="signup_bonus" value="{{setting('signup_bonus')}}"/>
                                        </div>
                                    </div>

                                    <div class="form-control">
                                        <x-label value="Affiliate Signup Fee (₦)" />
                                        <x-input type="text" name="affiliate_fee" id="affiliate_fee" value="{{setting('affiliate_fee')}}" />
                                    </div>

                                    <div class="form-control">
                                        <x-label value="Post Share Commission (₦)" class="" />
                                        <x-input type="text" name="share_commission" id="share_commission" value="{{setting('share_commission')}}" />
                                    </div>

                                    <div class="form-control">
                                        <x-label value="Sponsored Ads Share Commission (₦)" class="" />
                                        <x-input type="text" name="sponsored_ads_commission" id="sponsored_ads_commission" value="{{setting('sponsored_ads_commission')}}" />
                                    </div>

                                    <div class="form-control">
                                        <x-label value="Referral Commission (₦)" class="" />
                                        <x-input type="text" name="referral_bonus" id="referral_bonus" value="{{setting('referral_bonus')}}" />
                                    </div>

                                    <div class="form-control">
                                        <x-label value="Max Shares Per Day" class="" />
                                        <x-input type="number" name="shares_per_day" id="shares_per_day" value="{{setting('shares_per_day',0)}}" />
                                    </div>

                                    <div class="form-control">
                                        <x-label value="Min. Withdrawable Sales Commission" class="" />
                                        <x-input type="number" name="min_withdrawable_sales_commission" id="min_withdrawable_sales_commission" value="{{setting('min_withdrawable_sales_commission',5000)}}" />
                                    </div>
                                </div>
                            </div>
                            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                <x-button type="submit" class="btn-primary">
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
