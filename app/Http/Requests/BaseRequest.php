<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class BaseRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return false;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, mixed>
   */
  public function rules()
  {
    return [
      //
    ];
  }

  protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
  {
    $response = new JsonResponse([
      'meta' => [
        "code" => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
        "error_message" => $validator->errors()
      ],
      'data' => [],
    ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);

    throw new \Illuminate\Validation\ValidationException($validator, $response);
  }
}
