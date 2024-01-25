<?php

use App\Http\Controllers\Api\v1\ConfigController;
use App\Http\Controllers\Api\v1\PartnerController;
use App\Http\Controllers\Api\v1\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'api\v1', 'prefix' => 'v1', 'middleware' => ['api_lang']], function () {

    Route::get('/info', [ConfigController::class, 'info']);


    Route::group(['prefix' => 'users'], function () {
        Route::post('/login', [UserController::class, 'login']);
        Route::post('/register', [UserController::class, 'register']);
    });


    Route::group(['prefix' => 'partner'], function () {
        Route::post('/register', [PartnerController::class, 'register']);
        Route::get('/offers', [PartnerController::class, 'offers']);
    });

    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::group(['prefix' => 'users'], function () {
            Route::get('/info', [UserController::class, 'info']);
            Route::post('/update', [UserController::class, 'update']);
            Route::post('/logout', [UserController::class, 'logout']);

            Route::group(['prefix' => 'offers'], function () {
                Route::post('/subscribe', [UserController::class, 'subscribe']);
                Route::post('/un-subscribe', [UserController::class, 'unsubscribe']);
                Route::post('/renewal', [UserController::class, 'renewal']);
                Route::get('/my-subscribes', [UserController::class, 'mysubscribes']);
            });

        });
    });
});


