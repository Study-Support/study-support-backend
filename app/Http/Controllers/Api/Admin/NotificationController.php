<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\NotificationRequest;
use App\Http\Resources\NotificationResource;
use App\Repositories\Contracts\NotificationRepository;
use App\Services\UtilService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
      'data' => NotificationResource::collection($notifications),
      'pagination'  => UtilService::paginate($notifications)
    ]);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\NotificationRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function store(NotificationRequest $request)
  {
    $data = $request->validated();

    $notification = $this->notificationRepository->create($data);

    if ($notification) {
      return $this->sendResponse(['messages' => __('messages.success.create')]);
    }

    return $this->sendResponse(['messages' => __('messages.error.create')]);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $notification = $this->notificationRepository->findOrFail($id);

    if ($notification) {
      return $this->sendResponse(new NotificationResource($notification));
    }

    return $this->sendError(__('messages.error.notification'));
  }


  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\NotificationRequest  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(NotificationRequest $request, $id)
  {
    try {
      $this->notificationRepository->update($id, $request->validated());

      return $this->sendResponse([
        'message' => __('messages.success.update')
      ]);
    } catch (\Exception $e) {
      Log::error($e);
      return $this->sendError(__('messages.error.update'));
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    try {
      $this->notificationRepository->delete($id);

      return $this->sendResponse([
        'message' => __('messages.success.delete')
      ]);
    } catch (\Exception $e) {
      Log::error($e);
      return $this->sendError(__('messages.error.delete'));
    }
  }
}
