<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\RAP\RAP_Facebook;
use App\Helpers\RAP\RAP_Youtube;
use App\Helpers\RAP\RAP_Tiktok;

class RAPController extends Controller
{
    public function facebook_videos(Request $request)
    {
        $url = trim($request->get('url'));

        if ($url) {
            return RAP_Facebook::setUrl($url, 'video');
        } else {
            return json_encode(['success' => false, 'message' => 'Please provide the URL']);
        }
    }

    public function youtube_videos(Request $request)
    {
        $url = trim($request->get('url'));

        if ($url) {
            return RAP_Youtube::setUrl($url, 'video');
        } else {
            return json_encode(['success' => false, 'message' => 'Please provide the URL']);
        }
    }

    public function youtube_channels(Request $request)
    {
        $url = trim($request->get('url'));

        if ($url) {
            return RAP_Youtube::setUrl($url, 'channel');
        } else {
            return json_encode(['success' => false, 'message' => 'Please provide the URL']);
        }
    }

    public function tiktok_videos(Request $request)
    {
        $url = trim($request->get('url'));

        if ($url) {
            return RAP_Tiktok::setUrl($url, 'video');
        } else {
            return json_encode(['success' => false, 'message' => 'Please provide the URL']);
        }
    }

    public function tiktok_audios(Request $request)
    {
        $url = trim($request->get('url'));

        if ($url) {
            return RAP_Tiktok::setUrl($url, 'audio');
        } else {
            return json_encode(['success' => false, 'message' => 'Please provide the URL']);
        }
    }
}
