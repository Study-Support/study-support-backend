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
            'number_of_subjects'  => $this->subjects_accepted_count,
            'bank'                => $this->smart_banking,
            'subjects'            => MentorSubjectResource::collection($this->subjects)
        ];
    }
}
