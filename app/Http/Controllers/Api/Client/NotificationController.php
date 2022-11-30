<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\NotificationResource;
use App\Repositories\Contracts\NotificationRepository;
use App\Services\UtilService;
use Illuminate\Http\Request;

class NotificationController extends BaseController
{

  public function __construct(
    public NotificationRepository $notificationRepository
  ) {
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    $notifications = $this->notificationRepository->getListNotification($request->all());

    return $this->sendResponse([
      'data'        => NotificationResource::collection($notifications),
      'pagination'  => UtilService::paginate($notifications)
    ]);
  }

}
