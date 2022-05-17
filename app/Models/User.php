<?php

namespace App\Models;

use App\Observers\UserObserver;
use Bavix\Wallet\Interfaces\Confirmable;
use Bavix\Wallet\Interfaces\Wallet;
use Bavix\Wallet\Traits\CanConfirm;
use Bavix\Wallet\Traits\HasWallet;
use Bavix\Wallet\Traits\HasWallets;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Permission\Traits\HasRoles;
use Zorb\Promocodes\Traits\AppliesPromocode;

class User extends Authenticatable implements MustVerifyEmail, Wallet, Confirmable, HasMedia
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, AppliesPromocode, HasWallet, HasWallets, CanConfirm, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'last_name',
        'first_name',
        'account_id',
        'email',
        'password',
        'phone',
        'referred_by',
        'referrer_id',
        'gender',
        'city',
        'address',
        'zip'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function boot()
    {
        parent::boot();
        self::observe(new UserObserver());
    }

    public function registerMediaCollections() : void
    {
        $this->addMediaCollection('avatar')
            ->useFallbackUrl(Storage::url('avatar.png'))
            ->useFallbackPath(Storage::url('avatar.png'))
            ->singleFile()
            ->registerMediaConversions(function (Media $media) {
                $this->addMediaConversion('thumb')
                    ->width(50)
                    ->height(50)
                    ->sharpen(10)
                    ->format('webp')
                    ->fit(Manipulations::FIT_CROP, 50,50)
                    ->nonQueued();
            });
    }

    public function getAvatarUrlAttribute(){
        return $this->getFirstMediaUrl('avatar', 'thumb');
    }

    public function scopeSocialWallet(){
        return $this->getWallet('social-wallet-'.$this->id);
    }

    public function delivery_addresses(){
        return $this->hasMany(DeliveryAddress::class);
    }

    public function getDeliveryAddressAttribute(){
        return $this->delivery_addresses()->firstWhere('is_default', '=', true);
    }

    public function getUserRoleAttribute(){
        $names = $this->getRoleNames()->first();
        return $names;
    }

    public function referred()
    {
        return $this->hasMany(self::class, 'referred_by', 'affiliate_tag');
    }

    public function wishlist(){
        return $this->hasMany(Wishlist::class);
    }

    /**
     * Get the reviews the user has made.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function orders() {
        return $this->hasMany(Order::class);
    }

    public function payment_information() {
        return $this->hasOne(PaymentInformation::class);
    }

    public function getNameAttribute()
    {
        return $this->last_name.' '.$this->first_name;
    }

    public function getReferralLinkAttribute()
    {
        return route('register', ['ref' => $this->account_id]);
    }

    /**
     * A user has a referrer.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function referrer()
    {
        return $this->belongsTo(User::class, 'referrer_id', 'id');
    }

    /**
     * A user has many referrals.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function referrals()
    {
        return $this->hasMany(User::class, 'referrer_id', 'id');
    }

    public function withdraws(){
        return $this->hasMany(WithdrawRequest::class);
    }
}
