<?php

use App\Http\Controllers\Api\Client\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout']);
