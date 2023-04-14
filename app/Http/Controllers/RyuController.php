<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ScrapAnime;

class RyuController extends Controller
{
    private $scrap;
    public function __construct()
    {
        $this -> scrap = new ScrapAnime();
    }
    public function  news(){
        return json_encode($this->scrap->getNews());     
    }
}
