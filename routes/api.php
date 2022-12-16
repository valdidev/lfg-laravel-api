<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\PartyController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserProfileController;
use Illuminate\Support\Facades\Route;

// AUTHENTICATION
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('jwt.auth');
// change account visibility as delete function to common users
Route::put('/deleteaccount', [AuthController::class, 'disableAccount'])->middleware('jwt.auth');

// USER PROFILES
Route::group([
    'middleware' => 'jwt.auth'
], function () {
    Route::post('/moreinfo', [UserProfileController::class, 'fillMoreUserInfo']);
    Route::get('/profile', [UserProfileController::class, 'getFullProfile']);
    Route::put('/moreinfo', [UserProfileController::class, 'updateMoreUserInfo']);
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

// POSTS
Route::group([
    'middleware' => 'jwt.auth'
], function () {
    Route::post('/sendpost', [PostController::class, 'sendPost']);
    Route::put('/removepost/{id}', [PostController::class, 'changePostVisibility']);
    Route::get('/allposts/{id}', [PostController::class, 'getAllPartyPosts']);
    Route::put('/editpost', [PostController::class, 'editPost']);
});

// ONLY ADMIN
Route::group([
    'middleware' => ['jwt.auth', 'isAdmin']
], function () {
    Route::post('/creategame', [GameController::class, 'createGame']);
    Route::get('/games', [GameController::class, 'getAllGames']);
});
