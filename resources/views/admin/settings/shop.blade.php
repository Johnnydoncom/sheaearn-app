<x-admin-layout>
    <div>
        <h3 class="text-2xl font-medium text-gray-700">Shop Settings</h3>

        <div>
            <p class="my-2 text-sm text-gray-600">
                This information is used to configure your app shop so be careful with it.
            </p>
            <div class="md:grid md:grid-cols-3 md:gap-6">

                <div class="mt-5 md:mt-0 md:col-span-2">
                    <form action="{{ route('admin.settings.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="shadow sm:rounded-md sm:overflow-hidden">
                            <div class="px-4 py-5 bg-white space-y-6 sm:p-6">

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="form-control">
                                        <x-label value="Product Order Method" class="mt-1" />
                                        <x-select name="order_method" class="w-full">
                                            <option value="cart" @if(setting('order_method')=='cart') selected @endif>Cart/Checkout</option>
                                            <option value="call" @if(setting('order_method')=='call') selected @endif>Call to Order</option>
                                        </x-select>
                                    </div>
                                    <div class="form-control">
                                        <x-label value="Affiliate Signup Fee (₦)" class="mt-1" />
                                        <x-input type="text" name="affiliate_fee" id="affiliate_fee" value="{{setting('affiliate_fee')}}" />
                                    </div>
                                </div>

                                <div class="grid grid-cols-6 gap-6">
                                    <div class="col-span-6 sm:col-span-3">
                                        <x-label value="Minimum Withdrawal (₦)" class="mt-1" />
                                        <x-input type="text" name="minimum_withdrawal" id="minimum_withdrawal" value="{{setting('minimum_withdrawal')}}" />
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <x-label value="Maximum Withdrawal (₦)" class="mt-1" />
                                        <x-input type="text" name="maximum_withdrawal" id="maximum_withdrawal" value="{{setting('maximum_withdrawal')}}" />
                                    </div>
                                </div>


                                <h3 class="font-semibold text-xl">Shipping</h3>
                                <div class="divider my-1"></div>
                                <div class="form-control">
                                    <x-label value="Origin State" class="mt-1"/>
                                    <x-select name="origin_state_id" placeholder="Choose your State">
                                        @foreach($states as $state)
                                            <option value="{{$state->id}}" @if(setting('origin_state_id')==$state->id) selected @endif>{{$state->name}}</option>
                                        @endforeach
                                    </x-select>
                                </div>
                                <div class="grid grid-cols-6 gap-6">
                                    <div class="col-span-6 sm:col-span-3">
                                        <x-label value="Intra State Shipping (₦)" class="mt-1" />
                                        <x-input type="text" name="intra_state_shipping_fee" id="intra_state_shipping_fee" value="{{setting('intra_state_shipping_fee')}}" />
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <x-label value="Inter State Shipping (₦)" class="mt-1" />
                                        <x-input type="text" name="inter_state_shipping_fee" id="inter_state_shipping_fee" value="{{setting('inter_state_shipping_fee')}}" />
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
