<?php

//rmccue - request 
include('../library/Requests.php');

Requests::register_autoloader();
//Now let's make a request
$request = Requests::get('https://127.0.0.1/ws/backupServerAvailable');

if($request->body == "1")
{
	//Bacula disponible
	echo "Bacula disponible";
}
else
{
	//Bacula NO disponible
	echo "Bacula ocupado";	
}
