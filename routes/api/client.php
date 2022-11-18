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
Route::resource('faculties', FacultyController::class)->only('index', 'show');

Route::get('groups', [GroupController::class, 'index']);
Route::get('mentors', [MentorInfoController::class, 'getListMentor']);

Route::group(['middleware' => ['auth:api', 'auth.client']], function () {
  Route::resource('user', UserInfoController::class)->only(['index', 'update']);
  Route::put('user/password', [UserInfoController::class, 'updatePassword']);
  Route::get('user/groups', [GroupController::class, 'getMyListGroup']);
  Route::put('user/groups/{id}/acceptMember', [GroupController::class, 'acceptMember']);

  Route::resource('rate', RatingController::class)->only(['store', 'index']);

  Route::post('group/{id}/join', [GroupController::class, 'joinGroup']);
  Route::resource('groups', GroupController::class)->only(['index', 'store', 'show', 'update', 'destroy']);

  Route::resource('mentor', MentorInfoController::class)->only(['store', 'update', 'index']);
});
