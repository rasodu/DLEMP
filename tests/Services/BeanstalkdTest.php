<?php

class BeanstalkdTest extends TestCase
{

    private $pheanstalk;
    private $test_payload= 'job payload goes here';
    public function setUp()
    {
        if (!class_exists('Pheanstalk\Pheanstalk')) {
            $this->markTestSkipped('pda/pheanstalk package is not available.');
        }
        $this->pheanstalk= new Pheanstalk\Pheanstalk('beanstalkd');
    }

    public function testIsServiceListening()
    {
        $result= $this->pheanstalk->getConnection()->isServiceListening();
        $this->assertSame(true, $result);
    }

    /**
    *@depends testIsServiceListening
    */
    public function testPushToQueue()
    {
        $result= $this->pheanstalk->useTube('testtube')
            ->put($this->test_payload);
    }

    /**
    *@depends testPushToQueue
    */
    public function testPopFromQueue()
    {
        $job = $this->pheanstalk->watch('testtube')
            ->ignore('default')
            ->reserve();

        $result= $job->getData();
        $this->assertSame($this->test_payload, $result);

        $this->pheanstalk->delete($job);
    }
}
