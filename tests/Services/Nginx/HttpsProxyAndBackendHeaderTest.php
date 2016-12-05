<?php

class HttpsProxyAndBackendHeaderTest extends TestCase
{
    private $server_var_https= null;
    private $server_var_httpbackend= null;

    private $custom_http_header_key= 'X-CUSTOM-HEADER-KEY';//Custom HTTP header must start with 'X-' and use '-' instead of '_'
    private $custom_http_header_value= 'custom header value';
    private $custom_http_header_key_server= 'HTTP_X_CUSTOM_HEADER_KEY';

    public function setUp()
    {
        $custom_http_headers= [
            "{$this->custom_http_header_key}: $this->custom_http_header_value",
        ];
        $this->server_var_https= json_decode($this->getFullResponseFromURL('https://nginxhttps/test_server_8_load_balancer.php', false, $custom_http_headers), true);
        $this->server_var_httpbackend= json_decode($this->getFullResponseFromURL('https://httpbackend/test_server_8_load_balancer.php', false, $custom_http_headers), true);
    }

    public function testProxyIsForwardingAdditionalHeadersToBackend()
    {
        $this->assertEquals($this->server_var_https[$this->custom_http_header_key_server], $this->custom_http_header_value);
        $this->assertEquals($this->server_var_httpbackend[$this->custom_http_header_key_server], $this->custom_http_header_value);
    }

    public function testMakeSureThatXForwardHeaderAreSet()
    {
        $this->assertEquals($this->server_var_https['HTTP_X_FORWARDED_FOR'], getHostByName(getHostName()));
        $this->assertEquals($this->server_var_https['HTTP_X_FORWARDED_PROTO'], 'https');
        $this->assertEquals($this->server_var_https['HTTP_X_FORWARDED_PORT'], '443');
    }

    public function testCorrectHostNameSetForProxyRequest()
    {
        $this->assertEquals($this->server_var_https['HTTP_HOST'], 'nginxhttps');
        $this->assertEquals($this->server_var_httpbackend['HTTP_HOST'], 'httpbackend');
    }

    public function testProxyResquestAreReportedAsHttps()
    {
        $this->assertEquals($this->server_var_https['HTTPS'], 'on');
        //$this->assertEquals($this->server_var_https['HTTPS'], 'on');
    }

    public function testProxyRedirectionIsOff()
    {
        $this->assertContains('https://webapp.dev/', $this->getFullResponseFromURL('https://nginxhttps/test_server_8_load_redirect.php'));
    }
}
