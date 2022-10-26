<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\GroupRequest;
use App\Http\Resources\GroupResource;
use App\Repositories\Contracts\GroupRepository;
use App\Services\UtilService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Enums\UserRole;
use Illuminate\Support\Facades\DB;

class GroupController extends BaseController
{
  public function __construct(
    public GroupRepository $groupRepository
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

    $groups =  $groups->filter(function ($group) use ($request) {
      if ($request->type === config('group.type.not_enough_members'))
        return $group->student_amount > $group->members_count;
      elseif ($request->type === config('group.type.no_mentor'))
        return $group->mentor_count === 0;
      else return $group;
    });

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
    $data = $request->validated();
    $data['status'] = config('group.status.waiting');

    $roles = auth()->user()->roles;

    foreach ($roles as $role) {
      if ($role->id === UserRole::MENTOR) {
        $mentor = $data['is_mentor'];
        break;
      } else $mentor = config('member.mentor.false');
    }

    DB::beginTransaction();

    try {
      $group = $this->groupRepository->create($data);

      if ($group) {
        $group->members()->attach(auth()->id(), [
          'is_creator' => config('member.creator.true'),
          'is_mentor'  => $mentor,
          'status'     => config('member.status.accepted')
        ]);
      }

      DB::commit();
      return $this->sendResponse(['message' => __('messages.success.create')]);
    } catch (\Exception $e) {
      DB::rollBack();
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
