<div class="container" x-data="{paystackPayment: false}">
    <div class="py-0 my-0 mt-0 relative">
        <h3 class="uppercase text-xs sm:text-lg md:text-2xl mt-0 pt-3">Order Summary</h3>
        <div class="divider mt-0"></div>

        <div class="card bg-white mb-4 rounded-none">
            <div class="relative flex flex-row space-y-0 space-x-2 gap-4 sm:gap-6 p-0 w-full">
                <div class="bg-white grid place-items-center">
                    <img src="{{$product->featured_img_thumb}}" class="rounded-xl h-20 sm:h-24" alt="{{$product->title}}"  />
                </div>
                <div class="bg-white flex flex-col p-0 items-start">

                    <h3 class="text-md pt-1"><a href="{{$product->product_url}}">{{ $product->title }}</a></h3>

                    <div class='price my-2 flex items-center space-x-2'>
                        @if($product->sales_price > 0)
                            <p class="text-md font-bold text-primary">{{ $product->formatted_sales_price }}</p>
                        @endif

                        <p class="{{ $product->sales_price > 0 ? 'text-gray-500 text-sm line-through' : 'text-gray-900 text-md font-bold' }}">{{ $product->formatted_regular_price }}</p>
                        <span class="text-gray-400">x 1</span>
                    </div>
                </div>
            </div>
            <div class="divider my-2"></div>
            <div class="flex justify-between mb-2 items-center">
                <span class="font-normal text-md">Items Total</span>
                <span class="font-semibold text-md">{{ $subtotal }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="font-normal text-md">VAT</span>
                <span class="font-semibold text-md">{{ app_money_format($vat) }}</span>
            </div>
            <div class="divider my-2"></div>
            <div class="flex justify-between items-center">
                <span class="font-semibold text-lg">Total</span>
                <span class="text-primary font-bold text-lg">{{ app_money_format($total) }}</span>
            </div>

        </div>

        <div class="uppercase text-xs mt-0 sm:mt-10">
            <div class="flex justify-between items-center w-full">
                <h2 class="uppercase sm:text-lg">Customer address</h2>
            </div>
            <div class="divider my-0"></div>
        </div>

        <div class="card bg-white mb-4 rounded-none">
            <div class="card bg-white rounded-sm">
                <div class="p-0">
                    <h2 class="font-semibold text-sm">{{Auth::user()->name}}</h2>
                    <div class="font-light text-sm w-8/12">{{Auth::user()->email}}</div>
                    <div class="font-light text-sm mt-1">{{Auth::user()->phone}}</div>
                </div>
            </div>
        </div>

        <div class="card bg-white mt-0 sm:mt-10 rounded-none">
            <button id="paystackBtn" class="btn btn-primary btn-block mb-2" wire:loading.class="loading" wire:loading.attr="disabled">Confirm</button>
        </div>
    </div>

    {{-- @push('scripts') --}}
    <script src="https://js.paystack.co/v2/inline.js"></script>
    {{-- @if($payingWithPaystack) --}}
    <script>
        document.addEventListener('livewire:load', function () {

            const paystackBtn = document.getElementById('paystackBtn');
            paystackBtn.addEventListener("click", payWithPaystack, false);

            function payWithPaystack(e) {
                e.preventDefault();

                const paystack = new PaystackPop();
                paystack.newTransaction({
                    key: '{{setting('paystack_key')}}',
                    email: '{{Auth::user()->email}}',
                    amount: '{{$total * 100}}',
                    currency: '{{$currency}}',
                    onSuccess: (transaction) => {
                        // Payment complete! Reference: transaction.reference
                        // console.log(transaction)

                    @this.finalize(transaction.reference)
                    },
                    onCancel: () => {
                        // user closed popup
                        // alert('Transaction was not completed, window closed.');
                    }
                });
            }
        });
    </script>

</div>

