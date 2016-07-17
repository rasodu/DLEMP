<?php

use Symfony\Component\Process\Process;

class A73LaravelInstallerTest extends TestCase
{

    /**
    *@group cmd
    */
    public function testLaravelCommandworks()
    {
        $process = new Process('~/.composer/vendor/bin/laravel --version');
        $process->run();
        $output= $process->getOutput();

        $this->assertContains("Laravel Installer version", $output);
    }
}
