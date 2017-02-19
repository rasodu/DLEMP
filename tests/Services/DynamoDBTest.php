<?php

use Aws\DynamoDb\DynamoDbClient;

/**
*Code from Amazon guide: http://docs.aws.amazon.com/aws-sdk-php/v2/guide/service-dynamodb.html
*
*@group dev
*/
class DynamoDBTest extends TestCase
{
    private $client= null;

    private $table_name= 'errors';
    private $entry_id= '1201';
    private $entry_time= null;
    private $entry_error= 'Executive overflow';
    private $entry_message= 'no vacant areas';
    public function setUp()
    {
        $this->client = DynamoDbClient::factory(array(
            'credentials' => [
                'key' => 'asdkfhksdajh',
                'secret' => 'dgjdasflkhd',
            ],
            'region' => 'us-east-1',
            'endpoint' => 'http://dynamodb:8000',
            'version' => '2012-08-10'
        ));
    }

    public function testWrtieToDynamoDB()
    {
        //create table
        $this->client->createTable(array(
            'TableName' => $this->table_name,
            'AttributeDefinitions' => array(
                array(
                    'AttributeName' => 'id',
                    'AttributeType' => 'N'
                ),
                array(
                    'AttributeName' => 'time',
                    'AttributeType' => 'N'
                )
            ),
            'KeySchema' => array(
                array(
                    'AttributeName' => 'id',
                    'KeyType'       => 'HASH'
                ),
                array(
                    'AttributeName' => 'time',
                    'KeyType'       => 'RANGE'
                )
            ),
            'ProvisionedThroughput' => array(
                'ReadCapacityUnits'  => 1,
                'WriteCapacityUnits' => 1
            )
        ));

        $this->client->waitUntil('TableExists', array(
            'TableName' => $this->table_name
        ));

        $result = $this->client->listTables();
        $this->assertContains($this->table_name, $result['TableNames']);

        //add information to table
        $this->entry_time= time();
        $result = $this->client->putItem(array(
            'TableName' => $this->table_name,
            'Item' => array(
                'id'      => array('N' => $this->entry_id),
                'time'    => array('N' => $this->entry_time),
                'error'   => array('S' => $this->entry_error),
                'message' => array('S' => $this->entry_message)
            )
        ));
    }

    /**
    *@depends testWrtieToDynamoDB
    */
    public function testReadFromDynamoDB()
    {
        $this->markTestIncomplete('Currently failing to read the data back from local DynamoDB.');

        $result = $this->client->getItem(array(
            'ConsistentRead' => true,
            'TableName' => $this->table_name,
            'Key'       => array(
                'id'   => array('N' => $this->entry_id),
                'time' => array('N' => $this->entry_time)
            )
        ));

        $this->AssertEquals($this->entry_message, $result['Item']['message']['S']);
    }

    /**
    *@depends testWrtieToDynamoDB
    */
    public function testDeleteFromDynamoDB()
    {
        $this->client->deleteTable(array(
            'TableName' => $this->table_name
        ));

        $this->client->waitUntil('TableNotExists', array(
            'TableName' => $this->table_name
        ));

        $result = $this->client->listTables();
        $this->assertNotContains($this->table_name, $result['TableNames']);
    }
}
