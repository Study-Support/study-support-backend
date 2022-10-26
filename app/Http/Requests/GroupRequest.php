<?php

namespace App\Http\Requests;

use App\Enums\GroupStudy;
use App\Enums\MemberRole;
use Illuminate\Validation\Rule;

class GroupRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'topic' => [
                'required'
            ],
            'information' => [
                'required'
            ],
            'time_study' => [
                'required'
            ],
            'student_amount' => [
                'required',
                'numeric',
                'between:0,10'
            ],
            'location_study' => [
                'required'
            ],
            'subject_id' => [
                'required',
                Rule::exists('subjects', 'id')
            ],
            'faculty_id' => [
                'required',
                Rule::exists('faculties', 'id')
            ],
            'self_study' => [
                'required',
                Rule::in(GroupStudy::all())
            ],
            'is_mentor' => [
                'required',
                Rule::in(MemberRole::all())
            ]
        ];
    }
}
