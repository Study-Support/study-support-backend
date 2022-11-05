<?php

use App\Http\Controllers\Api\Client\Auth\LoginController;
use App\Http\Controllers\Api\Client\Auth\RegisterController;
use App\Http\Controllers\Api\Client\FacultyController;
use App\Http\Controllers\Api\Client\GroupController;
use App\Http\Controllers\Api\Client\MentorInfoController;
use App\Http\Controllers\Api\Client\NotificationController;
use App\Http\Controllers\Api\Client\RatingController;
use App\Http\Controllers\Api\Client\UserInfoController;
use Illuminate\Support\Facades\Route;

Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout']);
Route::post('register', [RegisterController::class, 'register']);

Route::get('notification', [NotificationController::class, 'index']);
Route::get('faculties', [FacultyController::class, 'index']);

Route::get('groups', [GroupController::class, 'index']);
Route::get('mentors', [MentorInfoController::class, 'getListMentor']);

Route::group(['middleware' => ['auth:api', 'auth.client']], function () {
  Route::resource('user', UserInfoController::class)->only(['index']);
  Route::put('user/edit', [UserInfoController::class, 'update']);
  Route::put('user/password', [UserInfoController::class, 'updatePassword']);

  Route::resource('rate', RatingController::class)->only(['store']);

  Route::post('group/{id}/join', [GroupController::class, 'joinGroup']);
  Route::resource('groups', GroupController::class)->only(['store', 'show']);

  Route::put('mentor', [MentorInfoController::class, 'update']);
  Route::resource('mentor', MentorInfoController::class)->only(['store', 'index']);
});
