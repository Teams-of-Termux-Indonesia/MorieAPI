<?php
namespace App\Models;
use Goutte\Client;
use Stichoza\GoogleTranslate\GoogleTranslate;
class ScrapAnime
{
    private $springs = [];
    private $news = [];
    private $looks = [];
    public function teks($teks)
    {
        $tr = new GoogleTranslate();
        $tr->setSource("en");
        $tr->setTarget("id");
        return $tr->translate($teks);
    }
    public function getSpring()
    {
        $site = $this->get("https://myanimelist.net/anime/season");
        $site
            ->filter(
                "div.seasonal-anime-list.js-seasonal-anime-list.js-seasonal-anime-list-key-1"
            )
            ->each(function ($parent) {
                $parent
                    ->filter(
                        "div.js-anime-category-producer.seasonal-anime.js-seasonal-anime.js-anime-type-all.js-anime-type-1"
                    )
                    ->each(function ($childen1) {
                        array_push($this->springs, [
                            "header" => [
                                "title" => $childen1
                                    ->filter("div.title div.title-text")
                                    ->text(),
                                "info_product" => $childen1
                                    ->filter("div.prodsrc div.info")
                                    ->text(),
                                "genres" => $childen1
                                    ->filter("div.genres-inner.js-genre-inner")
                                    ->text(),
                            ],
                            "body" => [
                                "image" => [
                                    "src" => $childen1
                                        ->filter("div.image a img")
                                        ->attr("src"),
                                    "width" => $childen1
                                        ->filter("div.image a img")
                                        ->attr("width"),
                                    "height" => $childen1
                                        ->filter("div.image a img")
                                        ->attr("height"),
                                ],
                                "synopsis" => $this->teks(
                                    $childen1
                                        ->filter("div.synopsis.js-synopsis")
                                        ->text("p")
                                ),
                            ],
                        ]);
                    });
            });
        return $this->springs;
    }
    public function getNews()
    {
        $site = $this->get(
            "https://www.kaorinusantara.or.id/rubrik/aktual/anime"
        );
        $site->filter("div.td-block-row")->each(function ($parent) {
            $parent
                ->filter(
                    "div.td-block-span6 div.td_module_4.td_module_wrap.td-animation-stack"
                )
                ->each(function ($childen1) {
                    array_push($this->news, [
                        "image" => [
                            "src" => $childen1
                                ->filter(
                                    "div.td-module-image div.td-module-thumb img"
                                )
                                ->attr("data-lazy-src"),
                            "width" => $childen1
                                ->filter(
                                    "div.td-module-image div.td-module-thumb img"
                                )
                                ->attr("width"),
                            "height" => $childen1
                                ->filter(
                                    "div.td-module-image div.td-module-thumb img"
                                )
                                ->attr("height"),
                        ],
                        "body" => [
                            "title" => $childen1
                                ->filter("h3.entry-title.td-module-title")
                                ->text(),
                            "time" => $childen1
                                ->filter(
                                    "div.td-module-meta-info span.td-post-date"
                                )
                                ->text(),
                            "author" => $childen1
                                ->filter(
                                    "div.td-module-meta-info span.td-post-author-name"
                                )
                                ->text(),
                            "caption" => $childen1
                                ->filter("div.td-excerpt")
                                ->text(),
                        ],
                    ]);
                });
        });
        return $this->news;
    }

    public function get($url)
    {
        $client = new Client();
        return $client->request("GET", $url);
    }
}
