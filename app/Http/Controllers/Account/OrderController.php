<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(){
        $allTimeEarning = auth()->user()->balance;

        return view('account.home',[
            'allTimeEarning' => $allTimeEarning
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show($order_number)
    {
        $order = Order::with('items')->whereOrderNumber($order_number)->firstOrFail();

        $items = $order->items->map(function ($item){
            $attr = '';
            $item->name = $item->product->title.' - '.$attr;
            return $item;
        });

        return view('account.order.show', [
            'order' => $order,
            'items' => $items
        ]);
    }
}
