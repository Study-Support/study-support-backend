<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\RatingRequest;
use App\Repositories\Contracts\GroupRepository;
use App\Repositories\Contracts\MentorInfoRepository;
use App\Repositories\Contracts\UserInfoRepository;
use Illuminate\Http\Request;

class RatingController extends BaseController
{
  public function __construct(
    public GroupRepository $groupRepository,
    public UserInfoRepository $userInfoRepository,
    public MentorInfoRepository $mentorInfoRepository
  ) {
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    //
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
  public function store(RatingRequest $request)
  {
    $data = $request->validated();
    $group = $this->groupRepository->getGroup($data['group_id']);

    $mentor_id = $group->mentorAccepted->first()->id;

    foreach ($group->membersAccepted as $member) {
      if ($member->id == auth()->id() && $mentor_id == $data['user_id']) {
        $mentor = $this->mentorInfoRepository->getMentor($data['user_id']);
        $mentor->rate($data['rate'], $data['comment'], $data['group_id']);
      } elseif ($member->id == $data['user_id']  && $mentor_id == auth()->id()) {
        $user = $this->userInfoRepository->getUser($data['user_id']);
        $user->rate($data['rate'], $data['comment'], $data['group_id']);
      }
    }

    return $this->sendResponse(['message' => __('messages.success.create')]);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    //
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
