<?php

namespace App\Repositories\Contracts;

use App\Repositories\Base\Contracts\BaseRepository;

interface GroupRepository extends BaseRepository
{
    /**
     * get list group in dashboard
     *
     * @param array $params
     * @return Collection
     */
    public function getListGroupInDashBoard(array $params);

    /**
     * get one group
     * @param $id
     */
    public function getGroup($id);

    /**
     * get all group
     *
     * @param array $params
     * @return Collection
     */
    public function getAllGroup(array $params);

    /**
     * get my list group
     *
     * @param array $params
     * @return Collection
     */
    public function getMyListGroup(array $params);
}
