<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RyuController;
Route::controller(RyuController::class)->prefix('ryu')->group(function(){
    Route::get('anime/spring','index');
});