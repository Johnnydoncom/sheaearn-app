<x-slot name="title">{{$product->title}}</x-slot>
<div x-data="{variationSheetOpened:false}" class="py-1 relative mx-0 product bg-gray-100 lg:bg-white" id="single-product">

    <div class="lg:p-4 container z-0 relative product-summary px-0 pl-0" style="">
        <div class="grid grid-cols-1 lg:grid-cols-4 lg:gap-8 ">
            <div class="lg:col-span-2 " wire:ignore>
                <div class="swiper gallery-slider">
                    <div class="swiper-wrapper">
                        <!-- Slides -->
                        @foreach($gallery as $key => $slide)
                            <div class="swiper-slide bg-white">
                                <figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject" class="">
                                    <a href="{{ $slide }}" itemprop="contentUrl" data-size="2136x1424">
                                        <img src='{{ $slide }}' class="object object-cover slide-image h-[18rem] sm:h-[25rem] w-full"/>
                                    </a>
                                </figure>

{{--                                <img src="{{ $slide }}" class="rounded-none w-full slide-image">--}}
                            </div>
                        @endforeach
                    </div>

                    <!-- If we need pagination -->
                    <div class="swiper-scrollbar"></div>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="card card-body p-4 rounded-none bg-white lg:bg-transparent">
                    <h2 class="font-bold text-2xl mb-2">{{ $product->title }}</h2>
                    <div class="price">
                        <div class="mt-2 flex items-end space-x-2">
                            <div class="font-medium block">
                                @if($product->product_type=='variable')
                                    <span class="text-red-600 font-bold text-2xl">{{ $product->variation_price }} </span>
                                @else
                                <span class="text-red-600 font-bold text-2xl">{{ $product->sales_price > 0 ? $product->formatted_sales_price : $product->formatted_regular_price }} </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                @if($product->commission > 0)
                <div class="promotion">
                    <div class="card rounded-none">
                        <h3 class="uppercase px-4 py-2 text-sm font-semibold">Promotions</h3>
                        <div class="card-body px-4 py-0 bg-white">
                            <p class="text-xs lg:text-base font-normal text-red-600">Get {{ app_money_format($product->commission) }} commission when you refer this product to a friend. NB. T&C apply <a href="#" class="text-xs text-blue-600 py-2 font-normal underline hover:text-primary">How it works</a></p>
                        </div>
                    </div>
                </div>
                @endif

                <div id="sticky-cart" class="card sticky bottom-0 bg-white rounded-none z-20 mt-5">
                    <div class="card-body p-2">
                        @if(setting('order_method') === 'cart')

                        <div class="flex items-center space-x-4">
                            <a href="tel:{{ setting('site_phone_number') }}" class="btn btn-outline border-none hover:bg-transparent hover:text-primary rounded-md shadow-md">
                                {{-- <mdicon name="phone" :spin="true" class="inline-block w-6 h-6 text-primary" /> --}}
                                <x-fas-phone class="inline-block w-6 h-6 text-primary"/>
                            </a>

                            @if($cart && count($cart) > 0)
                                {{-- {{ dd($cart['627fc2ce2b39e'])}} --}}
                                <div class="flex items-center justify-between w-full">
                                    @if($product->product_type=='variable')
                                        <button @click.prevent="variationSheetOpened=true" class="btn btn-primary rounded-lg border-none shadow-md rounded-md"><x-cui-cil-minus class="w-6 h-6"/></button>
                                    @else
                                    <button wire:click="updateCart('{{array_key_first($cart->toArray())}}', {{$getTotalCartItem-1}})" wire:loading.class="loading" class="btn btn-primary rounded-lg border-none shadow-md rounded-md" @if($getTotalCartItem < 2) disabled="disabled" @endif><x-cui-cil-minus class="w-6 h-6"/></button>
                                    @endif

                                    <span>{{$getTotalCartItem}}</span>

                                    @if($product->product_type=='variable')
                                    <button @click.prevent="variationSheetOpened=true" class="btn btn-primary rounded-lg border-none shadow-md rounded-md">
                                        <x-cui-cil-plus class="w-6 h-6"/>
                                    </button>
                                    @else
                                    <button wire:click="updateCart('{{array_key_first($cart->toArray())}}', {{$getTotalCartItem+1}})" wire:loading.class="loading" @if($product->manage_stock && $getTotalCartItem >= $product->stock_quantity) disabled="disabled" @endif class="btn btn-primary rounded-lg border-none shadow-md rounded-md">
                                        <x-cui-cil-plus class="w-6 h-6"/>
                                    </button>
                                    @endif
                                </div>
                            @else
                            <div class="flex flex-grow">
                                @if($product->product_type=='variable')
                                    <button @click.prevent="variationSheetOpened=true" class='btn btn-primary justify-between btn-primary btn-block'>
                                        <x-cui-cil-cart class="w-6 h-6 flex-none"/>
                                        <span class='flex-1 uppercase flex items-center justify-center'>
                                                <span>Add to Cart</span>
                                        </span>
                                    </button>
                                @else
                                    <button @if($product->manage_stock && $product->stock_quantity < 1) disabled="disabled" @endif class='btn btn-primary justify-between btn-primary btn-block' wire:click="addToCart" wire:loading.class="loading">
                                        <x-cui-cil-cart class="w-6 h-6 flex-none"/>
                                        <span class='flex-1 uppercase flex items-center justify-center'>
                                            @if($product->manage_stock && $product->stock_quantity < 1)
                                            <span>Out of Stock</span>
                                            @else
                                            <span>Add to Cart</span>
                                            @endif
                                        </span>
                                    </button>
                                @endif
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

                @if($product->product_type=='variable' && $product->variations->count())
                <div class="variations border-t border-gray-200 my-3">

                    <h3 class="uppercase py-2">Variations</h3>
                    @foreach($variations as $attr => $variation)
                        <h4>{{$attr}}</h4>
                        <div class="flex space-x-2">
                            @foreach($variation as $variationValue)
                            <button class="btn btn-sm btn-outline btn-primary" @click="variationSheetOpened=true">{{ $variationValue->attribute_value }}</button>
                            @endforeach
                        </div>
                    @endforeach
                </div>
                @endif

                <div class="share card card-body p-4 flex-row items-center gap-4">
                    <span class="font-semibold">Share:</span>
                    <button @auth @click.prevent="fbShare()" wire:target="shared('{{ config("appstore.social_shares.facebook_id")}}')" wire:loading.class="loading" @else @click.prevent="showLoginModal=true" @endauth class="btn btn-ghost btn-circle">
                        <x-cui-cib-facebook class="w-6 h-6 text-[#4267B2] flex-nonee"/>
                    </button>
                </div>
            </div>
        </div>

        <div class="description sm:mt-10">
            <div class="card rounded-none">
                <h3 class="uppercase px-4 sm:px-0 py-2 text-sm sm:text-xl sm:font-semibold">Description</h3>
                <div class="card-body p-4 sm:px-0 bg-white description break-all text-sm">
                    {!! $product->description !!}
                </div>
            </div>
        </div>

        <div class="reviews lg:mt-4">
            <div class="card rounded-none">
                <h3 class="uppercase px-4 sm:px-0 py-2 sm:text-xl lg:text-xl 2xl:text-xl text-sm 2xl:font-semibold">Verified Customer Feedback</h3>
                <a href="{{ route('product.reviews', $product->slug) }}" class="flex justify-between items-center w-full text-sm bg-secondary bg-opacity-20 px-4 py-2">
                        <span>
                            <span>Product Ratings & Reviews</span>
                            <p><span class="text-primary mr-1">{{ $product->average_rating }}/5</span> {{ $product->reviews->count() }} ratings</p>
                            </span>
                    <span>
                            <x-fas-chevron-right class="w-4 h-4"/>
                        </span>
                </a>

                <div class="card-body p-4 bg-white text-blue-600">
                                @if($product->reviews->count())
                                @foreach($product->reviews as $review)
                                    <x-product.review :review="$review" />
                                @endforeach
{{--                                <Review v-if="reviews.length" v-for="(review,index) in reviews.slice(0, 4)" :key="review.id" :review="review" />--}}
                                @else
                                <p class="pb-3-safe">No review</p>
                                @endif
                            </div>

            </div>
        </div>

        @if($related->count())
        <div class="mb-0 mt-4">
            <h2 class="font-semibold mb-4 text-md">You may also like</h2>
            <div class="grid grid-cols-2 gap-2">
                @foreach($related as $rp)
                <x-product.related :product="$rp" />
                @endforeach
            </div>
        </div>
       @endif




        @if($product->product_type=='variable')
        <div class="modal modal-bottom sm:modal-middle" :class="{'modal-open': variationSheetOpened}">
            <div class="modal-box relative">
                <label for="variationSheetModal" @click.prevent="variationSheetOpened=false" class="btn btn-sm btn-circle absolute right-2 top-2">✕</label>
                <h4 class="font-semibold text-lg">Please select a variation</h4>

                <div class="py-4">
                    @foreach($available_variations as $variation)
                    <div class="grid grid-cols-2 mb-2 items-center">
                        <x-product.variation-item :variation="$variation" />
                    </div>
                    @endforeach
                </div>

            </div>
        </div>
        @endif

    </div>


    <livewire:cart-action />
</div>


@push('styles')
<link rel="stylesheet" href="{{ mix('css/swiper-bundle.min.css')}}">
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
                    },
                    autoplay:{
                        delay: 5000,
                        disableOnInteraction: false
                    },
                    navigation:false,
                    breakpoints: {
                        991: {
                            slidesPerView: 1,
                            spaceBetween: 10
                        }
                    }
                })
            }

            initSlider();

        })();



        function fbShare(){
            FB.ui({
                    method: 'share',
                    name: '{{$product->title}}',
                    href: '{{url()->current()}}',
                    picture: '{{ $product->featured_img_url }}',
                    caption: '{{$product->title}}',
                    description: '{{ $product->excerpt }}'
                },
                function(response) {
                    if (response && !response.error_code) {
                        if (typeof response != 'undefined'){
                            //shered
                        @this.shared('{{ config("appstore.social_shares.facebook_id")}}');
                        }
                    }else if (response && response.post_id) {
                    @this.shared('{{ config("appstore.social_shares.facebook_id")}}');
                    } else {
                        // alert('Post was not published.');
                    }
                });
        }
    </script>

@endpush
