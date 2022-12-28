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
     */
    public function deleteMyAnswer(int $group_id)
    {
        return $this->_model
            ->where('account_id', auth()->id())
            ->where('group_id', $group_id)
            ->delete();
    }

    /**
     * delete many answer in group
     *
     * @param int $group_id
     * @param array $account_id
     *
     */
    public function deleteAnswers(int $group_id, array $account_id)
    {
        return $this->_model
            ->whereIn('account_id', $account_id)
            ->where('group_id', $group_id)
            ->delete();
    }

    /**
     * get mentor answers of group
     *
     * @param int $group_id
     *
     */
    public function getMentorAnswersOfGroup(int $group_id)
    {
        return $this->_model
            ->where('group_id', $group_id)
            ->where('type', 1)
            ->get();
    }
}
