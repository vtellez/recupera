<?php
/*
 *    Copyright 2012 Víctor Téllez Lozano <vtellez@us.es>
 *
 *    This file is part of Recuper@.
 *
 *    Seguimiento is free software: you can redistribute it and/or modify it
 *    under the terms of the GNU Affero General Public License as
 *    published by the Free Software Foundation, either version 3 of the
 *    License, or (at your option) any later version.
 *
 *    Seguimiento is distributed in the hope that it will be useful, but
 *    WITHOUT ANY WARRANTY; without even the implied warranty of
 *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 *    Affero General Public License for more details.
 *
 *    You should have received a copy of the GNU Affero General Public
 *    License along with Seguimiento.  If not, see
 *    <http://www.gnu.org/licenses/>.
 */
class cola extends Model {

	function cola()
	{
		parent::Model();
	}

	/**
         * Carga bibliotecas de pheanstalk
         */
        function _inicializa_pheanstalk() {
                $pheanstalkClassRoot = getcwd() . '/' . APPPATH . 'libraries/pheanstalk/classes';
                require_once($pheanstalkClassRoot . '/Pheanstalk/ClassLoader.php');

                Pheanstalk_ClassLoader::register($pheanstalkClassRoot);
        }

	
	function encola($job_id,$type,$date,$user,$source)
	{
		// Carga biblioteca
                $this->_inicializa_pheanstalk();

		// Encolar en beanstalkd
                $host = $this->config->item('beanstalkd_host');
                $port = $this->config->item('beanstalkd_port');
                $tube = $this->config->item('beanstalkd_tube');
                $ttr = $this->config->item('beanstalkd_ttr');

                $exito = FALSE;

                try {
                        $pheanstalk = new Pheanstalk($host, $port);
			if($type == 'cal' || $type == 'mail'){
			
				$param = "$job_id--$type--$date--$user--$source";

	                        $pheanstalk
        	                        ->useTube($tube)
        	                        ->put($param, 1, 0, $ttr);
			}
                       	$exito = TRUE;
                } catch (Exception $e) {

                }

	}

}
