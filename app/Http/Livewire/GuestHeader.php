<?php

namespace App\Http\Livewire;

use App\Models\Topic;
use Livewire\Component;

class GuestHeader extends Component
{
    public $pageTitle;
    public $searchIcon;

    public function render()
    {
        return view('livewire.guest-header', ['menu_topics' => Topic::get()]);
    }
}
