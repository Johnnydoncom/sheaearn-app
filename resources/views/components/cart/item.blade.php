@props(['cart'])

<div class="card bg-white shadow-lg mb-2" x-data="{alertOpen:false}">
    <div class="card-body p-2">
        <div class="relative flex flex-row space-y-0 space-x-2  p-0 w-full">
            <div class="w-1/3 bg-white grid place-items-center">
                <img src="{{$cart->attributes->image}}" class="rounded-xl sm:h-32" alt="{{$cart->name}}"  />
            </div>
            <div class="w-2/3 bg-white flex flex-col p-0 items-start">

                <h3 class="text-md pt-1"><a href="{{$cart->attributes->product_url}}">{{ $cart->name }}</a></h3>

                <div class='price my-2 flex items-center space-x-2'>
                    @if($cart->attributes->sales_price > 0)
                    <p class="text-md font-bold text-primary">{{ $cart->attributes->formatted_sales_price }}</p>
                    @endif

                    <p class="{{ $cart->attributes->sales_price > 0 ? 'text-gray-500 text-sm line-through' : 'text-gray-900 text-md font-bold' }}">{{ $cart->attributes->formatted_regular_price }}</p>
                    <span class="text-gray-400">x {{$cart->quantity}}</span>
                </div>
            </div>
        </div>

        <div class="divider divider-x my-0"></div>

        {{-- cart action --}}
        <div class="grid grid-cols-2 sm:grid-cols-4">
            <div class="flex sm:col-span-3">
                <button type="button" class="text-primary font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center uppercase" @click="alertOpen=true" data-bs-toggle="modal" data-bs-target="#deleteModal{{$cart->id}}">
                    <x-cui-cil-trash class="w-4 h-4 sm:w-6 sm:h-6"/> Remove
                </button>
            </div>
            <div class="flex justify-end">


                <div class="flex items-center justify-between w-full">
                    <button wire:click="$emitTo('cart-action', 'updateCart', '{{$cart->id}}', {{$cart->quantity-1}})" class="btn btn-primary btn-sm rounded-lg border-none shadow-md @if($cart->quantity < 1) opacity-50 @endif" wire:loading.class="loading" @if($cart->quantity < 2) disabled="disabled" @endif><x-cui-cil-minus class="w-4 h-4 sm:w-6 sm:h-6"/></button>

                    <span>{{$cart->quantity}}</span>

                    <button wire:click.prevent="$emitTo('cart-action', 'updateCart', '{{$cart->id}}', {{$cart->quantity+1}})" @if($cart->manage_stock && $cart->quantity >= $cart->available_quantity) disabled="disabled" @endif class="btn btn-primary btn-sm rounded-lg border-none shadow-md" wire:loading.class="loading"><x-cui-cil-plus class="w-4 h-4 sm:w-6 sm:h-6"/></button>
                </div>

            </div>
        </div>



        <div class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto" id="deleteModal{{$cart->id}}" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-modal="true" role="dialog">
            <div class="modal-dialog modal-dialog-centered relative w-auto">
                <div class="modal-content border-none shadow-lg relative flex flex-col w-full bg-white bg-clip-padding rounded-md outline-none text-current">
                    <div class="modal-body relative p-4 text-center">
                        <h3 class="text-xl font-bold py-5">Do you really want to remove this item from cart?</h3>
                    </div>

                    <div class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-between p-4 border-t border-gray-200 rounded-b-md">
                        <button type="button" class="btn btn-outline btn-primary shadow-md" data-bs-dismiss="modal">
                            Cancel
                        </button>
                        <button type="button" class="btn btn-primary" wire:click="$emitTo('cart-action', 'removeCart', '{{$cart->id}}')">
                            Remove Item
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- end cart action --}}

    </div>
</div>
