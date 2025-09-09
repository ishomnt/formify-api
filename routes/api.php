<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ResponseController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->prefix('v1/')->group(function () {
    Route::prefix('auth/')->group(function () {
        Route::post('login', [AuthController::class, 'login'])->withoutMiddleware('auth:sanctum');
        Route::post('logout', [AuthController::class, 'logout']);
    });

    Route::prefix('forms')->group(function () {
        Route::post('/', [FormController::class, 'store'])->name('forms.store');
        Route::get('/', [FormController::class, 'index'])->name('forms.index');
        Route::get('/{slug}', [FormController::class, 'show'])->name('forms.show')->middleware('allowedDomain');
    });

    Route::middleware('allowedDomain')->prefix('forms')->group(function () {
        Route::post('/{slug}/questions', [QuestionController::class, 'store'])->name('questions.store');
        Route::delete('/{slug}/questions/{question}', [QuestionController::class, 'destroy'])->name('questions.destroy');
    });

    Route::middleware('allowedDomain')->prefix('forms')->group(function () {
        Route::get('/{slug}/responses', [ResponseController::class, 'index'])->name('responses.index');
        Route::post('/{slug}/responses', [ResponseController::class, 'store'])->name('responses.store');
    });
});
