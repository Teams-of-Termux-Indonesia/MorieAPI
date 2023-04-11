<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ScrapAnime;

class RyuController extends Controller
{
    public function index(){
       $scrap = new ScrapAnime();
       dd($scrap->getSpring());
    }
}
