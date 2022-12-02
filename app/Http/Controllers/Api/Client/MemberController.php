<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\AnswerRequest;
use App\Repositories\Contracts\AnswerRepository;
use App\Repositories\Contracts\GroupRepository;
use App\Services\JoinGroup\JoinGroupServiceInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class MemberController extends BaseController
{

    public function __construct(
        public GroupRepository $groupRepository,
        public JoinGroupServiceInterface $joinGroupServiceInterface,
        public AnswerRepository $answerRepository
    ) {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\AnswerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id, AnswerRequest $request)
    {
        $data = $request->validated();
        $group = $this->groupRepository->getGroup($id);

        try {
            foreach ($group->accounts as $account) {
                if ($account->pivot->account_id === auth()->id()) {
                    return $this->sendError(__('messages.error.account_exist'));
                }
            }

            if ($group->surveyQuestions->count() != count($data['answers'])) {
                return $this->sendError(__('messages.error.must_enough_answers'));
            }

            if ($group->status === config('group.status.find_member') || ($group->self_study && $group->status === config('group.status.studying'))) {
                return $this->joinGroupServiceInterface->joinGroupAsMember($group, $data['answers']);
            } elseif ($group->status === config('group.status.find_mentor') && !$group->self_study) {
                return $this->joinGroupServiceInterface->joinGroupAsMentor($group, $data['answers']);
            }

            return $this->sendError(__('messages.error.can_not_join'));
        } catch (\Exception $e) {
            Log::error($e);
            return $this->sendError(__('messages.error.can_not_join'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\AnswerRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AnswerRequest $request, $id)
    {
        try {
            DB::transaction(function () use ($request) {
                foreach ($request->answers as $answer) {
                    $this->answerRepository
                        ->findOrFail($answer['id'])
                        ->update(['content' => $answer['content']]);
                }
            });

            return $this->sendResponse([
                'message' => __('messages.success.update')
            ]);
        } catch (\Exception $e) {
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
        try {
            DB::transaction(function () use ($id) {
                $this->answerRepository->deleteMyAnswer($id);
                $group = $this->groupRepository->getGroup($id);
                $group->accounts()->detach(auth()->id());
            });

            return $this->sendResponse([
                'message' => __('messages.success.leave_group')
            ]);
        } catch (\Exception $e) {
            Log::error($e);
            return $this->sendError(__('messages.error.leave_group'));
        }
    }
}
