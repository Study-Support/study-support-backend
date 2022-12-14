<?php

namespace App\Http\Resources\Admin\User;

use App\Http\Resources\Admin\GroupResource;
use App\Http\Resources\RatingResource;
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
            'id'            => $this->account->id,
            'email'         => $this->account->email,
            'full_name'     => $this->full_name,
            'address'       => $this->address,
            'phone_number'  => $this->phone_number,
            'birthday'      => $this->birthday,
            'faculty_id'    => $this->faculty_id,
            'gender'        => $this->gender,
            'avatar_url'    => $this->avatar_url,
            'group'         => $this->account->account_in_group_count,
            'rating_score'  => $this->averageRating,
            'ratings'       => RatingResource::collection($this->ratings),
            'is_active'     => $this->account->is_active,
            'groups'        => GroupResource::collection($this->accountInGroup)
        ];
    }
}
