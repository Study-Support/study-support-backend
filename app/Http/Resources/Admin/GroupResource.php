<?php

namespace App\Http\Resources\Admin;

use App\Http\Resources\MemberResource;
use App\Http\Resources\MentorInGroupResource;
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
            'subject_id'    => $this->subject_id,
            'faculty_id'    => $this->faculty_id,
            'quantity'      => $this->members_accepted_count,
            'self_study'    => $this->self_study,
            'subject'       => $this->subject->name,
            'faculty'       => $this->faculty->name,
            'image_url'     => $this->image_url,
            'status'        => $this->status,
            'members'       => MemberResource::collection($this->membersAccepted),
            'mentorAccepted' => new MentorInGroupResource($this->mentorAccepted),
            'mentorWaiting' => MentorInGroupResource::collection($this->mentorWaiting)
        ];
    }
}
