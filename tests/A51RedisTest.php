<?php

class A51RedisTest extends TestCase{

    private $redis= NULL;
    private $key= 'user';
    private $value= 'aamin';
    public function setUp(){
        if(!class_exists('Predis\Client')){
            $this->markTestSkipped('predis/predis package is not available.');
        }
        $this->redis= new Predis\Client('tcp://redis:6379');
    }

    public function testWriteToRedis(){
        $result= $this->redis->set($this->key, $this->value);
        $result= new SebastianBergmann\PeekAndPoke\Proxy($result);
        $this->assertEquals("OK", $result->payload);
    }

    /**
    *@depends testWriteToRedis
    */
    public function testReadFromRedis(){
        $result= $this->redis->get($this->key);
        $this->assertEquals($this->value, $result);
    }

    /**
    *@depends testReadFromRedis
    */
    public function testDeleteFromRedis(){
        $result= $this->redis->del($this->key);
        $this->assertSame(1, $result);

        $result= $this->redis->get($this->key);
        $this->assertSame(NULL, $result);
    }
}
