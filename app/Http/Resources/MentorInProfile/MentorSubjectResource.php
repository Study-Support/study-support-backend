<?php

namespace App\Http\Resources\MentorInProfile;

use Illuminate\Http\Resources\Json\JsonResource;

class MentorSubjectResource extends JsonResource
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
            'name'      => $this->name,
            'active'    => $this->pivot->active
        ];
    }
}
