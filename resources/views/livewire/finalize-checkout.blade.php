<div class="container">
    <div class="grid grid-cols-3 bg-white text-sm shadow-sm mb-2 py-2">
        <div class="text-center">
            <a href="{{route('checkout.index')}}" class="btn-sm btn-link rounded-btn uppercase">
                Delivery
            </a>
        </div>
        <div class="text-center">
            <a href="{{route('checkout.payment-method.index')}}" class="btn-sm btn-link rounded-btn uppercase">
                Payment
            </a>
        </div>
        <div class="text-center">
            <span class="btn-sm btn-primary rounded-btn uppercase">
                Summary
            </span>
        </div>
    </div>
    <div class="py-0 my-0 mt-0 relative">
        <h3 class="uppercase text-xs sm:text-lg md:text-2xl mt-0 pt-3">Order Summary</h3>
        <div class="divider mt-0"></div>

        <div strong class="card bg-white mb-4 rounded-none">
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

        </div>

        <div class="uppercase text-xs mt-0 sm:mt-10">
            <div class="flex justify-between items-center w-full">
                <h2 class="uppercase sm:text-lg">Customer address</h2>

                <a href="{{ route('checkout.shipping') }}" class="text-primary">
                    Change
                </a>
            </div>
            <div class="divider my-0"></div>
        </div>

        <div strong class="card bg-white mb-4 rounded-none">
            <div class="card bg-white rounded-sm">
                <div class="p-0">
                    <h2 class="font-semibold text-sm">{{$delivery_address->name}}</h2>
                    <div class="font-light text-sm w-8/12">{{$delivery_address->address}}</div>
                    <div class="font-light text-sm mt-1">{{$delivery_address->phone}}</div>
                </div>
            </div>
        </div>

        <div class="uppercase text-xs mt-0 sm:mt-10">
            <div class="flex justify-between items-center w-full">
                <h2 class="uppercase sm:text-lg">Payment Method</h2>
                <a href="{{route('checkout.payment-method.index')}}" class="text-primary">
                    Change
                </a>
            </div>
            <div class="divider my-0"></div>
        </div>

        <div strong class="card mb-0 rounded-none">
            <div class="card-body p-0 bg-white rounded-none">
                <div class="p-0">
                    <h2 class="font-semibold text-sm">{{$payment_method->title}}</h2>
                    <div class="font-light text-sm w-8/12">{{$payment_method->subtitle}}</div>
                </div>
            </div>
        </div>

        <div strong class="card bg-white mt-0 sm:mt-10 rounded-none">
            @if(Str::contains($payment_method->name, 'paystack') || Str::contains($payment_method->name, 'Paystack'))
                <button wire:click.prevent="payWithPaystack" class="btn btn-primary btn-block mb-2">Confirm</button>
            @else
                <button class="btn btn-primary btn-block mb-2" wire:click.prevent="payOnDelivery" >Confirm</button>
            @endif
            <a class="btn btn-link btn-block shadow-sm" href="{{ route('cart.index') }}">
                Modify Cart
            </a>
        </div>

    </div>

</div>
