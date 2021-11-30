<?php

namespace VK;

use \VK\API;

class Client {
    public function __construct($token)
    {
        API::Initialize($token);
    }
}