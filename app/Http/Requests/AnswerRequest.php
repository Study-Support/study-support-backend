<?php

namespace App\Http\Requests;

class AnswerRequest extends BaseRequest
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
            'answers'           => 'required|array',
            'answers.*.content'  => 'required',
            'answers.*.answer' => 'required'
        ];
    }
}
