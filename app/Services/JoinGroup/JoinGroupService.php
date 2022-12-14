<?php

namespace App\Services\JoinGroup;

use App\Http\Controllers\Api\BaseController;
use App\Services\CreateAnswer\CreateAnswerServiceInterface;
use App\Services\JoinGroup\JoinGroupServiceInterface;
use Illuminate\Support\Facades\Log;

class JoinGroupService extends BaseController implements JoinGroupServiceInterface
{
    public function __construct(
        public CreateAnswerServiceInterface $createAnswerServiceInterface
    ) {
    }
    /**
     * Form action join group
     *
     * @param $data
     * @param $answers
     * @return \Illuminate\Http\Response
     */
    public function joinGroupAsMember($data, $answers)
    {

        try {
            foreach (auth()->user()->accountInGroup as $group) {
                if ($group->subject_id === $data->subject_id) {
                    return $this->sendError(__('messages.error.group_of_subject_exist'));
                };
            }

            $data->accounts()->attach(auth()->id(), [
                'is_creator'    => config('member.creator.false'),
                'is_mentor'     => config('member.mentor.false'),
                'status'        => config('member.status.waiting')
            ]);

            $this->createAnswerServiceInterface->createAnswer($answers, config('answer.type.member'), $data->id);

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
     * @param $answers
     * @param $data
     * @return \Illuminate\Http\Response
     */
    public function joinGroupAsMentor($data, $answers)
    {
        try {
            $subjects = auth()->user()->mentorInfo->subjectsAccepted;

            foreach ($subjects as $subject) {
                if ($subject->id === $data->subject_id) {

                    $data->accounts()->attach(auth()->id(), [
                        'is_creator'    => config('member.creator.false'),
                        'is_mentor'     => config('member.mentor.true'),
                        'status'        => config('member.status.waiting')
                    ]);

                    $this->createAnswerServiceInterface->createAnswer($answers, config('answer.type.mentor'), $data->id);

                    return $this->sendResponse([
                        'message' => __('messages.success.create')
                    ]);
                }
            }

            return $this->sendError(__('messages.error.not_is_mentor'));
        } catch (\Exception $e) {
            Log::error($e);
            return $this->sendError(__('messages.error.create'));
        }
    }
}
