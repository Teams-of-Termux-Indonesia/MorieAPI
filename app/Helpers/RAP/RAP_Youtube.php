<?php

namespace App\Helpers\RAP;

use Exception;

class RAP_Youtube
{
    private static $api_key = 'AIzaSyDevY98QDxTXSj5GsiqH1w_BNUyfxp0dO8';
    private static $api_url = 'https://www.googleapis.com/youtube/v3/';

    public static function setUrl($url, $type)
    {
        if ($url) {
            if ($type == 'video') {
                return RAP_Youtube::getVideo($url);
            } elseif ($type == 'channel') {
                return RAP_Youtube::getChannel($url);
            }
        } else {
            return json_encode(['message' => 'Please provide the URL']);
        }
    }

    public static function getVideo($url)
    {
        $video_id = '';
        if (strpos($url, 'v=') !== false) {
            $video_id = substr($url, strpos($url, 'v=') + 2);
        } elseif (strpos($url, 'youtu.be/') !== false) {
            $video_id = substr($url, strpos($url, 'youtu.be/') + 9);
        } elseif (strpos($url, 'embed/') !== false) {
            $video_id = substr($url, strpos($url, 'embed/') + 6);
        }

        try {
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, 'https://www.youtube.com/youtubei/v1/player?key=AIzaSyAO_FJ2SlqU8Q4STEHLGCilw_Y9_11qcW8');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, '{  "context": {    "client": {      "hl": "en",      "clientName": "WEB",      "clientVersion": "2.20210721.00.00",      "clientFormFactor": "UNKNOWN_FORM_FACTOR",   "clientScreen": "WATCH",      "mainAppWebInfo": {        "graftUrl": "/watch?v=' . $video_id . '",           }    },    "user": {      "lockedSafetyMode": false    },    "request": {      "useSsl": true,      "internalExperimentFlags": [],      "consistencyTokenJars": []    }  },  "videoId": "' . $video_id . '",  "playbackContext": {    "contentPlaybackContext": {        "vis": 0,      "splay": false,      "autoCaptionsDefaultOn": false,      "autonavState": "STATE_NONE",      "html5Preference": "HTML5_PREF_WANTS",      "lactMilliseconds": "-1"    }  },  "racyCheckOk": false,  "contentCheckOk": false}');
            curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

            $headers = array();
            $headers[] = 'Content-Type: application/json';
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }
            curl_close($ch);

            $data = json_decode($result);

            $links = [];
            $v = [];
            foreach ($data->streamingData->formats as $link) {
                $links['url'] = $link->url;
                $links['type'] = $link->mimeType;
                $links['size'] = RAP_Youtube::formatBytes($link->bitrate);
                $links['quality'] = strtoupper($link->qualityLabel);

                $v[] = $links;
            }

            $vd = $data->videoDetails;

            $getVideo = [
                'success' => true,
                'id' => $vd->videoId,
                'title' => $vd->title,
                'description' => $vd->shortDescription,
                'viewers' => $vd->viewCount,
                'author' => $vd->author,
                'thumbnails' => $vd->thumbnail->thumbnails,
                'links' => $v
            ];
        } catch (Exception $e) {
            $getVideo = [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
        return json_encode($getVideo);
    }

    public static function formatBytes($bytes, $precision = 2)
    {
        $units = array('KB', 'MB', 'GB', 'TB');

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= pow(1024, $pow);

        return round($bytes, $precision) . ' ' . $units[$pow];
    }

    public static function getChannel($url)
    {
        if (strpos($url, 'channel/') !== false) {
            $urlYoutube = explode("channel/", $url);
            $id = $urlYoutube[1];
            $api = self::$api_url . "channels?id=$id&key=" . self::$api_key . "&part=snippet,statistics";
        } else {
            $urlYoutube = explode(".com/", $url);
            $search = '@';
            if (strpos($urlYoutube[1], $search) !== false) {
                $username = preg_replace("/$search/", "", $urlYoutube[1]);
            } else {
                $username = $urlYoutube[1];
            }

            $api = self::$api_url . "channels?forUsername=$username&key=" . self::$api_key . "&part=snippet,statistics";
        }

        try {
            $json_data = file_get_contents($api);
            $data = json_decode($json_data);

            $id_channel = $data->items[0]->id;
            $username_channel = $data->items[0]->snippet->customUrl;
            $name = $data->items[0]->snippet->title;
            $description = $data->items[0]->snippet->description;
            $profile_picture = $data->items[0]->snippet->thumbnails->high->url;
            $video_count = $data->items[0]->statistics->videoCount;
            $subscriber_count = $data->items[0]->statistics->subscriberCount;
            $viewers = $data->items[0]->statistics->viewCount;

            $getChannel = [
                'success' => true,
                'id' => $id_channel,
                'username' => $username_channel,
                'name' => $name,
                'description' => $description,
                'profile' => $profile_picture,
                'video' => $video_count,
                'subscribe' => $subscriber_count,
                'viewers' => $viewers
            ];
        } catch (Exception $e) {
            $getChannel = [
                'success' => false,
                'message' => 'Please provide a valid url'
            ];
        }

        return json_encode($getChannel);
    }
}
