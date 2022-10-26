<?php

namespace App\Http\Requests\Admin\UserInfo;

use App\Enums\AccountStatus;
use App\Http\Requests\BaseRequest;
use App\Enums\UserGender;
use Illuminate\Validation\Rule;

class UpdateUserInfoRequest extends BaseRequest
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
            'full_name' => [
                'required'
            ],
            'gender' => [
                'required',
                Rule::in(UserGender::all())
            ],
            'phone_number' => [
                'required',
                'numeric'
            ],
            'address' => [
                'required'
            ],
            'birthday' => [
                'required'
            ],
            'faculty_id' => [
                'required',
                Rule::exists('faculties', 'id')
            ],
            'is_active' => [
                'required',
                Rule::in(AccountStatus::all())
            ]
        ];
    }
}
