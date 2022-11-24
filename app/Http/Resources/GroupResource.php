<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GroupResource extends JsonResource
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
            'id'                => $this->id,
            'topic'             => $this->topic,
            'time_study'        => $this->time_study,
            'location_study'    => $this->location_study,
            'quantity'          => $this->members_accepted_count,
            'self_study'        => $this->self_study,
            'subject'           => $this->subject->name,
            'faculty'           => $this->faculty->name,
            'status'            => $this->status,
        ];
    }
}
