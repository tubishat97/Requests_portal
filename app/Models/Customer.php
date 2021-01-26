<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use SMartins\PassportMultiauth\HasMultiAuthApiTokens;

class Customer extends Authenticatable
{
    use Notifiable, HasMultiAuthApiTokens;

    protected $fillable = ['mobile', 'password'];
    protected $hidden = ['password', 'fcm_token'];
    protected $casts = ['verified_mobile_at' => 'datetime'];

    public function verifications()
    {
        return $this->morphMany(Verification::class, 'accountable')->orderBy('id', 'desc');
    }

    public function profile()
    {
        return $this->hasOne(CustomerProfile::class);
    }

    public function socials()
    {
        return $this->hasMany(CustomerProvider::class);
    }

    public function findForPassport($mobile)
    {
        return $this->where([
            ['username', '=', $mobile],
            ['account_verified_at', '!=', null],
        ])->first();
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function customerAddresses()
    {
        return $this->hasMany(CustomerAddress::class);
    }

    public function defaultCustomerAddress()
    {
        return $this->hasMany(CustomerAddress::class)->where('is_active', 1);
    }

    public function customerNotifications()
    {
        return $this->hasMany(CustomerNotification::class)->where('is_deleted', false)->orderBy('created_at', 'desc');
    }
}
