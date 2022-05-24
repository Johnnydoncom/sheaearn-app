<?php

namespace App\Providers;

use App\Events\CommissionEarned;
use App\Events\OrderPlaced;
use App\Events\UserReferred;
use App\Listeners\AssignReferralBonus;
use App\Listeners\SendEarningNotification;
use App\Listeners\SendNewOrderNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
//        Verified::class => [
//            AssignReferralBonus::class
//        ],
//        UserReferred::class => [
////            AssignReferralBonus::class
//        ],
        OrderPlaced::class => [
            SendNewOrderNotification::class
        ],
        CommissionEarned::class => [
            SendEarningNotification::class
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
