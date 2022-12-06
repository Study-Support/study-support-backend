<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\BankRequest;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\MentorRequest;
use App\Http\Requests\MentorSubjectRequest;
use App\Http\Resources\MentorInfoResource;
use App\Http\Resources\MentorInProfile\MentorInProfileResource;
use App\Repositories\Contracts\AccountRepository;
use App\Repositories\Contracts\MentorInfoRepository;
use App\Services\RegisterMentor\RegisterMentorServiceInterface;
use Illuminate\Http\Request;

class MentorInfoController extends BaseController
{
    public function __construct(
        private MentorInfoRepository $mentorInfoRepository,
        private AccountRepository $accountRepository,
        public RegisterMentorServiceInterface $registerMentorServiceInterface
    ) {
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mentor = $this->mentorInfoRepository->getMentor(auth()->id());

        return $this->sendResponse([
            'data'    => new MentorInProfileResource($mentor)
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
     * @param  \Illuminate\Http\MentorRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MentorRequest $request)
    {
        $data = $request->validated();

        return $this->registerMentorServiceInterface->registerMentor($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\MentorSubjectRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateSubject(MentorSubjectRequest $request)
    {
        try {
            $mentor = $this->mentorInfoRepository->getMentor(auth()->id());

            $data = $request->validated();

            foreach ($mentor->subjects as $subject) {
                if ($subject->pivot->id == $data['id'] && $subject->pivot->active == config('mentor.active.false')) {
                    $subject->pivot->subject_id = $data['subject_id'];
                    $subject->pivot->cv_link = $data['cv_link'];
                    $subject->pivot->save();

                    return $this->sendResponse([
                        'message' => __('messages.success.update')
                    ]);
                }
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
            $mentorInfo = auth()->user()->mentorInfo;

            foreach ($mentorInfo->subjects as $subject) {
                if ($subject->pivot->subject_id == $id && $subject->pivot->status == config('mentor.active.false')) {
                    $mentorInfo->subjects()->detach($id);

                    return $this->sendResponse([
                        'message' => __('messages.success.delete')
                    ]);
                }
            }

            return $this->sendError(__('messages.error.delete'));
        } catch (\Exception $e) {
            Log::error($e);
            return $this->sendError(__('messages.error.delete'));
        }
    }

    public function getListMentor(Request $request)
    {
        $mentors = $this->mentorInfoRepository->getListMentor($request->all());

        return $this->sendResponse([
            'data'    => MentorInfoResource::collection($mentors)
        ]);
    }

    public function updateBank(BankRequest $bankRequest)
    {
        try {
            $mentor = $this->mentorInfoRepository->getMentor(auth()->id());

            $this->mentorInfoRepository->update($mentor->id, $bankRequest->only('smart_banking'));

            return $this->sendResponse([
                'message' => __('messages.success.update')
            ]);
        } catch (\Exception $e) {
            Log::error($e);
            return $this->sendError(__('messages.error.update'));
        }
    }
}
