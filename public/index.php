<?php

require __DIR__.'/../vendor/autoload.php';

use Symfony\Component\Process\Process;

//start return special response if cron is called
if ($_SERVER['REQUEST_URI'] == '/schedule/run') {
    $ret= "//start cron\n";
    $ret.= date("h:i:sa")."\n";
    $process= new Process('php /usr/share/nginx/WEBAPP/artisan schedule:run');
    $process->run();
    $ret.= $process->getOutput()."\n";
    $ret.= date("h:i:sa")."\n";
    $ret.= "//end cron\n\n";
    echo $ret;
} //end return special response if cron is called
else {
    echo "This is 'index.php' - It supports Laravel Pretty URLs: <b>{$_SERVER['REQUEST_URI']}</b>";
}
