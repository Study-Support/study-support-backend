<?php

use App\Http\Controllers\Api\Admin\Auth\LoginController;
use App\Http\Controllers\Api\Admin\FacultyController;
use App\Http\Controllers\Api\Admin\GroupController;
use App\Http\Controllers\Api\Admin\MentorInfoController;
use App\Http\Controllers\Api\Admin\MentorQuestionController;
use App\Http\Controllers\Api\Admin\NotificationController;
use App\Http\Controllers\Api\Admin\SubjectController;
use App\Http\Controllers\Api\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout']);

Route::group(['middleware' => ['auth:api', 'auth.admin']], function () {
    Route::resource('notifications', NotificationController::class)->only('index', 'show', 'store', 'update', 'destroy');
    Route::resource('faculties', FacultyController::class)->only('index', 'show');
    Route::resource('subjects', SubjectController::class)->only('index');

    Route::resource('users', UserController::class)->only('index', 'show', 'update');
    Route::resource('mentors', MentorInfoController::class)->only('index', 'show', 'update', 'destroy');

    Route::put('close-group/{id}', [GroupController::class, 'closeGroup']);
    Route::put('groups/{id}/acceptMentor', [GroupController::class, 'acceptMentor']);
    Route::resource('groups', GroupController::class)->only('index', 'update', 'show', 'destroy');

    Route::resource('mentor-questions', MentorQuestionController::class)->except('edit', 'create');
});
