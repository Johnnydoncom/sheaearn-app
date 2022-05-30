<?php

namespace App\Http\Livewire;

use App\Enums\UserRole;
use App\Events\CommissionEarned;
use App\Models\Ads;
use App\Models\Share;
use Illuminate\Support\Carbon;
use Livewire\Component;

class ShowAds extends Component
{
    public $ads;

    public function mount($slug){
        $this->ads = Ads::whereDate('created_at', '<', Carbon::tomorrow())->whereSlug($slug)->firstOrFail();
    }

    public function render()
    {
        return view('livewire.show-ads');
    }

    public function shared($method)
    {
//        if(Share::whereShareableType(Ads::class)->whereUserId(auth()->user()->id)->whereDate('created_at', Carbon::today())->count() < 10) {
        if(Share::whereUserId(auth()->user()->id)->whereDate('created_at', Carbon::now())->count() < setting('shares_per_day',0)){
            if ($record = $this->ads->shares()->whereUserId(auth()->user()->id)->first()) {
                if ($record->created_at->isToday()) {
                    $this->dispatchBrowserEvent('alert', [
                        'type' => 'error',
                        'message' => "Ads already shared"
                    ]);
                } else {
                    $this->processShare($method);

                    // Set Flash Message
                    $this->dispatchBrowserEvent('alert', [
                        'type' => 'success',
                        'message' => "Ads shared."
                    ]);
                }

            } else {
                $this->processShare($method);

                // Set Flash Message
                $this->dispatchBrowserEvent('alert', [
                    'type' => 'success',
                    'message' => "Ads shared."
                ]);
            }
        }else{
            $this->dispatchBrowserEvent('alert', [
                'type' => 'error',
                'message' => "You have exceeded the number of shares per day."
            ]);
        }
    }


    private function processShare($method)
    {
        if(auth()->user()->hasRole(UserRole::AFFILIATE)) {
            $this->ads->shares()->create([
                'user_id' => auth()->user()->id,
                'social_id' => $method
            ]);

            if (setting('sponsored_ads_commission')) {
                $tx = auth()->user()->socialWallet()->deposit(setting('sponsored_ads_commission'), ['type' => 'sponsored_ads_commission', 'description' => 'Commission for sharing sponsored', 'ads_id' => $this->ads->id]);

                CommissionEarned::dispatch($tx);
            }
        }
    }
}
