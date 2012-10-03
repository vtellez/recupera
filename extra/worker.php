#!/usr/bin/php
<?php
/*
 *    Copyright 2012 Víctor Téllez Lozano <vtellez@us.es>
 *
 *    This file is part of Recuper@.
 *
 *    Recuper@ is free software: you can redistribute it and/or modify it
 *    under the terms of the GNU Affero General Public License as
 *    published by the Free Software Foundation, either version 3 of the
 *    License, or (at your option) any later version.
 *
 *    Recuper@ is distributed in the hope that it will be useful, but
 *    WITHOUT ANY WARRANTY; without even the implied warranty of
 *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 *    Affero General Public License for more details.
 *
 *    You should have received a copy of the GNU Affero General Public
 *    License along with Recuper@.  If not, see
 *    <http://www.gnu.org/licenses/>.
 */
$ruta = '/var/www/html/recupera';
$ws_base_url = "https://127.0.0.1/ws/";
$max_rebounds = 170;

define('BASEPATH',$ruta);
require $ruta . "/app/config/config.php";
// Pheanstalk
require_once($ruta.'/app/libraries/pheanstalk/pheanstalk_init.php');
// Request 
include($ruta.'/extra/rmccue-Requests/library/Requests.php');

echo "Recuper@ worker starts listen at ".$config['beanstalkd_host'].":".$config['beanstalkd_port']."\n";

try {
	$pheanstalk = new Pheanstalk(
			$config['beanstalkd_host'],
			$config['beanstalkd_port']
			);

	Requests::register_autoloader();

	while (1) {
		//RESERVE JOB
		$job = $pheanstalk
			->watch($config['beanstalkd_tube'])
			->ignore('default')
			->reserve();
		
		$job_stats = $pheanstalk->statsJob($job);
		$job_rebounds = $job_stats->releases;
		list($job_id, $type, $fecha, $user_uid, $source) = split('--', $job->getData());
	
		if ($job === FALSE) {
			//RELEASE JOB
                        $pheanstalk->release($job,0xFFFFFFFF,5);
                        echo "Error reading job, delaying: " . $job->getData() . "\n";
		} else {
			echo "Getting job: $job_id ($job_rebounds times)\n";
			$ended = FALSE;
			$delayed = FALSE;
			//Get JobStatus
			$request = Requests::post($ws_base_url.'getJobStatus/',
                                                array(),array('job_id' => $job_id, 'wspass' => $config['wspass']));
                        $actual_status = trim($request->body);

			//MAX REBOUNDS
			if($job_rebounds > $max_rebounds) {
				echo "Superados máximo de rebotes para job: $job_id\n";
				//WS updateJobStatus error
				$request = Requests::post($ws_base_url.'update_job/'
					.$config['wspass'].'/'.$job_id.'/error', array(), 
					array('info' => 'La recuperación se ha cancelado debido '
						.'a que superó el tiempo máximo de ejecución.'));
				$ended = TRUE;

			}elseif ($type == "cal" && !$ended) {			
				//CALENDAR RESTORE PROCESS
				echo "Calling ".$config['calendar_server']." recupera_calendario for $job_id\n";

                                echo("(ssh ".$config['calendar_server']
                                                ." /usr/local/bin/recupera_calendario.sh "
                                                ."$fecha $user_uid \'$source\' $job_id) &");

				
				exec("(ssh ".$config['calendar_server']
						." /usr/local/bin/recupera_calendario.sh "
						."$fecha $user_uid \'$source\' $job_id) &");

				$ended = TRUE;
			
			}elseif ($type == "mail" && !$ended) {		
				//MAIL RESTORE PROCESS
				//WS backupServerAvailable			
				$request = Requests::get($ws_base_url.'backupServerAvailable');

				if($request->body != "1") {
					//BACULA STATUS IS BUSY
                                        $delayed = TRUE;
                                } else{
					//BACULA STATUS IS READY
					list($user,$domain) = split('@', $user_uid);
					list($path,$folder) = split('##', $source);

					$buzon_server = $config['mail_server_us'];
					$cliente_bacula = 'buzon_us';
					if($domain == "alum.us.es") {
						$buzon_server = $config['mail_server_alum'];
						$cliente_bacula = 'buzalum';
					}


                                        echo("Calling ".$config['backup_server']." recupera_restore.pl "
                                                        ."'$job_id--$cliente_bacula--$fecha--$path/'\n");

					//BACKUP REMOTE RESTORE
					exec("ssh ".$config['backup_server']." /usr/bin/perl"
							." /usr/local/bin/recupera_restore.pl "
							."\'$job_id--$cliente_bacula--$fecha--$path/\'");

					//WS getJobStatus
	                                $request = Requests::post($ws_base_url.'getJobStatus/',
                                                array(),array('job_id' => $job_id, 'wspass' => $config['wspass']));

                                        $actual_status = trim($request->body);
                                        
					if($actual_status == "encolado") {
						$delayed = TRUE;

                                        } elseif ($actual_status == "error") {
        	                                $ended = TRUE;
                                        }else {
                                                echo("Calling $buzon_server"." recupera_buzon.sh "
                                                        ."$job_id $domain \'$path\' \'$folder\' $user\n");

                                        	//BUZON REMOTE DOVEADM
	                                	exec("ssh $buzon_server"." /usr/local/bin/recupera_buzon.sh "
								."$job_id $domain \'$path\' \'$folder\' $user");

        	                                $ended = TRUE;
                                        }
				}//else bacula is ready
			}else {
				//NO MAIL, NO CALENDAR
				$pheanstalk->delete($job);
			} 

			if ($ended) {
				//WS finish Job
				$request = Requests::get($ws_base_url."finishJob/".$config['wspass']."/$job_id");
				//DELETE JOB
				$pheanstalk->delete($job);
			}

			if ($delayed) {
				//UPDATE TIME DELAY
				$time_delay = 10;
				if ($job_rebounds <= 5) {
				}elseif ($job_rebounds <= 11) {
					$time_delay = 60;
				}elseif ($job_rebounds <= 23) {
					$time_delay = 900;
				}else {
					$time_delay = 1800;
				}

				//RELEASE JOB
				$pheanstalk->release($job,0,$time_delay);
				echo "Backup not available. Delaying job $job_id ($job_rebounds delays) for $time_delay seconds.\n";

				//WS updateJobStatus delay
				if ($job_rebounds > 0 && $actual_status != "encolado") {
					$request = Requests::post('https://127.0.0.1/ws/update_job/'
						.$config['wspass'].'/'.$job_id.'/encolado', array(),
						array('info' => 'Tarea de restauración encolada, a la espera de ser atendida.'));
				}
			}
		}//else, valid job
	}//while
} catch (Exception $e) {
	echo "Error!: " . var_export($e, TRUE) . "\n";
	exit(1);
}
