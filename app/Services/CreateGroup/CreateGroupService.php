<?php

namespace App\Services\CreateGroup;

use App\Http\Controllers\Api\BaseController;
use App\Repositories\Contracts\GroupRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreateGroupService extends BaseController implements CreateGroupServiceInterface
{
  public function __construct(
    public GroupRepository $groupRepository
  ) {
  }
  /**
   * Form action create group
   *
   * @param $data
   * @return \Illuminate\Http\Response
   */
  public function createGroup($data)
  {
    DB::beginTransaction();

    try {
      $group = $this->groupRepository->create($data);

      if ($group) {
        $group->accounts()->attach(auth()->id(), [
          'is_creator'    => config('member.creator.true'),
          'is_mentor'     => $data['is_mentor'],
          'status'        => config('member.status.accepted')
        ]);
      }

      DB::commit();
      return $this->sendResponse(['messages' => __('messages.success.create')]);
    } catch (\Exception $e) {
      DB::rollBack();
      Log::error($e);
      return $this->sendError(__('messages.error.create'));
    }
  }
}
