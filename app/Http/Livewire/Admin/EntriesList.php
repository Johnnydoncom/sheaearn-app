<?php

namespace App\Http\Livewire\Admin;

use App\Models\Entry;
use Livewire\Component;
use Livewire\WithPagination;

class EntriesList extends Component
{
    use WithPagination;

    public $search = '';
    public $orderBy = 'created_at@desc';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.admin.entries-list', [
            'entries' => Entry::where('title', 'like', '%'.$this->search.'%')->orderBy(explode('@',$this->orderBy)[0], explode('@', $this->orderBy)[1])->paginate(5)
        ]);
    }

    public function deleteRecord($id){
        Entry::find($id)->delete();
    }
}
