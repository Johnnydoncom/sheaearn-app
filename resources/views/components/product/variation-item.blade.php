@props(['variation'])

@php
$quantity = 0;
$cartId = null;
$cartItem = collect(\Cart::getContent())->where('attributes.variation_id', $variation->id)->where('item.attributes.product_id', $variation->parent_product_id)->first();

if($cartItem){
    $quantity = $cartItem['quantity'];
    $cartId = $cartItem['id'];
}
@endphp

<div>
    <h4 class="block mb-1 text-sm font-semibold text-gray-900">{{ $variation->attribute_name }}: {{ $variation->attribute_value }}</h4>
    <div class="flex space-x-2 items-center">
        @if($variation->stock->sales_price > 0)
        <p class="text-sm font-normal text-gray-900">{{app_money_format($variation->stock->sales_price)}}</p>
        @endif
        <p class="@if($variation->stock->sales_price > 0)  text-gray-500 text-xs line-through @else text-gray-900 text-sm font-normal @endif">
            {{ app_money_format($variation->stock->regular_price) }}
        </p>
    </div>
</div>
<div class="flex justify-end">
    <div class="flex items-center justify-between w-full">
        <button @if($quantity < 1) disabled="" @else wire:click="updateCart('{{ $cartId }}', {{$quantity - 1}})" wire:target="updateCart('{{ $cartId }}', {{$quantity - 1}})" @endif class="btn btn-xs btn-primary rounded-lg border-none shadow-md rounded-md">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
        </button>

        <span >{{$quantity}}</span>

        <a @if($quantity < 1) wire:click="addToCart(1, {{$variation->id}})" wire:target="addToCart(1, {{$variation->id}})" @else wire:click="updateCart('{{ $cartId }}', {{$quantity + 1}})" wire:target="updateCart" @endif wire:loading.class="loading" class="btn btn-xs btn-primary rounded-lg border-none shadow-md rounded-md">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
        </a>
    </div>
</div>
