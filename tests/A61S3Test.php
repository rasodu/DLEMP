<?php

//https://github.com/laravel/framework/blob/5.2/src/Illuminate/Filesystem/FilesystemAdapter.php
//https://github.com/thephpleague/flysystem-aws-s3-v3/tree/1.0.10

//http://docs.aws.amazon.com/AmazonS3/latest/dev/UsingBucket.html

//http://docs.aws.amazon.com/aws-sdk-php/v3/api/class-Aws.S3.S3Client.html#___construct
//http://docs.aws.amazon.com/aws-sdk-php/v3/api/class-Aws.AwsClient.html#___construct

use Aws\S3\S3Client;
use League\Flysystem\AwsS3v3\AwsS3Adapter;
use League\Flysystem\Filesystem;
use Illuminate\Filesystem\FilesystemAdapter;

use Illuminate\Contracts\Filesystem\Filesystem as FilesystemContract;

class A61S3Test extends TestCase
{
    private $end_point= 'http://webapp.dev:4569';
    private $bucket_region= 'us-east-1';
    private $bucket_name= 'unittestbucket';
    private $root_folder_in_bucket= 'news';
    private $bucket_file_path= 'example_notes.txt';
    private $bucket_file_content= 'Content inside the file(Randon: dfkjha89yhdkjfrhwe8)';

    public function testCreateBucket()
    {
        //start create S3 client
        $client= new S3Client(
            [
                'credentials' => [
                  'key'    => 'AKIAIOSFODNN7EXAMPLE',
                  'secret' => 'wJalrXUtnFEMI/K7MDENG/bPxRfiCYEXAMPLEKEY'
                ],
                'region' => $this->bucket_region,
                'version' => 'latest',

                'endpoint' => $this->end_point,
                'scheme' => 'http',
                //'bucket_endpoint' => true, //<= This may not be required. Because this is used for CNAME type bucket.
            ]
        );
        //end create S3 client

        //start create bucket
        $client->createBucket(
            [
            'ACL' => 'private',
            'Bucket' => $this->bucket_name,
            'CreateBucketConfiguration' => [
              'LocationConstraint' => $this->bucket_region,
            ],
            ]
        );
        //end create bucket

        return $client;
    }

    /**
    *@depends testCreateBucket
    */
    public function testPutFile($s3_client)
    {
        //start create laravel filesystem adapter
        $cloud_adapter= new AwsS3Adapter($s3_client, $this->bucket_name, $this->root_folder_in_bucket);
        $filesystem= new Filesystem($cloud_adapter);
        $laravel_filesystem_adapter= new FilesystemAdapter($filesystem);
        //end create laravel filesystem adapter

        //start pul file
        $laravel_filesystem_adapter->put(
            $this->bucket_file_path,
            $this->bucket_file_content,
            FilesystemContract::VISIBILITY_PUBLIC //Currently this option has no effect on FakeS3
        );
        //end put file

        //start check file exists
        $this->assertTrue($laravel_filesystem_adapter->exists($this->bucket_file_path));
        //end check file exists

        //start check contect of file
        $this->assertEquals(
            $this->bucket_file_content,
            $laravel_filesystem_adapter->get($this->bucket_file_path)
        );
        //end check contect of file

        return $laravel_filesystem_adapter;
    }

    /**
    *@depends testPutFile
    */
    public function testGetURL($laravel_filesystem_adapter)
    {
        $url= $laravel_filesystem_adapter->url($this->bucket_file_path);

        $response= $this->getFullResponseFromURL($url);
        $this->assertContains($this->bucket_file_content, $response);
    }

    /**
    *@depends testPutFile
    */
    public function testDeleteFile($laravel_filesystem_adapter)
    {
        //start delete file
        $laravel_filesystem_adapter->delete($this->bucket_file_path);
        //end delete file

        //start check file exists
        $this->assertFalse($laravel_filesystem_adapter->exists($this->bucket_file_path));
        //end check file exists
    }

    /**
    *@depends testCreateBucket
    */
    public function testDeleteBucket($s3_client)
    {
        $result= $s3_client->deleteBucket(
            [
            'Bucket' => $this->bucket_name,
            ]
        );
    }
}
