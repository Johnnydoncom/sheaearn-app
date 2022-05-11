<?php

namespace App\Http\Livewire\Admin;

use App\Models\Tag;
use App\Models\Topic;
use Livewire\Component;
use Livewire\WithPagination;

class EntryCategory extends Component
{
    use WithPagination;

    public $name, $description, $topic;
    public $editing = false;
//
    protected $rules = [
        'name' => 'required|min:3'
    ];

    public function render()
    {
        return view('livewire.admin.entry-category', [
            'categories' => Topic::paginate()
        ]);
    }

    public function store()
    {
        $this->validate();

        $topic = $this->topic ?? new Topic();
        $topic->name = $this->name;
        $topic->description = $this->description;
        $topic->save();

        // Set Flash Message
        $this->dispatchBrowserEvent('alert',[
            'type'=>'success',
            'message'=>"Record Saved Successfully!!"
        ]);
    }

    public function editRecord($id){
        $this->topic = Topic::findOrFail($id);
        $this->name = $this->topic->name;
        $this->description = $this->topic->description;
        $this->editing = true;
    }

    public function resetForm(){
//        $this->topic = null;
//        $this->name = null;
//        $this->description = null;
//        $this->editing = false;

        $this->reset(['name','description','editing', 'topic']);
    }

    public function deleteRecord($id){

    }
}
