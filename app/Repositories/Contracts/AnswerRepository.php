<?php

namespace App\Repositories\Contracts;

use App\Repositories\Base\Contracts\BaseRepository;

interface AnswerRepository extends BaseRepository
{
    /**
   * get list answer
   * @return array
   */
  public function getListAnswer(array $params);
}
