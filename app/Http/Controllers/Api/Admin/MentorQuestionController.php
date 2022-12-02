<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\MentorQuestionRequest;
use App\Http\Resources\MentorQuestionResource;
use App\Repositories\Contracts\MentorQuestionRepository;

class MentorQuestionController extends BaseController
{
    public function __construct(
        private MentorQuestionRepository $mentorQuestionRepository
    ) {
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mentorQuestions = $this->mentorQuestionRepository->getListMentorQuestion();

        return $this->sendResponse([
            'data'          => MentorQuestionResource::collection($mentorQuestions),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\MentorQuestionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MentorQuestionRequest $request)
    {
        $data = $request->validated();

        $mentorQuestion = $this->mentorQuestionRepository->create($data);

        if ($mentorQuestion) {
            return $this->sendResponse(['messages' => __('messages.success.create')]);
        }

        return $this->sendResponse(['messages' => __('messages.error.create')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $mentorQuestion = $this->mentorQuestionRepository->find($id);

        return $this->sendResponse([
            'data'      => new MentorQuestionResource($mentorQuestion)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\MentorQuestionRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MentorQuestionRequest $request, $id)
    {
        try {
            $this->mentorQuestionRepository->update($id, $request->all());

            return $this->sendResponse(['messages' => __('messages.success.update')]);
        } catch (\Throwable $th) {
            return $this->sendResponse(['messages' => __('messages.error.update')]);
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
            $this->mentorQuestionRepository->delete($id);

            return $this->sendResponse(['messages' => __('messages.success.delete')]);
        } catch (\Throwable $th) {
            return $this->sendResponse(['messages' => __('messages.error.delete')]);
        }
    }
}
