<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Flight extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'flight_number' => $this->flight_number,
            'flight_airline' => Airline::make($this->airline),
            'flight_from_airport' => Airport::make($this->fromAirport),
            'flight_to_airport' => Airport::make($this->toAirport),
            'flight_airplane' => Airplane::make($this->airplane),
        ];
    }
}
