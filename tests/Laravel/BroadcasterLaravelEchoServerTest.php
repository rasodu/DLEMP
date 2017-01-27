<?php

class BroadcasterLaravelEchoServerTest extends TestCase
{
    public function testPrettyURLsEnabled()
    {
        $result= $this->getFullResponseFromURL('https://https:6001/socket.io/socket.io.js');

        $this->assertContains(
            'HTTP/1.1 200 OK',
            $result
        );
    }

}
