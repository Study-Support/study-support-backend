<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\AcceptMemberRequest;
use App\Http\Requests\GroupRequest;
use App\Http\Resources\AnswerResource;
use App\Http\Resources\GroupDetailResource;
use App\Http\Resources\GroupResource;
use App\Models\Member;
use App\Repositories\Contracts\AnswerRepository;
use App\Repositories\Contracts\GroupRepository;
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
        public AnswerRepository $answerRepository
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
            $myAnswers = $this->answerRepository->getMyAnswer($group->id);

            return $this->sendResponse([
                'group'     => new GroupDetailResource($group),
                'myAnswers' => AnswerResource::collection($myAnswers)
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

            if ($group->creator->id === auth()->id() && $group->status === config('group.status.waiting')) {
                $data = $request->validated();
                $group->update($data);

                $oldKeys = array_column($group->surveyQuestions->toArray(), 'id');
                $newKeys = array_column($data['survey_questions'], 'id');

                foreach (array_diff($oldKeys, $newKeys) as $deleteKey) {
                    if ($deleteKey) {
                        $this->surveyQuestionRepository->delete($deleteKey);
                    }
                }

                foreach ($data['survey_questions'] as $newQuestion) {
                    $newQuestion['id']
                        ? $this->surveyQuestionRepository->update($newQuestion['id'], $newQuestion)
                        : $this->surveyQuestionRepository->create([
                            'content'   => $newQuestion['content'],
                            'group_id'  => $id
                        ]);
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
            $creatorId = $group->creator->id;
            if (!($creatorId === auth()->id())) {
                return $this->sendError(__('messages.error.not_is_creator'));
            }

            $member_id = array_column($group->membersWaiting->toArray(), 'id');
            $data = $request->only('account_id', 'accept');

            $member_accept = array_intersect($member_id, $data['account_id']);

            DB::transaction(function () use ($data, $member_accept, $group) {
                if ($data['accept']) {
                    Member::whereIn('account_id', $member_accept)
                        ->where('group_id', $group->id)->update([
                            'status'    => 1
                        ]);
                } else {
                    $this->answerRepository->deleteAnswers($group->id, $member_accept);
                    $group->accounts()->detach($member_accept);
                }
            });

            return  $this->sendResponse(['message' => __('messages.success.update')]);
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
