<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\AcceptMemberRequest;
use App\Http\Requests\GroupRequest;
use App\Http\Resources\GroupDetailResource;
use App\Http\Resources\GroupResource;
use App\Http\Resources\SurveyAnswerResource;
use App\Repositories\Contracts\GroupRepository;
use App\Repositories\Contracts\SurveyAnswerRepository;
use App\Repositories\Contracts\SurveyQuestionRepository;
use App\Services\CreateGroup\CreateGroupServiceInterface;
use App\Services\UtilService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\JoinGroup\JoinGroupServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class GroupController extends BaseController
{
    public function __construct(
        public GroupRepository $groupRepository,
        public JoinGroupServiceInterface $joinGroupServiceInterface,
        public CreateGroupServiceInterface $createGroupServiceInterface,
        public SurveyQuestionRepository $surveyQuestionRepository,
        public SurveyAnswerRepository $surveyAnswerRepository
    ) {
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $groups = $this->groupRepository->getListGroupInDashBoard($request->all());

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
        try {
            $group = $request->validated();

            $group['status'] = config('group.status.waiting');
            return $this->createGroupServiceInterface->createGroup($group);
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
        try {
            $group = $this->groupRepository->getGroup($id);
            $myAnswers = $this->surveyAnswerRepository->getMyAnswer($group->id);

            return $this->sendResponse([
                'group'           => new GroupDetailResource($group),
                'survey_answers'  => SurveyAnswerResource::collection($myAnswers)
            ]);
        } catch (\Exception $e) {
            Log::error($e);
            return $this->sendError(__('messages.error.not_found'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\GroupRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(GroupRequest $request, $id)
    {
        try {
            $group = $this->groupRepository->find($id);

            if ($group->creator->first()->id === auth()->id() && $group->status === config('group.status.waiting')) {
                $data = $request->validated();
                $group->update($data);

                foreach ($data['survey_questions'] as $newQuestion) {
                    if ($newQuestion['id']) {
                        foreach ($group->surveyQuestions as $oldQuestion) {
                            if ($oldQuestion->id === $newQuestion['id']) {
                                $oldQuestion->content = $newQuestion['question'];
                                $oldQuestion->save();
                                break;
                            }
                        }
                    } else {
                        $this->surveyQuestionRepository->create([
                            'content'   => $newQuestion['question'],
                            'group_id'  => $group->id
                        ]);
                    }
                }

                return $this->sendResponse([
                    'message' => __('messages.success.update')
                ]);
            }

            return $this->sendError(__('messages.error.update'));
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
            $group = $this->groupRepository->getGroup($id);

            if ($group->creator->id === auth()->id() && $group->status === config('group.status.waiting')) {
                DB::transaction(function () use ($group) {
                    $group->accounts()->detach();
                    $group->surveyQuestions()->delete();
                    $group->delete();
                });


                return $this->sendResponse([
                    'message' => __('messages.success.delete')
                ]);
            }

            return $this->sendError(__('messages.error.delete'));
        } catch (\Exception $e) {
            Log::error($e);
            return $this->sendError(__('messages.error.delete'));
        }
    }

    public function acceptMember(AcceptMemberRequest $request, $id)
    {
        try {
            $group = $this->groupRepository->getGroup($id);
            $creatorId = $group->creator()->first()->id;
            if (!($creatorId === auth()->id())) {
                return $this->sendError(__('messages.error.not_is_creator'));
            }

            $data = $request->only('account_id', 'accept');
            $check = 0;
            foreach (($data['account_id']) as $id) {
                foreach ($group->membersWaiting as $member) {
                    if ($member->id === $id) {
                        $check++;
                        if ($data['accept']) {
                            $member->pivot->status = 1;
                            $member->pivot->save();
                            break;
                        } else {
                            $group->accounts()->detach($id);
                        }
                    }
                }
            }
            return  $check ? $this->sendResponse(['message' => __('messages.success.update')])
                : $this->sendError(__('messages.error.update'));
        } catch (\Exception $e) {
            Log::error($e);
            return $this->sendError(__('messages.error.update'));
        }
    }

    public function getMyListGroup(Request $request)
    {
        try {
            $groups = $this->groupRepository->getMyListGroup($request->all());

            return $this->sendResponse([
                'data'        => GroupResource::collection($groups)
            ]);
        } catch (\Throwable $th) {
            return $this->sendError(__('messages.error.not_found'), JsonResponse::HTTP_NOT_FOUND);
        }
    }
}
