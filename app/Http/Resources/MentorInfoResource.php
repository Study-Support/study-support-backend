<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MentorInfoResource extends JsonResource
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
            'id'                  => $this->account->id,
            'full_name'           => $this->account->userInfo->full_name,
            'faculty'             => $this->account->userInfo->faculty->name,
            'rating'              => $this->averageRating,
            'number_of_subjects'  => $this->subjects_accepted_count,
            'avatar_url'          => $this->account->userInfo->avatar_url,
            'subjects'            => SubjectResource::collection($this->subjectsAccepted),
            'ratings'             => RatingResource::collection($this->ratings)
        ];
    }
}
