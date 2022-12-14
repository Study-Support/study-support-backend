<?php

namespace App\Http\Requests;

class UpdatePasswordRequest extends BaseRequest
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
            'current_password' => [
                'required'
            ],
            'password' => [
                'required',
                'different:current_password'
            ],
            'password_confirmation' => [
                'required',
                'same:password'
            ],
        ];
    }
}
