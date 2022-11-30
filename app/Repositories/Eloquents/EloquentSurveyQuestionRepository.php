<?php

namespace App\Repositories\Eloquents;

use App\Repositories\Base\Eloquents\EloquentBaseRepository;
use App\Models\SurveyQuestion;
use App\Repositories\Contracts\SurveyQuestionRepository;

/**
 * Class EloquentSurveyQuestionRepository
 * @package App\Repositories\Eloquents
 */
class EloquentSurveyQuestionRepository extends EloquentBaseRepository implements SurveyQuestionRepository
{
    public function getModel()
    {
        return SurveyQuestion::class;
    }
}
