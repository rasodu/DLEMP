<?php

class HttpsTest extends TestCase
{
    public function testResponseFromServerIsHTTP2()
    {
        //Add test to check that the response is HTTP2
    }

    public function testResponseFromServerIsEncodedWithGzip()
    {
        $response= $this->getFullResponseFromURL('https://https/page2.php');

        $this->assertContains('Content-Encoding: gzip', $response);
    }

    //curl --http2 https://https/page1.htm --insecure
    public function testServingHtmlFile()
    {
        $response= $this->getFullResponseFromURL('https://https/page1.htm');

        $this->assertContains('HTTP/1.1 200 OK', $response);
        $this->assertContains('<title>NGINX Test</title>', $response);
    }

    public function testServingPHPFile()
    {
        $response= $this->getFullResponseFromURL('https://https/page2.php');

        $this->assertContains('HTTP/1.1 200 OK', $response);
        $this->assertContains('<title>phpinfo()</title>', $response);
    }

    public function testDontSendXPoweredByHeader()
    {
        $response= $this->getFullResponseFromURL('https://https/page2.php');

        $this->assertNotContains('X-Powered-By:', $response, "x-powered-by header is sent by server. This will expose php version that is installed on your server.");
    }

    public function testDontSendNginxVersionNumberInHeader()
    {
        $response= $this->getFullResponseFromURL('https://https/page1.htm');

        $this->assertNotContains('Server: nginx/', $response);
    }

    public function testSendPrecompressedGzipFiles()
    {
        $response= $this->getFullResponseFromURL('https://https/css/app.css');

        $this->assertContains('/*compressed file*/', $response);
    }
}
