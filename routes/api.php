<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;



// Authentication Routes
Route::Post("login",[AuthController::class,'login']);
Route::Post("register",[AuthController::class,'store']);


// Protected routes
Route::middleware(['jwtAuthCheck'])->group(function () {
    Route::Post("logout",[AuthController::class,'logout']);
});
