<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FormController;
use Illuminate\Support\Facades\Route;


Route::prefix('v1/')->group(function () {
    Route::post('auth/login', [AuthController::class, 'login'])->name('login');
    Route::post('auth/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
});
