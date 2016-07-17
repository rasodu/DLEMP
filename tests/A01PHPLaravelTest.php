<?php

/**
*At this point all Laravel checks are made for Laravel version 5.1
*/
class A01PHPLaravelTest extends TestCase
{

    public function testPhpVersionRequiredByLaravel()
    {
        $laravel_minimum_php_version= '5.5.9';
        $installed_version= phpversion();

        $this->assertSame(
            true,
            version_compare($laravel_minimum_php_version, $installed_version, '<='),
            "Laravel requires minimym php version $laravel_minimum_php_version. Currently installed version is $installed_version."
        );
    }

    public function testPrettyURLsEnabled()
    {
        $result= $this->getFullResponseFromURL('https://nginxhttps/random-dir/page1?example=value');

        $this->assertContains(
            'HTTP/1.1 200 OK',
            $result
        );
        $this->assertContains(
            "This is 'index.php' - It supports Laravel Pretty URLs: <b>/random-dir/page1?example=value</b>",
            $result
        );
    }

    /**
    *@group dev
    */
    public function testStaticStorageFilesServedDuringDevelopment()
    {
        $result= $this->getFullResponseFromURL('https://nginxhttps/storage/static_file.txt');

        $this->assertContains(
            'Text in static file.',
            $result
        );
    }

    /**
    *@group prod
    */
    public function testStaticStorageFilesShouldntBeCopiedToProductionVolume()
    {
        $result= $this->getFullResponseFromURL('https://nginxhttps/storage/static_file.txt');

        $this->assertContains('HTTP/1.1 404 Not Found', $result);
    }

    public function testStaticStorageNewFileIsServed()
    {
        $file_name= 'static_file9876.txt';
        $file_folder= '/usr/share/nginx/WEBAPP/storage/app/public/';
        $file_path= $file_folder.$file_name;
        $file_content= 'Text in static file.';

        //create files for test
        $delete_folder= false;
        if (!file_exists($file_folder)) {
            $delete_folder= true;
            mkdir($file_folder);
        }
        file_put_contents($file_path, $file_content);
        //end files for test

        $result= $this->getFullResponseFromURL('https://nginxhttps/storage/'.$file_name);

        //start remove files created for test
        unlink($file_path);
        if ($delete_folder) {
            rmdir($file_folder);
        }
        //end remove files created for test

        $this->assertContains(
            $file_content,
            $result
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
