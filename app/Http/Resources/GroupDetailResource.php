<?php

namespace App\Http\Resources;

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
            'status'            => $this->status,
            'membersAccepted'   => MemberResource::collection($this->membersAccepted),
            'membersWaiting'    => $this->creator->id === auth()->id()
                ? MemberResource::collection($this->membersWaiting)
                : null,
            'mentorAccepted'    => new MentorInGroupResource($this->mentorAccepted),
            'survey_questions'  => SurveyQuestionResource::collection($this->surveyQuestions),
            'answers'           => $this->creator->id === auth()->id()
                ? AnswerResource::collection($this->memberAnswers)
                : null,
            'is_creator'        => $this->creator->id === auth()->id() ?? false
        ];
    }
}
