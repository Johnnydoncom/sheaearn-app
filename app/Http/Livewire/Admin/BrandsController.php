<?php

namespace App\Http\Livewire\Admin;

use App\Models\Brand;
use Livewire\Component;
use Livewire\WithPagination;

class BrandsController extends Component
{
    use WithPagination;

    public $brand, $name;

    protected $rules = [
        'name' => 'required'
    ];

    public function render()
    {
        return view('livewire.admin.brands-controller')->with([
            'brands' => Brand::paginate()
        ])->layout('layouts.admin');
    }

    public function editBrand($id){
        $this->brand = Brand::find($id);
        $this->name = $this->brand->name;
    }

    public function store(){
        $this->validate();

        $brand = $this->brand ?? new Brand();
        $brand->name = $this->name;
        $brand->save();

        if(!$this->brand)
            $this->reset(['name']);

        // Set Flash Message
        $this->dispatchBrowserEvent('alert',[
            'type'=>'success',
            'message'=>"Record Saved!"
        ]);
    }

    public function deleteBrand($id){
        $this->brand = Brand::find($id)->delete();

        $this->dispatchBrowserEvent('alert',[
            'type'=>'error',
            'message'=>"Record Deleted!"
        ]);
    }

    public function resetForm(){
        $this->reset();
    }
}
