<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\RAP\RAP_Facebook;
use App\Helpers\RAP\RAP_Youtube;
use App\Helpers\RAP\RAP_Tiktok;
use App\Helpers\RAP\RAP_Instagram;
use Illuminate\Support\Facades\Mail;
use App\Mail\Gmail;
use Exception;

class RAPController extends Controller
{
    public function ip(Request $request)
    {
        return json_encode(['success' => true, 'ip_address' => $request->ip()]);
    }

    public function gmail_send(Request $request)
    {
        if ($request->get('email') && $request->get('password') && $request->get('name') && $request->get('title') && $request->get('message') && $request->get('to')) {
            try {
                $data = [
                    'title' => trim($request->get('title')),
                    'message' => trim($request->get('message'))
                ];

                config(['mail.mailers.smtp.host' => "smtp.gmail.com"]);
                config(['mail.mailers.smtp.encryption' => "tls"]);
                config(['mail.mailers.smtp.username' => trim($request->get('email'))]);
                config(['mail.mailers.smtp.password' => trim($request->get('password'))]);
                config(['mail.mailers.smtp.port' => 465]);
                config(['mail.from.address' => trim($request->get('email'))]);
                config(['mail.from.name' => trim($request->get('name'))]);

                Mail::to(trim($request->get('to')))->send(new Gmail($data));

                $sendMail = [
                    'success' => true,
                    'message' => 'Message sent successfully',
                    'data' => [
                        'to' => trim($request->get('to')),
                        'email' => trim($request->get('email')),
                        'password' => trim($request->get('password')),
                        'name' => trim($request->get('name')),
                        'title' => trim($request->get('title')),
                        'message' => trim($request->get('message'))
                    ]
                ];
            } catch (Exception $e) {
                $sendMail = [
                    'success' => false,
                    'message' => $e->getMessage()
                ];
            }

            return json_encode($sendMail);
        } else {
            return json_encode(['success' => false, 'message' => 'Complete the requirements']);
        }
    }

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
