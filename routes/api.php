<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\GoogleAuthController;



Route::prefix('v1')->group(function(){



    Route::prefix('auth')->group(function(){

        Route::controller(AuthController::class)->group(function(){
            Route::post('/register','register');
            Route::post('/verify-email', 'verifyEmail');
            Route::post('/resend-verification', 'resendVerification');
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

        Route::post('/google', [GoogleAuthController::class, 'login']);
    });















});








