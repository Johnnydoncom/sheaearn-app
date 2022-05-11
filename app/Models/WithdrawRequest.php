<?php

namespace App\Models;

use App\Enums\WithdrawStatus;
use App\Observers\WithdrawRequestObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WithdrawRequest extends Model
{
    use HasFactory;

    protected $appends = [
        'status_label',
        'request_date'
    ];

    protected $fillable = [
        'transaction_id',
        'user_id',
        'amount',
        'status'
    ];

    public static function boot()
    {
        parent::boot();
        self::observe(new WithdrawRequestObserver());
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function getStatusLabelAttribute(){
        $text = '';
        if($this->status == WithdrawStatus::PENDING){
            $text = 'Pending';
        }
        if($this->status == WithdrawStatus::CANCELED){
            $text = 'Rejected';
        }
        if($this->status == WithdrawStatus::PAID){
            $text = 'Paid';
        }
        return $text;
    }

    public function getRequestDateAttribute(){
        return $this->created_at->format('j F, Y h:s:i a');
    }

}
