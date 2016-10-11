<?php

use Elasticsearch\ClientBuilder;

class ElasticsearchTest extends TestCase
{
    private $elasticsearch= null;

    public function setUp()
    {
        //build elasticsearch client
        $hosts = [
            [
                'host' => 'elasticsearch',
                'port' => '9200',
            ],
        ];
        $this->elasticsearch= ClientBuilder::create()
            ->setHosts($hosts)
            ->build();
    }

    public function testInfo()
    {
        $info= $this->elasticsearch->info();
        $this->assertTrue(isset($info['version']['lucene_version']));
    }

    public function testWrtieToElasticsearch()
    {
        $params = [
            'index' => 'dlemp',
            'type' => 'contacts',
            'id' => 'aamin',
            'body' => [
                'first_name' => 'Abhijit',
                'last_name' => 'Amin',
                'email' => 'aamin@example.com',
            ],
        ];

        $response = $this->elasticsearch->index($params);
        $this->AssertEquals('created', $response['result']);
    }

    /**
    *@depends testWrtieToElasticsearch
    */
    public function testReadFromElasticsearch()
    {
        $params = [
            'index' => 'dlemp',
            'type' => 'contacts',
            'id' => 'aamin',
        ];

        $response = $this->elasticsearch->get($params);
        $this->AssertEquals('aamin@example.com', $response['_source']['email']);
    }

    /**
    *@depends testWrtieToElasticsearch
    */
    public function testDeleteFromElasticsearch()
    {
        $params = [
            'index' => 'dlemp',
            'type' => 'contacts',
            'id' => 'aamin',
        ];

        $response = $this->elasticsearch->delete($params);
        $this->AssertEquals('deleted', $response['result']);
    }
}
