<?php

namespace App\Http\Livewire\Admin;

use App\Models\Order;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class OrdersTable extends LivewireDatatable
{
    public $model = Order::class;

    public function builder()
    {
        return Order::query();
    }

    public function columns()
    {
        return [
            Column::checkbox(),
//            Column::name('order_number', 'user.name')->searchable()->label('# Order No'),
            Column::callback(['order_number','id', 'user.last_name', 'user.first_name'], function ($order_number,$id, $last_name, $first_name) {
                return '<a href="'.route('admin.orders.edit', $id).'" class="flex items-center gap-1 text-sm text-primary hover:underline">
                                    <span class="flex-shrink-0">#'
                                       .$order_number.
                                    '</span>
                                    <span>'.$last_name.' '.$first_name.'</span>
                                </a>';
            })->exportCallback(function ($order_number){
                return $order_number;
            })->searchable()->label('# Order No'),

            Column::callback(['grand_total'], function ($grand_total) {
                return app_money_format($grand_total);
            })->label('Total'),

            Column::callback(['status'], function ($status) {
                return '<span class="badge badge-sm '.($status == 'completed' ? 'bg-success' : ($status == 'canceled' || $status == 'canceled' ? 'bg-error' : ($status == 'pending' ? 'bg-warning' : 'bg-secondary'))).'">'.$status.'</span>';
            })->exportCallback(function ($order_number){
                return $order_number;
            })->searchable()->label('Status'),

            DateColumn::name('created_at')
                ->label('Created at'),

            Column::callback(['id'], function ($id) {
                return view('admin.order.table-actions', ['id' => $id]);
            })->unsortable()->label('Action')->excludeFromExport()
        ];
    }


}
