<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Airplane extends JsonResource
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
            'airplane_name' => $this->name,
            'airplane_max_seat' => $this->max_seat,
            'airplane_type' => $this->type,
        ];
    }
}
