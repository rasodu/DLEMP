<?php

use Symfony\Component\Process\Process;

class A71PhpcsAndPhpcbfTest extends TestCase
{
    public function testDefaultStandardForPhpcs()
    {
        $process = new Process('/usr/local/bin/phpcs --config-show standard');
        $process->run();
        $output= $process->getOutput();

        $this->assertEquals("default_standard: PSR2\n", $output);
    }

    public function testDefaultStandardForPhpcbf()
    {
        $process = new Process('/usr/local/bin/phpcbf --config-show standard');
        $process->run();
        $output= $process->getOutput();

        $this->assertEquals("default_standard: PSR2\n", $output);
    }
}
