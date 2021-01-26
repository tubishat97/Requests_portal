<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerProfile extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $active_address = null;
        $customerAddresses = $this->customer->customerAddresses()->where('is_active', true);
        if ($customerAddresses->count() > 0) {
            $active_address = $customerAddresses->first();
        }

        return [
            'fullname' => $this->fullname,
            'birthdate' => $this->birthdate,
            'is_active' => $this->is_active,
            'age' => $this->age,
            'device_id' => $this->device_id,
            'image' =>  ($this->image) ? asset('storage/' . $this->image) : asset('img/user.jpg'),
            'customer_address' => (!is_null($active_address)) ? CustomerAddress::make($active_address) : null,
            'customer_receive_notifications' => $this->customer->receive_notifications
        ];
    }
}
