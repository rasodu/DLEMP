<?php
require __DIR__.'/../vendor/autoload.php';

use Aws\S3\S3Client;
use League\Flysystem\AwsS3v3\AwsS3Adapter;
use League\Flysystem\Filesystem;
use Illuminate\Filesystem\FilesystemAdapter;

//start define settings
$end_point= 'http://webapp.dev:4569';
$bucket_region= 'us-east-1';
$bucket_name= 'dslkgslakgjiorukj';
$file_path= 'test.jpg';
//end define settings

//start create S3 client
$s3_client= new S3Client(
    [
        'credentials' => [
            'key'    => 'AKIAIOSFODNN7EXAMPLE',
            'secret' => 'wJalrXUtnFEMI/K7MDENG/bPxRfiCYEXAMPLEKEY'
        ],
        'region' => $bucket_region,
        'version' => 'latest',

        'endpoint' => $end_point,
        'scheme' => 'http',
        //'bucket_endpoint' => true, //<= This may not be required. Because this is used for CNAME type bucket.
    ]
);
//end create S3 client

//start create bucket
$s3_client->createBucket(
    [
        'ACL' => 'private',
        'Bucket' => $bucket_name,
        'CreateBucketConfiguration' => [
            'LocationConstraint' => $bucket_region,
        ],
    ]
);
//end create bucket

//start create laravel filesystem adapter
$cloud_adapter= new AwsS3Adapter($s3_client, $bucket_name);
$filesystem= new Filesystem($cloud_adapter);
$disk= new FilesystemAdapter($filesystem);
//end create laravel filesystem adapter

//start put file on disk
if (!$disk->exists($file_path)) {
    $disk->put($file_path, file_get_contents('../resources/assets/img/test.jpg'));
}
//start put file on disk



print("<img src='".$disk->url($file_path)."'/>");
