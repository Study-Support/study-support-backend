<?php

namespace App\Repositories\Contracts;

use App\Repositories\Base\Contracts\BaseRepository;

interface MentorInfoRepository extends BaseRepository
{
  /**
   * get one mentor
   * @param int $id
   */
  public function getMentor(int $id);

  /**
   * get list mentor
   *
   * @param arary $params
   * @return Collection
   */
  public function getListMentor(array $params);
}
