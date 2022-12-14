<?php

namespace App\Repositories\Contracts;

use App\Repositories\Base\Contracts\BaseRepository;

interface AnswerRepository extends BaseRepository
{
    /**
     * get list my answer
     *
     * @param int $group_id
     * @return Collection
     */
    public function getMyAnswer(int $group_id);

    /**
     * delete my answer in group
     *
     * @param int $group_id
     * @return Collection
     */
    public function deleteMyAnswer(int $group_id);
}
