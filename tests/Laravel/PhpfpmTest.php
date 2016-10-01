<?php

class PhpfpmTest extends TestCase
{
    public function testPhpVersionRequiredByLaravel()
    {
        $laravel_minimum_php_version= '5.6.4';
        $installed_version= phpversion();

        $this->assertSame(
            true,
            version_compare($laravel_minimum_php_version, $installed_version, '<='),
            "Laravel requires minimym php version $laravel_minimum_php_version. Currently installed version is $installed_version."
        );
    }
    public function testExtensionOpenSSL()
    {
        $this->assertSame(
            true,
            $this->isExtensionLoaded('openssl'),
            'OpenSSL is not intalled. OpenSSL is required by Laravel.'
        );
    }

    public function testPDO()
    {
        $this->assertSame(
            true,
            $this->isExtensionLoaded('PDO'),
            "PDO is not installed. PDO is required by Laravel."
        );
    }

    public function testPDOMYSQL()
    {
        $this->assertSame(
            true,
            $this->isExtensionLoaded('pdo_mysql'),
            "PDO_MYSQL is not installed. PDO_MYSQL is optional. But if you want to use MySQL in your app, then it is required."
        );
    }

    public function testMbstring()
    {
        $this->assertSame(
            true,
            $this->isExtensionLoaded('mbstring'),
            "Mbstring is not installed. Mbstring is required by Laravel."
        );
    }

    public function testTokenizer()
    {
        $this->assertSame(
            true,
            $this->isExtensionLoaded('tokenizer'),
            "Tokenizer is not installed. Tokenizer is required by Laravel."
        );
    }


    public function testXml()
    {
        $this->assertSame(
            true,
            $this->isExtensionLoaded('xml'),
            "XML is not installed. XML is required by Laravel."
        );
    }

    public function testPcntl()
    {
        $this->assertSame(
            true,
            $this->isExtensionLoaded('pcntl'),
            "Pcntl is not installed. Pcntl is required if you want to set timeout in queue worker."
        );
    }

    public function testMcrypt()
    {
        $this->assertSame(
            true,
            $this->isExtensionLoaded('mcrypt'),
            "Mcrypt is not installed. Mcrypt is optional. But installing Mcrypt will make Laravel faster."
        );
    }

    public function testMemcached()
    {
        $this->assertSame(
            true,
            $this->isExtensionLoaded('memcached'),
            "Memcached is not installed. Memcached is optional. But if you want to use Memcached for caching or session, then it must be installed."
        );
    }

    public function testZip()
    {
        $this->assertSame(
            true,
            $this->isExtensionLoaded('zip'),
            "Zip is not installed. Zip is optional. But without zip you will not be able to use laravel installer."
        );
    }
}
