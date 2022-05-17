<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index(){

        $salesEarning = auth()->user()->balance;
        $socialEarning = auth()->user()->socialWallet()->balance;

        $allTimeEarning = auth()->user()->balance;


        return view('account.home',[
            'allTimeEarning' => $allTimeEarning,
            'salesEarning' => $salesEarning,
            'socialEarning' => $socialEarning
        ]);
    }
}
