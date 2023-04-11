<?php
namespace App\Models;
use Goutte\Client;

class ScrapAnime{
    private $data_result=[];
    public function getSpring(){
        $client = new Client();
        $site = $client -> request("GET","https://myanimelist.net/anime/season");
        $site -> filter('div.seasonal-anime-list.js-seasonal-anime-list.js-seasonal-anime-list-key-1')->each(function($parent){
            $parent->filter('div.js-anime-category-producer.seasonal-anime.js-seasonal-anime.js-anime-type-all.js-anime-type-1')->each(function($childen1){
                array_push($this->data_result,$childen1->text());
            });
        });

        return $this->data_result;
    }
}