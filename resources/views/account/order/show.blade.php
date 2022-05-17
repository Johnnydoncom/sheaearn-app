<x-account-layout>
    <x-slot name="title">Orders</x-slot>

    <div class="pt-2">
        <div class="card rounded-none" >
            <div class="card-body p-0 sm:p-2">
                <p>Order Nº {{$order->order_number }}</p>
                <p class="text-xs sm:text-sm text-gray-400">{{$order->items->count()}} Items</p>
                <p class="text-xs sm:text-sm text-gray-400">Placed on {{$order->created_at}}</p>
                <p class="text-xs sm:text-sm text-gray-400">Total: {{$order->grand_total}}</p>
            </div>
        </div>


        <h3 class="uppercase text-sm p-0 pt-2 sm:p-2">Items in your order</h3>
        <div class="divider my-0"></div>

        @foreach($items as $item)
        <div class="grid grid-cols-3 sm:grid-cols-4 gap-4 items-center">
            <div class="col-span-2">
                <div class="relative flex flex-row space-y-0 space-x-3  p-0 w-full">
                    <div class="w-1/3 bg-white grid place-items-center">
                        <img src="{{$item->product->featured_img_thumb}}" class="rounded-xl w-full sm:w-28" alt="{{$item->product->title}}"  />
                    </div>
                    <div class="w-2/3 bg-white flex flex-col p-0 items-start">
                        <div class="block relative w-full">
                            <p class="text-xs sm:text-sm py-1">{{ $item->name }}</p>
                            <p class="font-light text-xs sm:text-sm text-gray-400 mt-1">QTY: {{ $item->quantity }}</p>
                            <div class="font-light text-xs sm:text-sm text-gray-400 mt-1">
                                @if($item->product->sales_price > 0)
                                <p class="text-sm sm:text-sm font-medium text-gray-900">{{$item->product->formatted_sales_price}}</p>
                                @endif

                                <p class="@if($item->product->sales_price > 0) text-gray-500 text-xs sm:text-sm line-through @else text-gray-900 text-xs sm:text-sm font-normal @endif">
                                    {{ $item->product->formatted_regular_price }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="">
                <div class="uppercase text-sm w-full">
                    @if($order->status==='order_placed' || $order->status==='processing' || $order->status==='shipped' || $order->status==='out_for_delivery')
                        <p class="badge badge-info uppercase badge-xs">
                            {{ ucwords($order->status) }}
                        </p>
                    @elseif($order->status==='delivered' || $order->status==='completed')
                        <p class="badge badge-success uppercase badge-xs">
                            {{ ucwords($order->status) }}
                        </p>
                    @else
                        <p class="badge badge-error uppercase badge-xs">
                            {{ ucwords($order->status) }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="col-span-3 sm:col-span-1">
               <div class="flex flex-col flex-wrap gap-2">
                   <form action="{{ route('account.order.cancelItem', $item->id) }}" method="post">
                       @csrf
                       @method('DELETE')
                       <x-button class="btn btn-primary btn-block btn-xs">
                           <span class='flex-1'>Cancel Item</span>
                       </x-button>
                   </form>
                   @if($item->product->type==='digital')
                       <a href="{{route('account.order.download', $item->order_number)}}" class="btn btn-secondary btn-block btn-xs rounded-none">
                           <span class='flex-1'>Download Item</span>
                       </a>
                   @else
                       <a href="/" class="btn btn-secondary btn-block btn-xs rounded-none">
                           <span class='flex-1'>Track My Item</span>
                       </a>
                   @endif
               </div>
            </div>

        </div>
        @endforeach

    </div>

</x-account-layout>
