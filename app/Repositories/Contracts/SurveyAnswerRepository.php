<?php

namespace App\Repositories\Contracts;

use App\Repositories\Base\Contracts\BaseRepository;

interface SurveyAnswerRepository extends BaseRepository
{

    /**
   * delete my answers in group
   * @return array
   */
  public function deleteMyAnswer(int $id);
}
