<?php

namespace App\Repositories\Contracts;

use App\Repositories\Base\Contracts\BaseRepository;

interface NotificationRepository extends BaseRepository
{
    /**
   * get list notification
   *
   * @param array $params
   * @return Collection
   */
  public function getListNotification(array $params);
}
