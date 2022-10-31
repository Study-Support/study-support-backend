<?php

namespace App\Services\RegisterMentorService;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Support\Facades\Log;

class LoginService extends BaseController implements RegisterMentorServiceInterface
{
  /**
   * Form action register mentor
   *
   * @param $data
   * @return \Illuminate\Http\Response
   */
  public function registerMentor($data)
  {
    try {
      $mentorInfo = $this->mentorInfoRepository->getMentor(auth()->id())
        ? $this->mentorInfoRepository->getMentor(auth()->id())
        : $this->mentorInfoRepository->create($data);

      foreach ($mentorInfo->subjects as $subject) {
        if ($subject->id == $data['subject_id']) {
          return $this->sendResponse(['messages' => __('messages.error.mentor_exist')]);
        }
      }

      $mentorInfo->subjects()->attach($data['subject_id'], [
        'cv_link'   => $data['cv_link'],
        'active'    => config('mentor.active.false')
      ]);

      return $this->sendResponse([
        'message' => __('messages.success.create')
      ]);
    } catch (\Exception $e) {
      Log::error($e);
      return $this->sendError(__('messages.error.create'));
    }
  }
}
