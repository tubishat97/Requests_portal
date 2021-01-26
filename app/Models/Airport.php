<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Airport extends Model
{
    public function flights()
    {
        return $this->hasMany(Flight::class);
    }
}
