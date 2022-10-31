<?php

namespace App\Repositories\Contracts;

use App\Repositories\Base\Contracts\BaseRepository;

interface MentorInfoRepository extends BaseRepository
{
  /**
   * get one mentor
   * @param $id
   */
  public function getMentor($id);

  /**
   * get list mentor
   * @return array
   */
  public function getListMentor(array $params);
}
