<div>
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
        <k-block-title class="uppercase text-xs mt-0 pt-3">Order Summary</k-block-title>
        <k-block strong class="mb-4">
            <div class="flex justify-between mb-2 items-center">
                <span class="font-normal text-md">Items Total</span>
                <span class="font-semibold text-md">{{ subtotal }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="font-normal text-md">Shipping Fees</span>
                <span class="font-semibold text-md">{{ shippingCost }}</span>
            </div>
            <div class="divider my-2"></div>
            <div class="flex justify-between items-center">
                <span class="font-semibold text-lg">Total</span>
                <span class="text-primary font-bold text-lg">{{ total }}</span>
            </div>

        </k-block>

        <k-block-title class="uppercase text-xs mt-0">
            <div class="flex justify-between items-center w-full">
                <h2 class="uppercase">Customer address</h2>
                <Link :href="route('checkout.shipping')" class="text-primary">
                    Change
                </Link>
            </div>
        </k-block-title>

        <k-block strong class="mb-4">
            <div class="card bg-white rounded-sm">
                <div class="p-0">
                    <h2 class="font-semibold text-sm">{{delivery_address.name}}</h2>
                    <div class="font-light text-sm w-8/12">{{delivery_address.address}}</div>
                    <div class="font-light text-sm mt-1">{{delivery_address.phone}}</div>
                </div>
            </div>
        </k-block>

        <k-block-title class="uppercase text-xs mt-0">
            <div class="flex justify-between items-center w-full">
                <h2 class="uppercase">Payment Method</h2>
                <Link :href="route('checkout.payment-method.index')" class="text-primary">
                    Change
                </Link>
            </div>
        </k-block-title>

        <k-block strong class="mb-0">
            <div class="card bg-white rounded-sm">
                <div class="p-0">
                    <h2 class="font-semibold text-sm">{{payment_method.title}}</h2>
                    <div class="font-light text-sm w-8/12">{{payment_method.subtitle}}</div>
                </div>
            </div>
        </k-block>

        <k-block strong class="mt-0" :hairlines="false">
            <form v-if="payment_method.name.includes('paystack') || payment_method.name.includes('Paystack') || payment_method.name.includes('PayStack')" method="post" class="w-full mb-2" @submit.prevent="payWithPaystack">
                <button class="btn btn-primary btn-block" :class="{ 'loading': form.processing }" :disabled="form.processing">Confirm</button>
            </form>
            <form v-else method="post" class="w-full mb-2" @submit.prevent="payOnDelivery">
                <button class="btn btn-primary btn-block" :class="{ 'loading': form.processing }" :disabled="form.processing">Confirm</button>
            </form>
            <Link class="btn btn-link btn-block shadow-sm" :href="route('cart.index')">
                Modify Cart
            </Link>
        </k-block>

    </div>

</div>
