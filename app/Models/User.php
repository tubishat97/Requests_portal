<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use SMartins\PassportMultiauth\HasMultiAuthApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasMultiAuthApiTokens;

    protected $fillable = ['username', 'password'];
    protected $guard = 'admin';
    protected $hidden = ['password'];
    protected $casts = ['account_verified_at' => 'datetime'];

    public function verifications()
    {
        return $this->morphMany(Verification::class, 'accountable')->orderBy('id', 'desc');
    }

    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }
}
