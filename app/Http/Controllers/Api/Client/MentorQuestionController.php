<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\MentorQuestionResource;
use App\Repositories\Contracts\MentorQuestionRepository;

class MentorQuestionController extends BaseController
{
    public function __construct(
        private MentorQuestionRepository $mentorQuestionRepository,
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
}
