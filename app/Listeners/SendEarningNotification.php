<?php

namespace App\Listeners;

use App\Events\CommissionEarned;
use App\Notifications\PaymentReceived;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendEarningNotification
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
     * @param  \App\Events\CommissionEarned  $event
     * @return void
     */
    public function handle(CommissionEarned $event)
    {
        Notification::send($event->transaction->payable, new PaymentReceived($event->transaction));
    }
}
