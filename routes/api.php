<?php

use App\Http\Controllers\CategoriasController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('me', [AuthController::class, 'me']);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'categoria'
], function ($router) {
    Route::get('/', [CategoriasController::class, 'index']);
    Route::post('/', [CategoriasController::class, 'store']);
});
