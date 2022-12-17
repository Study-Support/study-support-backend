<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\RatingRequest;
use App\Http\Resources\MyListRatingResource;
use App\Repositories\Contracts\GroupRepository;
use App\Repositories\Contracts\MentorInfoRepository;
use App\Repositories\Contracts\UserInfoRepository;
use Illuminate\Support\Facades\Log;

class RatingController extends BaseController
{
    public function __construct(
        public GroupRepository $groupRepository,
        public UserInfoRepository $userInfoRepository,
        public MentorInfoRepository $mentorInfoRepository
    ) {
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->sendResponse([
            'data'  => new MyListRatingResource(auth()->user())
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RatingRequest $request)
    {
        try {
            $data = $request->validated();
            $group = $this->groupRepository->getGroup($data['group_id']);

            if ($group->status === config('group.status.studying')) {
                $mentor_id = $group->mentorAccepted->id;

                foreach ($group->membersAccepted as $member) {
                    if ($member->id == auth()->id() && $mentor_id == $data['user_id']) {

                        $mentor = $this->mentorInfoRepository->getMentor($data['user_id']);
                        $mentor->rateOnce($data['rate'], $data['comment'], $data['group_id']);

                        return $this->sendResponse(['message' => __('messages.success.rate')]);
                    } elseif ($member->id == $data['user_id']  && $mentor_id == auth()->id()) {

                        $user = $this->userInfoRepository->getUser($data['user_id']);
                        $user->rateOnce($data['rate'], $data['comment'], $data['group_id']);

                        return $this->sendResponse(['message' => __('messages.success.rate')]);
                    }
                }
            }

            return $this->sendError(__('messages.error.rate'));
        } catch (\Exception $e) {
            Log::error($e);
            return $this->sendError(__('messages.error.rate'));
        }
    }
}
