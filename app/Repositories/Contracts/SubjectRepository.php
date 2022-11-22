<?php

namespace App\Repositories\Contracts;

use App\Repositories\Base\Contracts\BaseRepository;

interface SubjectRepository extends BaseRepository
{
    /**
   * get list subject
   * @return array
   */
  public function getListSubject(array $params);
}
