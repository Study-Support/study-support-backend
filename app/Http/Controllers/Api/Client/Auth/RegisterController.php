<?php

namespace App\Http\Controllers\Api\Client\Auth;

use App\Enums\UserRole;
use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\RegisterRequest;
use App\Repositories\Contracts\AccountRepository;
use App\Repositories\Contracts\UserInfoRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RegisterController extends BaseController
{
  public function __construct(
    private AccountRepository $accountRepository,
    private UserInfoRepository $userInfoRepository
  ) {
  }

  /**
   * Register a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function register(RegisterRequest $request)
  {
    $data_account = $request->only(['email', 'password']);
    $data_account['role_id'] = UserRole::USER;
    $data_info = $request->only(['full_name', 'phone_number', 'birthday', 'gender', 'faculty_id', 'address']);

    DB::beginTransaction();

    try {
      $account = $this->accountRepository->create($data_account);

      if ($account) {
        $data_info['account_id'] = $account->id;
        $this->userInfoRepository->create($data_info);
      }

      DB::commit();
      return $this->sendResponse(['messages' => __('messages.success.register')]);
    } catch (\Exception $e) {
      DB::rollBack();
      Log::error($e);
      return $this->sendError(__('messages.error.register'));
    }
  }
}
