<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Customer extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $socials = $this->socials->map(function ($item) {
            return $item->provider;
        });

        return [
            'customer_id' => $this->id,
            'customer_username' => $this->username,
            'customer_created_at' => $this->created_at->diffforhumans(),
            'customer_profile' => CustomerProfile::make($this->profile),
            'customer_social' => $socials,
            'customer_receive_notifications' => $this->receive_notifications
        ];
    }
}
