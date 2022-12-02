<?php

namespace App\Services\CreateAnswer;

interface CreateAnswerServiceInterface
{
    /**
     * Form action create answer
     *
     * @param $answers
     * @param $type
     * @return \Illuminate\Http\Response
     */
    public function createAnswer($answers, $type, $group_id);
}
