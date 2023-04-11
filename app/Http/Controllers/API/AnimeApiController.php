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
        $page = $client->request("GET", self::URL . "/anime-list");
        $result = [];
        
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
        
        return json_encode($this->result);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
