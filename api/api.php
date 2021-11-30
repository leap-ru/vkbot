<?php

namespace VK;

class API {
    private static $access_token = NULL;
    
    public static function Initialize($token)
    {
        self::$access_token = $token;
    }

    public static function Call($method, $params=[])
    {
        $params['access_token'] = self::$access_token;
        $params['v'] = '5.131';
        return json_decode(file_get_contents('http://api.vk.com/method/'.$method.'?'.http_build_query($params)), true);
    }
}