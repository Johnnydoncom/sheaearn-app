<?php

namespace App\Listeners;

use App\Events\OrderPlaced;
use App\Notifications\Admin\AdminOrderPlaced;
use App\Notifications\OrderPlacedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendNewOrderNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\OrderPlaced  $event
     * @return void
     */
    public function handle(OrderPlaced $event)
    {
//        $event->order->user;
        Notification::send($event->order->user, new OrderPlacedNotification($event->order));

        // Admin notification
        Notification::route('mail', setting('site_email'))
            ->notify(new AdminOrderPlaced($event->order));

    }
}
