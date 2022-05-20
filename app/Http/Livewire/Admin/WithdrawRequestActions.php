<?php

namespace App\Http\Livewire\Admin;

use App\Enums\WithdrawStatus;
use App\Models\WithdrawRequest;
use Livewire\Component;

class WithdrawRequestActions extends Component
{
    public $requestId, $withdrawRequest, $status, $showModal=false;
    public $statuses;

    public function mount()
    {
        $this->withdrawRequest = WithdrawRequest::find($this->requestId);
        $this->statuses = array(
            WithdrawStatus::PENDING => 'Pending',
            WithdrawStatus::PAID => 'Paid',
            WithdrawStatus::CANCELED => 'Rejected'
        );
    }

    public function render()
    {
        return view('livewire.admin.withdraw-request-actions');
    }

    public function updateRequest()
    {
        $this->validate([
            'status' => 'required'
        ]);

        $this->withdrawRequest->status = $this->status;
        $this->withdrawRequest->save();

         // Set Flash Message
         $this->dispatchBrowserEvent('alert',[
            'type'=>'success',
            'message'=>"Withdraw Request Updated"
        ]);
        $this->emitSelf('closeModal');
    }
}
