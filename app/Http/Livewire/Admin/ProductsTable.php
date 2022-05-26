<?php

namespace App\Http\Livewire\Admin;

use App\Models\Category;
use App\Models\Product;
use Mediconesystems\LivewireDatatables\Action;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\NumberColumn;

class ProductsTable extends LivewireDatatable
{
//    public $hideable = 'select';
    public $persistComplexQuery = true;
    public $afterTableSlot = 'components.selected';
    public $hideable = 'inline';
    public $exportable = true;

    public $model = Product::class;

    public function builder()
    {
        return Product::query();
    }

    public function columns(): array
    {
        return [
            Column::checkbox(),

            Column::callback('id', function ($id) {
                $row = app()->make($this->model)->find($id);
                return '<img class="h-10 w-10 rounded-full" src="'.$row->featured_img_thumb.'" alt="'.$row->title.'" />';
            })->unsortable()->label('Image')->width('50px')->excludeFromExport(),

            Column::callback(['id','title'], function ($id,$title) {
                return '<div class="group"><span class="mr-2 text-sm">ID: '.$id.'</span><a href="'.route('admin.products.edit', $id).'" title="'.$title.'" class="">'.$title.'</a>
                       </div>';
            })->filterable()->exportCallback(function ($title){
                return $title;
            })->searchable()->label('Title'),

            Column::callback(['stock.regular_price','stock.sales_price', 'id'], function ($regular_price, $sales_price, $id) {
                $row = app()->make($this->model)->find($id);
                if($row->product_type=='variable'){
                    return $row->variation_price;
                }else {
                    return $sales_price > 0 ? '<span class="line-through">' . app_money_format($regular_price) . '</span><span>' . app_money_format($sales_price) . '</span>' : app_money_format($regular_price);
                }
            })->filterable()->searchable()->label('Price'),

            Column::name('categories.name')
                ->filterable($this->categories->pluck('name'))
                ->searchable()
                ->label('Categories'),

            DateColumn::name('created_at')
                ->label('Created at'),

            Column::callback(['id','slug','title'], function ($id,$slug,$title) {
                return view('admin.product.table-actions', ['id' => $id, 'slug' => $slug, 'name'=>$title]);
            })->unsortable()->label('Action')->excludeFromExport()


        ];
    }

    public function getCategoriesProperty()
    {
        return Category::all();
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
