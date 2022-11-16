<?php

namespace App\Repositories\Contracts;

use App\Repositories\Base\Contracts\BaseRepository;

interface GroupRepository extends BaseRepository
{
    /**
   * get list group in dashboard
   * @return array
   */
  public function getListGroupInDashBoard(array $params);

  /**
   * get one group
   * @param $id
   */
  public function getGroup($id);

  /**
   * get all group
   * @return array
   */
  public function getAllGroup(array $params);
}
