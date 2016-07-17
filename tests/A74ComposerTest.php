<?php

use Symfony\Component\Process\Process;

class A74LaravelInstallerTest extends TestCase
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
}
