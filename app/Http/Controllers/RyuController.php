<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ScrapAnime;
use App\Models\bmkg\ScrapBmkg;
use App\Models\TextPro;
class RyuController extends Controller
{
    private $scrap;
    private $bmkg;
    private $textpro;
    public function __construct()
    {
        $this -> scrap = new ScrapAnime();
        $this -> bmkg = new ScrapBmkg();
        $this -> textpro = new TextPro();
    }
    public function  news(){
        return response()->json($this->scrap->getNews(),200);     
    }
    public function gempaTerkini(){
        return response()->json($this->bmkg->getGempaTerkini(),200);
    }
    public function textpro(Request $request,$text){
        $data = [
            "teks"=>$request->get("teks"),
            "type"=>$text
        ];
        return response()->json(["data"=>$this->textpro->getText($data)],200);
    }
}
