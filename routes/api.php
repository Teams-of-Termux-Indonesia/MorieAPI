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
            Route::get('/videos', 'facebook_videos');
        });

        Route::prefix('tiktok')->group(function () {
            Route::get('/videos', 'tiktok_videos');
            Route::get('/audios', 'tiktok_audios');
        });

        Route::prefix('youtube')->group(function () {
            Route::get('/videos', 'youtube_videos');
            Route::get('/channels', 'youtube_channels');
        });
    });
});
