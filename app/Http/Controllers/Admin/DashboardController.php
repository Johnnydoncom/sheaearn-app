<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatus;
use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\PaymentHistory;
use App\Models\User;
use App\Models\WithdrawRequest;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $totalRevenue = PaymentHistory::sum('amount');
        $userCount = User::role([UserRole::AFFILIATE, UserRole::CUSTOMER])->count();

        $withdrawRequests = WithdrawRequest::latest()->limit(5)->get();

        $recentOrders = Order::latest()->limit(5)->get()->map(function ($order){
            $order['date'] = $order->created_at->format('d-m-Y');
            $order['total'] = app_money_format($order->grand_total);
            return $order;
        });

        $totalOrders = Order::count();

        $pendingOrdersCount = Order::whereStatus('pending')->count();
        $totalSales = app_money_format(Order::whereStatus(OrderStatus::COMPLETED)->sum('grand_total'));

        return view('admin.dashboard',[
            'recentOrders' => $recentOrders,
            'totalRevenue' => $totalRevenue,
            'userCount' => $userCount,
            'withdrawRequests' => $withdrawRequests
        ]);
    }

    public function fileUpload(Request $request){
        $fileName=$request->file('file')->getClientOriginalName();
        $path=$request->file('file')->storeAs('attachment', $fileName, 'public');
        return response()->json(['location'=>"/storage/$path"]);

        /*$imgpath = request()->file('file')->store('uploads', 'public');
        return response()->json(['location' => "/storage/$imgpath"]);*/
    }
}
