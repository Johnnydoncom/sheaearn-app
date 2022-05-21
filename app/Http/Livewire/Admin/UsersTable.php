<?php

namespace App\Http\Livewire\Admin;

use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Models\User;
use Mediconesystems\LivewireDatatables\Action;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Spatie\Permission\Models\Role;

class UsersTable extends LivewireDatatable
{
    public $persistComplexQuery = true;
    public $afterTableSlot = 'components.selected';
    public $hideable = 'inline';
    public $exportable = true;


    public $model = User::class;

    public function builder()
    {
        return User::whereHas('roles', function ($q){
            $q->where('name', '!=', UserRole::SUPERADMIN);
        });
    }

    public function columns()
    {
       return [
           Column::checkbox(),
           Column::callback(['last_name','first_name'], function ($last_name,$first_name) {
               return $last_name.' '.$first_name;
           })->exportCallback(function ($last_name,$first_name){
               return $last_name.' '.$first_name;
           })->searchable()->label('Name'),
           Column::name('email')->searchable()->label('Email'),
           Column::name('roles.name')
               ->filterable($this->roles->pluck('name'))
               ->label('User Role'),
           Column::callback(['status'], function ($status) {
               return $status == UserStatus::ACTIVE ? '<span class="badge badge-success badge-sm">Active</span>' : '<span class="badge badge-danger badge-sm">Inactive</span>';
           })->exportCallback(function ($status){
               return $status == UserStatus::ACTIVE ? 'Active' : 'Inactive';
           })->label('Status'),

           DateColumn::name('created_at')
               ->label('Created at'),
           Column::callback(['id','last_name', 'first_name'], function ($id,$last_name,$first_name) {
               return view('admin.user.table-actions', ['id' => $id,  'name'=>$last_name.' '.$first_name]);
           })->unsortable()->label('Action')->excludeFromExport()
       ];
    }

    public function getRolesProperty()
    {
        return Role::where('name', '!=', UserRole::SUPERADMIN)->get();
    }


    public function buildActions()
    {
        return [
            Action::groupBy('Export Options', function () {
                return [
                    Action::value('pdf')->label('Export PDF')->export('Products.pdf'),
                    Action::value('csv')->label('Export CSV')->export('Products.csv'),
                    Action::value('html')->label('Export HTML')->export('Products.html'),
                    Action::value('xlsx')->label('Export XLSX')->export('Products.xlsx')->styles($this->exportStyles)->widths($this->exportWidths)
                ];
            }),
        ];
    }

    public function getExportStylesProperty()
    {
        return [
            '1'  => ['font' => ['bold' => true]],
            'B2' => ['font' => ['italic' => true]],
            'C'  => ['font' => ['size' => 16]],
        ];
    }

    public function getExportWidthsProperty()
    {
        return [
            'A' => 55,
            'B' => 45,
        ];
    }
}
