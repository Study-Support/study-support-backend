<?php

namespace App\Repositories\Eloquents;

use App\Repositories\Base\Eloquents\EloquentBaseRepository;
use App\Repositories\Contracts\UserInfoRepository;

/**
 * Class EloquentUserInfoRepository
 * @package App\Repositories\Eloquents
 */
class EloquentUserInfoRepository extends EloquentBaseRepository implements UserInfoRepository
{
  /**
   * get model
   * @return string
   */
  public function getModel()
  {
    return \App\Models\UserInfo::class;
  }

  /**
   * get current user
   *
   * @return \App\Models\UserInfo
   */
  public function getCurrentUser()
  {
    return $this->_model
      ->where('account_id', auth()->id())
      ->first();
  }
}
