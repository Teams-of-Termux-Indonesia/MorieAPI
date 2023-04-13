<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AnimeApiController;
use App\Http\Controllers\RAPController;
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

Route::controller(RAPController::class)->group(function () {
    Route::prefix('rap')->group(function () {
        Route::prefix('facebook')->group(function () {
            Route::get('/video', 'facebook_video');
        });

        Route::prefix('tiktok')->group(function () {
            Route::get('/video', 'tiktok_video');
            Route::get('/audio', 'tiktok_audio');
        });

        Route::prefix('youtube')->group(function () {
            Route::get('/video', 'youtube_video');
            Route::get('/channel', 'youtube_channel');
        });

        Route::prefix('instagram')->group(function () {
            Route::get('/profile', 'instagram_profile');
            // Route::get('/video', 'instagram_video');
            // Route::get('/reel', 'instagram_reel');
            // Route::get('/image', 'instagram_image');
        });
    });
});
