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

    public function index(){
        echo "<pre>".json_encode(['data'=>$this->scrap->getSpring()])."</pre>";
    //    dd($this -> scrap->getSpring());
    }
    public function news(){
        echo "<pre>".json_encode(['data'=>$this->scrap->getNews()])."</pre>";
    }
    public function loli(){
        // echo "<pre>".json_encode(['data'=>$this->scrap->getLoli()])."</pre>";
        dd($this->scrap->getLoli());
    }
    public function donghua(){
        
    }
}
