<?php

namespace App\Http\Controllers\Account;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\PaymentInformation;
use App\Models\User;
use App\Models\Wishlist;
use App\Models\WithdrawRequest;
use App\Rules\MatchOldPassword;
use Illuminate\Http\Request;
use Bavix\Wallet\Internal\Service\DatabaseServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\MessageBag;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;

// use Asantibanez\LivewireCharts\Facades\LivewireCharts;
// use Asantibanez\LivewireCharts\Models\ColumnChartModel;

class AccountController extends Controller
{
    public function index(){

        auth()->user()->wallet->refreshBalance();
        // auth()->user()->socialWallet->refreshBalance();

//        auth()->user()->socialWallet()->deposit(15);
    //    auth()->user()->withdraw(30);

        $salesEarning = auth()->user()->wallet->balance;
        $socialEarning = auth()->user()->socialWallet()->balance;

        $allTimeEarning = Auth::user()->transactions()->where('type', '=', 'deposit')->get()->sum('amount');

        return view('account.home',[
            'allTimeEarning' => $allTimeEarning,
            'salesEarning' => $salesEarning,
            'socialEarning' => $socialEarning,
        ]);
    }

    public function edit()
    {
        return view('account.settings',[
            'user' => User::find(Auth::id()),
            'countries' => Country::get(['id','name']),
            'payment_information' => Auth::user()->payment_information,
        ]);
    }

    public function update(Request $request){
        $request->validate([
            'last_name' => 'required',
            'first_name' => 'required',
        ]);

        $request->user()->update([
            'last_name' => $request->last_name,
            'first_name' => $request->first_name,
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
            'zip' => $request->zip,
            'gender' => $request->gender
        ]);
        return redirect()->back()->withSuccess('Account updated');
    }

    public function updatePassword(Request $request){
        $request->validate([
            'password' => ['min:8','confirmed', Rules\Password::defaults()],
            'oldpassword' => ['required', new MatchOldPassword],
        ]);

        $request->user()->update([
            'password' => Hash::make($request->password)
        ]);
        return redirect()->back()->withSuccess('Password updated');
    }

    public function storeBank(Request $request){
        // if(!$request->user()->hasRole(UserRole::AFFILIATE)){
        //     return redirect()->route('account.index');
        // }

        $request->validate([
            'bank_name' => ['required'],
            'bank_account_no' => ['required'],
            'bank_account_name' => ['required'],
            'country_id' => ['required']
        ]);

        if(!$paymentInformation = PaymentInformation::whereUserId($request->user()->id)->first()){
            $paymentInformation = new PaymentInformation();
        }
        $paymentInformation->bank_name = $request->bank_name;
        $paymentInformation->bank_account_no = $request->bank_account_no;
        $paymentInformation->bank_account_name = $request->bank_account_name;
        $paymentInformation->bank_swift_code = $request->bank_swift_code;
        $paymentInformation->bank_branch = $request->bank_branch;
        $paymentInformation->country_id = $request->country_id;
        $paymentInformation->user_id = $request->user()->id;
        $paymentInformation->save();

        return redirect()->back()->withSuccess('Payment information updated');
    }


    public function wishlist(Request $request){
        return view('account.wishlist.list',[
            'products' => $request->user()->wishlist->map(function ($wish){
                $wish->product = $wish->product;
                return $wish;
            }),
        ]);
    }

    public function destroyWishlist(Request $request, Wishlist $wishlist){
        $wishlist->delete();
        return redirect()->back()->withSuccess('Wishlist Deleted');
    }

    public function upgrade(Request $request){
        if($request->user()->hasRole(UserRole::AFFILIATE)){
            return redirect()->route('account.affiliate.index');
        }
        return view('account.upgrade',[
            'user'=>$request->user(),
            'payment_methods' => [
                'coupon',
//                'paystack'
            ]
        ]);
    }

    public function withdrawRequest(Request $request){
//        if(!$request->user()->hasRole(UserRole::AFFILIATE)){
//            return redirect()->route('account.index');
//        }

        $salesEarning = auth()->user()->wallet->balance;
        $socialEarning = auth()->user()->socialWallet()->balance;

        $total = $salesEarning + $socialEarning;

        $canWithdraw = false;



        if($total > 0 ){

            if(setting('minimum_withdrawal') && $request->user()->balance <= setting('minimum_withdrawal')){
//                'status', \App\Enums\WithdrawStatus::PENDING
                $lastWithdraw = $request->user()->withdraws()->latest()->first();
                if($lastWithdraw){
                    if($lastWithdraw->created_at->diffInMonths() > 1){
                        $canWithdraw = true;
                    }else{
                        $canWithdraw = false;
                    }
                }else {
                    $canWithdraw = true;
                }
            }
        }

        return view('account.withdraw', [
            'withdrawable' => $total,
            'canWithdraw' => $canWithdraw,
            'user'=>$request->user(),
            'payment_information' => $request->user()->payment_information ? $request->user()->payment_information->load('country') : null
        ]);
    }

    public function submitWithdrawRequest(Request $request, MessageBag $message_bag){
        $balance = $request->user()->balance;
        $maxWithdrawPercent = setting('maximum_withdrawal');
        $minWithdraw = setting('minimum_withdrawal');

        $request->validate([
            'amount' => 'required',
        ]);

        // Check for pending transaction
        if($withdrawExist = $request->user()->withdraws()->where('status', \App\Enums\WithdrawStatus::PENDING)->first()){
            throw ValidationException::withMessages([
                'exist' => __('You have a pending withdrawal requests'),
            ]);
        }

        if($request->amount < $minWithdraw){
            throw ValidationException::withMessages([
                'amount' => __('Requested amount is below the minimum withdrawal amount ('.app_money_format($minWithdraw).')'),
            ]);
        }

        if(!$request->user()->payment_information){
            throw ValidationException::withMessages([
                'payment_information' => __('Payment information is required to request withdrawal of commission.'),
            ]);
        }

        $tx = $request->user()->withdraw((float)$request->amount, ['type' => 'order_commission', 'description' => 'Commission withdrawal']);
        $request->user()->wallet->refreshBalance();

        $withdrawRequest = new WithdrawRequest();
        $withdrawRequest->user_id = $request->user()->id;
        $withdrawRequest->amount = (float)$request->amount;
        $withdrawRequest->transaction_id = $tx->id;
        $withdrawRequest->save();

        $admins = User::role(UserRole::ADMIN)->get();
        Notification::send($admins, new \App\Notifications\WithdrawRequest($withdrawRequest));

        return redirect()->back()->withSuccess('Withdraw request submitted and would be processed within 24hrs.');
    }
}
