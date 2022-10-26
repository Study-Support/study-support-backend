<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\Admin\User\UserResource;
use App\Http\Resources\RatingResource;
use App\Repositories\Contracts\UserInfoRepository;
use App\Services\UtilService;
use Illuminate\Http\Request;

class UserController extends BaseController
{

  public function __construct(
    public UserInfoRepository $userInfoRepository
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
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    //
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
    $ratings = $user->ratings;

    return $this->sendResponse([
        'user'      => new UserResource($user),
        'ratings'   => RatingResource::collection($ratings)
    ]);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    //
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
