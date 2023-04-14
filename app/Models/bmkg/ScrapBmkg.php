<?php
namespace APP\Models\bmkg;
use Goutte\Client;
class ScrapBmkg{
    private $gempa_terkini=[];
    public function getGempaTerkini(){
        $site = $this -> get('https://www.bmkg.go.id/gempabumi-terkini.html');
        $site -> filter("tbody tr")->each(function($childen){
            array_push($this->gempa_terkini,[
                "nomor"=>$childen -> filter('td')->eq(0)->text(),
                "waktu"=>$childen -> filter('td')->eq(1)->text(),
                "lintang"=>$childen -> filter('td')->eq(2)->text(),
                "bujur"=>$childen -> filter('td')->eq(3)->text(),
                "magnitudo"=>$childen -> filter('td')->eq(4)->text(),
                "kedalaman"=>$childen -> filter('td')->eq(5)->text(),
                "wilayah"=>$childen -> filter('td')->eq(6)->text()
            ]);
        });
        return ["data"=>$this->gempa_terkini];
    }
    public function get($url){
        $cl = new Client();
        return $cl->request("GET",$url);
    }
}