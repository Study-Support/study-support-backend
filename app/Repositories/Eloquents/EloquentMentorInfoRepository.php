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
            ->with('account.userInfo', 'subjectsAccepted')
            ->when(isset($params['full_name']), function ($q1) use ($params) {
                $q1->whereHas('account.userInfo', function ($q2) use ($params) {
                    $q2->where('full_name', 'LIKE', '%' . $params['full_name'] . '%');
                });
            })
            ->when(isset($params['faculty_id']), function ($q1) use ($params) {
                $q1->whereHas('account.userInfo', function ($q2) use ($params) {
                    $q2->where('faculty_id', $params['faculty_id']);
                });
            })
            ->when(isset($params['subject_id']), function ($q1) use ($params) {
                $q1->whereHas('subjectsAccepted', function ($q2) use ($params) {
                    $q2->where('subject_id', $params['subject_id']);
                });
            })
            ->withCount('subjects')
            ->orderBy('id', 'asc')
            ->paginate($this->MAX_PER_PAGE);
    }
}
