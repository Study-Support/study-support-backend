<?php

namespace App\Http\Resources\MentorInProfile;

use Illuminate\Http\Resources\Json\JsonResource;

class MentorInProfileResource extends JsonResource
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
            'full_name'           => $this->account->userInfo->full_name,
            'faculty'             => $this->account->userInfo->faculty->name,
            'rating'              => $this->averageRating,
            'number_of_subjects'  => $this->subjects_accepted_count,
            'bank'                => $this->smart_banking,
            'subjects'            => MentorSubjectResource::collection($this->subjectsAccepted)
          ];
    }
}