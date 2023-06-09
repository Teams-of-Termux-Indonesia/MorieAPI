<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\RyuController;
use App\Http\Controllers\FdevController;
use App\Http\Controllers\RAPController;

Route::controller(RyuController::class)
    ->prefix("senpai")
    ->group(function () {
        Route::get("/", function () {
            echo "
              <pre>
              MORIE API 
              prefix : /senpai
              </pre>";
        })->name("senpai.home");
        Route::get("anime/news", "news");

        Route::get("gempa/terkini", "gempaTerkini");
        Route::get("textpro/{text}", "textpro");
    });

Route::controller(RAPController::class)->group(function () {
    Route::prefix("rap")->group(function () {
        Route::get("/ip", "ip");
        Route::get("/gmail/send", "gmail_send");

        Route::prefix("facebook")->group(function () {
            Route::get("/video", "facebook_video");
        });

        Route::prefix("tiktok")->group(function () {
            Route::get("/video", "tiktok_video");
            Route::get("/audio", "tiktok_audio");
        });

        Route::prefix("youtube")->group(function () {
            Route::get("/video", "youtube_video");
            Route::get("/channel", "youtube_channel");
        });

        Route::prefix("instagram")->group(function () {
            Route::get("/profile", "instagram_profile");
            // Route::get('/video', 'instagram_video');
            // Route::get('/reel', 'instagram_reel');
            // Route::get('/image', 'instagram_image');
        });
    });
});

Route::controller(FdevController::class)->group(function () {
    Route::prefix("fdev")->group(function () {
        Route::prefix("/anime")->group(function () {
            Route::get("/all", "anime_all");
            Route::get("/{uid}", "anime_detail");
            Route::get("/episode/{episode}", "anime_episode");
        });
        Route::prefix("/crypto")->group(function () {
            Route::get("/all", "crypto_all");
        });
    });
});


Route::fallback(function (){
  return response()->json([
    "code" => 404,
    "status" => false,
    "message" => "invalid route",
    "suggestion" => "please see our documentation or repository, for look available routes",
    "links" => [
      "repository" => env("GITHUB_REPO", "#"),
      "documentation" => env("DOCS_URL", "#")
    ]
  ]);
});