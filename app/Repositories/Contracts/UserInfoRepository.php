<?php

namespace App\Repositories\Contracts;

use App\Repositories\Base\Contracts\BaseRepository;

interface UserInfoRepository extends BaseRepository
{
    /**
   * get current user
   */
  public function getCurrentUser();

  /**
   * get list user
   * @return array
   */
  public function getListUser(array $params);

  /**
   * get one user
   * @param $id
   */
  public function getUser($id);
}
