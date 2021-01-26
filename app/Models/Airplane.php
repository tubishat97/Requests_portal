<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Airplane extends Model
{
    public function flights()
    {
        return $this->hasMany(Flight::class);
    }
}
