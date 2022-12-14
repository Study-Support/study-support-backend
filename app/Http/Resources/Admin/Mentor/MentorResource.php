<?php

namespace App\Http\Resources\Admin\Mentor;

use App\Http\Resources\RatingResource;
use Illuminate\Http\Resources\Json\JsonResource;

class MentorResource extends JsonResource
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
            'id'                => $this->account->id,
            'full_name'         => $this->account->userInfo->full_name,
            'faculty'           => $this->account->userInfo->faculty->name,
            'rating_score'      => $this->averageRating,
            'smart_banking'     => $this->smart_banking,
            'number_of_subjects'=> $this->subjects_accepted_count,
            'subject_list'      => MentorDetailResource::collection($this->subjects),
            'ratings'           => RatingResource::collection($this->ratings)
        ];
    }
}
