<?php

use App\Http\Controllers\AuthController;
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

Route::prefix('v1')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    // Route::get('/login/google', [AuthController::class, 'redirectToGoogle']);
    // Route::get('/login/google', [AuthController::class, 'loginWithGoogle']);

    // Route::middleware('auth:sanctum')->group(function () {
    //     Route::get('/users', [AuthController::class, 'index']);
    // });
});