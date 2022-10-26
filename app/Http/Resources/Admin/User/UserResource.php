<?php

namespace App\Http\Resources\Admin\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'faculty_id'    => $this->faculty_id,
            'gender'        => $this->gender,
            'avatar_url'    => $this->avatar_url,
            'group'         => $this->account->account_in_group_count,
            'rating'        => $this->averageRating,
            'is_active'     => $this->account->is_active
        ];
    }
}
