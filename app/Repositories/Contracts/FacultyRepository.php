<?php

namespace App\Repositories\Contracts;

use App\Repositories\Base\Contracts\BaseRepository;

interface FacultyRepository extends BaseRepository
{
    /**
   * get list faculty
   *
   * @param array $params
   * @return Collection
   */
  public function getListFaculty(array $params);

   /**
   * get one faculty
   * @param $id
   */
  public function getFaculty($id);
}
