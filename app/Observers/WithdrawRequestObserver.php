<?php

namespace App\Observers;

use App\Enums\UserRole;
use App\Enums\WithdrawStatus;
use App\Models\User;
use App\Models\WithdrawRequest;
use Illuminate\Support\Facades\Notification;

class WithdrawRequestObserver
{
    /**
     * Handle the WithdrawRequest "created" event.
     *
     * @param  \App\Models\WithdrawRequest  $withdrawRequest
     * @return void
     */
    public function created(WithdrawRequest $withdrawRequest)
    {
//        $admins = User::whereHas('roles', function ($query) {
//            $query->where('id', UserRole::ADMIN);
//        })->get();
//        Notification::send($admins, new \App\Notifications\WithdrawRequest($withdrawRequest));
    }

    /**
     * Handle the WithdrawRequest "updated" event.
     *
     * @param  \App\Models\WithdrawRequest  $withdrawRequest
     * @return void
     */
    public function updated(WithdrawRequest $withdrawRequest)
    {
        if ($withdrawRequest->status == WithdrawStatus::PAID && $withdrawRequest->status != $withdrawRequest->getOriginal('status')) {
            $user = User::find($withdrawRequest->user_id);
            if($user) {
                $transaction = $user->transactions()->where('confirmed', false)->first();
                if($transaction){
                    $user->confirm($transaction);
                }
            }
        }
    }

    /**
     * Handle the WithdrawRequest "deleted" event.
     *
     * @param  \App\Models\WithdrawRequest  $withdrawRequest
     * @return void
     */
    public function deleted(WithdrawRequest $withdrawRequest)
    {
        //
    }

    /**
     * Handle the WithdrawRequest "restored" event.
     *
     * @param  \App\Models\WithdrawRequest  $withdrawRequest
     * @return void
     */
    public function restored(WithdrawRequest $withdrawRequest)
    {
        //
    }

    /**
     * Handle the WithdrawRequest "force deleted" event.
     *
     * @param  \App\Models\WithdrawRequest  $withdrawRequest
     * @return void
     */
    public function forceDeleted(WithdrawRequest $withdrawRequest)
    {
        //
    }
}
