@props(['product'])

<div class="max-w-xs rounded-md overflow-hidden shadow-md transition duration-500">
    <a href="{{ route('product.show', $product->slug) }}">
    <img src="{{ $product->featured_img_thumb }}" alt="{{ $product->title }}" />
    </a>
    <div class="py-2 px-2 bg-white">
        <h3 class="text-sm sm:text-base font-normal text-gray-600 relative line-clamp-2">
            <a href="{{ route('product.show', $product->slug) }}">
            {{ $product->title }}
            </a>
        </h3>
        <div class="mt-2 text-lg font-thin">
            @if($product->sales_price > 0)
            <p class="text-sm font-medium text-gray-900">{{$product->formatted_sales_price}}</p>
            @endif

            <p class="{{ $product->sales_price > 0 ? 'text-gray-500 text-xs line-through' : 'text-gray-900 text-md font-semibold'}}">
                {{ $product->formatted_regular_price }}
            </p>
        </div>
    </div>
</div>
