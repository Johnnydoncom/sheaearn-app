<x-slot name="title">Checkout</x-slot>

<div class="container">
    <div class="grid grid-cols-3 bg-white text-sm py-1 shadow-sm mb-2">
        <div class="text-center">
            <span class="btn-sm rounded-btn uppercase">
                Delivery
            </span>
        </div>
        <div class="text-center">
            <span class="btn-sm rounded-btn uppercase">
                Payment
            </span>
        </div>
        <div class="text-center">
            <span class="btn-sm rounded-btn uppercase">
                Summary
            </span>
        </div>
    </div>


    <div class="py-0 my-0 mt-0 relative">
        <h2 class="uppercase text-xs mt-0 border-b">
            <div class="flex justify-between items-center w-full">
                <h2 class="uppercase px-2 sm:px-0 py-2 text-sm sm:text-xl sm:font-semibold">Your address</h2>
                <a href="{{route('checkout.shipping')}}" class="text-primary">
                    Change Address
                </a>
            </div>
        </h2>

        <div class="card bg-white rounded-sm">
            <div class="card-body p-2">
                @if($delivery_address)
                <div>
                    <h2 class="font-semibold text-sm">{{$delivery_address->name}}</h2>
                    <div class="font-light text-sm w-8/12">{{$delivery_address->address}}</div>
                    <div class="font-light text-sm mt-1">{{$delivery_address->phone}}</div>
                </div>
                @else
                <div>
                    <a class="text-primary px-2 py-2" href="{{route('checkout.shipping')}}">
                        Add Address
                    </a>
                </div>
                @endif
            </div>
        </div>


        <h3 class="uppercase px-2 text-sm sm:text-xl sm:font-semibold border-b mt-6 mb-2">My Cart ({{ Cart::getContent()->count() }} Items)</h3>

        @if(count($cart) > 0)
        <div>
            @foreach ($cart as $c)
            <x-cart.item :cart="$c" />
            @endforeach

        </div>
        @else
        <div class="card card-body rounded-none text-center">
            <div class="p-10 text-center flex flex-col justify-center">
                <img src="{{ Storage::url('empty-cart.png') }}" class="w-1/2 mx-auto" alt="Empty Cart" />
                <h3 class="mt-3 font-bold text-gray-400">Your cart is empty!</h3>
            </div>
            <a href="{{route('index')}}" class="btn btn-link">Start Shopping</a>
        </div>
        @endif

        <div class="card mt-4 bg-white rounded-none">
            <div class="card-body p-0">
                <div class="flex justify-between">
                    <span class="font-normal text-lg">Total</span>
                    <span class="text-primary font-bold text-lg">{{ $total }}</span>
                </div>
                <div class="flex justify-end mb-2">
                    <small> Delivery fee not included yet</small>
                </div>

                <div class="w-full sm:w-1/3 sm:ml-auto max-w-full">
                    @if($delivery_address)
                    <a href="{{route('checkout.payment-method.index')}}" class="btn btn-primary btn-block">
                        <span class='flex-1'>Next</span>
                    </a>
                    @else
                    <button class="btn btn-primary btn-block" disabled="disabled">
                        <span class='flex-1'>Next</span>
                    </button>
                    @endif

                    <a href="{{route('cart.index')}}" class="btn btn-link btn-block">
                        <span class='flex-1'>Modify Cart</span>
                    </a>
                </div>

            </div>
        </div>

    </div>

</div>
