<?php

use Symfony\Component\Process\Process;

class NodeAndNpmTest extends TestCase
{
    /**
    *@group cmd
    */
    public function testNodeIsInstalled()
    {
        $process= new Process('node --help');
        $process->run();
        $output= $process->getOutput();

        $this->assertContains('node', $output);
    }

    /**
    *@group cmd
    */
    public function testNpmIsInstalled()
    {
        $process= new Process('npm --help');
        $process->run();
        $output= $process->getOutput();

        $this->assertContains('npm@', $output);
    }

    /**
    *@group cmd
    */
    public function testNpmCacheIsWritableByAllUsrs()
    {
        $this->assertEquals(16895, fileperms('/.npm'), "Non root user will not be able to execute 'npm' command in cmd image.");
    }
}
