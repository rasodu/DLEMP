<?php

use Symfony\Component\Process\Process;

class A72PhpDocumentorTest extends TestCase
{

    public function testPhpdocIsInstalled()
    {
        $process = new Process('/DLEMP/tools/phpdoc/vendor/bin/phpdoc --version');
        $process->run();
        $output= $process->getOutput();

        $this->assertContains("phpDocumentor version", $output);
    }
}
