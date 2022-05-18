<x-account-layout>
    <x-slot name="title">Wishlist</x-slot>

<div>
    <h3 class="font-bold text-lg sm:text-xl">My Wishlist</h3>
    <div class="divider mt-0"></div>

    @if($products->count())
    <div class='grid gap-2 sm:gap-4 grid-cols-2 sm:grid-cols-3 2xl:grid-cols-4 mb-3'>
        @foreach ($products as $product)
            <div class="max-w-xs rounded-md overflow-hidden shadow-lg hover:scale-105 transition duration-500 relative bg-white">
                <div>
                    <img src="{{$product->featured_img_thumb}}" alt="{{$product->title}}" class="w-full"/>
                </div>
                <div class="py-4 px-2 bg-white h-full min-h-full">
                    <h3 class="text-xs lg:text-sm font-normal text-gray-600 relative line-clamp-2">
                        <a href="{{ route('product.show', $product->slug) }}">
                            {{$product->title}}
                        </a>
                    </h3>

                    <div class="mt-2 font-thin flex items-center space-x-2">
                        @if($product->sales_price > 0)
                            <p class="text-xs font-medium text-gray-900">{{ $product->formatted_sales_price }}</p>
                        @endif

                        <p class="@if($product->sales_price > 0) text-gray-500 text-xs line-through @else text-gray-900 text-xs font-semibold @endif">
                            {{ $product->formatted_regular_price }}
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @else
    <div>No data</div>
    @endif

</div>
</x-account-layout>
