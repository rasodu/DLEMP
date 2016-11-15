<?php

//start init $pheanstalk instance
require __DIR__.'/../vendor/autoload.php';
$pheanstalk= new Pheanstalk\Pheanstalk('beanstalkd');
//end init $pheanstalk instance

if ($pheanstalk->getConnection()->isServiceListening() === false) {
    print("Error: Cannot connect to beanstalkd.");
} else {
    print("Connected to beanstalkd.<br/><br/>");

    //start add job to queue
    $job_data= "Current timestamp: ".time();
    $pheanstalk
        ->useTube('testqueue')
        ->put($job_data);
    //end add job to queue

    print("Job sent data => <b>$job_data</b>");
}
