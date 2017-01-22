<?php

class NodeJSTest extends TestCase
{
    /**
    *@group dev
    */
    public function testCanServePageOverHttp()
    {
        $response= $this->getFullResponseFromURL('http://nodejs:8080/');
        $this->assertContains('Hello World', $response);
    }

    public function testCanServePageOverHttps()
    {
        $response= $this->getFullResponseFromURL('https://https:8080/');
        $this->assertContains('Hello World', $response);
    }
}
