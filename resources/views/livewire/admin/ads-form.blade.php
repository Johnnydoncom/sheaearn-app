<div>
    <form wire:submit.prevent="store">
        @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div>
                <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-2">

            <div class="md:col-span-2">
                <x-card class="card shadow-xl">
                    <x-slot name="title"><h5 class="text-gray-900 text-xl leading-tight font-medium mb-2">Add Ads</h5></x-slot>
                    <hr>

                    <div class="form-control mb-2 mt-4">
                        <x-label for="title" :value="__('Title')" />
                        <x-input id="title" class="block mt-1 w-full" type="text" wire:model.defer="title" name="title" :value="old('title')" required autofocus />
                        @error('title')  <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label> @enderror
                    </div>

                    <div class="py-6 form-control" wire:ignore>
                        <x-label for="description" :value="__('Description')" />
                        <x-input.tinymce wire:model.defer="description" placeholder="Type anything you want..." />
                    </div>
                </x-card>
            </div>

{{--            <div class="mt-4">--}}
                <x-card class="card shadow-xl space-y-4">
                    <div class="form-control">
                        <x-label for="category" :value="__('Category')" />
                        <x-select class="w-full" wire:model.defer="category" name="category">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" wire:key="{{$category->id}}">{{ $category->name }}</option>
                            @endforeach
                        </x-select>
                        @error('category')  <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label> @enderror
                    </div>

                    <div class="form-control mb-2">
                        <x-label for="status" :value="__('Status')" />
                        <x-select id="status" class="mt-1 w-full" wire:model.defer="status"  name="status" required>
                            <option value="0">Draft</option>
                            <option value="1">Published</option>
                        </x-select>
                    </div>

                    <div class="form-control mb-2">
                        <label class="label"><span class="label-text">Featured Image</span></label>
                        <div class="relative rounded-md shadow-sm">
                            <label
                                class="
                                        flex flex-col
                                        items-center
                                        tracking-wide
                                        uppercase
                                        border border-blue
                                        cursor-pointer
                                        text-purple-600
                                        ease-linear
                                        transition-all
                                        duration-150
                                        relative
                                      ">
                                @if($image)
                                    <img class="w-auto h-40 mx-auto" src="{{ $image->temporaryUrl() }}" alt="Featured Image Placeholder">
                                @elseif($ads)
                                    <img class="w-auto h-40 mx-auto" src="{{ $ads->featured_img_thumb }}" alt="Featured Image Placeholder">
                                @else
                                    <svg class="h-40" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                                    </svg>
                                @endif

                                <input type="file" class="hidden" wire:model="image">
                            </label>
                        </div>
                    </div>

                    <x-button type="submit" class="btn-primary btn-block mt-4" wire:loading.class="loading" wire:target="store">Publish</x-button>
                </x-card>
{{--            </div>--}}
        </div>
    </form>
</div>


@push('styles')
    {{--    <link--}}
    {{--      href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css"--}}
    {{--      rel="stylesheet"--}}
    {{--    />--}}

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@push('scripts')
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    {{--    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>--}}

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        // new TomSelect('#payment-methods', {
        //   maxItems: 5,
        //   plugins: ['remove_button'],
        //   onItemAdd:function(){
        // 	this.setTextboxValue('');
        // 	this.refreshOptions();
        // },
        // });
        //
        // new TomSelect('#delivery-options', {
        //     maxItems: 5,
        //     plugins: ['remove_button'],
        //     onItemAdd:function(){
        //         this.setTextboxValue('');
        //         this.refreshOptions();
        //     },
        // });
        //
        // new TomSelect('#tags', {
        //     create: true,
        //     createOnBlur: true,
        //     persist: false,
        //     maxItems: 5,
        //     plugins: ['remove_button'],
        //     onItemAdd:function(){
        //         this.setTextboxValue('');
        //         this.refreshOptions();
        //     },
        // });


        $(document).ready(function() {
            $('#country').select2();
            $('#country').on('change', function (e) {
                var data = $('#country').select2("val");
            @this.set('country_id', data);
            });

        });

    </script>
@endpush
