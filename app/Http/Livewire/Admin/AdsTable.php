<?php

namespace App\Http\Livewire\Admin;

use App\Models\Ads;
use App\Models\Topic;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class AdsTable extends LivewireDatatable
{
    public $model = Ads::class;

    public function columns()
    {
        return [
//            Column::checkbox(),

            Column::callback('id', function ($id) {
                $row = app()->make($this->model)->find($id);
                return '<img class="h-10 w-10 rounded-full" src="'.$row->featured_img_thumb.'" alt="'.$row->title.'" />';
            })->unsortable()->label('Image')->width('50px')->excludeFromExport(),

            Column::callback(['id','title'], function ($id,$title) {
                return '<a href="'.route('admin.ads.edit', $id).'" title="'.$title.'" class="">'.$title.'</a>';
            })->exportCallback(function ($title){
                return $title;
            })->searchable()->label('Title'),

            Column::name('topic.name')
                ->searchable()
                ->label('Category'),

            Column::name('created_at')
                ->label('Ads Date'),

            Column::callback('published', function ($published) {
                return $published ? '<span class="bg-green-500 px-1.5 py-0.5 rounded-lg text-gray-100">Published</span>' : '<span class="bg-red-500 px-1.5 py-0.5 rounded-lg text-gray-100">Draft</span>';
            })->exportCallback(function ($published){
                return $published ? 'Published' : 'Draft';
            })->label('Status'),

            Column::callback(['id'], function ($id) {
                return view('admin.ads.table-actions', ['id' => $id]);
            })->unsortable()->label('Action')->excludeFromExport()
        ];
    }

}
