<template>
    <Head title="Products" />
    <div>
        <div class="flex justify-between">
            <h3 class="text-2xl font-medium text-gray-700">Products</h3>
            <Link :href="route('admin.products.create')" class="btn btn-primary btn-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19 11h-6V5h-2v6H5v2h6v6h2v-6h6z"></path></svg> Add Product
            </Link>
        </div>

        <div class="flex flex-col mt-8">
            <div class="container py-2">
                <div class="block align-middle border-b border-gray-200 shadow sm:rounded-lg">

                    <table class="min-w-full">
                        <thead class="bg-primary">
                        <tr>
                            <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-white uppercase border-b border-gray-200">
                                 Title

                            </th>
                            <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-white uppercase border-b border-gray-200">
                                Categories
                            </th>
                            <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-white uppercase border-b border-gray-200">
                               Price
                            </th>

                            <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-white uppercase border-b border-gray-200">
                                Status
                            </th>
                            <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-right text-white uppercase border-b border-gray-200">Actions</th>
                        </tr>
                        </thead>

                        <tbody class="bg-white">
                        <tr v-if="products.data.length" v-for="(product, index) in products.data" :key="index">
                            <td class="px-6 py-4 border-b border-gray-200 ">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 w-10 h-10">
                                        <img
                                            class="w-10 h-10"
                                            :src="product.featured_img_thumb"
                                            :alt="product.title"
                                        />
                                    </div>

                                    <div class="ml-4 max-w-xl">
                                        <div class="text-sm font-medium leading-5 text-gray-900">
                                            {{ product.title }}
                                        </div>
                                        <div class="text-sm leading-5 text-gray-500 truncate">
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 border-b border-gray-200">
<!--                                <span class="badge badge-primary badge-sm" v-text="product.category.name"></span>-->
                                <span v-for="category in product.categories" class="badge badge-primary badge-sm" v-text="category.name"></span>
                            </td>
                            <td class="px-6 py-4 border-b border-gray-200">
                                <template v-if="product.product_type !=='variable'">
                                <p v-if="product.stock.sales_price > 0" class="text-sm font-medium text-gray-900 block w-full">{{product.stock.formatted_sales_price}}</p>

                                <p :class="[product.stock.sales_price > 0 ? 'text-gray-500 text-xs line-through' : 'text-gray-900 text-sm font-semibold']">
                                    {{ product.stock.formatted_regular_price }}
                                </p>
                                </template>
                                <template v-else>
                                    <p class="text-gray-900 text-sm font-semibold">{{ product.variation_price }}</p>
                                </template>
                            </td>
                            <td class="px-6 py-4 border-b border-gray-200">
                                <div class="inline-flex px-2 text-xs font-semibold leading-5">
                                    <span class="badge badge-success badge-sm" v-if="product.status==1">Published</span>
                                    <span class="badge badge-danger badge-sm" v-else-if="product.status==2">Draft</span>
                                    <span class="badge badge-danger badge-sm" v-else>Disabled</span>
                                </div>
                            </td>


                            <td class="px-6 py-4 text-sm font-medium leading-5 text-right border-b border-gray-200 space-x-2">
                                <Link :href="route('admin.products.edit', product.id)"  class="btn btn-xs btn-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-4 h-4" viewBox="0 0 24 24"><path d="m7 17.013 4.413-.015 9.632-9.54c.378-.378.586-.88.586-1.414s-.208-1.036-.586-1.414l-1.586-1.586c-.756-.756-2.075-.752-2.825-.003L7 12.583v4.43zM18.045 4.458l1.589 1.583-1.597 1.582-1.586-1.585 1.594-1.58zM9 13.417l6.03-5.973 1.586 1.586-6.029 5.971L9 15.006v-1.589z"></path><path d="M5 21h14c1.103 0 2-.897 2-2v-8.668l-2 2V19H8.158c-.026 0-.053.01-.079.01-.033 0-.066-.009-.1-.01H5V5h6.847l2-2H5c-1.103 0-2 .897-2 2v14c0 1.103.897 2 2 2z"></path></svg>
                                </Link>
<!--                                <a @click.prevent="deleteProduct(product.id)" href="#" class="btn btn-xs btn-error">-->
<!--                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4"><path d="M5 20a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8h2V6h-4V4a2 2 0 0 0-2-2H9a2 2 0 0 0-2 2v2H3v2h2zM9 4h6v2H9zM8 8h9v12H7V8z"></path><path d="M9 10h2v8H9zm4 0h2v8h-2z"></path></svg>-->
<!--                                </a>-->

                                <Link class="btn btn-xs btn-error" :href="route('admin.products.destroy', product.id)" method="delete" as="button" type="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4"><path d="M5 20a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8h2V6h-4V4a2 2 0 0 0-2-2H9a2 2 0 0 0-2 2v2H3v2h2zM9 4h6v2H9zM8 8h9v12H7V8z"></path><path d="M9 10h2v8H9zm4 0h2v8h-2z"></path></svg>
                                </Link>
                            </td>
                        </tr>
                        <tr v-else>
                            <td colspan="5" class="px-6 py-4 border-b border-gray-200 whitespace-nowrap">No data</td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <Pagination
                    class="w-full mt-4 p-0 max-w-full"
                    :links="products.links"
                />

            </div>
        </div>
    </div>
</template>

<script>
    import Admin from "@/Layouts/AdminLayout";
    import Pagination from "@/Components/Pagination/Pagination";
    import { usePage, Link, Head } from '@inertiajs/inertia-vue3'
    import { Inertia } from '@inertiajs/inertia'
    import { watch, ref, reactive } from 'vue'
    import { pickBy, throttle } from 'lodash';
    // import moment from 'moment';

    export default {
        name: "ProductsIndex",
        layout:Admin,
        components: {
            Pagination,
            Link,
            Head
        },
        props: {
            products:Object,
            statuses:Object
        },
        methods: {
            dateTime(value) {
                // return moment(value).format("YYYY-MM-DD hh:mm:ss");
                return 1;
            },
        },
        setup(props){
            // const params = reactive({
            //     search: props.filters.search,
            //     field: props.filters.field,
            //     direction: props.filters.direction,
            // })

            // const sort = (field) => {
            //         params.field = field;
            //         params.direction = params.direction === 'asc' ? 'desc' : 'asc';
            // }
            //
            // watch(
            //     () => params,
            //     (param, prevParams) => {
            //         Inertia.get(route('admin.products.index'), param, {replace:true, preserveState:true});
            //         // console.log('deep', state.attributes.name, prevState.attributes.name)
            //     },
            //     { deep: true }
            // )
            const deleteProduct = async (id) => {
                let response = await axios.delete(route('admin.products.destroy', id))
                    .then(response => {

                    });
            }

            return {
                // params,
                // sort,
                deleteProduct,
            }
        }
    }
</script>

<style scoped>

</style>
