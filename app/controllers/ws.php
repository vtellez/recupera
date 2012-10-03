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


//Web services definidos para Recuper@


class Ws extends Controller {

	function Ws()
	{
		parent::Controller();	
	}


	function update_job($pass,$job_id,$value)
	{
		/*
		* Dado un trabajo se actualiza su progreso siempre
		* y cuando la clave dada como parámetro coincida
		* con la clave definida en config.php
		*/
		$info = $this->input->post('info',TRUE);

		if($pass == $this->config->item('wspass')){
			$data = array(
		               'status' => $value,
		               'info' => $info,
            		);
			$this->db->where('job_cod', $job_id);
			$this->db->update('jobs', $data); 
		}		
	}



        function getJobValue()
        {
                /*
                * Dado un trabajo se devuelve su estado y cadena de información.
                */
		$this->controlacceso->control(); //Solo usuarios autenticados

		$job_id = $this->input->post('job_id',TRUE);

		//Get job info
                $this->db->where('job_cod',$job_id);
       	        $jobs = $this->db->get('jobs');
        	$job = $jobs->row();
		$this->output->set_output("$job->status#$job->info");
        }



        function getJobStatus()
        {
                /*
                * Dado un trabajo se devuelve su estado.
                */

		$job_id = $this->input->post('job_id',TRUE);
		$pass = $this->input->post('wspass',TRUE);
	
		if($pass == $this->config->item('wspass')){

                	//Get job info
	                $this->db->where('job_cod',$job_id);
        	        $jobs = $this->db->get('jobs');
                	$job = $jobs->row();
	                $this->output->set_output("$job->status");
		}
        }



	function backupServerAvailable()
        {
		/* Hace uso del helper recupera y la función
		* backupAvailable. Devuleve un 1 si el resultado 
		* era true o 0 si el resultado era falso
                */
		$this->load->helper('backup_helper');

		if(backupAvailable()){
                	$this->output->set_output("1");
		}else{
                	$this->output->set_output("0");
		}


        }


 	function finishJob($pass,$jobId)
        {
		/*
		* Método que será llamado por el worker de beanstalkd.
		* Worker nos informa de que ha finalizado un trabajo,
		* y desde aquí determinaremos las acciones necesarias
		* tales como la notificación al usuario por correo
		* electrónico si fuese necesario.
		* NOTA: Para su ejecución, debe coincidir la clave
		* privada.
                */

		if($pass != $this->config->item('wspass')){
			exit; //Clave privada incorrecta
		}

		$this->db->where('job_cod',$jobId);
		$jobs = $this->db->get('jobs');
		$row =  $jobs->row();

		if ($jobs->num_rows != 1) {
			exit; //Trabajo no existente
		}

		$this->load->library('email');
		$this->email->clear();
		$this->email->from('no-reply@us.es', 'Servicio Recuper@');
		$this->email->reply_to('correo@us.es', 'Servicio de correo electrónico');

		$this->email->to("$row->owner@$row->domain");
		$this->email->bcc('correo@us.es','vtellez@us.es');
		$this->email->subject('Completada la recuperación solicitada');

		$tipo = "correo";
		if($row->type == 'cal') {
			$tipo = "calendario";
		}
		
		$body = "La recuperación de $tipo solicitada para el usuario $row->owner se ha completado. ";
		$body .= "Puede consultar el estado detallado de dicha recuperación en la siguiente dirección:\n\n";
		$body .= site_url("historial/job/$jobId")."\n\n";
		$body .= "Para cualquier duda o sugerencia, puede contactarnos a través de la dirección de correo electrónico correo@us.es.";
		$this->email->message($body);
		$this->email->send();

        }


}
