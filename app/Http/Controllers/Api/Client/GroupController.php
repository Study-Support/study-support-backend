<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\GroupRequest;
use App\Http\Resources\GroupResource;
use App\Http\Resources\MemberResource;
use App\Repositories\Contracts\GroupRepository;
use App\Services\CreateGroup\CreateGroupService;
use App\Services\CreateGroup\CreateGroupServiceInterface;
use App\Services\UtilService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\JoinGroup\JoinGroupServiceInterface;

class GroupController extends BaseController
{
  public function __construct(
    public GroupRepository $groupRepository,
    public JoinGroupServiceInterface $joinGroupServiceInterface,
    public CreateGroupServiceInterface $createGroupServiceInterface
  ) {
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    $groups = $this->groupRepository->getListGroup($request->all());

    return $this->sendResponse([
      'data' => GroupResource::collection($groups),
      'pagination'  => UtilService::paginate($groups)
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
   * @param  \Illuminate\Http\GroupRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function store(GroupRequest $request)
  {
    $group = $request->validated();
    $group['status'] = config('group.status.waiting');

    try {
      if ($group['is_mentor'] && !$group['self_study']) {
        $subjects = auth()->user()->mentorInfo->subjectsAccepted;
        foreach ($subjects as $subject) {
          if ($subject->pivot->subject_id === $group['subject_id']) {
            return $this->createGroupServiceInterface->createGroup($group);
          }
        }

        return $this->sendError(__('messages.error.not_is_mentor'));
      } elseif (!$group['is_mentor']) {
        return $this->createGroupServiceInterface->createGroup($group);
      }

      return $this->sendError(__('messages.error.create'));
    } catch (\Exception $e) {
      Log::error($e);
      return $this->sendError(__('messages.error.create'));
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $group = $this->groupRepository->getGroup($id);

    return $this->sendResponse(new GroupResource($group));
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

  public function joinGroup($id)
  {
    $group = $this->groupRepository->getGroup($id);

    try {
      foreach ($group->accounts as $account) {
        if ($account->pivot->account_id === auth()->id()) {
          return $this->sendError(__('messages.error.account_exist'));
        }
      }

      if ($group->status === config('group.status.find_member')) {
        return $this->joinGroupServiceInterface->joinGroupAsMember($group);
      } elseif ($group->status === config('group.status.find_mentor') && !$group->self_study) {
        return $this->joinGroupServiceInterface->joinGroupAsMentor($group);
      }

      return $this->sendError(__('messages.error.can_not_join'));
    } catch (\Exception $e) {
      Log::error($e);
      return $this->sendError(__('messages.error.can_not_join'));
    }
  }
}
