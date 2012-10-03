<?php

//rmccue - request 
include('../library/Requests.php');

Requests::register_autoloader();
//Now let's make a request
//$request = Requests::get('https://127.0.0.1/ws/getJobStatus/697');


$request = Requests::post('https://127.0.0.1/ws/getJobStatus/', array(),array('job_id' => '638', 'wspass' => 'xxxx'));

echo "$request->body\n";

if($request->body == "100")
{
	//Bacula disponible
	echo "Bacula disponible";
}
else
{
	//Bacula NO disponible
	echo "Bacula ocupado";	
}
