<?php

class HttpTest extends TestCase
{
    /**
    *@group prod
    */
    public function testHttpRedirectToHttps()
    {
        $response= $this->getFullResponseFromURL('http://http/');

        $this->assertContains('HTTP/1.1 301 Moved Permanently', $response);
        $this->assertContains('Location: https://http/', $response);
    }
    /**
    *@group prod
    *
    *Make sure the acme-challenge directory is served over http and requester is not redirected to https.
    */
    public function testServingLetsencryptAcmeChallenge()
    {
        $response= $this->getFullResponseFromURL('http://http/.well-known/acme-challenge/');

        $this->assertContains('HTTP/1.1 404 Not Found', $response);
    }

    /**
    *@group prod
    */
    public function testDontSendNginxVersionNumberInHeader()
    {
        $response= $this->getFullResponseFromURL('http://http/');

        $this->assertNotContains('Server: nginx/', $response);
    }
}
