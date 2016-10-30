<?php

class ExecutionTimeTest extends TestCase
{

    /**
    *@group dev
    */
    public function testCustomDevelopmentSettings()
    {
        $phpfpm_settings= $this->getPhpfpmIniSettings();
        $this->assertSame('600', $phpfpm_settings['max_execution_time']);
    }

    /**
    *@group prod
    */
    public function testProductionSettings()
    {
        $phpfpm_settings= $this->getPhpfpmIniSettings();
        $this->assertSame('60', $phpfpm_settings['max_execution_time']);
    }
}
