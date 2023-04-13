<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\RAP\RAP_Facebook;
use App\Helpers\RAP\RAP_Youtube;
use App\Helpers\RAP\RAP_Tiktok;
use App\Helpers\RAP\RAP_Instagram;

class RAPController extends Controller
{
    public function facebook_video(Request $request)
    {
        $url = trim($request->get('url'));

        if ($url) {
            return RAP_Facebook::setUrl($url, 'video');
        } else {
            return json_encode(['success' => false, 'message' => 'Please provide the URL']);
        }
    }

    public function youtube_video(Request $request)
    {
        $url = trim($request->get('url'));

        if ($url) {
            return RAP_Youtube::setUrl($url, 'video');
        } else {
            return json_encode(['success' => false, 'message' => 'Please provide the URL']);
        }
    }

    public function youtube_channel(Request $request)
    {
        $url = trim($request->get('url'));

        if ($url) {
            return RAP_Youtube::setUrl($url, 'channel');
        } else {
            return json_encode(['success' => false, 'message' => 'Please provide the URL']);
        }
    }

    public function tiktok_video(Request $request)
    {
        $url = trim($request->get('url'));

        if ($url) {
            return RAP_Tiktok::setUrl($url, 'video');
        } else {
            return json_encode(['success' => false, 'message' => 'Please provide the URL']);
        }
    }

    public function tiktok_audio(Request $request)
    {
        $url = trim($request->get('url'));

        if ($url) {
            return RAP_Tiktok::setUrl($url, 'audio');
        } else {
            return json_encode(['success' => false, 'message' => 'Please provide the URL']);
        }
    }

    public function instagram_profile(Request $request)
    {
        $url = trim($request->get('url'));

        if ($url) {
            return RAP_Instagram::setUrl($url, 'profile');
        } else {
            return json_encode(['success' => false, 'message' => 'Please provide the URL']);
        }
    }

    // public function instagram_video(Request $request)
    // {
    //     $url = trim($request->get('url'));

    //     if ($url) {
    //         return RAP_Instagram::setUrl($url, 'video');
    //     } else {
    //         return json_encode(['success' => false, 'message' => 'Please provide the URL']);
    //     }
    // }

    // public function instagram_reel(Request $request)
    // {
    //     $url = trim($request->get('url'));

    //     if ($url) {
    //         return RAP_Instagram::setUrl($url, 'reel');
    //     } else {
    //         return json_encode(['success' => false, 'message' => 'Please provide the URL']);
    //     }
    // }

    // public function instagram_image(Request $request)
    // {
    //     $url = trim($request->get('url'));

    //     if ($url) {
    //         return RAP_Instagram::setUrl($url, 'image');
    //     } else {
    //         return json_encode(['success' => false, 'message' => 'Please provide the URL']);
    //     }
    // }
}
