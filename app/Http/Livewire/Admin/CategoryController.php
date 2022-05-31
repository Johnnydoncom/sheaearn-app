<?php

namespace App\Http\Livewire\Admin;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class CategoryController extends Component
{
    use WithPagination;

    public $category, $name, $parent, $description;

    protected $rules = [
        'name' => 'required'
    ];

    public function render()
    {
        return view('livewire.admin.categories')->with([
            'categories' => Category::latest()->simplePaginate(10),
            'allcategories' => Category::get(['id','name'])
        ])->layout('layouts.admin');
    }

    public function editCategory($id){
        $this->brand = Brand::find($id);
        $this->name = $this->brand->name;
    }

    public function store(){
        $this->validate();

        $category = $this->category ?? new Category();
        $category->name = $this->name;
        $category->parent_id = $this->parent;
        $category->description = $this->description;
        $category->save();

        if(!$this->category)
            $this->reset();

        // Set Flash Message
        $this->dispatchBrowserEvent('alert',[
            'type'=>'success',
            'message'=>"Record Saved!"
        ]);
    }

    public function deleteBrand($id){
        $this->category = Category::find($id)->delete();

        $this->dispatchBrowserEvent('alert',[
            'type'=>'error',
            'message'=>"Record Deleted!"
        ]);
    }

    public function resetForm(){
        $this->reset();
    }
}
