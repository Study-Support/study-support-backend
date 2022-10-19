<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\UpdatePasswordRequest;
use App\Repositories\Contracts\AccountRepository;
use App\Repositories\Contracts\UserInfoRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class UserInfoController extends BaseController
{

    public function __construct(
        private UserInfoRepository $userInfoRepository,
        private AccountRepository $accountRepository
    ) {
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

}
