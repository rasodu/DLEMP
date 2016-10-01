<?php

class MySqlTest extends TestCase
{
    private $mysql= null;
    private $email= 'example@example.com';
    private $first_name= 'Abhijit';
    private $last_name= 'Amin';
    private $user_id= null;
    public function setUp()
    {
        if (!$this->isExtensionLoaded('mysqlnd')) {
            $this->markTestSkipped('MySQL Native Driver are not installed. PDO_MySQL and mysqli may not work correctly.');
        }

        if (!$this->isExtensionLoaded('pdo_mysql')) {
            $this->markTestSkipped('PDO_MySQL is not installed.');
        }

        if (!$this->isExtensionLoaded('sqlite3')) {
            $this->markTestSkipped('mysqli is not installed.');
        }

        $this->mysql= new PDO("mysql:host=mysql;dbname=homestead", 'homestead', 'secret');
        $this->mysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function testWrtieToMySql()
    {
        //create table
        $stmt = $this->mysql->prepare("CREATE TABLE users (
                id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                email VARCHAR(50),
                firstname VARCHAR(10) NOT NULL,
                lastname VARCHAR(10) NOT NULL
                )");
        $this->assertSame(true, $stmt->execute());

        //insert sample entry
        $stmt= $this->mysql->prepare("INSERT INTO users (email, firstname, lastname) VALUES (:email, :firstname, :lastname)");
        $stmt->bindParam(':email', $this->email, PDO::PARAM_STR, 50);
        $stmt->bindParam(':firstname', $this->first_name, PDO::PARAM_STR, 10);
        $stmt->bindParam(':lastname', $this->last_name, PDO::PARAM_STR, 10);
        $this->assertSame(true, $stmt->execute());
        //$this->user_id= $this->mysql->lastInsertId();
    }

    /**
    *@depends testWrtieToMySql
    */
    public function testReadFromMySql()
    {
        //read inserted user entry from table
        $stmt= $this->mysql->prepare("SELECT * FROM homestead.users WHERE email = :email");
        $stmt->bindParam(':email', $this->email, PDO::PARAM_STR, 50);
        $this->assertSame(true, $stmt->execute());
        $result= $stmt->fetchAll(PDO::FETCH_ASSOC);

        //match returned result
        $this->AssertEquals($this->email, $result[0]['email']);
        $this->AssertEquals($this->first_name, $result[0]['firstname']);
        $this->AssertEquals($this->last_name, $result[0]['lastname']);
    }

    /**
    *@depends testReadFromMySql
    */
    public function testDeleteFromMySql()
    {
        //drop table
        $stmt= $this->mysql->prepare("DROP TABLE users");
        $this->assertSame(true, $stmt->execute());
    }
}
