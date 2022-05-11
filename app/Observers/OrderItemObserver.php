<?php

namespace App\Observers;

use App\Models\Order;
use App\Models\OrderItem;

class OrderItemObserver
{
    /**
     * Handle the OrderItem "created" event.
     *
     * @param  \App\Models\OrderItem  $order
     * @return void
     */
    public function creating(OrderItem $orderItem)
    {
        $orderItem->order_number = generateUniqueOrderItemNumber();
    }

    /**
     * Handle the OrderItem "created" event.
     *
     * @param  \App\Models\OrderItem  $orderItem
     * @return void
     */
    public function created(OrderItem $orderItem)
    {
        //
    }

    /**
     * Handle the OrderItem "updated" event.
     *
     * @param  \App\Models\OrderItem  $orderItem
     * @return void
     */
    public function updated(OrderItem $orderItem)
    {
        //
    }

    /**
     * Handle the OrderItem "deleted" event.
     *
     * @param  \App\Models\OrderItem  $orderItem
     * @return void
     */
    public function deleted(OrderItem $orderItem)
    {
        $order = Order::find($orderItem->order_id);
        $item_count = $order->item_count - 1;
        $total = (float)$order->gand_total - (float)$orderItem->amount;

        if(count($order->items)){
            $order->update([
                'item_count' => $item_count,
                'grand_total' => $total
            ]);
        }
       else{
           $order->delete();
       }
    }

    /**
     * Handle the OrderItem "restored" event.
     *
     * @param  \App\Models\OrderItem  $orderItem
     * @return void
     */
    public function restored(OrderItem $orderItem)
    {
        //
    }

    /**
     * Handle the OrderItem "force deleted" event.
     *
     * @param  \App\Models\OrderItem  $orderItem
     * @return void
     */
    public function forceDeleted(OrderItem $orderItem)
    {
        //
    }
}
