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
     * @param array $params
     * @return Collection
     */
    public function getListGroupInDashBoard(array $params)
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
     * @return Collection
     */
    public function getGroup($id)
    {
        return $this->_model
            ->with('membersAccepted', 'mentorAccepted', 'mentorWaiting', 'creator', 'members', 'memberAnswers', 'mentorAnswers', 'membersWaiting', 'ratings')
            ->withCount('membersAccepted', 'membersWaiting')
            ->Where('id', $id)
            ->first();
    }

    /**
     * Get all group
     *
     * @param array $params)
     * @return Collection
     */
    public function getAllGroup(array $params)
    {
        return $this->_model
            ->withCount(['membersAccepted'])
            ->when(isset($params['status']), function ($q) use ($params) {
                $q->where('status', $params['status']);
            })
            ->when(isset($params['subject']), function ($q) use ($params) {
                $q->whereHas('subject', function ($q1) use ($params) {
                    return $q1->where('name', 'LIKE', '%' . $params['subject'] . '%');
                });
            })
            ->when(isset($params['faculty']), function ($q) use ($params) {
                $q->where('faculty_id', $params['faculty']);
            })
            ->orderBy('id', 'asc')
            ->paginate(9);
    }

    /**
     * Get my list group
     *
     * @param array $params
     * @return Collection
     */
    public function getMyListGroup(array $params)
    {
        return $this->_model
            ->with('accounts')
            ->withCount(['membersAccepted'])
            ->whereHas('accounts', function ($q1) use ($params) {
                $q1->where('account_id', auth()->id())
                    ->when(isset($params['is_mentor']), function ($q2) use ($params) {
                        $q2->where('is_mentor', $params['is_mentor']);
                    })
                    ->when(isset($params['accepted']), function ($q2) use ($params) {
                        $q2->where('status', $params['accepted']);
                    })
                    ->when(isset($params['is_creator']), function ($q2) use ($params) {
                        $q2->where('is_creator', $params['is_creator']);
                    });
            })
            ->when(isset($params['status']), function ($q) use ($params) {
                $q->where('status', $params['status']);
            })
            ->when(!isset($params['status']), function ($q) {
                $q->where('status', '!=', config('group.status.waiting'));
            })
            ->orderBy('id', 'asc')
            ->paginate($this->GROUP_PAGE);
    }
}
