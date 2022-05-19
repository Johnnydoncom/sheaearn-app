<?php

namespace App\Http\Controllers\Admin;

use App\Enums\WithdrawStatus;
use App\Http\Controllers\Controller;
use App\Models\WithdrawRequest;
use Illuminate\Http\Request;

class WithdrawController extends Controller
{
    public function index(Request $request){
        $withdraws = WithdrawRequest::with('user.payment_information.country')->paginate(10);
        $status = array(
            WithdrawStatus::PENDING => 'Pending',
            WithdrawStatus::PAID => 'Paid',
            WithdrawStatus::CANCELED => 'Rejected'
        );

        return view('admin.withdraw.home', [
            'records' => $withdraws,
            'statuses' => $status
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(WithdrawRequest $withdrawRequest)
    {
        $status = array(
            WithdrawStatus::PENDING => 'Pending',
            WithdrawStatus::PAID => 'Paid',
            WithdrawStatus::CANCELED => 'Rejected'
        );
        return view('admin.withdraw.index', [
            'withdraw' => $withdrawRequest,
            'statuses' => $status
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WithdrawRequest $withdrawRequest)
    {
        $request->validate([
            'status' => 'required'
        ]);

        $withdrawRequest->status = $request->status;
        $withdrawRequest->save();

        return redirect()->back()->withSuccess('Withdraw Request Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
