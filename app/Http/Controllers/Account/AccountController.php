<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index(){
        $allTimeEarning = auth()->user()->balance;

        return view('account.home',[
            'allTimeEarning' => $allTimeEarning
        ]);
    }
}
