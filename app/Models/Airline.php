<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Airline extends Model
{
    public function flights()
    {
        return $this->hasMany(Flight::class);
    }
}
