<?php

use App\Http\Controllers\Api\Client\MentorQuestionController;
use App\Http\Controllers\Api\Client\Auth\LoginController;
use App\Http\Controllers\Api\Client\Auth\RegisterController;
use App\Http\Controllers\Api\Client\FacultyController;
use App\Http\Controllers\Api\Client\GroupController;
use App\Http\Controllers\Api\Client\MailController;
use App\Http\Controllers\Api\Client\MemberController;
use App\Http\Controllers\Api\Client\MentorInfoController;
use App\Http\Controllers\Api\Client\NotificationController;
use App\Http\Controllers\Api\Client\RatingController;
use App\Http\Controllers\Api\Client\SubjectController;
use App\Http\Controllers\Api\Client\UserInfoController;
use Illuminate\Support\Facades\Route;

Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout']);
Route::post('register', [RegisterController::class, 'register']);

Route::get('notifications', [NotificationController::class, 'index']);
Route::resource('faculties', FacultyController::class)->only('index', 'show');
Route::resource('subjects', SubjectController::class)->only('index');

Route::get('groups', [GroupController::class, 'index']);
Route::get('mentors', [MentorInfoController::class, 'getListMentor']);

Route::group(['middleware' => ['auth:api', 'auth.client']], function () {
    Route::put('user/password', [UserInfoController::class, 'updatePassword']);
    Route::resource('user', UserInfoController::class)->only(['index', 'update']);
    Route::get('user/groups', [GroupController::class, 'getMyListGroup']);
    Route::put('user/groups/{id}/acceptMember', [GroupController::class, 'acceptMember']);

    Route::get('mentors/{id}', [MentorInfoController::class, 'show']);

    Route::resource('rate', RatingController::class)->only(['store', 'index']);

    Route::post('groups/{id}/join', [MemberController::class, 'store']);
    Route::put('groups/{id}/join', [MemberController::class, 'update']);
    Route::delete('groups/{id}/join', [MemberController::class, 'destroy']);
    Route::resource('groups', GroupController::class)->only(['store', 'show', 'update', 'destroy']);

    Route::put('mentor/bank', [MentorInfoController::class, 'updateBank']);
    Route::put('mentor/subjects', [MentorInfoController::class, 'updateSubject']);
    Route::resource('mentor', MentorInfoController::class)->only(['store', 'index', 'destroy']);

    Route::get('mentor-questions', [MentorQuestionController::class, 'index']);

    Route::post('invite-mentor', [MailController::class, 'sendEmail']);
});
