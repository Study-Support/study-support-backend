<?php

use App\Http\Controllers\Api\Client\Auth\LoginController;
use App\Http\Controllers\Api\Client\Auth\RegisterController;
use App\Http\Controllers\Api\Client\FacultyController;
use App\Http\Controllers\Api\Client\GroupController;
use App\Http\Controllers\Api\Client\NotificationController;
use App\Http\Controllers\Api\Client\UserInfoController;
use Illuminate\Support\Facades\Route;

Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout']);
Route::post('register', [RegisterController::class, 'register']);

Route::get('notification', [NotificationController::class, 'index']);
Route::get('faculties', [FacultyController::class, 'index']);

Route::group(['middleware' => ['auth:api', 'auth.client']], function () {
    Route::resource('user', UserInfoController::class)->only(['index']);
    Route::put('user/edit', [UserInfoController::class, 'update']);
    Route::put('user/password', [UserInfoController::class, 'updatePassword']);
    Route::put('mentor/edit', [UserInfoController::class, 'updateMentor']);

    Route::resource('groups', GroupController::class)->only(['index']);
});
