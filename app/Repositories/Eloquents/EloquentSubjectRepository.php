<?php

namespace App\Repositories\Eloquents;

use App\Repositories\Base\Eloquents\EloquentBaseRepository;
use App\Models\Subject;
use App\Repositories\Contracts\SubjectRepository;

/**
 * Class EloquentSubjectRepository
 * @package App\Repositories\Eloquents
 */
class EloquentSubjectRepository extends EloquentBaseRepository implements SubjectRepository
{
    public function getModel()
    {
        return Subject::class;
    }

    /**
     * Get list subject
     *
     * @return \App\Models\Subject
     */
    public function getListSubject(array $params)
    {
        return $this->_model
            ->with('faculties')
            ->when(isset($params['faculty_id']), function ($q1) use ($params) {
                $q1->whereHas('faculties', function ($q2) use ($params) {
                    $q2->where('faculty_id', $params['faculty_id']);
                });
            })
            ->orderBy('id', 'asc')
            ->get();
    }
}
