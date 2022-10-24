<?php

namespace App\Repositories\Eloquents;

use App\Repositories\Base\Eloquents\EloquentBaseRepository;
use App\Models\Faculty;
use App\Repositories\Contracts\FacultyRepository;

/**
 * Class EloquentFacultyRepository
 * @package App\Repositories\Eloquents
 */
class EloquentFacultyRepository extends EloquentBaseRepository implements FacultyRepository
{
    public function getModel()
    {
        return Faculty::class;
    }

    /**
   * Get list faculty
   *
   * @return \App\Models\Faculty
   */
  public function getListFaculty(array $params)
  {
    return $this->_model
      ->orderBy('id', 'asc')
      ->get();
  }

}
