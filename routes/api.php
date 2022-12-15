<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GameController;
use Illuminate\Support\Facades\Route;

// AUTHENTICATION
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('jwt.auth');

// ONLY ADMIN
Route::group([
    'middleware' => ['jwt.auth', 'isAdmin']
], function () {
    Route::post('/creategame', [GameController::class, 'createGame']);
});