<?php

namespace App\Http\Livewire\Admin;

use App\Enums\WithdrawStatus;
use App\Models\Withdrawrequest;
use Illuminate\Support\Facades\Storage;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class WithdrawRequestsTable extends LivewireDatatable
{
    public $model = Withdrawrequest::class;

    public function columns()
    {
        return [
            Column::checkbox(),
            Column::callback(['user.first_name', 'user.last_name'], function ($first_name, $last_name) {
                return '<div class="flex items-center">
                <div class="flex-shrink-0">
                    <img src="'.Storage::url('avatar.png').'"  class="rounded-full w-14" />
                </div>
                <div class="ml-2">
                    <div class="text-sm font-medium leading-5 text-gray-900">
                        '.$last_name.' '.$first_name.'
                    </div>
                </div>
            </div>';
            })->exportCallback(function ($last_name,$first_name){
                return $last_name.' '.$first_name;
            })->searchable()->label('User'),

            Column::callback(['amount'], function ($amount) {
                return app_money_format($amount);
            })->label('Amount'),

            Column::callback(['status'], function ($status) {
                return $status == WithdrawStatus::PENDING ? 'Pending' : ($status == WithdrawStatus::CANCELED ? 'Rejected' : ($status == WithdrawStatus::PAID ? 'Paid' : ''));
            })->label('Status'),

            DateColumn::name('created_at')
            ->format('j F, Y h:s:ia')
                ->label('Request Date'),

            Column::callback(['id'], function ($id) {
                    return view('admin.withdraw.table-actions', ['id' => $id]);
                })->unsortable()->label('Action')->excludeFromExport()

        ];
    }

    public function getStatusProperty()
    {
        $status = array(
            WithdrawStatus::PENDING => 'Pending',
            WithdrawStatus::PAID => 'Paid',
            WithdrawStatus::CANCELED => 'Rejected'
        );
        return collect($status)->all();
    }
}
