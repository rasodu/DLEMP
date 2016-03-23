<?php

//start init $pheanstalk instance
require __DIR__.'/../vendor/autoload.php';
$pheanstalk= new Pheanstalk\Pheanstalk('beanstalkd');
//end init $pheanstalk instance

if( $pheanstalk->getConnection()->isServiceListening() === false){
    print("Error: Cannot connect to beanstalkd.");
}
else{
    print("Connected to beanstalkd.<br/><br/>");

    //start add job to queue
    $pheanstalk
        ->useTube('testtube')
        ->put("job payload goes here\n");
    //end add job to queue

    //start read and delete job from the queue
    $job = $pheanstalk
        ->watch('testtube')
        ->ignore('default')
        ->reserve();

    echo "Job data beanstalkd: <b>".$job->getData()."</b>";

    $pheanstalk->delete($job);
    //start read and delete job from the queue
}
