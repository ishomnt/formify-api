<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\QuestionController;
use Illuminate\Support\Facades\Route;


Route::prefix('v1/')->group(function () {
    Route::post('auth/login', [AuthController::class, 'login'])->name('login');
    Route::post('auth/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

    Route::middleware('auth:sanctum')->prefix('forms')->group(function () {
        Route::post('/', [FormController::class, 'store'])->name('forms.store');
        Route::get('/', [FormController::class, 'index'])->name('forms.index');
        Route::get('/{slug}', [FormController::class, 'show'])->name('forms.show');
        Route::post('/{slug}/questions', [QuestionController::class, 'store'])->name('questions.store');
        Route::delete('/{slug}/questions/{question}', [QuestionController::class, 'destroy'])->name('questions.destroy');
    });
});
