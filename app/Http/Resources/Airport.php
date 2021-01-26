<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Airport extends JsonResource
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
            'airport_name' => $this->name,
            'airport_city_location' => $this->city_location,
            'airport_lat' => $this->lat,
            'airport_lon' => $this->lon,
        ];
    }
}
