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
      ->whereIn('status', ['1', '2'])
      ->when(isset($params['type']) && $params['type'] == '0', function ($q) {
        $q->where('self_study', '1');
      })
      ->when(isset($params['type']) && ($params['type'] == '1' || $params['type'] == '2'), function ($q) use ($params) {
        $q->where('status', $params['type']);
      })
      ->when(isset($params['subject']), function ($q) use ($params) {
        $q->whereHas('subject', function ($q1) use ($params) {
          return $q1->where('name', 'LIKE', '%' . $params['subject'] . '%');
        });
      })
      ->when(isset($params['faculty']), function ($q) use ($params) {
        $q->where('faculty_id', $params['faculty']);
      })
      ->withCount(['membersAccepted'])
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
