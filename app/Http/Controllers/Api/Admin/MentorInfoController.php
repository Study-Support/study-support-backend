<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\Admin\MentorInfo\UpdateMentorInfoRequest;
use App\Http\Resources\Admin\Mentor\MentorResource;
use App\Repositories\Contracts\AccountRepository;
use App\Repositories\Contracts\MentorInfoRepository;
use App\Services\UtilService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class MentorInfoController extends BaseController
{
    public function __construct(
        private MentorInfoRepository $mentorInfoRepository,
        private AccountRepository $accountRepository
    ) {
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $mentors = $this->mentorInfoRepository->getListMentor($request->all());

        return $this->sendResponse([
            'data'          => MentorResource::collection($mentors),
            'pagination'    => UtilService::paginate($mentors)
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
        $mentor = $this->mentorInfoRepository->getMentor($id);

        return $this->sendResponse([
            'data'      => new MentorResource($mentor)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\UpdateMentorInfoRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMentorInfoRequest $request, $id)
    {
        $data = $request->only('subject_id');
        $mentorInfo = $this->mentorInfoRepository->getMentor($id);

        try {
            foreach ($mentorInfo->subjects as $subject) {
                if ($subject->pivot->subject_id == $data['subject_id']) {
                    $subject->pivot->active = !$subject->pivot->active;
                    $subject->pivot->save();

                    return $this->sendResponse(['messages' => __('messages.success.update')]);
                }
            }

            return $this->sendError(__('messages.error.not_subject_mentor'));
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
    public function destroy(UpdateMentorInfoRequest $request, $id)
    {
        try {
            $mentorInfo = $this->mentorInfoRepository->getMentor($id);
            foreach ($mentorInfo->subjects as $subject) {
                if ($subject->pivot->id == $request->subject_id) {
                    $mentorInfo->subjects()->detach($request->subject_id);
                    return $this->sendResponse(['messages' => __('messages.success.delete')]);
                }
            }

            return $this->sendError(__('messages.error.not_subject_mentor'));
        } catch (\Exception $e) {
            Log::error($e);
            return $this->sendError(__('messages.error.delete'));
        }
    }
}
