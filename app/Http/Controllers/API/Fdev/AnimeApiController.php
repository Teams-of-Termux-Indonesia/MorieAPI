<?php

namespace App\Http\Controllers\API\Fdev;

use App\Helpers\Fdev\Libraries\Otakudesu;
use App\Http\Controllers\Controller;
use App\Models\Fdev\Anime;
use Illuminate\Http\Request;
use Stichoza\GoogleTranslate\GoogleTranslate;
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
              $uid = substr(str_replace(self::URL."/anime/", "", $link), 0, -1);
              
              /* replacement */
              $title = str_replace($status, "", $title);
              
              /* passing */
              $data["title"] = $title;
              $data["description"] = $desc;
              $data["link"] = $link;
              $data["uid"] = $uid;
              $data["status"] = strtolower($status !== "" ? $status : "completed");
              
              $this->result["data"][] = $data;
              $this->result["catalog"][$catalog][] = $data;
              
              /* store to database */
              if (!Anime::where("uid", $uid)->first()) Anime::create($data);
            });
          });
          
          return $this->result;
        } catch (\Exception $e) {
          if (!is_production()) dd($e);
          abort(404);
        }
        
    }
    
    public function detailAnime(Request $request)
    {
        $client = new Client();
        
        try {
          $page = $client->request("GET", self::URL . "/anime/". $request->uid);
          
          $this->result["data"]["thumbnail"] = $page->filter(".fotoanime img")->attr("src");
          $this->result["data"]["uid"] = $request->uid;
          $this->result["time"] = time();
          
          $page->filter(".venser .fotoanime .infozin .infozingle p")->each(function ($info){
            $key = preg_replace(
              "/(\s)+/",
              "_",
              GoogleTranslate::trans(
                strtolower($info->filter("b")->text()),
                "en",
                "id"
              )
            );
            $value = trim(substr(str_replace($info->filter("b")->text(), "", $info->filter("span")->text()), 1));
            
            /* check key */
            if ($key === "duration") $value = GoogleTranslate::trans($value, "en", "id");
            
            $this->result["data"][$key] = $value;
          });
          
          $synopsis = $page->filter(".sinopc")->text();
          try {
            if ($request->lang) $this->result["data"]["synopsis"] = GoogleTranslate::trans($synopsis, $request->lang, "id");
            else $this->result["data"]["synopsis"] = $synopsis;
          } catch (\Exception $e) {
            if ($request->lang) $this->result["data"]["synopsis"] = GoogleTranslate::trans($synopsis, "en", "id");
          }
          
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
          
          /* update data */
          $anime = Anime::where("uid", $request->uid)->first();
          if ($anime) $anime->update($this->result["data"]);
          else Anime::create($this->result["data"]);
          
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
    
    public function searchAnime (Request $request) {
      $client = new Client();
      try {
        $page = $client->request("GET", self::URL . sprintf("/?s=%s&post_type=anime", $request->q));
        $total_page = 1;
        
      } catch (\Exception $e) {
        if (!is_production()) dd($e);
        abort(404);
      }
    }
    
   
    
    
}
