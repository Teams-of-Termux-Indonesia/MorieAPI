<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\RAP\RAP_Facebook;
use App\Helpers\RAP\RAP_Youtube;

class RAPController extends Controller
{
    public function facebook($url)
    {
        return RAP_Facebook::download($url);
    }

    public function youtube($url)
    {
    }
}
