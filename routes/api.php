<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TranslationController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware(['token.auth']);
Route::middleware(['token.auth'])->group(function () {
    Route::get('/translations', [TranslationController::class, 'index']);
    Route::post('/translations', [TranslationController::class, 'store']);
    Route::get('/translations/{id}', [TranslationController::class, 'show']);
    Route::put('/translations/{id}', [TranslationController::class, 'update']);
    Route::get('/export/{locale}', [TranslationController::class, 'export']);
});
