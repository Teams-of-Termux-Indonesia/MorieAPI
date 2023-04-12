<?php

namespace App\Helpers\Fdev\Libraries;

use Goutte\Client;

final class Otakudesu 
{
  private $result = [];
  
  public function linkDownloads ($url) 
    {
        $client = new Client();
        try {
          $page = $client->request("GET", $url);
          $page->filter("#venkonten .download ul li")->each(function ($list) {
            $arr = explode(" ", $list->filter("strong")->text());
            $quality = end($arr);
            $this->result[$quality] = [];
            
            $list->filter("a")->each(function($anchor) use ($quality) {
              $vendor = strtolower(trim($anchor->text()));
              $link = $anchor->attr("href");
              
              $this->result[$quality][$vendor] = $link;
            });
          });
          
          return $this->result;
        } catch (\Exception $e) {
          dd($e);
        }
    }
}