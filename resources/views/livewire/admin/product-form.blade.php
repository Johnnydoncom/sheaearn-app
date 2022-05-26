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

        <div x-data="{openAttrTab:false}" @attribute-selected.window="openAttrTab = true" class="grid grid-cols-1 md:grid-cols-3 gap-2">

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
                            <x-label class="label" value="Product Type" />
                            <x-select class="w-full" wire:model.lazy="product_type" name="product_type">
                                <option value="simple" wire:key="simple">Simple Product</option>
                                <option value="variable" wire:key="variable">Variable Product</option>
                            </x-select>
                        </div>
                        <div class="form-control w-full">
                            <x-label class="label" value="Physical/Digital" />
                            <x-select class="w-full" wire:model.defer="type" name="type">
                                <option value="physical" wire:key="physical">Physical</option>
                                @if($product_type=='simple')
                                <option value="digital" wire:key="digital">Digital</option>
                                @endif
                            </x-select>
                        </div>
                    </div>



{{--                    @if($product_type=='variable')--}}
{{--                        <div class="form-control w-1/2">--}}
{{--                            <div class="flex space-x-2">--}}
{{--                                <x-select class="w-full" wire:model.defer="selAttribute" x-model="selAttribute" aria-label="Product type">--}}
{{--                                    <option value="custom" selected>Custom product attribute</option>--}}
{{--                                    @foreach($allAttributes as $attr)--}}
{{--                                    <option v-for="attr in attributes" :value="attr.code" :disabled="form.attributes.some(item => item.name === attr.name)">{{attr.name}}</option>--}}
{{--                                        <option value="{{$attr->code}}">{{$attr->name}}</option>--}}
{{--                                    @endforeach--}}
{{--                                </x-select>--}}
{{--                                <button type="button" class="btn btn-primary" wire:click.prevent="addAttribute">Add</button>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                    @endif--}}



                    <ul class="nav nav-tabs nav-justified flex flex-col md:flex-row flex-wrap list-none border-b-0 px-2 mb-4 bg-gray-900 text-gray-200" id="tabs-tabJustify" role="tablist">
                        @if($product_type=='simple')
                        <li class="nav-item flex-grow text-center" role="presentation">
                            <a href="#tabs-generalJustify" class="nav-link w-full block font-medium text-xs leading-tight uppercase border-x-0 border-y-0 border-transparent px-6 py-3 my-2 hover:border-transparent hover:bg-gray-100 focus:border-transparent active" id="tabs-general-tabJustify" data-bs-toggle="pill" data-bs-target="#tabs-generalJustify" role="tab" aria-controls="tabs-generalJustify" :aria-selected="{'true': !openAttrTab, 'false': openAttrTab}" :class="{'active': !openAttrTab}">General</a>
                        </li>
                        @endif
                        <li class="nav-item flex-grow text-center" role="presentation">
                            <a href="#tabs-inventoryJustify" class="nav-link w-full block font-medium text-xs leading-tight uppercase border-x-0 border-t-0 border-b-2 border-transparent px-6 py-3 my-2 hover:border-transparent hover:bg-gray-100 focus:border-transparent" id="tabs-inventory-tabJustify" data-bs-toggle="pill" data-bs-target="#tabs-inventoryJustify" role="tab" aria-controls="tabs-inventoryJustify" aria-selected="false">Inventory</a>
                        </li>
                        <li class="nav-item flex-grow text-center" role="presentation">
                            <a href="#tabs-attributesJustify" class="nav-link w-full block font-medium text-xs leading-tight uppercase border-x-0 border-t-0 border-b-2 border-transparent px-6 py-3 my-2 hover:border-transparent hover:bg-gray-100 focus:border-transparent" id="tabs-attributes-tabJustify" data-bs-toggle="pill" data-bs-target="#tabs-attributesJustify" role="tab" aria-controls="tabs-attributesJustify" aria-selected="false">Attributes</a>
                        </li>
                            @if($product_type=='variable')
                        <li class="nav-item flex-grow text-center" role="presentation">
                            <a href="#tabs-variationsJustify" class="nav-link w-full block font-medium text-xs leading-tight uppercase border-x-0 border-t-0 border-b-2 border-transparent px-6 py-3 my-2 hover:border-transparent hover:bg-gray-100 focus:border-transparent" id="tabs-variations-tabJustify" data-bs-toggle="pill" data-bs-target="#tabs-variationsJustify" role="tab" aria-controls="tabs-variationsJustify" :aria-selected="{'true': openAttrTab, 'false': !openAttrTab}" :class="{'active': openAttrTab}">Variations</a>
                        </li>
                            @endif
                    </ul>
                    <div class="tab-content" id="tabs-tabContentJustify">
                        @if($product_type=='simple')
                        <div class="tab-pane fade" :class="{'show active': !openAttrTab}" id="tabs-generalJustify" role="tabpanel" aria-labelledby="tabs-general-tabJustify">
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
                        </div>
                        @endif
                        <div class="tab-pane fade" id="tabs-inventoryJustify" role="tabpanel" aria-labelledby="tabs-inventory-tabJustify">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                                <div class="form-control w-full">
                                    <x-label class="label" value="SKU" />
                                    <x-input type="text" wire:model.defer="sku" name="sku" class="w-full input input-bordered input-md" :value="old('sku')"/>
                                </div>

                                <div class="form-control w-full">
                                    <x-label class="label" value="Manage Stock" />
                                    <x-select class="w-full" wire:model="manage_stock" name="manage_stock">
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
                        </div>
                        <div class="tab-pane fade" :class="{'show active': openAttrTab}" id="tabs-attributesJustify" role="tabpanel" aria-labelledby="tabs-attributes-tabJustify">

                            <div class="flex ">
                                <div class="form-control w-2/3">
                                    <div class="flex space-x-2">
                                        <select class="select select-bordered select-md w-full" wire:model="selAttribute" aria-label="Product type">
                                            <option value="custom" wire:key="custom">Custom product attribute</option>
                                            @foreach($allAttributes as $attr)
{{--                                            <option v-for="attr in attributes" :value="attr.code" :disabled="form.attributes.some(item => item.name === attr.name)">{{attr.name}}</option>--}}
                                                <option value="{{$attr->code}}" @if(collect($pattributes)->contains('name', $attr->name)) disabled="" @endif>{{$attr->name}}</option>
                                            @endforeach
                                        </select>
                                        <button type="button" class="btn btn-primary" wire:loading.class="loading" wire:target="addAttribute" wire:click.prevent="addAttribute">Add</button>
                                    </div>
                                </div>
                            </div>


                            @if($pattributes && 1>2)
                            @foreach($pattributes as $key=>$attribute)
                                {{print_r($attribute)}}
                                <div class="w-full grid md:grid-cols-3 gap-3 mb-3">
                                    <div class="form-control w-full col-span-1">
                                        <label class="label"><span class="label-text">Name:</span></label>
                                        @if($attribute['type']=='custom')
                                        <input wire:model="pattributes[{{$key}}]->name" type="text" class="input input-bordered input-md">
                                        @else
                                        <h3>{{$attribute['name']}}</h3>
                                        @endif
                                    </div>
                                    <div class="col-span-2">
                                        <div class="w-full flex">
                                            <div class="form-control w-full">
                                                <label class="label"><span class="label-text">Values:</span></label>
                                                @if($attribute['type']=='custom')
                                                <textarea class="input input-textarea h-24 textarea-bordered" wire:model="pattributes[{{$key}}]->name" placeholder='Enter some text, or some attributes by "|" separating values.'></textarea>
                                                @else
                                                <div>
                                                    <x-input.selectize wire:model.defer="pattributes[{{$key}}]->name" name="pattributes[{{$key}}]->name[]" multiple>
                                                        <x-slot name="maxitems">5</x-slot>
                                                        <x-slot name="create">1</x-slot>
                                                        @foreach($pattributes[$key]['value'] as $option)
                                                            <option value="{{ $option->id }}" @if(old('tags') && in_array($option->id, old('tags'))) selected @elseif($product && $pattributes[$key]['value'] && in_array($option->id, collect($pattributes[$key]['value'])->pluck('id'))) selected @endif>{{ $option->name }}</option>
                                                        @endforeach
                                                    </x-input.selectize>

{{--                                                    {{print_r($pattributes[$key]['value'])}}--}}


{{--                                                    <Multiselect--}}
{{--                                                        wire:model="pattributes[{{$key}}]->name"--}}
{{--                                                        :options="form.attributes[index].value"--}}
{{--                                                        mode="tags"--}}
{{--                                                        :caret="false"--}}
{{--                                                        :createTag="true"--}}
{{--                                                        :createOption="true"--}}
{{--                                                        :searchable="true"--}}
{{--                                                    />--}}
                                                </div>
                                                @endif
                                            </div>
                                            <div class="action flex">
                                                <!-- Remove Svg Icon-->
                                                <svg
                                                    wire:click="removeAttribute({{$key}})"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 24 24"
                                                    width="24"
                                                    height="24"
                                                    class="ml-2 cursor-pointer"
                                                >
                                                    <path fill="none" d="M0 0h24v24H0z" />
                                                    <path fill="#EC4899"
                                                          d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm0-9.414l2.828-2.829 1.415 1.415L13.414 12l2.829 2.828-1.415 1.415L12 13.414l-2.828 2.829-1.415-1.415L10.586 12 7.757 9.172l1.415-1.415L12 10.586z"
                                                    />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            @endif

                        </div>
                            @if($product_type=='variable')
                        <div class="tab-pane fade" id="tabs-variationsJustify" role="tabpanel" aria-labelledby="tabs-variations-tabJustify">
                            Variations content justify
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


    <script>
        document.addEventListener('livewire:load', function () {
            // Livewire.on('attributeSelected', response => {
            //     alert(1)
            // })

            @this.on('attributeSelected', () => {
                // alert(1)
            });
        });

        window.addEventListener('attribute-selected', event => {

            // alert('Name updated to: tt');

        })
     </script>
</div>


@push('styles')
    {{--    <link--}}
    {{--      href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css"--}}
    {{--      rel="stylesheet"--}}
    {{--    />--}}

{{--    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />--}}
@endpush
@push('scripts')


    <script>


        // $(document).ready(function() {
        //     $('#country').select2();
        //     $('#country').on('change', function (e) {
        //         var data = $('#country').select2("val");
        //     @this.set('country_id', data);
        //     });
        //
        // });

    </script>
@endpush
