<?php

namespace App\Http\Requests;

class AcceptMemberRequest extends BaseRequest
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
            'account_id'    => 'required|array',
            'accept'        => 'required|boolean'
        ];
    }
}
