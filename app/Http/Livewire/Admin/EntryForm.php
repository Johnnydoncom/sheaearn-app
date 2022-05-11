<?php

namespace App\Http\Livewire\Admin;

use App\Models\Entry;
use App\Models\Tag;
use App\Models\Topic;
use Livewire\Component;
use Livewire\WithFileUploads;

class EntryForm extends Component
{
    use WithFileUploads;

    public $title, $category, $description, $entry, $status;
    public $tags = [];
    public $sticky = false;
    public $categories;
    public $allTags;
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
        $this->allTags = Tag::get();
        $this->status = 0;
        $this->sticky = false;

        if($this->entry){
            $this->title = $this->entry->title;
            $this->category = $this->entry->topic_id;
            $this->description = $this->entry->description;
            $this->status = $this->entry->published;
        }
    }

    public function render()
    {
        return view('livewire.admin.entry-form');
    }

    public function store(){

        $this->validate();

        $entry = $this->entry ?? new Entry();
        $entry->title = $this->title;
        $entry->topic_id = $this->category;
        $entry->user_id = auth()->user()->id;
        $entry->description = $this->description;
        $entry->sticky = $this->sticky;
        $entry->published = $this->status;
        $entry->save();

        // Tags
        if($this->tags) {
            foreach ($this->tags as $key => $tag) {
                if (!is_numeric($tag)) {
                    $new = Tag::create(['name' => $tag, 'user_id' => auth()->user()->id]);
                    $this->tags[$key] = $new->id;
                }
            }
            $entry->tags()->sync($this->tags);
        }

        if($this->image)
            $entry
                ->addMedia($this->image->getRealPath())
                ->toMediaCollection('featured_image');

        if(!$this->entry)
            $this->reset(['title','description','image', 'status', 'category', 'tags', 'sticky']);

        // Set Flash Message
        $this->dispatchBrowserEvent('alert',[
            'type'=>'success',
            'message'=>"Entry Added Successfully!!"
        ]);
    }
}
