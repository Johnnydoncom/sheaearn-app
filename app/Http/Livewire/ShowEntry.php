<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ShowEntry extends Component
{
    public $entry;
    public $shareUrls;
    public $showLogin = false;

    public function render()
    {
        return view('livewire.show-entry');
    }

    public function addBookmark(){
        if(!Auth::check()) {
            $this->showLogin = true;
        }else {
            $this->entry->bookmarks()->attach(['user_id' => Auth::id()]);
        }
    }
}
