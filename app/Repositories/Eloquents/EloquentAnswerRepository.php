<?php

namespace App\Repositories\Eloquents;

use App\Models\Answer;
use App\Repositories\Base\Eloquents\EloquentBaseRepository;
use App\Repositories\Contracts\AnswerRepository;

/**
 * Class EloquentAnswerRepository
 * @package App\Repositories\Eloquents
 */
class EloquentAnswerRepository extends EloquentBaseRepository implements AnswerRepository
{
    public function getModel()
    {
        return Answer::class;
    }

    /**
     * Get list answer
     *
     * @param int $group_id
     * @return Collection
     */
    public function getMyAnswer(int $group_id)
    {
        return $this->_model
            ->where('account_id', auth()->id())
            ->where('group_id', $group_id)
            ->orderBy('id', 'asc')
            ->get();
    }

    /**
     * Get list answer
     *
     * @param int $group_id
     * @return Collection
     */
    public function deleteMyAnswer(int $group_id)
    {
        return $this->_model
            ->where('account_id', auth()->id())
            ->where('group_id', $group_id)
            ->delete();
    }
}
