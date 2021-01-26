<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class CustomerProfile extends Model
{
    public function getAgeAttribute()
    {
        return Carbon::parse($this->attributes['birthdate'])->age;
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
