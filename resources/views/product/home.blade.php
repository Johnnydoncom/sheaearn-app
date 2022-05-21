<x-app-layout>
    <div class="container">
        <h2 class="py-6 sm:py-10 font-semibold text-2xl sm:text-4xl">
            <span>Shop Online in Nigeria</span>
        </h2>
        <div class="mb-0 pb-4">
            <div class='grid gap-2 sm:gap-4 grid-cols-2 sm:grid-cols-4 mb-3'>
                @foreach ($products as $product)
                    <div class="">
                        @livewire('product.product-layout-one', ['product'=>$product])
                    </div>
                @endforeach
            </div>
            {{ $products->links() }}

            {{--        <Pagination--}}
            {{--            class="w-full mt-4 p-0 max-w-full"--}}
            {{--            :current_page="products.current_page"--}}
            {{--            :first_page_url="products.first_page_url"--}}
            {{--            :next_page_url="products.next_page_url"--}}
            {{--            :prev_page_url="products.prev_page_url"--}}
            {{--            :last_page="products.last_page"--}}
            {{--            :from="products.from"--}}
            {{--            :to="products.to"--}}
            {{--            :per_page="products.per_page"--}}
            {{--            :path="products.path"--}}
            {{--            :total="products.total"--}}
            {{--        />--}}
        </div>
    </div>

</x-app-layout>
