<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionsController extends Controller
{
    public function index(){
        return view('account.transactions', [
            'transactions' => Auth::user()->transactions
        ]);
    }
}
