<?php

use App\Http\Controllers\CategoriasController;
use App\Http\Controllers\ActividadController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::middleware('api')->group(function () {
    // Auth routes
    Route::prefix('auth')->group(function () {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('register', [AuthController::class, 'register']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('me', [AuthController::class, 'me']);
    });

    // Categorías routes
    Route::prefix('categoria')->group(function () {
        Route::post('/', [CategoriasController::class, 'index']);
        Route::post('/crear', [CategoriasController::class, 'store']);
        Route::post('/actualizar', [CategoriasController::class, 'update']);
    });

    // Actividad routes
    Route::prefix('actividad')->group(function () {
        Route::post('/', [ActividadController::class, 'index']);
        Route::post('/crear', [ActividadController::class, 'store']);
        Route::post('/actualizar', [ActividadController::class, 'update']);
    });
});
