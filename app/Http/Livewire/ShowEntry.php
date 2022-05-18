<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ShowEntry extends Component
{
    public $entry;
    public $shareUrls;
    public $showLogin = false;
    public $isLiked;

    public $comment;

    public function mount(){

    }

    public function render()
    {
        if(auth()->check()) {
            $this->isLiked = $this->entry->isLikedBy(auth()->user());
        }

        return view('livewire.show-entry');
    }

    public function addBookmark(){
        if(!Auth::check()) {
            $this->showLogin = true;
        }else {
            $this->entry->bookmarks()->attach(['user_id' => Auth::id()]);
        }
    }

    public function like()
    {
        auth()->user()->toggleLike($this->entry);
    }

    public function comment(){
        $this->validate([
            'body' => 'required|min:6'
        ]);

        $this->entry->comments()->create([
            'user_id' => auth()->user()->id,
            'body' => $this->body,
            'name' => auth()->user()->name,
            'email' => auth()->user()->email
        ]);

        // Set Flash Message
        $this->dispatchBrowserEvent('alert',[
            'type'=>'success',
            'message'=>"Comment submitted."
        ]);
    }
}
