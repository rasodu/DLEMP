<?php

class A82XdebugTest extends TestCase
{
    /**
    *@group dev
    */
    public function testXdebugEnableDuringDevlopment()
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

    /**
    *@group prod
    */
    public function testXdebugDisableDuringProduction()
    {
        $this->assertFalse($this->isExtensionLoaded('xdebug'));
    }
}
