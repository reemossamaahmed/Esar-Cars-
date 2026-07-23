<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;



Route::prefix('v1')->group(function(){



    Route::prefix('auth')->controller(AuthController::class)->group(function(){

        Route::post('/register','register');
        Route::post('/verify-email', 'verifyEmail');
        Route::post('/login','login');
        Route::post('/forgot-password','forgotPassword');
        Route::post('/reset-password', 'resetPassword');

        route::middleware('auth:sanctum')->group(function(){
            Route::post('/logout','logout');
            Route::get('/profile','showProfile');
            Route::put('/profile', 'updateProfile');
            Route::put('/change-password','changePassword');
        });

    });










});








