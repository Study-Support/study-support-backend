<?php

namespace App\Services\Login;

use App\Enums\AccountStatus;
use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\AccountResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class LoginService extends BaseController implements LoginServiceInterface
{
    /**
     * Form action login
     *
     * @param $data
     * @return \Illuminate\Http\Response
     */
    public function actionLogin($data)
    {
        if (Auth::attempt($data)) {
            $account = Auth::user();

            if ($account->is_active === AccountStatus::ACTIVE) {
                $token = [
                    'token_type' => 'Bearer',
                    'access_token' => $account->createToken('token')->accessToken
                ];

                return $this->sendResponse([
                    'message' => __('messages.success.login'),
                    'data'    => new AccountResource($account),
                    'token'   => $token
                ]);
            }
        }

        return $this->sendError(__('messages.error.login'), JsonResponse::HTTP_UNAUTHORIZED);
    }

    /**
     * Form action logout
     *
     * @return \Illuminate\Http\Response
     */
    public function actionLogout()
    {
        if (Auth::check()) {
            Auth::user()->token()->delete();
        }

        return $this->sendResponse([
            'message'   => __('messages.success.logout'),
        ]);
    }
}
