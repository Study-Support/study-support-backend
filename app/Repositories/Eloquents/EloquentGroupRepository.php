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
      ->when(isset($params['status']) &&  $params['status'] != config('common.filter.all'), function ($q) use ($params) {
        $q->where('status', $params['status']);
      })
      ->when(isset($params['subject']), function ($q) use ($params) {
        $q->whereHas('subject', function ($q1) use ($params) {
          return $q1->where('name', 'LIKE', '%' . $params['subject'] . '%');
        });
      })
      ->withCount(['members', 'mentor'])
      ->orderBy('id', 'asc')
      ->paginate($this->MAX_PER_PAGE);
  }

  /**
   * get one group
   * @param $id
   *
   * @return \App\Models\Group
   */
  public function getGroup($id)
  {
    return $this->_model
      ->with('membersAccepted', 'mentorAccepted')
      ->Where('id', $id)->first();
  }
}
