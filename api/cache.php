<?php

namespace VK;

class Cache {
    private static $data = [];
    
    public static function set($a, $b) {
        self::$data[$a] = $b;
    }

    public static function get($a) {
        if(!isset(self::$data[$a])) return NULL;
        return self::$data[$a];
    }
}