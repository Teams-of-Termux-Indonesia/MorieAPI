<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Anime;
use Illuminate\Http\Request;
use Weidner\Goutte;

class AnimeApiController extends Controller
{
    const URL = "https://otakudesu.lol";
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $crawler = Goutte::request("GET", self::URL);
        $result = [];
        $res = $crawler->filter("#abtext > .bariskelom");
        
        dd($res);
        return json_encode($crawler);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Anime $anime)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Anime $anime)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Anime $anime)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Anime $anime)
    {
        //
    }
}
