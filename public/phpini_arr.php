<?php

$data= [
    'variables_order' => ini_get('variables_order'),
    'request_order' => ini_get('request_order'),

    'error_reporting' => ini_get('error_reporting'),
    'display_errors' => ini_get('display_errors'),
    'display_startup_errors' => ini_get('display_startup_errors'),

    'max_execution_time' => ini_get('max_execution_time'),
    'display_errors' => ini_get('display_errors'),
    'display_startup_errors' => ini_get('display_startup_errors'),

    'date.timezone' => date_default_timezone_get(),
];

echo json_encode($data, JSON_PRETTY_PRINT);
