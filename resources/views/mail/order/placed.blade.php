@component('mail::message')
    Dear {{$order->user->last_name}},
    <p>Thank you for shopping with {{ setting('site_name') }}!</p>
    <p>Your order {{$order->order_number}} has been confirmed successfully.</p>
    <p>It will be packed and shipped as soon as possible. You will receive a notification from us once the item(s) are available for collection.</p>
    @component('mail::table')
        | Estimated delivery date | Delivery Method |
        |:------------- |:------------- |
        | Within 4 days | Delivery to your home or office |
    @endcomponent
    @if($order->delivery_address)
    @component('mail::table')
        | Recipient details | Delivery Address |
        |:------------- |:------------- |
        | {{$order->delivery_address->name}} {{$order->delivery_address->phone}} | {{$order->delivery_address->full_address}} |
    @endcomponent
    @endif

@component('mail::button', ['url' => route('account.order.show', $order->order_number)])
View Order
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
