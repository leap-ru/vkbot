<?php

require('vendor/autoload.php');

use \VK\API;
use \VK\Client;
use \VK\Longpoll;
use \VK\Cache;

$vk = new Client('тут токен');
Longpoll::on('message', function($peer, $id, $sender, $ts, $data) {
    if($peer != 2000000087) return;
    $last_message = Cache::get($sender);
    if($last_message != NULL && time() - $last_message < 2) {
        API::Call('messages.delete', ['delete_for_all'=>1,'peer_id'=>$peer,'message_ids'=>$id]);
    }
    Cache::set($sender, time());
});
Longpoll::run();