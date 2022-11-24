<?php

namespace App\Repositories\Eloquents;

use App\Models\SurveyAnswer;
use App\Repositories\Base\Eloquents\EloquentBaseRepository;
use App\Repositories\Contracts\SurveyAnswerRepository;

/**
 * Class EloquentSurveyAnswerRepository
 * @package App\Repositories\Eloquents
 */
class EloquentSurveyAnswerRepository extends EloquentBaseRepository implements SurveyAnswerRepository
{
    public function getModel()
    {
        return SurveyAnswer::class;
    }

    /**
     * delete my answers in group
     *
     * @return \App\Models\SurveyAnswer
     */
    public function deleteMyAnswer(int $id)
    {
        return $this->_model
            ->where('account_id', auth()->id())
            ->whereHas('surveyQuestion', function ($q1) use ($id) {
                $q1->whereHas('group', function ($q2) use ($id) {
                    $q2->where('id', $id);
                });
            })
            ->delete();
    }

    /**
     * get my answers in group
     *
     * @return \App\Models\SurveyAnswer
     */
    public function getMyAnswer(int $id)
    {
        return $this->_model
            ->where('account_id', auth()->id())
            ->whereHas('surveyQuestion', function ($q1) use ($id) {
                $q1->whereHas('group', function ($q2) use ($id) {
                    $q2->where('id', $id);
                });
            })
            ->orderBy('id', 'asc')
            ->get();
    }
}
