<?php

namespace App\Http\Livewire;

use App\Enums\UserRole;
use App\Models\Entry;
use App\Models\Share;
use Illuminate\Support\Carbon;
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

    public function shared($method)
    {
        if(Share::whereShareableType(Entry::class)->whereUserId(auth()->user()->id)->whereDate('created_at', Carbon::today())->count() < 10) {
            if ($record = $this->entry->shares()->whereUserId(auth()->user()->id)->first()) {
                if ($record->created_at->isToday()) {
                    $this->dispatchBrowserEvent('alert', [
                        'type' => 'error',
                        'message' => "Post already shared"
                    ]);
                } else {
                    $this->processShare($method);

                    // Set Flash Message
                    $this->dispatchBrowserEvent('alert', [
                        'type' => 'success',
                        'message' => "Post shared."
                    ]);
                }

            } else {
                $this->processShare($method);

                // Set Flash Message
                $this->dispatchBrowserEvent('alert', [
                    'type' => 'success',
                    'message' => "Post shared."
                ]);
            }
        }
    }

    private function processShare($method)
    {
        if(auth()->user()->hasRole(UserRole::AFFILIATE)) {
            $this->entry->shares()->create([
                'user_id' => auth()->user()->id,
                'social_id' => $method
            ]);

            if (setting('share_commission'))
                auth()->user()->socialWallet()->deposit(setting('share_commission'), ['type' => 'share_commission', 'description' => 'Commission for sharing post', 'entry_id' => $this->entry->id]);
        }
    }

}
