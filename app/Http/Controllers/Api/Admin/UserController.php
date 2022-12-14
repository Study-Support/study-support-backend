<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\Admin\UserInfo\UpdateUserInfoRequest;
use App\Http\Resources\Admin\User\UserResource;
use App\Http\Resources\RatingResource;
use App\Repositories\Contracts\AccountRepository;
use App\Repositories\Contracts\UserInfoRepository;
use App\Services\UtilService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserController extends BaseController
{

    public function __construct(
        public UserInfoRepository $userInfoRepository,
        public AccountRepository $accountRepository
    ) {
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = $this->userInfoRepository->getListUser($request->all());

        return $this->sendResponse([
            'data' => UserResource::collection($users),
            'pagination'  => UtilService::paginate($users)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = $this->userInfoRepository->getUser($id);

        return $this->sendResponse([
            'data'      => new UserResource($user)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\UpdateUserInfoRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserInfoRequest $request, $id)
    {

        $user = $this->userInfoRepository->where('account_id', $id)->first();

        DB::beginTransaction();

        try {
            $this->userInfoRepository->update($user->id, $request->validated());
            $this->accountRepository->update($id, $request->only('is_active'));

            DB::commit();
            return $this->sendResponse([
                'message' => __('messages.success.update')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return $this->sendError(__('messages.error.update'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
