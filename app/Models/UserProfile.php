<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{

    protected $fillable = ['first_name', 'last_name'];

    public function getAgeAttribute()
    {
        return Carbon::parse($this->attributes['birthdate'])->age;
    }

    public function profile()
    {
        return $this->belongsTo(User::class);
    }
}
