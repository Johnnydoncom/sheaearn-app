<?php

namespace App\Http\Livewire;

use App\Models\Topic;
use Livewire\Component;

class AppHeader extends Component
{
    public $pageTitle;
    public $searchIcon;

    protected $listeners = ['refreshProduct' => '$refresh'];

    public function render()
    {
        return view('livewire.app-header', ['menu_topics' => Topic::get()]);
    }
}
