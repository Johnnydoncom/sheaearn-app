<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Bavix\Wallet\Internal\Service\DatabaseServiceInterface;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function index(){

        auth()->user()->wallet->refreshBalance();
        // auth()->user()->socialWallet->refreshBalance();

//        auth()->user()->socialWallet()->deposit(15);
//        auth()->user()->deposit(20);

        $salesEarning = auth()->user()->wallet->balance;
        $socialEarning = auth()->user()->socialWallet()->balance;

        $allTimeEarning = Auth::user()->transactions()->where('type', '=', 'deposit')->get()->sum('amount');



        return view('account.home',[
            'allTimeEarning' => $allTimeEarning,
            'salesEarning' => $salesEarning,
            'socialEarning' => $socialEarning
        ]);
    }
}
