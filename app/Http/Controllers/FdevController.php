<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\Fdev\AnimeApi;

class FdevController extends Controller
{
    
    public function anime_all (Request $request) 
    {
      $AnimeApi = new AnimeApi();
      return $AnimeApi->anime_all();
    }
    
    public function anime_detail (Request $request) 
    {
      $AnimeApi = new AnimeApi();
      return $AnimeApi->anime_detail($request);
    }
}
