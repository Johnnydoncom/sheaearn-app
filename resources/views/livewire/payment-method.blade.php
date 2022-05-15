<x-slot name="title">Payment Method</x-slot>

<div class="container">
    <div class="grid grid-cols-3 bg-white text-sm py-1 shadow-sm mb-2">
        <div class="text-center">
            <a href="{{route('checkout.index')}}" class="btn-sm btn-link rounded-btn uppercase">
                Delivery
            </a>
        </div>
        <div class="text-center">
            <span class="btn-sm btn-primary rounded-btn uppercase">
                Payment
            </span>
        </div>
        <div class="text-center">
            <span class="btn-sm rounded-btn uppercase">
                Summary
            </span>
        </div>
    </div>


    <div class="py-0 my-0">
        <div class="flex justify-between items-center">
            <h2 class="px-2 py-2 text-xs uppercase">Select a payment method:</h2>
        </div>

        <div class="card bg-white rounded-md mx-2">
            <div class="card-body p-3">

                <div class="my-4">
                    @foreach ($payment_methods as $method)
                    <x-radio name="payment_method" wire:model.defer="payment_method" value="{{$method->id}}" checked="{{$payment_method===$method->id}}" label="{{$method->title}}" id="gateway-{{$method->id}}" />

                        @if(Str::contains($method->name, 'paystack') || Str::contains($method->name, 'Paystack'))
                            <img src="{{Storage::url('paystack-gateway.png')}}" class="image-full w-full sm:w-60" alt="{{$method->title}}">
                        @endif
                    @endforeach

                </div>

            </div>
        </div>


        <div class="mx-0 rounded-none mt-8 bg-white w-full card card-body rounded-none p-2">
            <div class="flex justify-between mb-2 items-center">
                <span class="font-normal text-md">Items Total</span>
                <span class="font-semibold text-md">{{ $subtotal }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="font-normal text-md">Shipping Fees</span>
                <span class="font-semibold text-md">{{ $shippingCost }}</span>
            </div>
            <div class="divider my-2"></div>
            <div class="flex justify-between items-center">
                <span class="font-semibold text-lg">Total</span>
                <span class="text-primary font-bold text-lg">{{ $total }}</span>
            </div>

            <button wire:click="store" wire:target="store" class="mt-8 btn btn-primary btn-block" wire:loading.attr="disabled" wire:loading.class="loading">Next</button>
            <a href="{{route('cart.index')}}" class="mt-1 btn btn-link btn-block" wire:loading.class="loading">
                Modify Cart
            </a>
        </div>

    </div>
</div>
