<x-admin-layout>
    <x-slot name="title">{{ __('Edit Order - '.$order->id) }}</x-slot>

    <div>
        <div class="flex w-full gap-4 mt-3">
            <div class="w-3/4">
                <div class="card bg-white rounded-sm">

                    <form method="post" action="{{ route('admin.orders.update', $order->id) }}" class="card-body">
                        @csrf
                        @method('PATCH')
                        <div class="flex">
                            <h2 class="font-semibold text-md"> Order #{{$order->order_number}} details </h2>

                            <a href="{{route('admin.orders.index')}}" class="ml-auto btn btn-primary btn-xs">Back to Orders</a>
                        </div>
                        <p> Payment via {{ $payment->method }}. Customer IP: 188.226.58.86	</p>
                        <div class="flex gap-4 mt-4 w-full">
                            <div class="w-2/4">
                                <h3 class="font-semibold mb-3">General</h3>

                                <div class="form-control w-full max-w-xs mb-3">
{{--                                    <label class="label">--}}
{{--                                        <span class="label-text">Status:</span>--}}
{{--                                    </label>--}}
                                    <x-floating-select label="Status" class="select select-bordered w-full max-w-xs select-sm" name="status">
                                        @foreach($statuses as $key => $status)
                                        <option value="{{$key}}">{{$status}}</option>
                                        @endforeach
                                    </x-floating-select>
                                </div>

                                <div class="form-control w-full max-w-xs">
{{--                                    <label class="label">--}}
{{--                                        <span class="label-text">Customer:</span>--}}
{{--                                    </label>--}}
                                    <x-floating-select name="user_id" label="Customer" class="select select-bordered w-full max-w-xs select-sm">
                                        <option disabled>Select Customer</option>
                                        @foreach($customers as $key => $customer)
                                        <option value="{{$customer->id}}">{{$customer->name}}</option>
                                        @endforeach
                                    </x-floating-select>
                                </div>

                            </div>
                            <div class="w-5/12">
                                <h3 class="font-semibold mb-3">Shipping</h3>
                                <div>
                                    @if($delivery_address)
                                    <div>
                                        <h2 class="font-semibold text-sm">{{$delivery_address->name}}</h2>
                                        <div class="font-light text-sm w-8/12">{{$delivery_address->address}}</div>
                                        <div class="font-light text-sm mt-1">{{$delivery_address->phone}}</div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="w-2/12">&nbsp;</div>
                        </div>


                        <div class="flex justify-between mt-8">
                            <a href="#" class="text-error underline" onclick="event.preventDefault();
                                                document.getElementById('deleteForm').submit();">Move to Trash</a>
                            <x-button class="btn btn-primary">Update</x-button>
                        </div>
                    </form>
                    <form method="POST" id="deleteForm" action="{{ route('admin.orders.destroy', $order->id) }}" class="hidden" style="display: none">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
                @if(1>0)
                <div class="card bg-white rounded-sm mt-2">
                    <div class="card-body">
                        <div class="overflow-x-auto">
                            <table class="table w-full table-compact">
                                <thead>
                                <tr>
                                    <th>Item</th>
                                    <th class="w-8">Cost</th>
                                    <th class="w-8">Qty</th>
                                    <th class="w-8">Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($orderItems as $item)
                                    <tr class="text-sm">
                                    <td>
                                        <div class="flex gap-4 items-center">
                                            <img src="{{$item->product->featured_img_thumb}}" alt="" class="w-10">
                                            <a href="{{route('product.show', $item->product->slug)}}" class="underline text-blue-600">{{ $item->product->title }}</a>
                                        </div>
                                    </td>
                                    <td>{{ $item->current_price }}</td>
                                    <td><span class="text-gray-400">x </span>{{ $item->quantity }}</td>
                                    <td>{{ $item->total }}</td>
                                </tr>
                                @endforeach
                                </tbody>
                                <tfoot class="normal-case">
                                <tr>
                                    <td colspan="4">
                                        <table class="w-full border-t border-gray-400 pt-5">
                                            <tr>
                                                <td></td>
                                                <td class="w-32 text-right normal-case font-normal">Items Subtotal: </td>
                                                <td class="w-32 text-right"><span class="font-bold">{{ app_money_format($order->items()->sum('amount')) }}</span></td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td class="w-32 text-right normal-case font-normal">Shipping Cost: </td>
                                                <td class="w-32 text-right"><span class="font-bold">{{ app_money_format($order->shipping_charges) }}</span></td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td class="w-32 text-right normal-case font-normal">Order Total: </td>
                                                <td class="w-32 text-right"><span class="font-bold">{{ $order->total }}</span></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <!--                                    <tr>-->
                                <!--                                        <td colspan="2">&nbsp;</td>-->
                                <!--                                        <td class="w-20"></td>-->
                                <!--                                        <td class="w-20">-->
                                <!--                                            <span class="font-bold">{{ $order->total }}</span>-->
                                <!--                                        </td>-->
                                <!--                                    </tr>-->
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

</x-admin-layout>
