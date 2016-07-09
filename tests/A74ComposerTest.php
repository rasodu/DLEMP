<?php

use Symfony\Component\Process\Process;

class A74LaravelInstallerTest extends TestCase
{

    public function testComposerCommandworks()
    {
        $process = new Process('/usr/local/bin/composer --version');
        $process->run();
        $output= $process->getOutput();

        $this->assertContains("Composer version", $output);
    }
}
