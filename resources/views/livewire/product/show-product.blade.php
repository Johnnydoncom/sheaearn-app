<div class="py-1 relative mx-0 product bg-gray-100 lg:bg-white" id="single-product">

    <div class="p-4 container z-0 relative product-summary px-0 pl-0" style="">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8 ">
            <div class="lg:col-span-2 " wire:ignore>
                <div class="swiper gallery-slider">
                    <div class="swiper-wrapper">
                        <!-- Slides -->
                        @foreach($gallery as $key => $slide)
                            <div class="swiper-slide">
                                <img src="{{ $slide }}" class="rounded-none">
                            </div>
                        @endforeach
                    </div>
                    <!-- If we need pagination -->
                    <div class="swiper-pagination"></div>

                    <!-- If we need navigation buttons -->
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="card card-body p-4 rounded-none bg-white lg:bg-transparent">
                    <h2 class="font-bold text-2xl mb-2">{{ $product->title }}</h2>
                    <div class="price">
                        <div class="mt-2 flex items-end space-x-2">
                            <div class="font-medium block">
                                <span class="text-red-600 font-bold text-2xl">{{ $product->sales_price > 0 ? $product->formatted_sales_price : $product->formatted_regular_price }} </span>
                            </div>
                            {{--                                <span class="text-gray-400 text-sm">{{  $product->stock->unit->name }}</span>--}}
                            {{--                                <span class="text-success text-sm">Price excl. VAT</span>--}}
                        </div>
                    </div>
                </div>

                <div class="promotion mt-3">
                    <div class="card rounded-none">
                        <h3 class="uppercase  px-4">Promotions</h3>
                        <div class="card-body p-4 bg-white">
                            Get ₦ 500.00 commission when you refer this product to a friend. NB. T&C apply How it works
                        </div>
                    </div>
                </div>


                <div id="sticky-cart" class="card sticky bottom-0 bg-white rounded-none z-20 mt-5">
                    <div class="card-body p-2">
                        @if(setting('order_method') === 'cart')

                        <div class="flex items-center space-x-4">
                            <a href="tel:{{ setting('site_phone_number') }}" class="btn btn-outline border-none hover:bg-transparent hover:text-primary rounded-md shadow-md">
                                {{-- <mdicon name="phone" :spin="true" class="inline-block w-6 h-6 text-primary" /> --}}
                                <x-fas-phone class="inline-block w-6 h-6 text-primary"/>
                            </a>

                            @if($cart && count($cart) > 0)
                                <div class="flex items-center justify-between w-full">
                                    <a wire:click="decrease" class="btn btn-primary rounded-lg border-none shadow-md rounded-md"><x-cui-cil-minus class="w-6 h-6"/></a>

                                    <span>50</span>

                                    <button wire:click="increase" @if($product->manage_stock && $getTotalCartItem >= $product->stock_quantity) disabled="disabled" @endif class="btn btn-primary rounded-lg border-none shadow-md rounded-md"><x-cui-cil-plus class="w-6 h-6"/></button>
                                </div>
                            @else
                            <div class="flex flex-grow">


                                    <button @if($product->manage_stock && $product->stock_quantity < 1) disabled="" @endif class='btn flex justify-between btn-primary btn-block' wire:click="$emit('addToCart', {{$product->id}})">
                                        <x-cui-cil-cart class="w-6 h-6 flex-none"/>
                                        <span class='flex-1 uppercase flex items-center justify-center'>
                                            @if($product->manage_stock && $product->stock_quantity < 1)
                                            <span>Out of Stock</span>
                                            @else
                                            <span>Add to Cart</span>
                                            @endif
                                        </span>
                                    </button>


                            </div>
                            @endif
                        </div>

                        @else

                        <div class="">
                            <a href="tel:{{ setting('site_phone_number') }}" class="btn btn-outline btn-block border-none hover:bg-transparent hover:text-primary rounded-md shadow-md text-lg">
                                {{-- <mdicon name="phone" :spin="true" class="w-6 h-6 text-primary flex-none" /> --}}
                                <x-fas-phone class="w-6 h-6 text-primary flex-none" />
                                <span class="flex-1"> {{ setting('site_phone_number') }}</span>
                            </a>
                        </div>
                        @endif
                    </div>
                </div>


            </div>
        </div>

        <div class="description mt-14">
            <div class="card rounded-none">
                <h3 class="uppercase  px-4">Description</h3>
                <div class="card-body p-4 bg-white">
                    {!! $product->description !!}
                </div>
            </div>
        </div>



    </div>


</div>

@push('styles')
<style rel="stylesheet" href="{{ mix('css/swiper-bundle.min.css')}}"></style>
@endpush
@push('scripts')
    <script src="{{ mix('js/swiper-bundle.js')}}"></script>
    <script>
        (() => {
            const initSlider = () => {
                var gallerySwiper = new Swiper('.gallery-slider', {
                    slidesPerView: 1.3,
                    grabCursor: true,
                    loop: true,
                    freeMode: true,
                    spaceBetween: 10,
                    centeredSlides:true,
                    scrollbar: {
                        el: '.swiper-scrollbar',
                        hide: true
                    }
                })
            }

            initSlider();

        })();



        document.addEventListener('livewire:load', function () {
            // alert(1)
            // initSlider();

        })
    </script>

@endpush
