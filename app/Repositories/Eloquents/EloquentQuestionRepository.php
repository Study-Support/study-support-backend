<?php

namespace App\Repositories\Eloquents;

use App\Repositories\Base\Eloquents\EloquentBaseRepository;
use App\Models\Question;
use App\Repositories\Contracts\QuestionRepository;

/**
 * Class EloquentQuestionRepository
 * @package App\Repositories\Eloquents
 */
class EloquentQuestionRepository extends EloquentBaseRepository implements QuestionRepository
{
    public function getModel()
    {
        return Question::class;
    }

    /**
   * Get list question
   *
   * @return \App\Models\Question
   */
  public function getListQuestion(array $params)
  {
    return $this->_model
      ->orderBy('id', 'asc')
      ->get();
  }

}
