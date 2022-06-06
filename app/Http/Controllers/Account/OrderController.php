<?php

namespace App\Http\Controllers\Account;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(){
        $orders = Order::whereUserId(auth()->user()->id)->latest()->paginate();

        return view('account.order.list',[
            'orders' => $orders
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function cancelItem(OrderItem $orderItem)
    {
        $orderItem->update([
            'status' => OrderStatus::CANCELED
        ]);
        return redirect()->back()->withSucess('Order Item Canceled!');
    }

    public function download(Request $request, $order_number){
        $item = OrderItem::whereHas('order', function ($q){
            $q->whereUserId(Auth::id());
        })->whereOrderNumber($order_number)->firstOrFail();
        $mediaItem = $item->product->getFirstMedia('digital');
        if($mediaItem)
            return response()->download($mediaItem->getPath(), $mediaItem->file_name);
    }
}
