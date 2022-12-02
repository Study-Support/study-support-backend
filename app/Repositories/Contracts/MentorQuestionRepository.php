<?php

namespace App\Repositories\Contracts;

use App\Repositories\Base\Contracts\BaseRepository;

interface MentorQuestionRepository extends BaseRepository
{
    /**
     * get list Mentor Question
     *
     * @return Collection
     */
    public function getListMentorQuestion();

}
