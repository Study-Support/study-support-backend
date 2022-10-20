<?php

use App\Http\Controllers\Api\Admin\Auth\LoginController;
use App\Http\Controllers\Api\Admin\NotificationController;
use Illuminate\Support\Facades\Route;

Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout']);

Route::group(['middleware' => ['auth:api', 'auth.admin']], function () {
  Route::resource('notifications', NotificationController::class)->only('index', 'show', 'store', 'update', 'destroy');
});
