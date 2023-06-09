<?php

namespace App\Helpers\Fdev;

use App\Http\Controllers\Controller;
use App\Models\Fdev\Anime;
use Illuminate\Http\Request;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Goutte\Client;

class AnimeApi
{
    const URL = "https://otakudesu.lol";
    private $result = [];
    private $links = [];
    
    public function anime_all ()
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
              
              if (!Anime::where("uid", $uid)->first()) Anime::create($data);
              $this->result["data"][] = $data;
              $this->result["catalog"][$catalog][] = $data;
            });
          });
          
          
          return $this->result;
        } catch (\Exception $e) {
          if (!is_production()) throw $e;
          abort(404);
        }
        
    }
    
    public function anime_detail (Request $request)
    {
        $client = new Client();
        
        try {
          $page = $client->request("GET", self::URL . "/anime/". $request->uid);
          
          $this->result["data"]["thumbnail"] = $page->filter(".fotoanime img")->attr("src");
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
            $this->result["data"][$key] = $value;
          });
          
          $synopsis = $page->filter(".sinopc")->text();
          try {
            if ($request->lang) $this->result["data"]["synopsis"] = GoogleTranslate::trans($synopsis, $request->lang, "id");
          } catch (\Exception $e) {
            if ($request->lang) $this->result["data"]["synopsis"] = GoogleTranslate::trans($synopsis, "en", "id");
            else $this->result["data"]["synopsis"] = $synopsis;
          }
          
          $page->filter(".episodelist")->each(function ($episodeContainer) use ($request) {
            $total = $episodeContainer->filter("ul li")->count();
            $type = $total > 1 ? "episode_list" : "batch";
            
            $episodeContainer->filter("ul li")->each(function ($list, $index) use ($type, $request) {
              $link = $list->filter("a")->attr("href");
              $date = $list->filter(".zeebr")->text();
              
              if ($type === "batch") {
                $this->result["data"]["metadata"][$type] = [
                    "name" => "batch download",
                    "link" => $link,
                    "date" => $date 
                ];
              } else {
                $eps = substr(str_replace(self::URL."/episode/", "", $link), 0, -1);
                $this->result["data"]["metadata"][$type][] = [
                    "uid" => $eps,
                    "name" => sprintf("episode %s", $index + 1),
                    "link" => $link,
                    "uploaded_at" => $date,
                    "metadata" => $this->link_downloads($link)
                ];
              }
              
              $anime = Anime::where("uid", $request->uid)->first();
              if ($anime) $anime->update($this->result["data"]);
            });
            
          });
          
          return $this->result;
        } catch (\Exception $e) {
          if (!is_production()) throw $e;
          abort(404);
        }
    }
    
    public function anime_episode (Request $request)
    {
        $client = new Client();
        try {
          $page = $client->request("GET", self::URL . "/episode/" .$request->episode);
          return json_encode($page);
          $title = $page->filter("#venkonten .download h4")->text();
          $title = trim(explode("episode")[2]);
          
          $this->result["title"] = $title;
          return $this->result;
        } catch (\Exception $e) {
          if (!is_production()) throw $e;
          abort(404);
        }
    }
    
    
    public function link_downloads ($url) 
    {
        $client = new Client();
        try {
          $page = $client->request("GET", $url);
          $page->filter("#venkonten .download ul li")->each(function ($list) {
            $arr = explode(" ", $list->filter("strong")->text());
            $quality = end($arr);
            $this->links[$quality] = [];
            
            $list->filter("a")->each(function($anchor) use ($quality) {
              $vendor = strtolower(trim($anchor->text()));
              $link = $anchor->attr("href");
              
              $this->links[$quality][$vendor] = $link;
            });
          });
          
          return $this->links;
        } catch (\Exception $e) {
          dd($e);
        }
    }
}
