<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login/google', function () {
    return Socialite::driver('google')->redirect();
});
Route::get('/login/google/callback', [AuthController::class, 'loginWithGoogle']);