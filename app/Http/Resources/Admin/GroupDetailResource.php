<?php

namespace App\Http\Resources\Admin;

use App\Http\Resources\AnswerResource;
use App\Http\Resources\MemberResource;
use App\Http\Resources\MentorInGroupResource;
use Illuminate\Http\Resources\Json\JsonResource;

class GroupDetailResource extends JsonResource
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
            'information'       => $this->information,
            'time_study'        => $this->time_study,
            'location_study'    => $this->location_study,
            'subject_id'        => $this->subject_id,
            'faculty_id'        => $this->faculty_id,
            'quantity'          => $this->members_accepted_count,
            'self_study'        => $this->self_study,
            'subject'           => $this->subject->name,
            'faculty'           => $this->faculty->name,
            'image_url'         => $this->image_url,
            'status'            => $this->status,
            'membersAccepted'   => MemberResource::collection($this->membersAccepted),
            'mentorAccepted'    => new MentorInGroupResource($this->mentorAccepted),
            'mentorWaiting'     => MentorInGroupResource::collection($this->mentorWaiting),
            'answers'           => AnswerResource::collection($this->mentorAnswers)
        ];
    }
}
