<template>
    <Head>
        <title>{{ product.title }}</title>
    </Head>

    <div class="py-1 relative mx-0 product" id="single-product">

        <k-block class="mt-1 mx-0 px-0 img-slider pl-0-safe pr-0-safe" :nested="true" style="padding-left:0px !important;padding-right:0px !important;">
            <swiper
                class="mySwiper"
                :modules="modules"
                :slides-per-view="1.3"
                :space-between="10"
                :scrollbar="{ hide: true }"
                :centered-slides="true"
                :loop="true"
                :autoplay="{
                  delay: 5000,
                  disableOnInteraction: false
              }">
                <swiper-slide v-for="slide in gallery" :key="slide" class='bg-white'>
                    <img :src="slide" :alt="product.title" class="rounded-md w-full" />
                </swiper-slide>
            </swiper>
        </k-block>

        <k-block :nested="true" class="mt-2 mb-0" strong>
            <h2 class='text-lg font-normal py-0 dark:text-gray-200'>
                {{product.title}}
            </h2>
            <div class='my-2' v-if="product.brand">
                <div class='flex text-xs dark:text-gray-200'>
                    Brand: <span class='ml-2'>{{product.brand.name}}</span>
                </div>
            </div>
            <div class='my-2'>
                <template v-if="product.product_type != 'variable'">
                <p v-if="product.stock.sales_price > 0" class="text-xl font-bold text-gray-900 dark:text-gray-200">{{product.stock.formatted_sales_price}}</p>

                <div class="flex space-x-2 items-center">
                    <p :class="[product.stock.sales_price > 0 ? 'text-gray-500 dark:text-gray-200 text-sm line-through' : 'text-gray-900 dark:text-gray-200 text-lg font-bold']">{{product.stock.formatted_regular_price}} </p>
                    <span v-if="product.stock.sales_price > 0" class="badge badge-primary badge-xs">-{{product.stock.discount_percent}}%</span>
                </div>
                </template>
                <template v-else>
                    <p class="text-gray-900 dark:text-gray-200 text-lg font-bold">{{product.variation_price}} </p>
                </template>

                <div class="average-review pt-2 flex justify-between items-center">
                   <div>
                       <div class="rating rating-xs">
                           <span v-for="r in [...Array(parseInt(product.average_rating))]" :key="r" type="radio" name="rating-6" class="mask mask-star-2 bg-warning"></span>
                           <span v-if="parseInt(product.average_rating) < 5" v-for="r in [...Array(5-parseInt(product.average_rating))]" :key="r" type="radio" name="rating-6" class="mask mask-star-2 bg-gray-200"></span>
                       </div>
                       <p class="text-xs text-blue-600">({{ reviews?.length }} verified ratings)</p>
                   </div>
                    <span>
                        <button v-if="wishlist" class="btn btn-ghost text-primary btn-circle" @click="addToWishlist" :class="{'loading': wishform.processing}">
                            <mdicon name="heart" />
                        </button>
                        <template v-else>
                             <button v-if="product.product_type==='variable'" :class="{'loading': wishform.processing}" class="btn btn-ghost text-primary btn-circle" @click="wishlistVariationSheetOpened = !wishlistVariationSheetOpened">
                                <mdicon name="heart-outline" />
                            </button>
                            <button v-else class="btn btn-ghost text-primary btn-circle" :class="{'loading': wishform.processing}" @click="addToWishlist">
                                <mdicon name="heart-outline" />
                            </button>
                        </template>
                    </span>
                </div>

                <div v-if="product.product_type==='variable' && Object.values(variations).length" class="variations border-t border-gray-200 my-3">
                    <h3 class="uppercase py-2">Variations</h3>
                    <template v-for="(variation,attr) in variations">
                       <div class="">
<!--                           <h4>{{// attr}}</h4>-->

                           <div class="flex space-x-2">
                               <button type="button" v-for="variationValue in variation" @click="variationSheetOpened=true" class="btn btn-sm btn-outline btn-primary ">
                                   {{variationValue.data.attribute.value}}
                               </button>
                           </div>
                       </div>
                    </template>
                </div>
            </div>

        </k-block>

        <k-block-header class="uppercase mt-3" v-if="product.commission > 0">
            Promotions
        </k-block-header>
        <k-block class="mx-2 mb-0" v-if="product.commission > 0" strong>
            <p class="text-xs py-2 font-normal text-red-600">Get {{commission}} commission when you refer this product to a friend. NB. T&C apply
                <Link :href="route('how-it-works')" class="text-xs text-blue-600 py-2 font-normal underline hover:text-primary">How it works</Link>
            </p>

        </k-block>

        <k-block-header class="uppercase mt-3">
                Product details
        </k-block-header>

        <k-block class="mx-2 mb-0 break-words" strong>
            <Link :href="route('product.details', product.slug)" class="uppercase text-sm flex justify-between mb-2 w-full">
                <span>Description</span><span><mdicon name="chevron-right" class="w-4 h-4" /></span>
            </Link>
            <div class='description break-all' v-html="product.excerpt"></div>
        </k-block>


<!--        <k-block-title class="uppercase text-sm mt-3">Verified Customer Feedback</k-block-title>-->
        <k-block-header class="uppercase mt-3">Verified Customer Feedback</k-block-header>
        <k-block-title :with-block="false" class="bg-secondary bg-opacity-20 p-2 mb-0 text-sm">
            <Link :href="route('product.reviews', product.slug)" class="flex justify-between items-center w-full">
                <span>
                    <span>Product Ratings & Reviews</span>
                    <p><span class="text-primary mr-1">{{ product.average_rating }}/5</span> {{ reviews?.length }} ratings</p>
                </span>
                <span><mdicon name="chevron-right" class="w-4 h-4" /></span>
            </Link>
        </k-block-title>
        <k-block strong class="mt-0 mb-0 pb-0" :hairlines="false">
            <div class="card rounded-none">
                <div class="card-body p-0 pb-0 text-blue-600">
                    <Review v-if="reviews.length" v-for="(review,index) in reviews.slice(0, 4)" :key="review.id" :review="review" />
                    <p class="pb-3-safe" v-else>No review</p>
                </div>
            </div>
        </k-block>
        <k-block strong class="mb-0 mt-4" :hairlines="false" v-if="related">
            <h2 class="font-semibold mb-4 text-md">You may also like</h2>
            <div class="grid grid-cols-2 gap-2">
                <related-product
                    v-for="(pro,index) in related"
                    :key="index"
                    :product="pro"
                />
            </div>
        </k-block>

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

        <k-block strong class="mb-0" v-if="1>2">
            <h2 class="font-semibold mb-4 text-md">You may also like</h2>
            <div class="grid grid-cols-2 gap-2">
                <related-product
                v-for="(pro,index) in related"
                :key="index"
                :product="pro"
                />
            </div>
        </k-block>

        <k-sheet
            v-if="product.product_type==='variable' && 1>5"
            class="pb-safe mx-auto "
            :opened="variationSheetOpened"
            @backdropclick="() => (variationSheetOpened = false)"
        >
            <k-toolbar top>
                <div class="left">Please select a variation</div>
                <div class="right">
                    <mdicon name="close" class="cursor:pointer text-error block" @click="variationSheetOpened = false" />
                    <!--                <k-link toolbar @click="() => (variationSheetOpened = false)"> Done </k-link>-->
                </div>
            </k-toolbar>
            <k-block>
                <div>
                    <div v-for="variation in available_variations" class="grid grid-cols-2 mb-2 items-center">
                        <variation-item :variation="variation" />
                    </div>
                </div>
                <div class="mt-4">
                    <Link :href="route('cart.index')" class="btn btn-primary btn-block">
                        <span class='flex-1'>View cart and checkout</span>
                    </Link>
                    <button @click.prevent="variationSheetOpened = false" class="btn btn-link btn-block">
                        <span class='flex-1'>Continue Shopping</span>
                    </button>
                </div>
            </k-block>
        </k-sheet>

        <k-sheet
            v-if="product.product_type==='variable' && 1>5"
            class="pb-safe"
            :opened="wishlistVariationSheetOpened"
            @backdropclick="() => (wishlistVariationSheetOpened = false)"
        >
            <k-toolbar top>
                <div class="left">Please select a variation</div>
                <div class="right">
                    <mdicon name="close" class="cursor:pointer text-error block" @click="wishlistVariationSheetOpened = false" />
                </div>
            </k-toolbar>
            <k-block>
                <div>
                    <div class="flex gap-2">
                        <template v-for="(variation,index) in available_variations">
                            <label :for="'variation-'+index">
                                <input type="radio" :id="'variation-'+index" class="radio hidden" v-model="wishform.variation" :value="variation.id">
                                <div class="border border-gray-200 p-2" :class="{'border-primary': wishform.variation===variation.id}">{{ variation.attribute.value }}</div>
                            </label>
                        </template>
                    </div>

                </div>
                <div class="mt-4">
                    <button @click="addToWishlist" :disabled="!wishform.variation" class="btn btn-primary btn-block" :class="{'loading': wishform.processing}" >
                        <span class='flex-1'>Add to wishlist</span>
                    </button>
                </div>
            </k-block>
        </k-sheet>

        <div class="fixed bottom-0 z-30 add-to-cart" v-if="product.product_type==='variable'">
            <Popover v-slot="{ open }" class="z-30 bg-white" :class="{'bg-white': variationSheetOpened}">
                <transition
                    enter-active-class="transition duration-200 ease-out"
                    enter-from-class="translate-y-1 opacity-0"
                    enter-to-class="translate-y-0 opacity-100"
                    leave-active-class="transition duration-150 ease-in"
                    leave-from-class="translate-y-0 opacity-100"
                    leave-to-class="translate-y-1 opacity-0"
                >

                    <div v-if="variationSheetOpened">
                        <div class="bg-black opacity-30 fixed inset-0" @click="variationSheetOpened = false"></div>

                        <PopoverPanel class="absolute bottom-0 w-screen max-w-sm px-4 mt-3 bg-white" static>
                            <div class="text-sm border-b mb-2 flex items-center justify-between py-2">
                                <span>Please select a variation</span>
                                <span>
                                <button type="button" class="btn btn-ghost btn-sm btn-circle" @click="variationSheetOpened = false"><mdicon name="close" class="text-red-600" /></button>
                            </span>
                            </div>
                            <div class="">
                                <div>
                                    <div v-for="variation in available_variations" class="grid grid-cols-2 mb-2 items-center">
                                        <variation-item :variation="variation" />
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <Link :href="route('cart.index')" class="btn btn-primary btn-block">
                                        <span class='flex-1'>View cart and checkout</span>
                                    </Link>
                                    <button @click.prevent="variationSheetOpened = false" class="btn btn-link btn-block">
                                        <span class='flex-1'>Continue Shopping</span>
                                    </button>
                                </div>
                            </div>
                        </PopoverPanel>
                    </div>
                </transition>
            </Popover>
        </div>


        <div class="fixed bottom-0 z-30 add-to-wishlist" v-if="product.product_type==='variable'">
            <Popover v-slot="{ open }" class="z-30 bg-white" :class="{'bg-white': wishlistVariationSheetOpened}">
                <transition
                    enter-active-class="transition duration-200 ease-out"
                    enter-from-class="translate-y-1 opacity-0"
                    enter-to-class="translate-y-0 opacity-100"
                    leave-active-class="transition duration-150 ease-in"
                    leave-from-class="translate-y-0 opacity-100"
                    leave-to-class="translate-y-1 opacity-0"
                >

                    <div v-if="wishlistVariationSheetOpened">
                        <div class="bg-black opacity-30 fixed inset-0" @click="wishlistVariationSheetOpened = false"></div>

                        <PopoverPanel class="absolute bottom-0 w-screen max-w-sm px-4 mt-3 bg-white" static>
                            <div class="text-sm border-b mb-2 flex items-center justify-between py-2">
                                <span>Please select a variation</span>
                                <span>
                                <button type="button" class="btn btn-ghost btn-sm btn-circle" @click="wishlistVariationSheetOpened = false"><mdicon name="close" class="text-red-600" /></button>
                            </span>
                            </div>
                            <div class="">
                                <div>
                                    <div class="flex gap-2">
                                        <template v-for="(variation,index) in available_variations">
                                            <label :for="'variation-'+index">
                                                <input type="radio" :id="'variation-'+index" class="radio hidden" v-model="wishform.variation" :value="variation.id">
                                                <div class="border border-gray-200 p-2" :class="{'border-primary': wishform.variation===variation.id}">{{ variation.attribute.value }}</div>
                                            </label>
                                        </template>
                                    </div>

                                </div>
                                <div class="mt-4">
                                    <button @click="addToWishlist" :disabled="!wishform.variation" class="btn btn-primary btn-block" :class="{'loading': wishform.processing}" >
                                        <span class='flex-1'>Add to wishlist</span>
                                    </button>
                                </div>
                            </div>
                        </PopoverPanel>
                    </div>
                </transition>
            </Popover>
        </div>

    </div>

</template>

<script>
    import {Head, Link, useForm, usePage} from '@inertiajs/inertia-vue3';
    import {
        kBlock,
        kBlockFooter,
        kBlockHeader,
        kBlockTitle,
        kSheet,
        kToolbar,
        kStepper,
        kButton,
        kFab
    } from 'konsta/vue';

    import SwiperCore, { Scrollbar, A11y } from 'swiper';
    import { Swiper, SwiperSlide } from 'swiper/vue';
    import 'swiper/css';
    import 'swiper/css/scrollbar';
    import Button from '@/Components/Button'
    import Review from "@/Components/Review";
    import { Inertia } from '@inertiajs/inertia'
    import {computed, ref, onMounted, onUnmounted, watchEffect} from 'vue'
    import VariationItem from "@/Components/Product/VariationItem";
    import useClipboard from 'vue-clipboard3'
    import RelatedProduct from "@/Components/Product/RelatedProduct";
    SwiperCore.use([Scrollbar]);
    import { Popover, PopoverButton, PopoverPanel, PopoverOverlay } from '@headlessui/vue';

    export default {
        name: "ShowProduct",
        props:{
            product: Object,
            gallery: Array,
            reviews: Array,
            wishlist: Object,
            variations: Object,
            available_variations: Object,
            affiliateUrl: String,
            commission: String,
            related:Object
        },
        components:{
            RelatedProduct,
            VariationItem,
            Review,
            Head,
            Link,
            kSheet,
            Swiper,
            SwiperSlide,
            kBlock,
            kBlockFooter,
            kBlockHeader,
            kBlockTitle,
            kToolbar,
            kStepper,
            kButton,
            kFab,
            Button,
            Popover, PopoverButton, PopoverPanel, PopoverOverlay
        },
        setup(props){
            const variationSheetOpened = ref(false);
            const wishlistVariationSheetOpened = ref(false);
            const selVariation = ref(null);

            const cart = ref(null);


            const form = useForm({
                id: props.product.id,
                quantity:1,
            })

            const wishform = useForm({
                id: props.product.id,
                variation: null,
            })

            const { toClipboard } = useClipboard();

            const copy = async () => {
                try {
                    await toClipboard(props.affiliateUrl)
                    console.log('Copied to clipboard')
                } catch (e) {
                    console.error(e)
                }
            }

            const getRating = () => {
                return props.reviews?.reduce(
                    (accumulator, item) => accumulator + item.rating, 0
                );
            }

            const increase = () =>{
                if(cart.value && cart.value.length){
                    // console.log(cart.value['id'])
                    Inertia.patch(route('cart.update'), {
                        quantity: cart.value[0]['quantity'] + 1,
                        id: cart.value[0]['id']
                    },{
                        onSuccess: (resp) => {
                            cart.value = Object.values(resp.props.cartItems).filter((item) =>{
                                return item.associatedModel.id===props.product.id
                            })
                            // quantity.value = cart.value['quantity']
                        }
                    })
                }else {
                    form.post(route('cart.store'), {
                        onSuccess: (resp) => {
                            cart.value = Object.values(resp.props.cartItems).filter((item) =>{
                                return item.associatedModel.id===props.product.id
                            })
                            // quantity.value = cart.value['quantity']
                        }
                    })
                }
            }

            const decrease = () =>{
                if(cart.value && cart.value.length){
                    if(cart.value[0]['quantity'] > 1) {
                        Inertia.patch(route('cart.update'), {
                            quantity: cart.value[0]['quantity'] - 1,
                            id: cart.value[0]['id']
                        }, {
                            onSuccess: (resp) => {
                                cart.value = Object.values(resp.props.cartItems).filter((item) => {
                                    return item.associatedModel.id===props.product.id
                                })
                                // quantity.value = cart.value['quantity']
                            }
                        })
                    }else{
                        // Delete cart
                        Inertia.delete(route('cart.destroy', cart.value[0]['id']), {
                            onSuccess: (resp) => {
                                cart.value = Object.values(resp.props.cartItems).filter((item) => {
                                    return item.associatedModel.id===props.product.id
                                })
                                // quantity.value = cart.value['quantity']
                            }
                        })

                    }
                }
            }

            const addToWishlist = () =>{
                wishform.post(route('product.wishlist.store', props.product.slug),{
                    onSuccess: (resp) => {
                        wishlistVariationSheetOpened.value = false
                        // quantity.value = cart.value['quantity']
                    }
                })
                // Inertia.post(route('product.wishlist.store'), {id: product, variation:variation})
            }

            const decrementQuantity = (id)=>{
                if(props.cart.quantity > 1) {
                    Inertia.patch(route('cart.update'), {
                        quantity: parseInt(props.cart.quantity) - 1,
                        id: props.cart.item.id
                    })
                }
            }
            const incrementQuantity = (id)=>{
                Inertia.patch(route('cart.update'), {
                    quantity: parseInt(props.cart.quantity) + 1,
                    id: props.cart.item.id
                })
            }

            const getCart = () => {
                let c = Object.values(usePage().props.value.cartItems).filter((item) =>{
                    // return item.attributes.some((attribute) => attribute.product_id===props.product.id)
                    return item.associatedModel.id===props.product.id
                })
                if(c.length){
                    // quantity.value = c[0].quantity
                    cart.value = c;
                    // form.cart_id = c[0].id
                }else{
                    cart.value = null
                }
            }

            getCart()

            const getTotalCartItem = computed(() => cart.value && cart.value.length ? cart.value.reduce((accumulator, item) => accumulator + item.quantity, 0) : 0);

            const stickCartBar = ref(false);
            let stickyElement = document.getElementById('sticky-cart');


            const handleScroll = () => {
                // scrollPosition.value = window.scrollY
                console.log('position', event)
                if(stickyElement)
                console.log('offset', stickyElement.offset().top)
            }

            // window.addEventListener("scroll", handleScroll());

            onMounted(() => {
                Inertia.on('success', (event) => {
                    getCart();
                    // stickyTop = stickyTop.offset().top
                });

                const element = document.getElementById("sticky-cart");
                // console.log('scrolly', window.scrollY)
                // console.log('aincontent', window.pageYOffset);
                // console.log(element.offsetTop);
            });

            watchEffect(() => {
                // console.log('scrolly', window.scrollY)
                // console.log('scrolly', window.scrollY)

                // if(stickyElement)
                //     console.log('offset', stickyElement.offsetTop)
            })

            // console.log('aincontent', window.pageYOffset);

            // console.log('scrolly', window.scrollTop())

            onUnmounted(() =>{
                // window.removeEventListener("scroll", handleScroll());
            })

            return {
                variationSheetOpened,
                wishlistVariationSheetOpened,
                modules: [Scrollbar, A11y],
                getRating,
                form,
                addToWishlist,
                decrementQuantity,
                incrementQuantity,
                cart,
                getTotalCartItem,
                increase,
                decrease,
                copy,
                selVariation,
                wishform,
                stickCartBar,
                handleScroll
            }
        },
        computed: {
            // CHANGE 3: create {passive:true} for browser that support it
            scrollEventOptions () {
                let passiveSupported = false

                try {
                    const options = {
                        get passive () { // This function will be called when the browser
                            //   attempts to access the passive property.
                            passiveSupported = true
                            return false
                        }
                    }
                    window.addEventListener('test', null, options)
                    window.removeEventListener('test', null, options)
                } catch (err) {
                    passiveSupported = false
                }
                return passiveSupported ? { passive: true } : false
            }
        },
        methods: {
            check(){
                console.log(111)
            },
            registerEvent () {
                // CHANGE 4: add {passive:true} for browser that support it, or false
                window.addEventListener('scroll', this.check, this.scrollEventOptions)
            },
            removeEvent () {
                // CHANGE 4: add {passive:true} for browser that support it, or false
                window.removeEventListener('scroll', this.check, this.scrollEventOptions)
            }
        },
        mounted () {
            this.registerEvent()
        },
    }
</script>

<style scoped>
    /*.img-slider{*/
    /*    padding-left:0px !important;*/
    /*    padding-right:0px !important;*/
    /*}*/
    /*.swiper {*/
    /*    width: 100%;*/
    /*    height: 100%;*/
    /*}*/

    /*.swiper-slide {*/
    /*    text-align: center;*/
    /*    font-size: 18px;*/
    /*    background: #fff;*/

    /*    !* Center slide text vertically *!*/
    /*    display: -webkit-box;*/
    /*    display: -ms-flexbox;*/
    /*    display: -webkit-flex;*/
    /*    display: flex;*/
    /*    -webkit-box-pack: center;*/
    /*    -ms-flex-pack: center;*/
    /*    -webkit-justify-content: center;*/
    /*    justify-content: center;*/
    /*    -webkit-box-align: center;*/
    /*    -ms-flex-align: center;*/
    /*    -webkit-align-items: center;*/
    /*    align-items: center;*/

    /*    align-self: stretch;*/
    /*    height: 200px*/
    /*}*/

    /*.swiper-slide img,*/
    /*.swiper-slide a img{*/
    /*    display: block;*/
    /*    width: 100%;*/
    /*    height: 100%;*/
    /*    object-fit: cover;*/
    /*    align-self: stretch;*/
    /*    height: 200px*/
    /*}*/
    /*.swiper-container a img{*/
    /*    align-self: stretch;*/
    /*    height: 200px*/
    /*}*/
</style>
