<?php

use App\Http\Controllers\ApiKeyController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LevelController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('api_key')->group(function () {
    Route::post('/create/key', [ApiKeyController::class, 'makeApiKey']);

    // API FOR LEVELS
    Route::prefix('/level')->group(function () {
        Route::post('/create', [LevelController::class, 'createStatusLevel']);
        Route::put('/update/{kode}', [LevelController::class, 'updateStatusLevel']);
        Route::delete('/delete/{kode}', [LevelController::class, 'deleteStatusLevel']);
        
        Route::prefix('/get')->group(function () {
            Route::get('/', [LevelController::class, 'getAllStatusLevel']);
            Route::get('/{kode}', [LevelController::class, 'getStatusLevel']);
        });
    });

    // API FOR USERS
    Route::prefix('/user')->group(function () {
        Route::post('/create', [AuthController::class, 'createUser']);
        Route::put('/update/{kode}', [AuthController::class, 'updateUser']);
        Route::delete('/delete/{kode}', [AuthController::class, 'deleteUser']);
    });
});