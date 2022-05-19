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
    public $isBookmarked;

    public $body;

    public function mount(){

    }

    public function render()
    {
        if(auth()->check()) {
            $this->isLiked = $this->entry->isLikedBy(auth()->user());
            $this->isBookmarked = $this->entry->bookmarks()->whereUserId(Auth::id())->exists();
        }

        return view('livewire.show-entry');
    }

    public function addBookmark(){
        if(!Auth::check()) {
            $this->showLogin = true;
        }else {
            if($bookmark = $this->entry->bookmarks()->whereUserId(Auth::id())->first()){
                $bookmark->delete();
            }else{
                $this->entry->bookmarks()->create(['user_id' => Auth::id()]);
            }
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

        $this->reset(['body']);

        // Set Flash Message
        $this->dispatchBrowserEvent('alert',[
            'type'=>'success',
            'message'=>"Comment submitted."
        ]);
    }
}
