<?php

use Symfony\Component\Process\Process;

class PhpDocumentorTest extends TestCase
{

    /**
    *@group cmd
    */
    public function testPhpdocIsInstalled()
    {
        $process = new Process('phpdoc --version');
        $process->run();
        $output= $process->getOutput();

        $this->assertContains("phpDocumentor version", $output);
    }
}
