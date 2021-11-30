<?php

namespace VK;

use \VK\API;

class Longpoll {
    private static $callbacks = [];
    private static $key = NULL, $ts = 0, $server = NULL;

    private static function call($method, $params=[])
    {
        if(!isset(self::$callbacks[$method])) return;
        call_user_func_array(self::$callbacks[$method], $params);
    }

    public static function on($method, $callback)
    {
        self::$callbacks[$method] = $callback;
    }

    public static function run()
    {
        $server_info = API::Call('messages.getLongPollServer');
        self::$server = $server_info['response']['server'];
        self::$ts = $server_info['response']['ts'];
        self::$key = $server_info['response']['key'];

        while(true) {
            $request = [
                'act' => 'a_check',
                'key' => self::$key,
                'ts' => self::$ts,
                'wait' => 25,
                'mode' => 2,
                'version' => 2
            ];
            $response = json_decode(file_get_contents('http://'.self::$server.'?'.http_build_query($request)), true);
            self::$ts = $response['ts'];
            if(count($response['updates']) > 0)
            {
                foreach($response['updates'] as $update) {
                    if($update[0] == 4) {
                        self::call('message', [$update[3], $update[1], isset($update[6]['from']) ? $update[6]['from'] : $update[3], $update[4], $update[5]]);
                    }
                }
            }
            sleep(1);
        }
    }
}