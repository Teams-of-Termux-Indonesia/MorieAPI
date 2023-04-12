<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Fdev\AnimeApiController;
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

Route::controller(AnimeApiController::class)->prefix("fdev")->group(function(){
  Route::get("/anime/all", "listAnime");
  Route::get("/anime/{id}", "detailAnime");
  Route::get("/anime/{anime}/episode/{id}", "detailEpisode");
});