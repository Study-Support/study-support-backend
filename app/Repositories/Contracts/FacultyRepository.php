<?php

namespace App\Repositories\Contracts;

use App\Repositories\Base\Contracts\BaseRepository;

interface FacultyRepository extends BaseRepository
{
    /**
   * get list faculty
   * @return array
   */
  public function getListFaculty(array $params);
}
