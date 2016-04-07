<?php

class A52SocketTest extends TestCase
{

    private $channel_name= 'unittest-channel';
    private $event_name= 'MyEvent';
    private $sent_data= null;

    private $client= null;


    public function setUp()
    {
        if (!class_exists('Predis\Client')) {
            $this->markTestSkipped('predis/predis package is not available. Probably this means socket.io is not setup.');
        }
    }

    public function testSubscribeSockerIOChannel()
    {
    }

    /**
    *@depends testSubscribeSockerIOChannel
    */
    public function testEmitSocketIOMessage()
    {
        $this->sent_data= 'Random string:'.rand();

        $redis= new Predis\Client('tcp://redis:6379');

        $publish= json_encode([
            'event' => $this->event_name
            ,'data' => $this->sent_data
        ]);

        $result= $redis->publish($this->channel_name, $publish);

        $this->assertSame(1, $result);
    }

    /**
    *@depends testEmitSocketIOMessage
    */
    public function testReadMessageFromChannel()
    {
    }
}
