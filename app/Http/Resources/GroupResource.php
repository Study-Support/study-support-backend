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
            'id'            => $this->id,
            'topic'         => $this->topic,
            'information'   => $this->information,
            'time_study'    => $this->time_study,
            'location_study'=> $this->location_study,
            'subject_id'    => $this->subject_id,
            'status'        => $this->status,
            'student_amount'=> $this->student_amount
        ];
    }
}
