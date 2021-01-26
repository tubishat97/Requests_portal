<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
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
            'user_id' => $this->id,
            'user_username' => $this->username,
            'user_created_at' => $this->created_at->diffforhumans(),
            'user_profile' => UserProfile::make($this->profile),
        ];
    }
}
