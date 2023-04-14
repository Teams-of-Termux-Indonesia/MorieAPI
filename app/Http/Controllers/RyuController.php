<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ScrapAnime;
use App\Models\bmkg\ScrapBmkg;

class RyuController extends Controller
{
    private $scrap;
    private $bmkg;
    public function __construct()
    {
        $this -> scrap = new ScrapAnime();
        $this -> bmkg = new ScrapBmkg();
    }
    public function  news(){
        return json_encode($this->scrap->getNews());     
    }
    public function gempaTerkini(){
        return json_encode($this->bmkg->getGempaTerkini());
    }
}
