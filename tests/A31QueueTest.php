<?php

class A31QueueTest extends TestCase{

    private $pheanstalk;
    private $test_payload= 'job payload goes here';
    public function setUp(){
        $this->pheanstalk= new Pheanstalk\Pheanstalk('beanstalkd');
    }

    public function testIsServiceListening(){
        $result= $this->pheanstalk->getConnection()->isServiceListening();
        $this->assertSame(true, $result);
    }

    /**
    *@depends testIsServiceListening
    */
    public function testPushToQueue(){
        $result= $this->pheanstalk->useTube('testtube')
            ->put($this->test_payload);
    }

    /**
    *@depends testPushToQueue
    */
    public function testPopFromQueue(){
        $job = $this->pheanstalk->watch('testtube')
            ->ignore('default')
            ->reserve();

        $result= $job->getData();
        $this->assertSame($this->test_payload, $result);

        $this->pheanstalk->delete($job);
    }
}
