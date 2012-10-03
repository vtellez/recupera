<?php

	//autoload pheanstalkd
	require_once 'pheanstalk_init.php';

	$pheanstalk = new Pheanstalk('127.0.0.1');

	//worker script
	$job = $pheanstalk->watch('agenda')
	    ->ignore('default')
	    ->reserve();

	echo $job->getData();
//	system('ls -l /home/victortellez/'.$job->getData());
	system('uptime');


	$pheanstalk->delete($job);

?>
