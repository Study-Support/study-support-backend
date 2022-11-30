<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MemberResource extends JsonResource
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
            'id'        => $this->id,
            'full_name' => $this->userInfo->full_name,
            'faculty'   => $this->userInfo->faculty->name,
            'faculty_id'=> $this->userInfo->faculty_id,
            'rating'    => $this->userInfo->rating,
            'status'    => $this->pivot->status,
            // 'survey_answers' => 
        ];
    }
}
