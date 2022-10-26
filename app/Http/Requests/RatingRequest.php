<?php

namespace App\Http\Requests;

class RatingRequest extends BaseRequest
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
            'group_id' => [
                'required'
            ],
            'user_id' => [
                'required'
            ],
            'comment' => [
                'required'
            ],
            'rate' => [
                'required',
                'numeric',
                'between:0,10'
            ]
        ];
    }
}
