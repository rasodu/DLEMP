<?php

$data= [
    'max_execution_time' => ini_get('max_execution_time'),
];

echo json_encode($data, JSON_PRETTY_PRINT);
