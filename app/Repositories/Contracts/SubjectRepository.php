<?php

namespace App\Repositories\Contracts;

use App\Repositories\Base\Contracts\BaseRepository;

interface SubjectRepository extends BaseRepository
{
    /**
   * get list subject
   *
   * @param array $params
   * @return Collection
   */
  public function getListSubject(array $params);
}
