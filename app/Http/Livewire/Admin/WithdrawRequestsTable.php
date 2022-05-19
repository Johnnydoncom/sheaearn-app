<?php

namespace App\Http\Livewire\Admin;

use App\Models\Withdrawrequest;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class WithdrawRequestsTable extends LivewireDatatable
{
    public $model = Withdrawrequest::class;

    public function columns()
    {
        return [
            Column::checkbox(),
        ];
    }
}
