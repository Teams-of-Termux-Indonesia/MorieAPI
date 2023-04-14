<?php

namespace App\Models\Fdev;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anime extends Model
{
    use HasFactory;
    protected $guarded = ["id"];
    protected $table = "otaku_animes";
    
    
}
