<?php

namespace App\Http\Controllers\Api\Client\Auth;

use App\Enums\UserRole;
use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\LoginRequest;
use App\Services\Login\LoginServiceInterface;

class LoginController extends BaseController
{
  public function __construct(public LoginServiceInterface $loginServiceInterface)
  {
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function login(LoginRequest $request)
  {
    $data = $request->validated();
    $data['role_id'] = UserRole::USER;

    return $this->loginServiceInterface->actionLogin($data);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function logout()
  {
    return $this->loginServiceInterface->actionLogout();
  }
}
