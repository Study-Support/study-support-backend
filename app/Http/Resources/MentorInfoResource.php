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
      'full_name'     => $this->account->userInfo->full_name,
      'faculty'       => $this->account->userInfo->faculty->name,
      'rating'        => $this->averageRating,
      'subjects'      => SubjectResource::collection($this->subjectsAccepted)
    ];
  }
}
