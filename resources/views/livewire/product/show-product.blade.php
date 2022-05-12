<div class="py-1 relative mx-0 product bg-gray-100 lg:bg-white" id="single-product">

    <div class="p-4 container z-0 relative product-summary px-0 pl-0" style="">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8 ">
            <div class="lg:col-span-2">
                <div class="swiper swiper-container gallery-slider">
        <div id="gallery" class="swiper-wrapper">
            <!-- Slides -->
            @foreach($gallery as $key => $slide)
                <a class="swiper-slide" data-src="{{$slide}}">
                    <img src="{{ $slide }}" class="rounded-none">
                </a>
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


                <div id="sticky-cart" @scroll.passive='handleScroll' class="card sticky bottom-0 bg-white rounded-none z-20 mt-5">
                    <div class="card-body p-2">
                        <div v-if="$page.props.settings.order_method==='cart'" class="flex items-center space-x-4">
                            <a :href="`tel:${$page.props.settings.site_phone_number}`" class="btn btn-outline border-none hover:bg-transparent hover:text-primary rounded-md shadow-md">
                                <mdicon name="phone" :spin="true" class="inline-block w-6 h-6 text-primary" />
                            </a>

                            <div v-if="cart && cart.length" class="flex items-center justify-between w-full">
                                <a v-if="product.product_type==='variable'" @click="variationSheetOpened=true" class="btn btn-primary rounded-lg border-none shadow-md rounded-md"><mdicon name="minus" /></a>
                                <a v-else @click="decrease" class="btn btn-primary rounded-lg border-none shadow-md rounded-md"><mdicon name="minus" /></a>

                                <span v-text="getTotalCartItem"></span>


                                <a v-if="product.product_type==='variable'" @click="variationSheetOpened=true" class="btn btn-primary rounded-lg border-none shadow-md rounded-md"><mdicon name="plus" /></a>

                                <button v-else @click="increase" :disabled="product.stock.manage_stock && getTotalCartItem >= product.stock.stock_quantity" class="btn btn-primary rounded-lg border-none shadow-md rounded-md"><mdicon name="plus" /></button>
                            </div>

                            <div v-else class="flex flex-grow">

                                <form v-if="product.product_type !== 'variable'" @submit.prevent="increase" class="block w-full">
                                    <Button :disabled="product.stock.manage_stock && product.stock.stock_quantity < 1" class='flex justify-between btn-primary btn-block' :class="{ 'opacity-25 loading': form.processing }">
                                        <mdicon name="cart-outline" class="w-6 h-6 flex-none" />
                                        <span class='flex-1 uppercase flex items-center justify-center'>
                                    <span v-if="product.stock.manage_stock && product.stock.stock_quantity < 1">Out of Stock</span>
                                    <span v-else>Add to Cart</span>
                                </span>
                                    </Button>
                                </form>
                                <Button v-else @click.prevent="variationSheetOpened=true" class='flex justify-between btn-primary btn-block' :class="{ 'opacity-25 loading': form.processing }">
                                    <mdicon name="cart-outline" class="w-6 h-6 flex-none" />
                                    <span class='flex-1 uppercase flex items-center justify-center'>
                                    <span>Add to Cart</span>
                                </span>
                                </Button>
                            </div>
                        </div>

                        <div v-else class="">
                            <!--                    <a :href="`tel:${$page.props.settings.site_phone_number}`" class="btn btn-outline border-none hover:bg-transparent hover:text-primary rounded-md shadow-md">-->
                            <!--                        <mdicon name="phone" :spin="true" class="inline-block w-6 h-6 text-primary" />-->
                            <!--                    </a>-->

                            <a :href="`tel:${$page.props.settings.site_phone_number}`" class="btn btn-outline btn-block border-none hover:bg-transparent hover:text-primary rounded-md shadow-md text-lg">
                                <mdicon name="phone" :spin="true" class="w-6 h-6 text-primary flex-none" />
                                <span class="flex-1"> {{$page.props.settings.site_phone_number}}</span>
                            </a>

                        </div>
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


@push('scripts')
    <script src="{{ mix('js/swiper-bundle.js')}}"></script>
    <script>
        (() => {
            const initSlider = () => {
                // var thumbSwiper = new Swiper(".galleryThumb", {
                //     // loop: true,
                //     spaceBetween: 10,
                //     slidesPerView: 4,
                //     freeMode: true,
                //     // centeredSlides: true,
                //     watchSlidesProgress: true,
                // });

                var gallerySwiper = new Swiper('.gallery-slider', {
                    slidesPerView: 1.3,
                    grabCursor: true,
                    loop: true,
                    spaceBetween: 10,
                    centeredSlides:true,
                    scrollbar: {
                        el: '.swiper-scrollbar',
                        hide: true
                    },
                    autoplay:{
                        delay: 5000,
                        disableOnInteraction: false
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
