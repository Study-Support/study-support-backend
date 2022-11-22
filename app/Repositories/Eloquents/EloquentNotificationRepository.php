<?php

namespace App\Repositories\Eloquents;

use App\Repositories\Base\Eloquents\EloquentBaseRepository;
use App\Models\Notification;
use App\Repositories\Contracts\NotificationRepository;

/**
 * Class EloquentAccountRepository
 * @package App\Repositories\Eloquents
 */
class EloquentNotificationRepository extends EloquentBaseRepository implements NotificationRepository
{
    public function getModel()
    {
        return Notification::class;
    }

    /**
   * Get list notification
   *
   * @return \App\Models\Notification
   */
  public function getListNotification(array $params)
  {
    return $this->_model
      ->when(isset($params['search']), function($q) use ($params) {
        $q->where('content', 'LIKE', '%' . $params['search'] . '%');
      })
      ->orderBy('id', 'asc')
      ->paginate($this->MAX_PER_PAGE);
  }

}
