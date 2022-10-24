<?php

namespace App\Repositories\Eloquents;

use App\Repositories\Base\Eloquents\EloquentBaseRepository;
use App\Models\Group;
use App\Repositories\Contracts\GroupRepository;

/**
 * Class EloquentGroupRepository
 * @package App\Repositories\Eloquents
 */
class EloquentGroupRepository extends EloquentBaseRepository implements GroupRepository
{
  public function getModel()
  {
    return Group::class;
  }

  /**
   * Get list group
   *
   * @return \App\Models\Group
   */
  public function getListGroup(array $params)
  {
    return $this->_model
      ->with('members')
      ->when(isset($params['status']) &&  $params['status'] != 'all', function ($q) use ($params) {
        $q->where('status', $params['status']);
      })
      ->when(isset($params['subject']), function ($q1) use ($params) {
        $q1->whereHas('subject', function ($q2) use ($params) {
          return $q2->where('name', 'LIKE', '%' . $params['subject'] . '%');
        });
      })
      ->orderBy('id', 'asc')
      ->get();
  }
}
