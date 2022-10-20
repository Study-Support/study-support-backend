<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\UpdateMentorRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateUserInfoRequest;
use App\Http\Resources\UserInfoResource;
use App\Repositories\Contracts\AccountRepository;
use App\Repositories\Contracts\UserInfoRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserInfoController extends BaseController
{

  public function __construct(
    private UserInfoRepository $userInfoRepository,
    private AccountRepository $accountRepository
  ) {
  }

  /**
   * Display the specified resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {

    $user = $this->userInfoRepository->getCurrentUser();
    $response = $user ? new UserInfoResource($user) : null;

    return $this->sendResponse($response);
  }

  /**
   * Update user profile info
   * @param UpdateUserInfoRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function update(UpdateUserInfoRequest $request)
  {
    try {
      $data = $request->validated();

      $this->userInfoRepository->update(auth()->user()->userInfo->id, $data);

      return $this->sendResponse(['message' => __('messages.success.update')]);
    } catch (\Exception $e) {
      Log::error($e);
      return $this->sendError(__('messages .error.update'));
    }
  }

  /**
   * update password
   * @param UpdatePasswordRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function updatePassword(UpdatePasswordRequest $request)
  {

    if (!Hash::check($request->current_password, auth()->user()->password)) {
      return $this->sendError([
        'current_password' => __('validation.current_password')
      ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }

    $this->accountRepository->update(auth()->id(), $request->only('password'));

    return $this->sendResponse(__('messages.success.update'));
  }

  /**
   * update mentor
   * @param UpdateMentorRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function updateMentor(UpdateMentorRequest $request)
  {
    try {
      $data = $request->validated();

      $this->userInfoRepository->update(auth()->user()->userInfo->id, $data);

      return $this->sendResponse(['message' => __('messages.success.update')]);
    } catch (\Exception $e) {
      Log::error($e);
      return $this->sendError(__('messages .error.update'));
    }
  }
}
