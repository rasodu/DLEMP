<?php

$key= "username";
	
	//start Check session on memcached is working
session_start();
if( isset($_SESSION[$key]) ){
	print("<br/><br/>Username in the session is: {$_SESSION[$key]}");
}
else{
	print("<br/><br/>Username is not found in the session. It will be added now.");
	$_SESSION[$key]= 'aamin(session)';
}
	//end Check session on memcached is working

	//start Test memcached is working
$mem = new Memcached();
$mem->addServer("192.168.99.100", 11211);

$result = $mem->get($key);

if ($result) {
    echo "<br/><br/>Username in the memcached is: $result";
}
else {
	print("<br/><br/>Username is not found in the memcached. It will be added now.");
    $mem->set($key, "aamin(memcached)") or die("Error: Couldn't save anything to memcached...");
}
	//end Test memcached is working

?>
