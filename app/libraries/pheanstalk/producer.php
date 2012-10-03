<?php

    //autoload pheanstalkd
    require_once 'pheanstalk_init.php';

    //producer script
    $beanstalkServer = new Pheanstalk('127.0.0.1');
    $beanstalkServer->useTube('agenda')
		    ->put('Descargas');

	echo "encolando peticion..";
?>
