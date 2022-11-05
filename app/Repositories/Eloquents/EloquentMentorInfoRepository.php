<?php

namespace App\Repositories\Eloquents;

use App\Enums\UserRole;
use App\Repositories\Base\Eloquents\EloquentBaseRepository;
use App\Repositories\Contracts\MentorInfoRepository;

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
      ->with('account', 'subjects')
      ->firstWhere('account_id', $id);
  }

  /**
   * Get list mentor
   *
   * @return \App\Models\MentorInfo
   */
  public function getListMentor(array $params)
  {
    return $this->_model
      ->with('account.userInfo', 'subjects')
      ->withCount('subjects')
      ->orderBy('id', 'asc')
      ->paginate($this->MAX_PER_PAGE);
  }
}
