<?php

class A11HttpTest extends TestCase
{

    public function testHttpRedirectToHttps()
    {
        $response= $this->getFullResponseFromURL('http://nginxhttp/');

        $this->assertContains('HTTP/1.1 301 Moved Permanently', $response);
        $this->assertContains('Location: https://nginxhttp/', $response);
    }

    /**
    *Make sure the acme-challenge directory is served over http and requester is not redirected to https.
    */
    public function testServingLetsencryptAcmeChallenge()
    {
        $response= $this->getFullResponseFromURL('http://nginxhttp/.well-known/acme-challenge/');

        $this->assertContains('HTTP/1.1 404 Not Found', $response);
    }
}
