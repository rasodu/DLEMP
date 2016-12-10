<?php

/**
*At this point all Laravel checks are made for Laravel version 5.1
*/
class NginxTest extends TestCase
{
    public function testPrettyURLsEnabled()
    {
        $result= $this->getFullResponseFromURL('https://https/random-dir/page1?example=value');

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
        $result= $this->getFullResponseFromURL('https://https/storage/static_file.txt');

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
        $result= $this->getFullResponseFromURL('https://https/storage/static_file.txt');

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

        $result= $this->getFullResponseFromURL('https://https/storage/'.$file_name);

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
}
