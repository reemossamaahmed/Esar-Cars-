<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\GoogleAuthController;
use App\Http\Controllers\Api\CarController;
use App\Http\Controllers\Api\CarDocumentController;


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
                Route::post('/set-password', 'setPassword');
            });
        });

        Route::post('/google', [GoogleAuthController::class, 'login']);
    });

    Route::middleware(['auth:sanctum', 'role:owner'])->prefix('owner')->group(function () {

        Route::post('/cars',[CarController::class, 'store']);

        Route::patch('/cars/{car}/documents',[CarDocumentController::class, 'update']);

    });







    // Route::middleware(['auth:sanctum','role:owner'])->prefix('car')->controller(CarController::class)->group(function(){

        // Route::post('/','store');

    //     Route::patch('/{car}/location', 'location');

    //     Route::patch('/{car}/documents', 'documents');

    //     Route::patch('/{car}/pricing','pricing');

    //     Route::patch('/{car}/images','images');

    //     Route::post('/{car}/publish','publish');

    // });








});








