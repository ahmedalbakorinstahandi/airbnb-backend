<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\ListingReviewController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'guest'], function () {


    Route::get('/listings', [ListingController::class, 'index']);
    Route::get('/listings/{id}', [ListingController::class, 'show']);


    Route::group(['middleware' => ['auth:sanctum']], function () {

        Route::get('/profile', [UserController::class, 'getProfile']);
        Route::put('/profile', [UserController::class, 'updateProfile']);

        Route::put('/listings/{id}/favorites', [ListingController::class, 'listingFavoritesUpdate']);


        Route::get('/bookings', [BookingController::class, 'index']);
        Route::get('/bookings/{id}', [BookingController::class, 'show']);
        Route::post('/bookings', [BookingController::class, 'create']);
        // Route::put('/bookings/{id}', [BookingController::class, 'update']);
        // Route::delete('/bookings/{id}', [BookingController::class, 'delete']);

        Route::post('/bookings/{id}/transactions', [BookingController::class, 'addTransaction']);

        Route::get('/transactions', [TransactionController::class, 'index']);
        Route::get('/transactions/{id}', [TransactionController::class, 'show']);
        // Route::post('/transactions', [TransactionController::class, 'create']);
        Route::put('/transactions/{id}', [TransactionController::class, 'update']);
        Route::delete('/transactions/{id}', [TransactionController::class, 'destroy']);

        Route::group(['prefix' => 'reviews'], function () {
            Route::get('/', [ListingReviewController::class, 'index']);
            Route::get('/{id}', [ListingReviewController::class, 'show']);
            Route::post('/', [ListingReviewController::class, 'create']);
            Route::put('/{id}', [ListingReviewController::class, 'update']);
            Route::delete('/{id}', [ListingReviewController::class, 'destroy']);
        });
    });
});
