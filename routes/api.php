<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;



Route::prefix('v1')->group(function(){

    Route::prefix('auth')->controller(AuthController::class)->group(function(){

        Route::post('/register','register');
        Route::post('/login','login');
        Route::post('/logout','logout');

    });









});





