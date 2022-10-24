<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'email'         => $this->account->email,
            'full_name'     => $this->full_name,
            'address'       => $this->address,
            'phone_number'  => $this->phone_number,
            'birthday'      => $this->birthday,
            'rating'        => $this->rating,
            'faculty_id'    => $this->faculty_id,
            'gender'        => $this->gender,
            'avatar_url'    => $this->avatar_url
        ];
    }
}
