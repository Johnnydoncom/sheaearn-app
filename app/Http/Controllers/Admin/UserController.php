<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRole;
use App\Events\CommissionEarned;
use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.user.home');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        $roles = $roles->reject(function ($role, $key) {
            return $role->name == UserRole::SUPERADMIN;
        });
        return view('admin.user.create', [
            'roles' => $roles
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', Rules\Password::defaults()],
            'role' => 'required'
        ]);

        $user = new User();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->phone  = $request->phone;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->email_verified_at = Carbon::now();
        $user->save();
        // Role
        $user->assignRole($request->role);

        event(new Registered($user));

        return redirect()->route('admin.users.index')->withSuccess('User Account Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        $roles = $roles->reject(function ($role, $key) {
            return $role->name == UserRole::SUPERADMIN;
        });
        return view('admin.user.edit', [
            'user' => $user,
            'roles' => $roles
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'role' => 'required'
        ]);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->phone  = $request->phone;
        $user->email = $request->email;
        if($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->save();
        // Role
//        $user->assignRole($request->role);
        $user->syncRoles([$request->role]);

        return redirect()->route('admin.users.index')->withSuccess('User Account Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    public function upgrade(User $user){

        $paymentHistory = \App\Models\PaymentHistory::whereUserId($user->id)->whereTransactionType('account_upgrade')->first();

        if($paymentHistory) {
            $user->syncRoles([UserRole::AFFILIATE]);

            // Referral Commission
            if ($user->referrer_id) {
                $ref = User::find($user->referrer_id);
                if ($ref && $ref->hasRole(UserRole::AFFILIATE)) {
                    $tx2 = $ref->deposit(setting('referral_bonus'), ['type' => 'referral_bonus', 'description' => 'Commission for referring ' . $user->name, 'product_id' => $paymentHistory->order->items[0]->product->id]);
                    CommissionEarned::dispatch($tx2);
                }
            }
        }

        return redirect()->back();
    }

    public function credit(Request $request, User $user)
    {
        $request->validate([
            'wallet' => 'required',
            'amount' => 'required'
        ]);

        if($request->wallet == 'sales'){
            $tx2 = $user->deposit($request->amount, ['type' => 'admin_bonus', 'description' => 'Commission from admin']);
        }else{
            $tx2 = $user->socialWallet()->deposit($request->amount, ['type' => 'admin_bonus', 'description' => 'Commission from admin']);
        }

        CommissionEarned::dispatch($tx2);

        return redirect()->back()->withSuccess('Account Credited');
    }

}
