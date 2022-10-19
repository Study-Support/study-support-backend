<?php

namespace App\Http\Middleware;

use Illuminate\Http\JsonResponse;

class ResponseInvalidToken
{
  public static function send()
  {
    $meta = [
      "code" =>  JsonResponse::HTTP_UNAUTHORIZED,
      "error_message" => 'Invalid token'
    ];
    $response = [
      'meta' => $meta,
      'data' => [],
    ];
    return response()->json($response, JsonResponse::HTTP_UNAUTHORIZED);
  }
}
