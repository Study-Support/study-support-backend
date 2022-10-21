<?php

namespace App\Repositories\Contracts;

use App\Repositories\Base\Contracts\BaseRepository;

interface QuestionRepository extends BaseRepository
{
    /**
   * get list question
   * @return array
   */
  public function getListQuestion(array $params);
}
