<?php

class A21HttpsTest extends TestCase{

    //curl https://nginxhttps/page1.htm --insecure
    public function testServingHtmlFile(){
        $response= $this->getFullResponseFromURL('https://nginxhttps/page1.htm');

        $this->assertContains('HTTP/1.1 200 OK', $response);
        $this->assertContains('<title>NGINX Test</title>', $response);
    }

    public function testServingPHPFile(){
        $response= $this->getFullResponseFromURL('https://nginxhttps/page2.php');

        $this->assertContains('HTTP/1.1 200 OK', $response);
        $this->assertContains('<title>phpinfo()</title>', $response);
    }
}
