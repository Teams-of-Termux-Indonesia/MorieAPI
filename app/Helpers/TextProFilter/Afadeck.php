<?php
namespace App\Helpers\TextProFilter;
use Intervention\Image\Filters\FilterInterface;

class Afadeck implements FilterInterface
{
   
    const DEFAULT_SIZE = 1;

    private $size;

    public function __construct($size = null)
    {
        $this->size = is_numeric($size) ? intval($size) : self::DEFAULT_SIZE;
    }

    public function applyFilter(\Intervention\Image\Image $image)
    {
        $image->pixelate($this->size);
        // $image->greyscale();
        $image->colorize(-10, 0, 10);

        return $image;
    }
}