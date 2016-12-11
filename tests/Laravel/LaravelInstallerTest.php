<?php

use Symfony\Component\Process\Process;

class LaravelInstallerTest extends TestCase
{

    /**
    *@group cmd
    */
    public function testLaravelCommandworks()
    {
        $process = new Process('/root/.composer/vendor/bin/laravel --version');
        $process->run();
        $output= $process->getOutput();

        $this->assertContains("Laravel Installer", $output);
    }
}
