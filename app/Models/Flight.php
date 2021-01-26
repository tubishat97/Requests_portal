<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    public function airline()
    {
        return $this->belongsTo(Airline::class);
    }
    
    public function fromAirport()
    {
        return $this->belongsTo(Airport::class, 'from_airport_id');
    }

    public function toAirport()
    {
        return $this->belongsTo(Airport::class, 'to_airport_id');
    }

    public function airplane()
    {
        return $this->belongsTo(Airplane::class);
    }
}
