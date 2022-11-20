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
}
