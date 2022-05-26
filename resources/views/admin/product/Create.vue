<template>
    <Head>
        <title>Add New Product</title>
    </Head>
    <div>
        <div class="flex justify-between">
            <h3 class="text-2xl font-medium text-gray-700">Add Product</h3>
            <Link :to="route('admin.products.index')" class="btn btn-primary btn-sm">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-4 h-4" fill="currentColor"><path d="M21 11H6.414l5.293-5.293-1.414-1.414L2.586 12l7.707 7.707 1.414-1.414L6.414 13H21z"></path></svg>
                All Products
            </Link>
        </div>

        <form @submit.prevent="submit">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-2">
                <div class="card mt-4 rounded bg-white rounded overflow-hidden shadow-xl md:p-5 md:col-span-3 ">
                    <div class="card-body p-4 md:p-5">
                        <div class="form-control">
                            <label class="label"><span class="label-text">Product Title</span></label>
                            <div class="relative mt-2 rounded-md shadow-sm">
                                <input type="text" v-model="form.title" class="w-full input input-bordered"/>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="py-6 form-control">
                            <label class="label"><span class="label-text">Description</span></label>
                            <div class="relative mt-2 rounded-md shadow-sm">
                                <quill-editor
                                    v-model:value="form.description"
                                    :options="{placeholder: 'Description'}"
                                    class="min-h-48"
                                    height="300"
                                />
                            </div>
                        </div>


                        <div class="border border-slate-300 mb-4">
                            <div class="w-full flex items-center gap-2 md:gap-4 p-2 md:p-3">
                                <label class="label w-48"><span class="label-text">Product Type -</span></label>
                                <div class="form-control w-full">
                                    <select v-model="form.product_type" class="select select-bordered select-md w-full" id="productType" aria-label="Product type">
                                        <option v-for="(ptype,index) in productTypes" :value="index">{{ ptype }}</option>
                                    </select>
                                </div>
                            </div>

                            <TabGroup as="div" class="flex border-t border-slate-300" vertical>
                                <TabList as="div" class="w-1/3 flex flex-col border-r border-slate-300">
                                    <Tab v-slot="{ selected }" as="template" v-if="form.product_type !== 'variable'">
                                        <a
                                            class="px-2 md:px-4 py-4 text-sm flex space-x-1 md:space-x-3 items-center border-b border-slate-200 cursor-pointer"
                                            :class="[selected ? 'font-bold bg-gray-200' : 'border-slate-200']"
                                        >
                                           <mdicon name="wrench-outline" :width="15" :height="15" aria-hidden="true" /><span>General</span>
                                        </a>
                                    </Tab>
                                    <Tab v-slot="{ selected }" as="template">
                                        <a
                                            class="px-2 md:px-4 py-4 text-sm flex space-x-1 md:space-x-3 items-center border-b border-slate-200 cursor-pointer"
                                            :class="[selected ? 'font-bold bg-gray-200' : 'border-slate-200']"
                                        >
                                            <mdicon name="animation" :width="15" :height="15" aria-hidden="true" /><span>Inventory</span>
                                        </a>
                                    </Tab>

                                    <Tab v-slot="{ selected }" as="template">
                                        <a
                                            class="px-2 md:px-4 py-4 text-sm flex space-x-1 md:space-x-3 items-center border-b border-slate-200 cursor-pointer"
                                            :class="[selected ? 'font-bold bg-gray-200' : 'border-slate-200']"
                                        >
                                            <mdicon name="theme-outline" :width="15" :height="15" aria-hidden="true" /><span>Attributes</span>
                                        </a>
                                    </Tab>

                                    <Tab v-slot="{ selected }" as="template" v-if="form.product_type==='variable'">
                                        <a
                                            class="px-2 md:px-4 py-4 text-sm flex space-x-1 md:space-x-3 items-center border-b border-slate-200 cursor-pointer"
                                            :class="[selected ? 'font-bold bg-gray-200' : 'border-slate-200']"
                                        >
                                            <mdicon name="theme-outline" :width="15" :height="15" aria-hidden="true" /><span>Variations</span>
                                        </a>
                                    </Tab>


                                    <Tab v-slot="{ selected }" as="template">
                                        <a
                                            class="px-2 md:px-4 py-4 text-sm flex space-x-1 md:space-x-3 items-center border-b border-slate-200 cursor-pointer"
                                            :class="[selected ? 'font-bold bg-gray-200' : 'border-slate-200']"
                                        >
                                            <mdicon name="atom" :width="15" :height="15" aria-hidden="true" /><span>Extras</span>
                                        </a>
                                    </Tab>

                                </TabList>
                                <TabPanels class="w-2/3 m p-2 d:p-4">
                                    <TabPanel v-if="form.product_type != 'variable'">
<!--                                        <div class="form-control w-full">-->
<!--                                            <label class="label"><span class="label-text">Product Type</span></label>-->
<!--                                            <select v-model="form.product_type" class="select select-bordered input-md" id="productType" aria-label="Product type">-->
<!--                                                <option value="" selected>&#45;&#45;select&#45;&#45;</option>-->
<!--                                                <option v-for="(type,index) in productTypes" :value="index">{{type}}</option>-->
<!--                                            </select>-->
<!--                                        </div>-->

                                        <div class="form-control w-full">
                                            <label class="label"><span class="label-text">Regular Price</span></label>
                                            <input type="text" v-model="form.regular_price" class="w-full input input-bordered input-md"/>
                                        </div>
                                        <div class="form-control w-full">
                                            <label class="label"><span class="label-text">Sales Price</span></label>
                                            <input type="text" v-model="form.sales_price" class="w-full input input-bordered input-md"/>
                                        </div>
                                    </TabPanel>

                                    <!-- Inventory-->
                                    <TabPanel>
                                        <div class="flex items-center mb-2">
                                            <div class="w-1/3">
                                                <label class="label"><span class="label-text">SKU</span></label>
                                            </div>
                                            <div class="form-control w-2/3">
                                                <input type="text" v-model="form.sku" class="input input-bordered input-md"/>
                                            </div>
                                        </div>

                                        <div class="flex items-center mb-2">
                                            <div class="w-1/3">
                                                <label class="label"><span class="label-text">Stock Status</span></label>
                                            </div>
                                            <div class="w-2/3">
                                                <select v-model="form.stock_status" class="select select-bordered input-md" id="stockStatus" aria-label="Stock Status">
                                                    <option value="instock">In Stock</option>
                                                    <option value="outofstock">Out of Stock</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="flex items-center mb-2">
                                            <div class="w-1/3">
                                                <label class="label"><span class="label-text">Sold individually</span></label>
                                            </div>
                                            <div class="w-2/3">
                                                <div class="form-control mt-4">
                                                    <label class="flex items-center">
                                                        <BreezeCheckbox name="terms" v-model="form.sold_individually" />
                                                        <span class="ml-2 text-xs text-gray-600">Enable this to only allow one of this item to be bought in a single order</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="flex items-center mb-2">
                                            <div class="w-1/3">
                                                <label class="label"><span class="label-text">Manage stock?</span></label>
                                            </div>
                                            <div class="w-2/3">
                                                <div class="form-control mt-4">
                                                    <label class="flex items-center">
                                                        <BreezeCheckbox name="terms" v-model="form.manage_stock" />
                                                        <span class="ml-2 text-xs text-gray-600">Enable stock management at product level</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="flex items-center mb-2" v-if="form.manage_stock">
                                            <div class="w-1/3">
                                                <label class="label"><span class="label-text">Stock quantity</span></label>
                                            </div>
                                            <div class="form-control w-2/3">
                                                <input type="number" v-model="form.stock_quantity" class="input input-bordered input-md"/>
                                            </div>
                                        </div>

                                    </TabPanel>
                                    <TabPanel>
                                        <div class="flex ">
                                            <div class="form-control w-2/3">
                                                <div class="flex space-x-2">
                                                    <select class="select select-bordered select-md w-full" v-model="selAttribute" aria-label="Product type">
                                                        <option value="custom" selected>Custom product attribute</option>
                                                        <option v-for="attr in attributes" :value="attr.code" :disabled="form.attributes.some(item => item.name === attr.name)">{{attr.name}}</option>
                                                    </select>
                                                    <button type="button" class="btn btn-primary" @click.prevent="addAttribute">Add</button>
                                                </div>
                                            </div>
                                        </div>



                                        <template v-for="(attribute,index) in form.attributes">
                                            <div class="w-full grid md:grid-cols-3 gap-3 mb-3">
                                                <div class="form-control w-full col-span-1">
                                                    <label class="label"><span class="label-text">Name:</span></label>
                                                    <input v-if="attribute.type === 'custom'" v-model="form.attributes[index].name" type="text" class="input input-bordered input-md">
                                                    <h3 v-else v-text="attribute.name"></h3>
                                                </div>
                                                <div class="col-span-2">
                                                <div class="w-full flex">
                                                    <div class="form-control w-full">
                                                        <label class="label"><span class="label-text">Values:</span></label>
                                                        <textarea v-if="attribute.type === 'custom'" class="input input-textarea h-24 textarea-bordered" v-model="form.attributes[index].value" placeholder='Enter some text, or some attributes by "|" separating values.'></textarea>
<!--                                                        <input v-else type="text" class="input input-bordered" v-model="form.attributes[index].value">-->
                                                        <div v-else>
                                                            <Multiselect
                                                                v-model="form.attributes[index].value"
                                                                :options="form.attributes[index].value"
                                                                mode="tags"
                                                                :caret="false"
                                                                :createTag="true"
                                                                :createOption="true"
                                                                :searchable="true"
                                                            />
                                                        </div>
                                                    </div>
                                                    <div class="action flex">
                                                        <!-- Remove Svg Icon-->
                                                        <svg
                                                            @click="removeAttribute(index)"
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
                                        </template>
                                    </TabPanel>
                                    <TabPanel v-if="form.product_type==='variable'">
                                        <div class="flex ">
                                            <div class="form-control w-2/3">
                                                <div class="flex space-x-2">
                                                    <select class="select select-bordered select-md w-full" v-model="selVariationOpt" aria-label="Product type">
                                                        <option v-for="attr in [{id:'createall', name:'Create variations from size attribute'}]" :value="attr.id">{{attr.name}}</option>
                                                    </select>
                                                    <button type="button" class="btn btn-primary" @click.prevent="addVariation">Go</button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="py-3">

                                            <div class="variation border border-primary mb-2 p-2" v-for="(variation,index) in form.variations">
                                                <h4 class="mb-2 font-semibold">{{ variation.attribute }} - {{ variation.attribute_value }}</h4>
                                                <div class="grid grid-cols-2 gap-4">
                                                    <div class="form-control w-full">
                                                        <label class="label"><span class="label-text">SKU</span></label>
                                                        <input type="text" v-model="form.variations[index].sku" class="w-full input input-bordered input-md"/>
                                                    </div>
                                                    <div class="form-control w-full">
                                                        <label class="label"><span class="label-text">Quantity In Stock</span></label>
                                                        <input type="text" v-model="form.variations[index].stock_quantity" class="w-full input input-bordered input-md"/>
                                                    </div>
                                                </div>
                                                <div class="grid grid-cols-2 gap-4">
                                                    <div class="form-control w-full">
                                                        <label class="label"><span class="label-text">Regular Price</span></label>
                                                        <input type="text" v-model="form.variations[index].regular_price" class="w-full input input-bordered input-md"/>
                                                    </div>
                                                    <div class="form-control w-full">
                                                        <label class="label"><span class="label-text">Sales Price</span></label>
                                                        <input type="text" v-model="form.variations[index].sales_price" class="w-full input input-bordered input-md"/>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                    </TabPanel>
                                    <TabPanel>
                                        <div class="py-3">
                                            <div class="form-control">
                                                <label>Downloadable File</label>
                                                <input type="file" class="input" @input="form.digital_file = $event.target.files[0]" required>
                                            </div>
                                        </div>
                                    </TabPanel>
                                </TabPanels>
                            </TabGroup>
                        </div>


                        <div class="md:flex gap-3 w-full">
                            <div class="w-full md:w-1/3">
                                <div class="form-control">
                                    <label class="label"><span class="label-text">Featured Image</span></label>
                                    <div class="relative rounded-md shadow-sm">
                                        <label
                                            class="
                                        p-6
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
                                            <img v-if="featuredImageUrl" class="w-full h-24" :src="featuredImageUrl" alt="Featured Image Placeholder">
                                            <svg v-else class="h-24" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                                            </svg>

                                            <input type="file" @input="pickFile($event)" class="hidden" />
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="w-full md:w-2/3">
                                <div class="">
                                    <label class="label"><span class="label-text">Gallery Images</span></label>
                                    <div class="grid grid-cols-4 gap-2">
                                        <div v-for="(gallery,index) in galleryUrls" class="relative">
                                            <img :src="gallery" class="h-full">
                                            <a class="absolute right-0 top-0 cursor-pointer" @click="removeGallery(index)">
                                                <mdicon name="close" class="block h-4 w-4 m-1 text-error" aria-hidden="true" />
                                            </a>
                                        </div>
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
                                                    <input type="file" @input="pickGalleryFile($event)" class="hidden" multiple />
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>



                    </div>
                </div>

                <div class="mt-4 rounded bg-white rounded overflow-hidden shadow-xl p-5">
                    <label class="label"><span class="label-text">Categories</span></label>
                    <div class="card h-64 mb-4 overflow-auto">
                        <div class="card-body">
                            <div class="space-y-4">
                                <template v-for="(parent, optionIdx) in categories" :key="parent.id">
                                    <div class="flex items-center">
                                        <input :id="`filter-${parent.id}`" :value="parent.id" type="checkbox" class="h-4 w-4 border-gray-300 rounded text-primary focus:ring-primary" v-model="form.category_ids" />
                                        <label :for="`filter-${parent.id}`" class="ml-3 text-sm text-gray-600">
                                            {{ parent.name }}
                                        </label>
                                    </div>

                                    <template v-for="(child1, optionId1) in parent.children_recursive" :key="child1.id">
                                        <div class="pl-3 flex items-center">
                                            <input :id="`filter-${child1.id}`" :value="child1.id" type="checkbox" class="h-4 w-4 border-gray-300 rounded text-primary focus:ring-primary" v-model="form.category_ids" />
                                            <label :for="`filter-${child1.id}`" class="ml-3 text-sm text-gray-600">
                                                {{ child1.name }}
                                            </label>
                                        </div>

                                        <template v-for="(child2, optionId2) in child1.children_recursive" :key="child2.id">
                                            <div class="pl-8 flex items-center">
                                                <input :id="`filter-${child2.id}`" :value="child2.id" type="checkbox" class="h-4 w-4 border-gray-300 rounded text-primary focus:ring-primary" v-model="form.category_ids" />
                                                <label :for="`filter-${child2.id}`" class="ml-3 text-sm text-gray-600">
                                                    {{ child2.name }}
                                                </label>
                                            </div>
                                        </template>

                                    </template>
                                </template>
                            </div>
                        </div>
                    </div>


                    <div class="form-control w-full mb-3">
                        <label class="label"><span class="label-text">Brand</span></label>
                        <select v-model="form.brand_id" class="select select-bordered" id="brand" aria-label="Brand">
                            <option value="" selected>--select--</option>
                            <option v-for="(b,index) in brands" :value="b.id">{{b.name}}</option>
                        </select>
                    </div>


                    <div class="form-control mb-3">
                        <label class="label"><span class="label-text">Commission (Optional)</span></label>
                        <div class="relative rounded-md shadow-sm">
                            <input type="text" v-model="form.commission" class="w-full input input-bordered"/>
                        </div>
                    </div>

                    <div class="form-control py-3">
                        <label class="cursor-pointer label justify-start space-x-3">
                            <input type="checkbox" v-model="form.featured" class="checkbox checkbox-primary">
                            <span class="label-text">Featured</span>
                        </label>
                    </div>


                    <button class="btn btn-primary btn-block mt-4" type="submit" :disabled="form.processing">Submit</button>
                    <div class="block mt-2">
                        <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                            {{ form.progress.percentage }}%
                        </progress>
                    </div>
                </div>
            </div>
        </form>

    </div>
</template>

<script>
    import Admin from "@/Layouts/AdminLayout";
    import Pagination from "@/Components/Pagination/Pagination";
    import { usePage, Link, useForm } from '@inertiajs/inertia-vue3'
    import { computed, ref, onMounted, reactive } from 'vue'
    import Select2 from 'vue3-select2-component';
    import FSelect2 from "@/Components/Admin/FSelect2";
    import { TabGroup, TabList, Tab, TabPanels, TabPanel } from '@headlessui/vue'
    import BreezeLabel from "@/Components/Label";
    import BreezeCheckbox from "@/Components/Checkbox";
    import BreezeRadio from "@/Components/Radio";

    import { quillEditor, Quill } from 'vue3-quill'
    // import customQuillModule from 'customQuillModule'
    // Quill.register('modules/customQuillModule', customQuillModule)
    import Multiselect from '@vueform/multiselect'
    export default {
        name: "CreateProduct",
        layout:Admin,
        components: {
            FSelect2,
            Pagination,
            Link,
            Select2,
            TabGroup,
            TabList,
            Tab,
            TabPanels,
            TabPanel,
            BreezeLabel,
            BreezeCheckbox,
            BreezeRadio,
            quillEditor,
            Multiselect
        },
        props: {
            brands: Object,
            pickup_dates: Object,
            countries: Object,
            categories:Object,
            auctioneer:Object,
            auction:Object,
            attributes:Object,
            productTypes:Object
        },
        setup(props){
            const featuredImageUrl = ref(null)

            const galleryUrls = ref([])

            const selAttribute = ref('custom')

            const selVariationOpt = ref('createall')


            const form = useForm({
                title: null,
                description: null,
                category_id: null,
                category_ids:[],
                sub_category_id:null,
                sub_category_id1:null,
                sub_category_id2:null,
                brand_id: null,
                regular_price:null,
                sales_price:null,
                product_type:'simple',
                featured:false,
                featured_image:null,
                digital_file:null,
                gallery:[],
                sku:null,
                stock_status: 'instock',
                sold_individually:false,
                manage_stock:false,
                stock_quantity:0,
                commission:0,
                attributes:[],
                variations: []
            })

            const addVariation = () => {
                let attr = form.attributes.filter((at) => at.code === 'size')

                if(attr.length) {
                    attr[0].value.forEach(function(currentValue, index){
                        form.variations.push({
                            sku: null,
                            regular_price: null,
                            sales_price: null,
                            stock_quantity: null,
                            attribute: attr[0].name,
                            attribute_code: attr[0].code,
                            attribute_value: currentValue
                        })
                    })

                }
            }
            const addAttribute = () =>{
                if(selAttribute.value === 'custom'){
                    form.attributes.push({
                        name: null,
                        value: null,
                        type: 'custom',
                        code:null,
                        id:null
                    })
                }else {
                    let att = props.attributes.filter((at) => at.code===selAttribute.value)
                    form.attributes.push({
                        name: att[0].name,
                        value: null,
                        type:null,
                        code: att[0].code,
                        id:att[0].id
                    })
                }
            }

            const pickFile = (e) => {
                let input = e.target
                let file = input.files
                if (file && file[0]) {
                    let reader = new FileReader
                    reader.onload = e => {
                        featuredImageUrl.value = e.target.result
                        form.featured_image = file[0]
                    }
                    reader.readAsDataURL(file[0])
                }
            }

            const pickGalleryFile = (e) =>{
                let input = e.target
                let files = input.files
                if(!files.length) return;

                for(let i = 0;i < files.length;i++){
                    if (files[i]) {
                        let reader = new FileReader
                        reader.onload = e => {
                            galleryUrls.value.push(e.target.result)
                            form.gallery.push(files[i])
                        }
                        reader.readAsDataURL(files[i])
                    }
                }
            }

            const removeGallery = (i) =>{
                form.gallery.splice(form.gallery.indexOf(form.gallery[i]), 1);
                galleryUrls.value.splice(galleryUrls.value.indexOf(galleryUrls.value[i]), 1);
            }

            const setFieldType = (index, id) =>{
                let att = props.attributes.filter((value) => value.id==id);
                form.attributes[index].type = att[0].frontend_type
                // console.log('aaa: ',att[0].name)
            }

            const removeAttribute = (index, id) =>{
                form.attributes.splice(index, 1)
                // form.gallery.splice(form.gallery.indexOf(form.gallery[i]), 1);
            }

            const submit = () => {
                form.transform((data) => ({
                    ...data,
                    featured: data.featured ? 'on' : '',
                    manage_stock: data.manage_stock ? 'on' : '',
                    sold_individually: data.sold_individually ? 'on' : ''
                })).post(route('admin.products.store'))
            }


            return {
                selAttribute,
                pickFile,
                pickGalleryFile,
                removeGallery,
                galleryUrls,
                form,
                featuredImageUrl,
                addAttribute,
                removeAttribute,
                setFieldType,
                submit,
                selVariationOpt,
                addVariation
            }
        }
    }
</script>

<style scoped>
    .ql-container {
        @apply min-h-48 !important;
        min-height: 20em !important;
    }
</style>
<style src="@vueform/multiselect/themes/default.css"></style>
