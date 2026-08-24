<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\GoogleAuthController;
use App\Http\Controllers\Api\CarController;
use App\Http\Controllers\Api\CarDocumentController;
use App\Http\Controllers\Api\CarPricingController;
use App\Http\Controllers\Api\CarCustomPriceController;
use App\Http\Controllers\Api\CarCalendarController;
use App\Http\Controllers\Api\CarMediaController;
use App\Http\Controllers\Api\CarCancellationPolicyController;
use App\Http\Controllers\Api\LookupController;
use App\Http\Controllers\Api\OwnerRequestController;
use App\Http\Controllers\Api\OwnerDocumentController;
use App\Http\Controllers\Api\CarHandoverPolicyController;


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


    Route::middleware(['auth:sanctum', 'role:owner|admin'])->scopeBindings()->prefix('owner')->group(function () {

        //CREATE CAR MODULE
        Route::post('/cars',[CarController::class, 'store']);

        Route::post('/cars/{car}/documents',[CarDocumentController::class, 'save']); //This Route For Create Or Update Documents

        Route::post('/cars/{car}/pricing', [CarPricingController::class,'store']);

        Route::post('/cars/{car}/custom-price',[CarCustomPriceController::class, 'store']);

        Route::get('/cars/{car}/calendar',[CarCalendarController::class, 'index']);

        Route::post('/cars/{car}/media', [CarMediaController::class,'store']);

        Route::post('/cars/{car}/cancellation-policy',[CarCancellationPolicyController::class,'store']);

        //UPDATE CAR MODULE
        Route::patch('/cars/{car}',[CarController::class,'update']);

        Route::patch('/cars/{car}/pricing',[CarPricingController::class,'update']);

        Route::patch('/cars/{car}/custom-prices/{customPrice}',[CarCustomPriceController::class, 'update']);

        Route::patch('/cars/{car}/media',[CarMediaController::class,'update']);

        Route::delete('/cars/{car}/media/{image}', [CarMediaController::class, 'destroy']);

        Route::patch('/cars/{car}/media/reorder',[CarMediaController::class, 'reorder']);

        Route::patch('/cars/{car}/cancellation-policy',[CarCancellationPolicyController::class,'update']);

        Route::post('/cars/{car}/handover-policy',[CarHandoverPolicyController::class, 'store']);

        Route::get('/cars/{car}',[CarController::class, 'show']);

    });





    Route::middleware('auth:sanctum')->prefix('owner-requests')->group(function () {
        Route::post('/documents', [OwnerDocumentController::class,'store']);
        Route::post('/', [OwnerRequestController::class,'store']);
    });

    Route::middleware(['auth:sanctum','role:admin',])->prefix('admin/owner-requests')->group(function () {
        Route::patch('/{ownerRequest}/approve',[OwnerRequestController::class, 'approve']);
        Route::patch('/{ownerRequest}/reject',[OwnerRequestController::class, 'reject']);
    });

    // Public Cars
    Route::get('/cars', [CarController::class, 'index']);

    Route::middleware('auth:sanctum')->get('/cars/{car}/handover-policy',[CarHandoverPolicyController::class, 'show']);


    Route::prefix('lookups')->group(function () {
        Route::get('/brands', [LookupController::class, 'brands']);
        Route::get('/car-models', [LookupController::class, 'carModels']);
        Route::get('/car-types', [LookupController::class, 'carTypes']);
        Route::get('/cities', [LookupController::class, 'cities']);
        Route::get('/features', [LookupController::class, 'features']);
    });

});








