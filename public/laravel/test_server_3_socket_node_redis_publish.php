<?php

require __DIR__.'/../../vendor/autoload.php';
$redis= new Predis\Client('tcp://redis:6379');

$publish= json_encode([
    'event' => 'MyEvent'
    ,'data' => 'Random string:'.rand()
]);

$redis->publish('example-channel', $publish);

print("Published data: <b>{$publish}</b>");
