<?php

class A31MemcachedTest extends TestCase{

    private $memcached= NULL;
    private $key= 'user';
    private $value= 'aamin';
    public function setUp(){
        if(!$this->isExtensionLoaded('memcached')){
            $this->markTestSkipped('Memcached extension is not available.');
        }

        $this->memcached= new Memcached();
        $this->memcached->addServer("memcached", 11211);
    }

    public function testWriteToMemcached(){
        $result= $this->memcached->set($this->key, $this->value);
        $this->assertSame(true, $result);
    }

    /**
    *@depends testWriteToMemcached
    */
    public function testReadFromMemcached(){
        $result= $this->memcached->get($this->key);
        $this->assertEquals($this->value, $result);
    }

    /**
    *@depends testReadFromMemcached
    */
    public function testDeleteFromMemcached(){
        $result= $this->memcached->delete($this->key);
        $this->assertSame(true, $result);

        $result= $this->memcached->get($this->key);
        $this->assertEquals(false, $result);
    }
}
