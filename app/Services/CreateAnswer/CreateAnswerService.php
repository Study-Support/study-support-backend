<?php

namespace App\Services\CreateAnswer;

use App\Http\Controllers\Api\BaseController;
use App\Repositories\Contracts\AnswerRepository;
use App\Services\CreateAnswer\CreateAnswerServiceInterface;
use Illuminate\Support\Facades\Log;

class CreateAnswerService extends BaseController implements CreateAnswerServiceInterface
{
    public function __construct(
        public AnswerRepository $answerRepository
    ) {
    }
    /**
     * Form action create answer
     *
     * @param $answers
     * @param $type
     * @return \Illuminate\Http\Response
     */
    public function createAnswer($answers, $type, $group_id)
    {
        try {
            foreach ($answers as $answer) {
                $this->answerRepository->create([
                    'question'  => $answer['content'],
                    'content'   => $answer['answer'],
                    'type'      => $type,
                    'group_id'  => $group_id,
                    'account_id'=> auth()->id()
                ]);
            }

        } catch (\Exception $e) {
            Log::error($e);

            return $this->sendError(__('messages.error.create'));
        }
    }
}
