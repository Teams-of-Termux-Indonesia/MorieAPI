<?php

namespace App\Helpers\RAP;

use Exception;

class RAP_Instagram
{
    public static function setUrl($url, $type)
    {
        if ($url) {
            if ($type == 'profile') {
                return RAP_Instagram::getProfile($url);
            } elseif ($type == 'video') {
                return RAP_Instagram::getVideo($url);
            } elseif ($type == 'reel') {
                return RAP_Instagram::getReel($url);
            } elseif ($type == 'image') {
                return RAP_Instagram::getImage($url);
            }
        } else {
            return json_encode(['message' => 'Please provide the URL']);
        }
    }

    public static function getProfile($url)
    {
        try {
            $user = explode('.com/', $url);
            if (strpos($user[1], '/') !== false) {
                $username = explode('/', $user['1'])[0];
            } else {
                $username = $user[1];
            }

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://www.instagram.com/$username/?__a=1&__d=dis");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $output = curl_exec($ch);
            curl_close($ch);
            $profile = json_decode($output, true);

            $getProfile = [
                'success' => true,
                'id' => $profile["graphql"]["user"]["id"],
                'username' => $profile["graphql"]["user"]["username"],
                'name' => $profile["graphql"]["user"]["full_name"],
                'bio'   => $profile["graphql"]["user"]["biography"],
                'follower' => $profile["graphql"]["user"]["edge_followed_by"]["count"],
                'following' => $profile["graphql"]["user"]["edge_follow"]["count"],
                'profile_picture' => $profile["graphql"]["user"]["profile_pic_url_hd"],
                'post_totals' => $profile["graphql"]["user"]["edge_owner_to_timeline_media"]['count'],
                'reel_totals' => $profile["graphql"]["user"]["edge_felix_video_timeline"]['count']
            ];
        } catch (Exception $e) {
            $getProfile = [
                'success' => false,
                'message' => 'Please provide a valid url'
            ];
        }

        return json_encode($getProfile);
    }

    public static function getVideo($url)
    {
        try {
            $user = explode('p/', $url);
            if (strpos($user[1], '/') !== false) {
                $id = explode('/', $user['1'])[0];
            } else {
                $id = $user[1];
            }

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://www.instagram.com/p/$id/?__a=1&__d=dis");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $output = curl_exec($ch);
            curl_close($ch);
            $video = json_decode($output, true);

            $getVideo = [];
        } catch (Exception $e) {
            $getProfile = [
                'success' => false,
                'message' => 'Please provide a valid url'
            ];
        }

        return json_encode($video);
    }

    public static function getReel($url)
    {
        try {
            $user = explode('reel/', $url);
            if (strpos($user[1], '/') !== false) {
                $id = explode('/', $user['1'])[0];
            } else {
                $id = $user[1];
            }

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://www.instagram.com/reel/$id/?__a=1&__d=dis");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $output = curl_exec($ch);
            curl_close($ch);
            $reel = json_decode($output, true);

            $getReel = [];
        } catch (Exception $e) {
            $getReel = [
                'success' => false,
                'message' => 'Please provide a valid url'
            ];
        }
        return json_encode($reel);
    }

    public static function getImage($url)
    {
        try {
            $user = explode('p/', $url);
            if (strpos($user[1], '/') !== false) {
                $id = explode('/', $user['1'])[0];
            } else {
                $id = $user[1];
            }

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://www.instagram.com/p/$id/?__a=1&__d=dis");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $output = curl_exec($ch);
            curl_close($ch);
            $image = json_decode($output, true);

            $getImage = [];
        } catch (Exception $e) {
            $getImage = [
                'success' => false,
                'message' => 'Please provide a valid url'
            ];
        }
        return json_encode($image);
    }
}
