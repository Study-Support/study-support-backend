<?php

namespace App\Services\JoinGroup;

use App\Http\Controllers\Api\BaseController;
use App\Services\JoinGroup\JoinGroupServiceInterface;
use Illuminate\Support\Facades\Log;

class JoinGroupService extends BaseController implements JoinGroupServiceInterface
{
  /**
   * Form action join group
   *
   * @param $data
   * @return \Illuminate\Http\Response
   */
  public function joinGroupAsMember($data)
  {
    try {
      $data->accounts()->attach(auth()->id(), [
        'is_creator'    => config('member.creator.false'),
        'is_mentor'     => config('member.mentor.false'),
        'status'        => config('member.status.accepted')
      ]);

      return $this->sendResponse([
        'message' => __('messages.success.create')
      ]);
    } catch (\Exception $e) {
      Log::error($e);
      return $this->sendError(__('messages.error.create'));
    }
  }

  /**
   * Form action join group as mentor
   *
   * @param $data
   * @return \Illuminate\Http\Response
   */
  public function joinGroupAsMentor($data)
  {
    try {
      $subjects = auth()->user()->mentorInfo->subjectsAccepted;
      foreach ($subjects as $subject) {
        if ($subject->pivot->id === $data->subject_id) {
          $data->accounts()->attach(auth()->id(), [
            'is_creator'    => config('member.creator.false'),
            'is_mentor'     => config('member.mentor.true'),
            'status'        => config('member.status.waiting')
          ]);

          return $this->sendError(__('messages.success.create'));
        }
      }

      return $this->sendResponse([
        'message' => __('messages.error.not_is_mentor')
      ]);
    } catch (\Exception $e) {
      Log::error($e);
      return $this->sendError(__('messages.error.create'));
    }
  }
}
