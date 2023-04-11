<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Anime;
use Illuminate\Http\Request;
use Goutte\Client;

class AnimeApiController extends Controller
{
    const URL = "https://otakudesu.lol";
    private $result = [];
    
    public function listAnime ()
    {
        $client = new Client();
        
        try {
          $page = $client->request("GET", self::URL . "/anime-list");
          
          $this->result["data"] = [];
          $this->result["catalog"] = [];
          $page->filter("#abtext .bariskelom")->each(function ($list) {
            $catalog = $list->filter(".barispenz")->text();
            $this->result["catalog"][$catalog] = [];
            
            $list->filter(".jdlbar .hodebgst")->each(function($anime) use ($catalog) {
              $title = $anime->text();
              $status = $anime->filter("color")->text();
              $desc = $anime->attr("title");
              $link = $anime->attr("href");
              $id = $anime->attr("href");
              
              /* replacement */
              $title = str_replace($status, "", $title);
              $id = substr(str_replace(self::URL."/anime/", "", $id), 0, -1);
              
              /* passing */
              $data["title"] = $title;
              $data["description"] = $desc;
              $data["link"] = $link;
              $data["id"] = $id;
              $data["status"] = strtolower($status !== "" ? $status : "completed");
              
              $this->result["data"][] = $data;
              $this->result["catalog"][$catalog][] = $data;
            });
          });
          
          return $this->result;
        } catch (\Exception ) {
          abort(404);
        }
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function detailAnime(Request $request)
    {
        $client = new Client();
        
        try {
          $page = $client->request("GET", self::URL . "/anime/". $request->id);
          
          $this->result["data"]["thumbnail"] = $page->filter(".fotoanime img")->attr("src");
          
          $page->filter(".venser .fotoanime .infozin .infozingle p")->each(function ($info){
            $key = strtolower($info->filter("b")->text());
            $value = trim(substr(str_replace($info->filter("b")->text(), "", $info->filter("span")->text()), 1));
            $this->result["data"][$key] = $value;
          });
          
          $page->filter(".episodelist")->each(function ($element){
            $total = $element->filter("ul li")->count();
            $type = $total > 1 ? "episode_list" : "batch";
            
            $data = [];
            $element->filter("ul li")->each();
            
            if ($type === "batch") {
              
            }
            else $this->result["data"]["metadata"][$type] = [];
          });
          
          return $this->result;
        } catch (\Exception $e) {
          abort(404);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Anime $anime)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Anime $anime)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Anime $anime)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Anime $anime)
    {
        //
    }
}
