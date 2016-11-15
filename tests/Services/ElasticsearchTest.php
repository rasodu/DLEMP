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

    /**
    *@depends testInfo
    */
    public function testCreateIndex()
    {
        $params = [
            'index' => 'dlemp',
        ];
        if (!$this->elasticsearch->indices()->exists($params)) {
            $response= $this->elasticsearch->indices()->create($params);
            $this->assertTrue($response['acknowledged']);
        }
    }

    /**
    *@depends testCreateIndex
    */
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

        $this->AssertEquals(true, $response['created']);
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
        $this->AssertEquals(true, $response['_shards']['successful']);
    }

    /**
    *@depends testDeleteFromElasticsearch
    */
    public function testDeleteIndex()
    {
        $params = [
            'index' => 'dlemp',
        ];
        if ($this->elasticsearch->indices()->exists($params)) {
            $response= $this->elasticsearch->indices()->delete($params);
            $this->assertTrue($response['acknowledged']);
        }
    }
}
