<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MentorInGroupResource extends JsonResource
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
            'full_name'     => $this->userInfo->full_name,
            'faculty'       => $this->userInfo->faculty->name,
            'rating'        => $this->mentorInfo->averageRating,
        ];
    }
}
