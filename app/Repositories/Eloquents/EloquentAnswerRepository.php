<?php

namespace App\Repositories\Eloquents;

use App\Models\Answer;
use App\Repositories\Base\Eloquents\EloquentBaseRepository;
use App\Repositories\Contracts\AnswerRepository;

/**
 * Class EloquentAnswerRepository
 * @package App\Repositories\Eloquents
 */
class EloquentAnswerRepository extends EloquentBaseRepository implements AnswerRepository
{
    public function getModel()
    {
        return Answer::class;
    }

    /**
   * Get list answer
   *
   * @return \App\Models\Answer
   */
  public function getListAnswer(array $params)
  {
    return $this->_model
      ->orderBy('id', 'asc')
      ->get();
  }

}
