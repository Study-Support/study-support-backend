<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MyListRatingResource extends JsonResource
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
            'userRatings'   => RatingResource::collection($this->userInfo->ratings),
            'mentorRatings' => RatingResource::collection($this->mentorInfo->ratings)
        ];
    }
}
