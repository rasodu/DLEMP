<?php

use Symfony\Component\Process\Process;

class A71PhpcsAndPhpcbfTest extends TestCase
{
    /**
    *@group cmd
    */
    public function testDefaultStandardForPhpcs()
    {
        $process = new Process('phpcs --config-show standard');
        $process->run();
        $output= $process->getOutput();

        $this->assertEquals("default_standard: PSR2\n", $output);
    }

    /**
    *@group cmd
    */
    public function testDefaultStandardForPhpcbf()
    {
        $process = new Process('phpcbf --config-show standard');
        $process->run();
        $output= $process->getOutput();

        $this->assertEquals("default_standard: PSR2\n", $output);
    }
}
