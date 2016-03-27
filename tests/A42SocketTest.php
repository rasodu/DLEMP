<?php

class A42SocketTest extends TestCase{

    private $channel_name= 'unittest-channel';
    private $event_name= 'MyEvent';
    private $sent_data= NULL;

    private $client= NULL;
    public function testSubscribeSockerIOChannel(){
    }

    /**
    *@depends testSubscribeSockerIOChannel
    */
    public function testEmitSocketIOMessage(){
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
    public function testReadMessageFromChannel(){
    }
}
