<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// AUTHENTICATION
Route::post('/register', [AuthController::class, 'register']);
