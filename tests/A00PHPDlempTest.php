<?php

class A00PHPDlempTest extends TestCase
{
    public function testCustomProductionSettings(){
        $this->assertSame('GPCS', ini_get('variables_order'));
        $this->assertSame('GP', ini_get('request_order'));
    }

    public function testCustomDevelopmentSettings(){
        $this->assertSame(strval(E_ALL), ini_get('error_reporting'));
        $this->assertSame('1', ini_get('display_errors'));
        $this->assertSame('1', ini_get('display_startup_errors'));
    }

    public function testExtensionCurl()
    {
        $this->assertSame(
            true,
            $this->isExtensionLoaded('curl'),
            "Curl not installed. A lot of unittest will be skipped."
        );
    }

    public function testExtensionXdebug()
    {
        $this->assertSame(
            true,
            $this->isExtensionLoaded('xdebug'),
            "Xdebug is not installed. You will not be able to generate PHPUnit code coverage report."
        );

        $this->assertSame('1', ini_get('xdebug.remote_enable'));
        $this->assertSame('1', ini_get('xdebug.remote_connect_back'));
        $this->assertSame('9000', ini_get('xdebug.remote_port'));
        $this->assertSame('dbgp', ini_get('xdebug.remote_handler'));
        $this->assertSame('req', ini_get('xdebug.remote_mode'));
        $this->assertSame('1', ini_get('xdebug.cli_color'));
        $this->assertSame('2', ini_get('xdebug.overload_var_dump'));
    }
}
