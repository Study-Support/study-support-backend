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
     * @param array $params
     * @return Collection
     */
    public function getListNotification(array $params)
    {
        return $this->_model
            ->when(isset($params['content']), function ($q) use ($params) {
                $q->where('content', 'LIKE', '%' . $params['content'] . '%');
            })
            ->when(isset($params['title']), function ($q) use ($params) {
                $q->where('title', 'LIKE', '%' . $params['title'] . '%');
            })
            ->orderBy('id', 'asc')
            ->paginate($this->MAX_PER_PAGE);
    }
}
