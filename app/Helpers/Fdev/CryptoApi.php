<?php

namespace App\Helpers\Fdev;

use App\Http\Controllers\Controller;
use App\Models\Fdev\Anime;
use Illuminate\Http\Request;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Goutte\Client;

class CryptoApi 
{
    const URL = "https://coinmarketcap.com";
    private $result = [];
    
    public function assets_all (Request $request) 
    {
      $client = new Client();
      
      try {
        $page = $client->request("GET", self::URL . "/");
        
        $this->result["data"]["assets"] = [];
        if (!$page) abort(500);
        $page->filter(".cmc-table tbody tr")->each(function($row){
            $asset = [];
            try {
              $statistics = [];
              $asset["name"] = strtolower($row->filter('.name-area p')->text());
              $asset["shorname"] = $row->filter('.name-area .coin-item-symbol')->text();
              $asset["icon"] = $row->filter('.cmc-link .coin-logo')->attr("src");
              $asset["amount_usd"] = trim($row->filter('.cmc-link span')->text());
              $asset["price"] = (float) str_replace(["$", ".", ","], ["", ".", ""], $row->filter('.cmc-link span')->text());
              
              $td = $row->children("td");
              
              $statistics["percentage"] = [
                "1_hours" => [
                  "percentage" => $td->eq(4)->text(),
                  "status" => crypto_status_up($td->eq(4)->filter("span")->attr("class"))
                ],
                "24_hours" => [
                  "percentage" => $td->eq(5)->text(),
                  "status" => crypto_status_up($td->eq(5)->filter("span")->attr("class"))
                ],
                "7_days" => [
                  "percentage" => $td->eq(6)->text(),
                  "status" => crypto_status_up($td->eq(6)->filter("span")->attr("class"))
                ],
              ];
              $asset["statistics"] = $statistics;
              $this->result["data"]["assets"][] = $asset;
            } catch (\Exception $e) {
              // return true;
            }
            
          
          
        });
        
        
        
        return $this->result;
      } catch (\Exception $e) {
        if (!is_production()) throw $e;
        abort(500);
      }
    }
}