<?php

namespace App\Helpers\Fdev;

use App\Http\Controllers\Controller;
use App\Models\Fdev\Anime;
use Illuminate\Http\Request;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Illuminate\Support\Facades\Http;
use Goutte\Client;

class CryptoApi 
{
    const URL = "https://coinmarketcap.com";
    private $assets = [];
    private $result = [];
    
    private static function check_crypto_status (string $str, $bind = null) {
      if ($bind) return $str === $bind ? "up" : "down";
      else return $str === "icon-Caret-up" ? "up" : "down";
    }
    
    private function get_all_assets (): array {
      $client = new Client();
      if ($this->assets) return $this->assets;
      
      try {
          $page = $client->request("GET", self::URL . "/");
          
          $page->filter(".cmc-table tbody tr")->each(function($row){
              try {
                $asset = [];
                $statistics = [];
                
                $asset["name"] = strtolower($row->filter('.name-area p')->text());
                $asset["shortname"] = $row->filter('.name-area .coin-item-symbol')->text();
                $asset["icon"] = $row->filter('.cmc-link .coin-logo')->attr("src");
                $asset["price_usd"] = trim($row->filter('.cmc-link span')->text());
                $asset["price"] = (float) str_replace(["$", ".", ","], ["", ".", ""], $row->filter('.cmc-link span')->text());
                
                $td = $row->children("td");
                
                $statistics["percentage"] = [
                  "1_hours" => [
                    "percentage" => $td->eq(4)->text(),
                    "status" => self::check_crypto_status($td->eq(4)->filter("span span")->attr("class"))
                  ],
                  "24_hours" => [
                    "percentage" => $td->eq(5)->text(),
                    "status" => self::check_crypto_status($td->eq(5)->filter("span span")->attr("class"))
                  ],
                  "7_days" => [
                    "percentage" => $td->eq(6)->text(),
                    "status" => self::check_crypto_status($td->eq(6)->filter("span span")->attr("class"))
                  ],
                ];
                
                $statistics["market_capital"] = [
                  "usd" => (float) str_replace(["$", ".", ","], ["", ".", ""], $td->eq(7)->filter("p span:nth-child(2)")->text()),
                ];
                
                $statistics["volume"] = [
                  "usd" => (float) str_replace(["$", ".", ","], ["", ".", ""], $td->eq(8)->filter("div a p")->text()),
                  "btc" => (float) str_replace(["BTC", ".", ","], ["", ".", ""], $td->eq(8)->filter("div div p")->text())
                ];
                
                
                $asset["statistics"] = $statistics;
                $this->assets[] = $asset;
              } catch (\Exception $e) {
                //
              }
          });
        
        return $this->assets;
      } catch (\Exception $e) {
        if (!is_production()) dd($e);
      }
    }
    
    private function convert_crypto($from, $to) {
      if (!$this->assets) get_all_assets();
      
      try {
        foreach ($this->assets as $asset) {
          if ($asset["shortname"] === $from) $from = $asset["price"];
          if ($asset["shortname"] === $to) $to = $asset["price"];
        }
        
        return round($from / $to, 16);
        
      } catch (\Exception $e) {
        dd($e);
      }
    }
    
    public function assets_all () 
    {
      $client = new Client();
      $assets = $this->get_all_assets();
      $result = [];
      
      try {
        
        foreach ($assets as $key => $asset) {
          $result["data"]["assets"][] = $asset;
        }
        
        return $result;
      } catch (\Exception $e) {
        if (!is_production()) throw $e;
        abort(500);
      }
    }
    
    
}