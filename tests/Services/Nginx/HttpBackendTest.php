<?php

class HttpBackendTest extends TestCase
{
    /**
    *@group dev
    */
    public function testServingWebsiteOverHttp()
    {
        $response= $this->getFullResponseFromURL('http://httpbackend/page1.htm');

        $this->assertContains('HTTP/1.1 200 OK', $response);
        $this->assertContains('<title>NGINX Test</title>', $response);
    }

    /**
    *@group dev
    */
    public function testDontSendNginxVersionNumberInHeader()
    {
        $response= $this->getFullResponseFromURL('http://httpbackend/');

        $this->assertNotContains('Server: nginx/', $response);
    }
}
