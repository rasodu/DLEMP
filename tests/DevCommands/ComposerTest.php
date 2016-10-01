<?php

use Symfony\Component\Process\Process;

class ComposerTest extends TestCase
{

    /**
    *@group cmd
    */
    public function testComposerCommandworks()
    {
        $process = new Process('composer --version');
        $process->run();
        $output= $process->getOutput();

        $this->assertContains("Composer version", $output);
    }

    /**
    *@group cmd
    */
    public function testComposerCacheIsWritableByAllUsers()
    {
        $this->assertEquals(16895, fileperms('/.composer'), "Non root user will not be able to execute 'composer' command in cmd image.");
    }
}
