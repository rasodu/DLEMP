<?php
require __DIR__.'/../vendor/autoload.php';

use Elasticsearch\ClientBuilder;

//build elasticsearch client
$hosts = [
    [
        'host' => 'elasticsearch',
        'port' => '9200',
    ],
];
$client = ClientBuilder::create()
    ->setHosts($hosts)
    ->build();

//print info
print("<pre>");
print(json_encode($client->info(), JSON_PRETTY_PRINT));
print("</pre>");
