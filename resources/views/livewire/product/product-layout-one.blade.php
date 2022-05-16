
    <div class="max-w-xs rounded-md overflow-hidden shadow-lg hover:scale-105 transition duration-500 relative bg-white">
        <div>
            <img src="{{$product->featured_img_thumb}}" alt="{{$product->title}}" />
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
