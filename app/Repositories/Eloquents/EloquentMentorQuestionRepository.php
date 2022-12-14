<?php

namespace App\Repositories\Eloquents;

use App\Models\MentorQuestion;
use App\Repositories\Base\Eloquents\EloquentBaseRepository;
use App\Repositories\Contracts\MentorQuestionRepository;

/**
 * Class EloquentMentorQuestionRepository
 * @package App\Repositories\Eloquents
 */
class EloquentMentorQuestionRepository extends EloquentBaseRepository implements MentorQuestionRepository
{
    public function getModel()
    {
        return MentorQuestion::class;
    }

     /**
     * get list Mentor Question
     *
     * @return Collection
     */
    public function getListMentorQuestion()
    {
        return $this->_model
            ->orderBy('id', 'asc')
            ->get();
    }
}
