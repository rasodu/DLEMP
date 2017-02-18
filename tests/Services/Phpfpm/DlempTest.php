<?php

class DlempTest extends TestCase
{
    public function testCustomCommonSettings()
    {
        $this->assertSame('GPCS', ini_get('variables_order'));
        $this->assertSame('GP', ini_get('request_order'));
    }

    public function testDefaultTimeZone()
    {
        $this->assertSame('UTC', date_default_timezone_get(), 'Default display timezone is not UTC');

        $phpfpm_settings= $this->getPhpfpmIniSettings();
        $this->assertSame('UTC', $phpfpm_settings['date.timezone'], 'Default display timezone is not UTC');
    }

    /**
    *@group cmd
    */
    public function testCustomDevelopmentSettingsCli()
    {
        $this->assertSame(strval(E_ALL), ini_get('error_reporting'));
        $this->assertSame('1', ini_get('display_errors'));
        $this->assertSame('1', ini_get('display_startup_errors'));
    }

    /**
    *@group dev
    */
    public function testCustomDevelopmentSettingsPhpfpm()
    {
        $phpfpm_settings= $this->getPhpfpmIniSettings();
        $this->assertSame(strval(E_ALL), $phpfpm_settings['error_reporting']);
        $this->assertSame('1', $phpfpm_settings['display_errors']);
        $this->assertSame('1', $phpfpm_settings['display_startup_errors']);
    }

    /**
    *@group prod
    */
    public function testProductionSettings()
    {
        $phpfpm_settings= $this->getPhpfpmIniSettings();
        $this->assertSame(strval(E_ALL - E_DEPRECATED - E_STRICT), $phpfpm_settings['error_reporting']);
        $this->assertSame('', $phpfpm_settings['display_errors']);
        $this->assertSame('', $phpfpm_settings['display_startup_errors']);
    }

    public function testExtensionCurl()
    {
        $this->assertSame(
            true,
            $this->isExtensionLoaded('curl'),
            "Curl not installed. A lot of unittest will be skipped."
        );
    }

    public function testAccessLogIsOff()
    {
        $this->markTestIncomplete(
            'Test that access log is off: access.log = /dev/null'
        );
    }
}
