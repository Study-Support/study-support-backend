<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;

class RegisterRequest extends BaseRequest
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
            'email' => [
                'required',
                'email',
                'unique:accounts,email'
            ],
            'password' => [
                'required'
            ],
            'confirm_password' => [
                'required',
                'same:password'
            ],
            'full_name' => [
                'required'
            ],
            'phone_number' => [
                'required',
                'numeric'
            ],
            'birthday' => [
                'required'
            ],
            'gender' => [
                'required'
            ],
            'faculty_id' => [
                'required',
                Rule::exists('faculties', 'id')
            ],
            'address' => [
                'required'
            ]
        ];
    }
}
