<?php

namespace App\Listeners;

use App\Events\UserReferred;
use App\Models\User;
use App\Notifications\ReferralNotification;
use Illuminate\Auth\Events\Verified;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class AssignReferralBonus
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
     * @param  \App\Events\Verified  $event
     * @return void
     */
    public function handle(Verified $event)
    {

        $affiliate_id = $event->user->referrer_id;
        if($affiliate_id){
            $affiliate = User::find($affiliate_id);
            if($affiliate && setting('referral_bonus')){
                $affiliate->deposit(setting('referral_bonus'),  ['type'=>'referral_commission', 'description'=>'Commission for referring a user.']);

                $referralData = [
                    'body' => 'You referred '.$event->user->name.' and got '.app_money_format(setting('referral_bonus')).' referral commission',
                    'thanks' => 'Thank you',
                    'offerText' => 'Check out the offer',
                    'offerUrl' => url('/'),
                ];

                Notification::send($affiliate, new ReferralNotification($referralData));
            }elseif ($affiliate){
                $referralData = [
                    'body' => 'You referred '.$event->user->name,
                    'thanks' => 'Thank you',
                    'offerText' => 'Check out the offer',
                    'offerUrl' => url('/'),
                ];

                Notification::send($affiliate, new ReferralNotification($referralData));
            }
        }


    }
}
