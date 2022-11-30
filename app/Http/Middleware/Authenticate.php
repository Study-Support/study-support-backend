<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\JsonResponse;

class Authenticate extends Middleware
{
  /**
   * Get the path the user should be redirected to when they are not authenticated.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return string|null
   */
  protected function redirectTo($request)
  {
    if (!$request->expectsJson()) {
      return route('login');
    }
  }

  public function handle($request, Closure $next, ...$guards)
  {
    if (!auth('api')->check()) {
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

    return parent::handle($request, $next, ...$guards);
  }
}
