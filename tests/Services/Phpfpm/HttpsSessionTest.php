<?php

class HttpsSessionTest extends TestCase
{

    private $key= 'user';
    private $value= 'aamin';

    public function testWriteToSession()
    {
        $_SESSION[$this->key]= $this->value;
    }

    /**
    *@depends testWriteToSession
    */
    public function testReadFromSession()
    {
        $result= $_SESSION[$this->key];
        unset($_SESSION[$this->key]);

        $this->assertEquals($this->value, $result);
    }
}
