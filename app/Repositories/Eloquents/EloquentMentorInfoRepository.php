<?php

namespace App\Repositories\Eloquents;

use App\Enums\UserRole;
use App\Repositories\Base\Eloquents\EloquentBaseRepository;
use App\Repositories\Contracts\MentorInfoRepository;
use App\Repositories\Contracts\UserInfoRepository;

/**
 * Class EloquentMentorInfoRepository
 * @package App\Repositories\Eloquents
 */
class EloquentMentorInfoRepository  extends EloquentBaseRepository implements MentorInfoRepository
{
  /**
   * get model
   * @return string
   */
  public function getModel()
  {
    return \App\Models\MentorInfo::class;
  }

  /**
   * get one mentor
   * @param $id
   *
   * @return \App\Models\MentorInfo
   */
  public function getMentor($id)
  {
    return $this->_model
      ->with('account','subjects')
      ->firstWhere('account_id', $id);
  }
}
