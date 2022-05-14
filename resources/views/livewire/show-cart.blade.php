<x-slot name="title">Cart</x-slot>

<div class="container relative">

    @if($totalQuantity > 0)
    <h3 class="uppercase px-4 py-4 text-sm sm:text-xl sm:font-semibold sm:py-5">My Cart ({{ Cart::getContent()->count() }} Items)</h3>
    @endif

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


        <div class="mb-6"><a href="{{route('index')}}" class="btn btn-ghost underline text-lg flex-none">Start Shopping</a></div>

    </div>
    @endif

    @if(count($cart) > 0)
        <div class="card mt-4 bg-white rounded-none">
            <div class="card-body p-3">
                <div class="flex justify-between">
                    <span class="font-normal text-lg">Total</span>
                    <span class="text-primary font-bold text-lg">{{ $total }}</span>
                </div>
                <div class="flex justify-end ">
                    <small> Delivery fee not included yet</small>
                </div>

                <div class="w-full sm:w-1/3 sm:ml-auto max-w-full justify-end text-right mt-6">
                    <a href="{{route('checkout.index')}}" class="btn btn-primary btn-block">
                        <span class='flex-1'>Checkout</span>
                    </a>
                    <a href="{{route('checkout.index')}}" class="btn btn-link btn-block">
                        <span class='flex-1'>Call to Order</span>
                    </a>
                </div>
            </div>
        </div>
    @endif

    <livewire:cart-action />
</div>
