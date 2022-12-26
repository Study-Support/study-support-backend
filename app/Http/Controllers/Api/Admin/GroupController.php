<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\Admin\AcceptMentorRequest;
use App\Http\Resources\Admin\GroupDetailResource;
use App\Http\Resources\Admin\GroupResource;
use App\Repositories\Contracts\GroupRepository;
use App\Services\UtilService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        $groups = $this->groupRepository->getAllGroup($request->all());

        return $this->sendResponse([
            'data' => GroupResource::collection($groups),
            'pagination'  => UtilService::paginate($groups)
        ]);
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

        return $this->sendResponse([
            'data' => new GroupDetailResource($group),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        try {
            $group = $this->groupRepository->find($id);

            switch ($group->status) {
                case (config('group.status.waiting')):
                    $group->status = config('group.status.find_member');
                    $group->save();
                    break;
                case (config('group.status.find_member')):
                    if ($group->self_study) {
                        $group->status = config('group.status.studying');
                    } else {
                        $group->status = config('group.status.find_mentor');
                    }
                    $group->save();
                    break;
                case (config('group.status.studying')):
                    $group->status = config('group.status.close');
                    $group->save();
                    break;
                default:
                    return $this->sendError(__('messages.error.update'));
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
            $group = $this->groupRepository->find($id);

            if ($group->status === config('group.status.waiting')) {
                $group->accounts()->detach();
                $group->delete();

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

    public function acceptMentor(AcceptMentorRequest $request, $id)
    {
        try {
            $group = $this->groupRepository->getGroup($id);
            $data = $request->validated();

            foreach ($group->mentorWaiting as $mentor) {
                if ($mentor->id === $data['account_id']) {
                    DB::transaction(function () use ($mentor, $group) {
                        $mentor->pivot->status = config('member.status.accepted');
                        $mentor->pivot->save();

                        $group->status = config('group.status.studying');
                        $group->save();
                    });
                } else {
                    $group->accounts()->detach($mentor->id);
                }
            }

            return $this->sendResponse([
                'message' => __('messages.success.delete')
            ]);
        } catch (\Exception $e) {
            Log::error($e);
            return $this->sendError(__('messages.error.update'));
        }
    }

    /**
     * close Group
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function closeGroup($id)
    {
        try {
            $group = $this->groupRepository->find($id);

            $group->status = config('group.status.close');
            $group->save();

            return $this->sendResponse([
                'message' => __('messages.success.update')
            ]);
        } catch (\Exception $e) {
            Log::error($e);
            return $this->sendError(__('messages.error.update'));
        }
    }
}
