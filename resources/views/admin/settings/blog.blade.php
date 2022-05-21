<x-admin-layout>
    <div>
        <h3 class="text-2xl font-medium text-gray-700">Blog Settings</h3>

        <div>
            <p class="my-2 text-sm text-gray-600">
                This information is used to configure your blog so be careful with it.
            </p>
            <div class="md:grid md:grid-cols-3 md:gap-6">

                <div class="mt-5 md:mt-0 md:col-span-2">
                    <form action="{{ route('admin.settings.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="shadow sm:rounded-md sm:overflow-hidden">
                            <div class="px-4 py-5 bg-white space-y-6 sm:p-6">

                                <div class="grid grid-cols-6 gap-6">
                                    <div class="form-control col-span-6 sm:col-span-3">
                                        <x-label value="Share Commission (₦)" class="mt-1" />
                                        <x-input type="text" name="share_commission" id="share_commission" value="{{setting('share_commission')}}" />
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">

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
