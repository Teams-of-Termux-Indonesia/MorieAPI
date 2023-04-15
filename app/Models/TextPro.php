<?php
namespace App\Models;
use Intervention\Image\Facades\Image;
use App\Helpers\TextProFilter\Afadeck;

class TextPro
{
    private $f;
    private $w;
    private $h;
    private $marginLeft;
    private $marginTop;
    public function getText($data)
    {
        $image = Image::make(storage_path("app/textpro/boke.jpg"));
        $this->w = $image->width();
        $this->h = $image->height();
        $rasio = $this->w / $this->h;
        $this->marginLeft = $rasio;
        $this->marginTop = $rasio;
        switch (true) {
            case strlen($data["teks"]) <= 8:
                $this->f = 55;
                break;
            case strlen($data["teks"]) <= 10 && strlen($data["teks"]) > 8:
                $this->f = 38;
                break;
            case strlen($data["teks"]) <= 12 && strlen($data["teks"]) > 10:
                $this->f = 29;
                break;
            default:
                return $data = ["status" => false];
        }
        $x = ($this->w - $this->f) / $this->marginLeft;
        $y = ($this->h - $this->f) / $this->marginTop;
        switch ($data["type"]) {
            case "boke":
                $image->text($data["teks"], $x, $y - 1, function ($font) {
                    $font->file(storage_path("app/textpro/font/Henshin.ttf"));
                    $font->size($this->f);
                    $font->color("#0e75d2"); //shadow biru
                    $font->align("center");
                    $font->valign("middle");
                });
                $image->text($data["teks"], $x + 1, $y + 5, function ($font) {
                    $font->file(storage_path("app/textpro/font/Henshin.ttf"));
                    $font->size($this->f);
                    $font->color("#f61100"); // shadow red
                    $font->align("center");
                    $font->valign("middle");
                });
                $image->text($data["teks"], $x, $y + 3, function ($font) {
                    $font->file(storage_path("app/textpro/font/Henshin.ttf"));
                    $font->size($this->f);
                    $font->color("#aefa01"); // fill green
                    $font->align("center");
                    $font->valign("middle");
                });
                $image->filter(new Afadeck(0.1));
                $imageData = $image->encode("data-url");
                return $data = ["status" => true, "src" => (string) $imageData];
                break;
            default:
                return $data = ["status" => false];
        }
        return $data;
    }
}
