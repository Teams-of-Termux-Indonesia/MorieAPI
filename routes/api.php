<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RyuController;
Route::controller(RyuController::class)->prefix('senpai')->group(function(){
    Route::get('/',function(){
        echo "
        <pre>
        MORIE API 
        prefix : /senpai
        </pre>
        ";
    });
    Route::get('anime/spring','index');
    Route::get('anime/news','news');
});