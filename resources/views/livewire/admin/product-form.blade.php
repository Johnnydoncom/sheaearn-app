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
                    <x-slot name="title"><h5 class="text-gray-900 text-xl leading-tight font-medium mb-2">Add New Product</h5></x-slot>
                    <hr>

                    <div class="form-control mb-4 mt-4">
                        <x-label for="title" :value="__('Title')" />
                        <x-input id="title" class="block mt-1 w-full" type="text" wire:model.defer="title" name="title" :value="old('title')" required autofocus />
                        @error('title')  <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div class="form-control w-full">
                            <x-label class="label" value="Regular Price" />
                            <x-input type="text" wire:model.defer="regular_price" name="regular_price" class="w-full input input-bordered input-md" :value="old('regular_price')"/>
                        </div>
                        <div class="form-control w-full">
                            <x-label class="label" value="Sales Price" />
                            <x-input type="text" wire:model.defer="sales_price" name="sales_price" class="w-full input input-bordered input-md" :value="old('sales_price')"/>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div class="form-control w-full">
                            <x-label class="label" value="SKU" />
                            <x-input type="text" wire:model.defer="sku" name="sku" class="w-full input input-bordered input-md" :value="old('sku')"/>
                        </div>
                        <div class="form-control w-full">
                            <x-label class="label" value="Product Type" />
                            <x-select class="w-full" wire:model.defer="product_type" name="product_type">
                                <option value="physical" wire:key="physical">Physical</option>
                                <option value="digital" wire:key="digital">Digital</option>
                            </x-select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 mb-4">
                        <div class="form-control w-full">
                            <x-label class="label" value="Manage Stock" />
                            <x-select class="w-full" wire:model.lazy="manage_stock" name="manage_stock">
                                <option value="0" wire:key="0">No</option>
                                <option value="1" wire:key="1">Yes</option>
                            </x-select>
                        </div>
                        @if($manage_stock)
                        <div class="form-control w-full">
                            <x-label class="label" value="Stock quantity" />
                            <x-input type="text" wire:model.defer="stock_quantity" name="stock_quantity" class="w-full input input-bordered input-md" :value="old('stock_quantity')"/>
                        </div>
                        <div class="form-control w-full">
                            <x-label class="label" value="Stock Status" />
                            <x-select class="w-full" wire:model.defer="stock_status" name="stock_status">
                                <option value="instock" wire:key="instock">In Stock</option>
                                <option value="outofstock" wire:key="outofstock">Out of Stock</option>
                            </x-select>
                        </div>
                        @endif
                    </div>

                    <div class="py-6 form-control" wire:ignore>
                        <x-label for="description" :value="__('Description')" />
                        <x-input.tinymce wire:model.defer="description" placeholder="Type anything you want..." />
                    </div>


                    <div class="grid grid-cols-1 sm:grid-cols-3 mb-2 gap-4">
                        <div class="form-control">
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
                                    @elseif($product)
                                        <img class="w-auto h-40 mx-auto" src="{{ $product->featured_img_thumb }}" alt="Featured Image Placeholder">
                                    @else
                                        <svg class="h-40" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                                        </svg>
                                    @endif

                                    <input type="file" class="hidden" wire:model="image">
                                </label>
                            </div>
                        </div>

                        <div class="form-control col-span-2">
                            <label class="label"><span class="label-text">Gallery Images</span></label>
                            <div class="grid grid-cols-4 gap-2">
                                @if($product && $product->gallery_images)
                                    @foreach ($product->gallery_images as $image)
                                        <div class="relative">
                                            <img src="{{ $image->getUrl('thumb') }}" class="">
                                            <a class="absolute right-0 top-0 cursor-pointer text-error" wire:click="removeGalleryById({{ $image->id }})">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-error" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                                            </a>
                                        </div>
                                    @endforeach
                                @endif

                                @if ($images)
                                    @foreach ($images as $key => $images)

                                        <div class="relative">
                                            <img src="{{ $images->temporaryUrl() }}" class="">
                                            <a class="absolute right-0 top-0 cursor-pointer text-error" wire:click="removeGallery({{ $key }})">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-error" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                                            </a>
                                        </div>
                                    @endforeach
                                @endif
                                <div class="form-control">
                                    <div class="relative rounded-md shadow-sm">
                                        <label
                                            class="p-6
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
                                            <svg class="w-8 h-8" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                                            </svg>
                                            <input type="file" class="hidden" wire:model="images" multiple>
                                        </label>
                                    </div>

                                    <div wire:loading wire:target="images">Uploading...</div>
                                    @error('images.*') <span class="error">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                    </div>


                </x-card>
            </div>



            {{--            <div class="mt-4">--}}
            <x-card class="card shadow-xl space-y-4">
                <x-label for="category" :value="__('Category')" />
                <div class="space-y-4 h-64 overflow-y-auto">
                        @foreach ($categories as $parent)
                        <div class="flex items-center">
                            <x-checkbox id="filter-{{$parent->id}}" :value="$parent->id" type="checkbox" class="h-4 w-4 border-gray-300 rounded text-primary focus:ring-primary" wire:model.defer="category_ids" />
                            <label for="filter-{{$parent->id}}" class="ml-3 text-sm text-gray-600">
                                {{$parent->name}}
                            </label>
                        </div>

                            @forelse($parent->children as $child1)
                                <div class="pl-3 flex items-center">
                                    <x-checkbox id="filter-{{$child1->id}}" :value="$child1->id" type="checkbox" class="h-4 w-4 border-gray-300 rounded text-primary focus:ring-primary" wire:model.defer="category_ids" />
                                    <label for="filter-{{$child1->id}}" class="ml-3 text-sm text-gray-600">
                                        {{$child1->name}}
                                    </label>
                                </div>

                                @forelse($child1->children as $child2)
                                    <div class="pl-8 flex items-center">
                                        <x-checkbox id="filter-{{$child2->id}}" :value="$child2->id" type="checkbox" class="h-4 w-4 border-gray-300 rounded text-primary focus:ring-primary" wire:model.defer="category_ids" />
                                        <label for="filter-{{$child2->id}}" class="ml-3 text-sm text-gray-600">
                                            {{$child2->name}}
                                        </label>
                                    </div>
                                @empty
                                @endforelse
                            @empty
                            @endforelse
                        @endforeach
                </div>


                <div class="form-control">
                    <x-label for="brand" :value="__('Brand')" />
                    <x-select class="w-full" wire:model.defer="brand" name="brand">
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}" wire:key="{{$brand->id}}">{{ $brand->name }}</option>
                        @endforeach
                    </x-select>
                    @error('brand')  <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label> @enderror
                </div>

                <div class="form-control">
                    <x-label for="commission" :value="__('Commission (Optional)')" />
                    <x-input id="commission" class="block w-full" type="text" wire:model.defer="commission" />
                </div>

{{--                <div class="form-control">--}}
{{--                    <x-label for="commission" :value="__('Commission (Optional)')" />--}}
{{--                    <x-input id="commission" class="block w-full" type="text" wire:model.defer="commission" />--}}
{{--                </div>--}}

                <div class="form-control flex items-center gap-4">
                    <x-label class="cursor-pointer label justify-start space-x-3" value="Featured" for="featured" />
                    <x-checkbox type="checkbox" wire:model.defer="featured" class="checkbox checkbox-primary" id="featured" />
                </div>

                <div class="mb-4 form-control" wire:ignore>
                    <x-label for="tags" :value="__(' Tags')" />
                    <x-input.selectize wire:model.defer="tags" name="tags[]" multiple>
                        <x-slot name="maxitems">5</x-slot>
                        <x-slot name="create">1</x-slot>
                        @foreach($allTags as $option)
                            <option value="{{ $option->id }}" @if(old('tags') && in_array($option->id, old('tags'))) selected @elseif($product && $tags && in_array($option->id, $tags)) selected @endif>{{ $option->name }}</option>
                        @endforeach
                    </x-input.selectize>
                </div>

                <div class="form-control mb-2">
                    <x-label for="status" :value="__('Status')" />
                    <x-select id="status" class="mt-1 w-full" wire:model.defer="status"  name="status" required>
                        <option value="0" wire:key="0">Draft</option>
                        <option value="1" wire:key="1">Published</option>
                    </x-select>
                </div>

                <x-button type="submit" class="btn-primary btn-block mt-4">
                    Publish
                </x-button>
                <div wire:loading wire:target="store">process...</div>
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
