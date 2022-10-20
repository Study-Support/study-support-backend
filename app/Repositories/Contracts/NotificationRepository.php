<?php

namespace App\Repositories\Contracts;

use App\Repositories\Base\Contracts\BaseRepository;

interface NotificationRepository extends BaseRepository
{
    /**
   * get list notification
   * @return array
   */
  public function getListNotification(array $params);
}
