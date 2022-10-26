<?php

namespace App\Repositories\Eloquents;

use App\Enums\UserRole;
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

  /**
   * Get list user
   *
   * @return \App\Models\User
   */
  public function getListUser(array $params)
  {
    return $this->_model
      ->whereHas('account.roles', function ($q) {
        return $q->where('id', UserRole::USER);
      })
      ->withCount('account')
      ->with(['account' => function ($q) {
        return $q->with('accountInGroup')->withCount('accountInGroup');
      }])
      ->orderBy('id', 'asc')
      ->paginate($this->MAX_PER_PAGE);
  }

  /**
   * get one user
   * @param $id
   *
   * @return \App\Models\UserInfo
   */
  public function getUser($id)
  {
    return $this->_model
      ->with(['account' => function ($q) {
        return $q->withCount('accountInGroup');
      }])
      ->firstWhere('account_id', $id);
  }
}
