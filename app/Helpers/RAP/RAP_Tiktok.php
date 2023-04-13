<?php

namespace App\Helpers\RAP;

use Exception;

class RAP_TikTok
{
    private static $token = 't4JdZ9etWtvCbI68c77THtVyYJEtEp4DrGg2Af8W';

    public static function setUrl($url, $type)
    {
        if ($url) {
            if ($type == 'video') {
                return RAP_Tiktok::getVideo($url);
            } elseif ($type == 'audio') {
                return RAP_Tiktok::getAudio($url);
            }
        } else {
            return json_encode(['message' => 'Please provide the URL']);
        }
    }

    public static function getVideo($url)
    {
        try {
            $get = json_decode(file_get_contents("https://tikdown.org/getAjax?url=" . urlencode($url) . "&_token=" . self::$token), true);
            $ex = explode('href="', $get['html']);
            $tb = explode('src=', $get['html']);

            $exp = explode('@', $url);
            $author = explode('/', $exp[1]);
            $id = explode('?', $author[2]);

            $getVideo = [
                'success' => true,
                'id' => $id[0],
                'author' => $author[0],
                'thumbnail' => explode('>', $tb[1])[0],
                'video' => explode('" name="download"', $ex[1])[0]
            ];
        } catch (Exception $e) {
            $getVideo = [
                'success' => false,
                'message' => 'Please provide a valid url'
            ];
        }
        return json_encode($getVideo);
    }

    public static function getAudio($url)
    {
        try {
            $get = json_decode(file_get_contents("https://tikdown.org/getAjax?url=" . urlencode($url) . "&_token=" . self::$token), true);
            $ex = explode('href="', $get['html']);
            $tb = explode('src=', $get['html']);

            $exp = explode('@', $url);
            $author = explode('/', $exp[1]);
            $id = explode('?', $author[2]);

            $getAudio = [
                'success' => true,
                'id' => $id[0],
                'author' => $author[0],
                'thumbnail' => explode('>', $tb[1])[0],
                'audio' => explode('" name="download"', $ex[2])[0]
            ];
        } catch (Exception $e) {
            $getAudio = [
                'success' => false,
                'message' => 'Please provide a valid url'
            ];
        }
        return json_encode($getAudio);
    }
}
