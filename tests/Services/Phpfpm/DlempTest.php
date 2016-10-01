<?php

class DlempTest extends TestCase
{
    public function testCustomCommonSettings()
    {
        $this->assertSame('GPCS', ini_get('variables_order'));
        $this->assertSame('GP', ini_get('request_order'));
    }

    /**
    *@group dev
    */
    public function testCustomDevelopmentSettings()
    {
        $this->assertSame(strval(E_ALL), ini_get('error_reporting'));
        $this->assertSame('1', ini_get('display_errors'));
        $this->assertSame('1', ini_get('display_startup_errors'));
    }

    /**
    *@group prod
    */
    public function testProductionSettings()
    {
        $this->assertSame(strval(E_ALL - E_DEPRECATED - E_STRICT), ini_get('error_reporting'));
        $this->assertSame('', ini_get('display_errors'));
        $this->assertSame('', ini_get('display_startup_errors'));
    }

    public function testExtensionCurl()
    {
        $this->assertSame(
            true,
            $this->isExtensionLoaded('curl'),
            "Curl not installed. A lot of unittest will be skipped."
        );
    }
}
