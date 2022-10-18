<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class BaseController extends Controller
{
  /**
   * success response method.
   *
   * @return \Illuminate\Http\Response
   */
  public function sendResponse($result)
  {
    $meta = [
      "code" => JsonResponse::HTTP_OK,
      "error_message" => null
    ];

    $response = [
      'meta' => $meta,
      'data' => $result
    ];

    return response()->json($response, JsonResponse::HTTP_OK);
  }
  /**
   * return error response.
   *
   * @return \Illuminate\Http\Response
   */
  public function sendError($errorMessages = [], $code = JsonResponse::HTTP_INTERNAL_SERVER_ERROR)
  {
    $meta = [
      "code" => $code,
      "error_message" => $errorMessages
    ];

    $response = [
      'meta' => $meta,
      'data' => [],
    ];

    return response()->json($response, $code);
  }
}
