<?php

namespace App\Http\Resources;

use App\Enums\UserRole;
use App\Models\SurveyQuestion;
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
            'information'       => $this->information,
            'time_study'        => $this->time_study,
            'location_study'    => $this->location_study,
            'subject_id'        => $this->subject_id,
            'faculty_id'        => $this->faculty_id,
            'quantity'          => $this->members_accepted_count,
            'self_study'        => $this->self_study,
            'subject'           => $this->subject->name,
            'faculty'           => $this->faculty->name,
            'status'            => $this->status,
            'members'           => ($this->creator->id === auth()->id() || auth()->user()->role_id === UserRole::ADMIN)
                ? MemberResource::collection($this->members)
                : MemberResource::collection($this->membersAccepted),
            'mentorAccepted'    => new MentorInGroupResource($this->mentorAccepted),
            'surveyQuestions'   => SurveyQuestionResource::collection($this->surveyQuestions)
        ];
    }
}
