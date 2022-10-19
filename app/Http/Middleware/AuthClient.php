<?php

namespace App\Http\Middleware;

use App\Enums\AccountStatus;
use App\Enums\UserRole;
use Closure;
use Illuminate\Http\Request;

class AuthClient
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
        if (
            (auth()->user()->role_id === UserRole::USER) &&
            (auth()->user()->is_active === AccountStatus::ACTIVE)
        ) {
            return $next($request);
        }
        return ResponseInvalidToken::send();
    }
}
