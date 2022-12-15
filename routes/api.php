<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\PartyController;
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
    Route::get('/games', [GameController::class, 'getAllGames']);
});

// PARTIES
Route::group([
    'middleware' => 'jwt.auth'
], function () {
    Route::post('/createparty', [PartyController::class, 'createParty']);
    Route::get('/parties/{id}', [PartyController::class, 'getPartiesByGameId']);
    Route::post('/joinparty/{id}', [PartyController::class, 'joinParty']);
    Route::post('/leaveparty/{id}', [PartyController::class, 'leaveParty']);
});
