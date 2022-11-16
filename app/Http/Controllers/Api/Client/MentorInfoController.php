<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\MentorRequest;
use App\Http\Resources\MentorInfoResource;
use App\Http\Resources\MentorResource;
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
            'data'    => new MentorResource($mentor)
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
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
     * @param  \Illuminate\Http\MentorRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MentorRequest $request)
    {
        try {
            $mentor = $this->mentorInfoRepository->where('account_id', auth()->id())->first();
            $this->mentorInfoRepository->update($mentor->id, $request->only('smart_banking'));

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
        //
    }

    public function getListMentor(Request $request)
    {
        $mentors = $this->mentorInfoRepository->getListMentor($request->all());
        
        return $this->sendResponse([
            'data'    => MentorInfoResource::collection($mentors)
        ]);
    }
}
