<?php

namespace App\Http\Controllers\API\Fdev;

use App\Helpers\Fdev\Libraries\Otakudesu;
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
              $id = substr(str_replace(self::URL."/anime/", "", $link), 0, -1);
              
              /* replacement */
              $title = str_replace($status, "", $title);
              
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
        } catch (\Exception $e) {
          abort(404);
        }
        
    }
    
    public function detailAnime(Request $request)
    {
        $client = new Client();
        
        try {
          $page = $client->request("GET", self::URL . "/anime/". $request->id);
          
          $this->result["data"]["thumbnail"] = $page->filter(".fotoanime img")->attr("src");
          $this->result["time"] = time();
          
          $page->filter(".venser .fotoanime .infozin .infozingle p")->each(function ($info){
            $key = strtolower($info->filter("b")->text());
            $value = trim(substr(str_replace($info->filter("b")->text(), "", $info->filter("span")->text()), 1));
            $this->result["data"][$key] = $value;
          });
          
          $page->filter(".episodelist")->each(function ($episodeContainer){
            $total = $episodeContainer->filter("ul li")->count();
            $type = $total > 1 ? "episode_list" : "batch";
            
            $data = [];
            
            $episodeContainer->filter("ul li")->each(function ($list, $index) use ($type) {
              $link = $list->filter("a")->attr("href");
              $date = $list->filter(".zeebr")->text();
              
              if ($type === "batch") {
                $this->result["data"]["metadata"][$type] = [
                    "name" => "batch download",
                    "link" => $link,
                    "date" => $date 
                ];
              } else {
                $id = substr(str_replace(self::URL."/episode/", "", $link), 0, -1);
                $this->result["data"]["metadata"][$type][] = [
                    "id" => $id,
                    "name" => sprintf("episode %s", $index + 1),
                    "link" => $link,
                    "uploaded_at" => $date,
                    "metadata" => (new Otakudesu)->linkDownloads($link)
                ];
              }
              
            });
            
          });
          
          return $this->result;
        } catch (\Exception $e) {
          if (is_production()) dd($e);
          abort(404);
        }
    }
    
    public function detailEpisode(Request $request)
    {
        $client = new Client();
        try {
          $client->request("GET", self::URL + "/anime/");
        } catch (\Exception $e) {
        }
    }
    
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
