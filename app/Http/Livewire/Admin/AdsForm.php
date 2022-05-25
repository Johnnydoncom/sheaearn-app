<?php

namespace App\Http\Livewire\Admin;

use App\Models\Ads;
use App\Models\Tag;
use App\Models\Topic;
use Livewire\Component;
use Livewire\WithFileUploads;

class AdsForm extends Component
{
    use WithFileUploads;

    public $title, $category, $description, $ads, $status;
    public $categories;
    public $images = [];
    public $image;

    protected $rules = [
        'title' => 'required|min:6',
        'description' => 'required|min:5',
        'category' => 'required|exists:topics,id',
        'image' => 'image|max:1024|nullable'
    ];

    public function mount(){
        $this->categories = Topic::all();
        $this->status = 0;

        if($this->ads){
            $this->title = $this->ads->title;
            $this->category = $this->ads->topic_id;
            $this->description = $this->ads->description;
            $this->status = $this->ads->published;
        }
    }

    public function render()
    {
        return view('livewire.admin.ads-form');
    }

    public function store(){

        $this->validate();

        $ads = $this->ads ?? new Ads();
        $ads->title = $this->title;
        $ads->topic_id = $this->category;
        $ads->user_id = auth()->user()->id;
        $ads->description = $this->description;
        $ads->published = $this->status;
        $ads->save();


        if($this->image)
            $ads
                ->addMedia($this->image->getRealPath())
                ->toMediaCollection('featured_image');

        if(!$this->ads)
            $this->reset(['title','description','image', 'status', 'category']);

        // Set Flash Message
        $this->dispatchBrowserEvent('alert',[
            'type'=>'success',
            'message'=>"Ads Added Successfully!!"
        ]);
    }
}
