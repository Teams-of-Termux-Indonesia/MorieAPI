<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\RyuController;
use App\Http\Controllers\API\AnimeApiController;
use App\Http\Controllers\RAPController;

Route::controller(RyuController::class)->prefix('senpai')->group(function(){
    Route::get('/',function(){
        echo "
        <pre>
        MORIE API 
        prefix : /senpai
        </pre>
        ";
    });
    Route::get('anime/news','news');
});
Route::controller(RAPController::class)->group(function () {
    Route::prefix('rap')->group(function () {
        Route::get('/ip', 'ip');
        Route::get('/gmail/send', 'gmail_send');

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


Route::controller(AnimeApiController::class)->prefix("fdev")->group(function(){

  Route::get("/anime/all", "listAnime");

  Route::get("/anime/{id}", "detailAnime");

  Route::get("/anime/{anime}/episode/{id}", "detailEpisode");

});

