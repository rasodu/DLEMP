<?php

//start print xdebug configurations
$xdebug_enabled= 'No';
if(isset($_COOKIE['XDEBUG_SESSION'])){
    $xdebug_enabled= "Yes({$_COOKIE['XDEBUG_SESSION']})";
}
print("'XDEBUG_SESSION' cookie set to initiate a debugging session: $xdebug_enabled<br/>");
print("Xdebug will connect to host at: {$_SERVER['REMOTE_ADDR']}<br/>");
print("Xdebug will connect the host at port: ".ini_get('xdebug.remote_port')."<br/>");
print("<br/>");
//end print xdebug configurations

//start example code where you can add break point and check if debugger if working or not
function add_numbers($a, $b){
    $sum= 0;
    $sum= $a + $b;
    return $sum;
}

$total= 0;//insert bread point here for checking if xdebug is working or not
$total= add_numbers(2, 3);
print("Total is: $total");
//end example code where you can add break point and check if debugger if working or not
