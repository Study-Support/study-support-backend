<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class MentorRequest extends BaseRequest
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
      'id' => [
        'required'
      ],
      'cv_link'  => [
        'required'
      ],
      'subject_id' => [
        'required',
        Rule::exists('subjects', 'id')
      ],
    ];
  }
}
