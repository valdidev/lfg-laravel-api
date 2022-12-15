<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// AUTHENTICATION
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('jwt.auth');