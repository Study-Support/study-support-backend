<?php

use App\Http\Controllers\Api\Admin\AnswerController;
use App\Http\Controllers\Api\Admin\Auth\LoginController;
use App\Http\Controllers\Api\Admin\NotificationController;
use App\Http\Controllers\Api\Admin\QuestionController;
use Illuminate\Support\Facades\Route;

Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout']);

Route::group(['middleware' => ['auth:api', 'auth.admin']], function () {
  Route::resource('notifications', NotificationController::class)->only('index', 'show', 'store', 'update', 'destroy');
  Route::resource('questions', QuestionController::class)->only('index');
  Route::resource('answers', AnswerController::class)->only('index');
});
