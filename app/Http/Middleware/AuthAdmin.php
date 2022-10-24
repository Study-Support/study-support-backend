<?php

namespace App\Http\Middleware;

use App\Enums\AccountStatus;
use App\Enums\UserRole;
use Closure;
use Illuminate\Http\Request;

class AuthAdmin
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
   * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
   */
  public function handle(Request $request, Closure $next)
  {
    $roles = auth()->user()->roles;
    foreach ($roles as $role) {
      if (
        ($role->id === UserRole::ADMIN) &&
        (auth()->user()->is_active === AccountStatus::ACTIVE)
      ) {
        return $next($request);
      }
    }
    return ResponseInvalidToken::send();
  }
}
