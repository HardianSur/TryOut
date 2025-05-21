<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\QuizzController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->middleware('redirectIfAuth')->prefix('auth')->group(function(){
    Route::get('/login', 'login');
    Route::get('/register', 'register');
    Route::get('/logout', 'logout')->withoutMiddleware('redirectIfAuth')->middleware('checkToken');
    Route::get('/sr', 'setToken');
});

    Route::middleware('checkToken')->group(function(){
        Route::get('/', [DashboardController::class, 'index']);
        Route::get('/tryout', [QuizzController::class, 'index']);
        Route::post('/tryout/result', [QuizzController::class, 'calculateScore']);
    });
