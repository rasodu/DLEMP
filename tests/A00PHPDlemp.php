<?php

class A00PHPDlemp extends TestCase
{

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
    }
}
