<?php

class A81OPCacheTest extends TestCase
{
    /**
    *@group dev
    */
    public function testOPcacheDisableDuringDevlopment()
    {
        $this->assertFalse($this->isExtensionLoaded('Zend OPcache'));
    }

    /**
    *@group prod
    */
    public function testOPCacheEnableDuringProduction()
    {
        $this->assertTrue($this->isExtensionLoaded('Zend OPcache'));
    }
}
