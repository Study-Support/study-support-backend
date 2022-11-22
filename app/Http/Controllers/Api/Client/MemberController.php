<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\SurveyAnswerRequest;
use App\Repositories\Contracts\GroupRepository;
use App\Repositories\Contracts\SurveyAnswerRepository;
use App\Services\JoinGroup\JoinGroupServiceInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class MemberController extends BaseController
{

    public function __construct(
        public GroupRepository $groupRepository,
        public JoinGroupServiceInterface $joinGroupServiceInterface,
        public SurveyAnswerRepository $surveyAnswerRepository
    ) {
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
     * @param  \Illuminate\Http\SurveyAnswerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id, SurveyAnswerRequest $request)
    {
        $data = $request->validated();
        $group = $this->groupRepository->getGroup($id);

        try {
            foreach ($group->accounts as $account) {
                if ($account->pivot->account_id === auth()->id()) {
                    return $this->sendError(__('messages.error.account_exist'));
                }
            }

            if ($group->surveyQuestions->count() != count($data['survey_answers'])) {
                return $this->sendError(__('messages.error.must_enough_answers'));
            }

            if ($group->status === config('group.status.find_member')) {
                return $this->joinGroupServiceInterface->joinGroupAsMember($group, $data);
            } elseif ($group->status === config('group.status.find_mentor') && !$group->self_study) {
                return $this->joinGroupServiceInterface->joinGroupAsMentor($group, $data);
            }

            return $this->sendError(__('messages.error.can_not_join'));
        } catch (\Exception $e) {
            Log::error($e);
            return $this->sendError(__('messages.error.can_not_join'));
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
     * @param  \Illuminate\Http\SurveyAnswerRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SurveyAnswerRequest $request, $id)
    {
        try {
            $group = $this->groupRepository->getGroup($id);
            $data = $request->validated();
            foreach ($group->surveyAnswers as $groupAnswer) {
                foreach ($data['survey_answers'] as $answer) {
                    if ($groupAnswer->account_id === auth()->id() && $groupAnswer->question_id === $answer['id']) {
                        $groupAnswer->content = $answer['answer'];
                        $groupAnswer->save();
                    }
                }
            }

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
                $this->surveyAnswerRepository->deleteMyAnswer($id);
                $group = $this->groupRepository->getGroup($id);
                $group->accounts()->detach(auth()->id());
            });

            return $this->sendResponse([
                'message' => __('messages.success.delete')
            ]);
        } catch (\Exception $e) {
            Log::error($e);
            return $this->sendError(__('messages.error.delete'));
        }
    }
}
