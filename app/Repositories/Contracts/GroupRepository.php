<?php

namespace App\Repositories\Contracts;

use App\Repositories\Base\Contracts\BaseRepository;

interface GroupRepository extends BaseRepository
{
    /**
   * get list group
   * @return array
   */
  public function getListGroup(array $params);
}
