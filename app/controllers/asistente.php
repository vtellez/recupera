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
class Asistente extends Controller {

	function Asistente()
	{
                parent::Controller();
                $this->controlacceso->control();
		$this->load->helper('backup_helper');
		$this->load->helper('date_helper');
	}

	function index($tipo = 'todos') {
		$user_uid = $this->session->userdata('uid');

		$data = array(
                                'subtitulo' => 'Asistente de recuperación',
                                'controlador' => 'asistente',
                                'css_adicionales' => array(
                                        'js/scrollable-buttons.css',
                                        'js/scrollable-horizontal.css'
                                ),
                );
                $this->load->view('cabecera', $data);

                if($tipo == 'correo') {
			
			$data = array(
				'warning' => !(backupAvailable() && workerAvailable()),
			);
	
                        $this->load->view('asistente_correo',$data);
        
	        }elseif ($tipo == 'agenda') {
 			//Get user's calendars from DataBase
			$this->db->where('owner',$user_uid); 
		        $calendars = $this->db->get('calendars');
	
			$data = array(
				'calendars' => $calendars,
				'uid' => $user_uid,
				'warning' => !(workerAvailable()),
			);

                        $this->load->view('asistente_agenda',$data);
	        }elseif ($tipo == 'debug') {
                        $this->load->view('asistente_prueba',$data);
                }else{
                       $this->load->view('asistente');
                }
                
		$this->load->view('asistente_bar.php',array('actual' => $tipo));

                $this->load->view('pie.php');


	}



	function espera($jobId) {
                $data = array(
                                'subtitulo' => 'Asistente de recuperación',
                                'controlador' => 'asistente',
                                'css_adicionales' => array(
                                        'js/scrollable-buttons.css',
                                        'js/scrollable-horizontal.css'
                                ),
                );
                $this->load->view('cabecera', $data);

		$this->db->where('job_cod',$jobId);
                $jobs = $this->db->get('jobs');
                        $job =  $jobs->row();

                $data = array(
                        "error" => FALSE,
                        "message" => "",
                        "job" => $job,

                );

                $this->load->view('maintenance',$data);
                $this->load->view('pie.php');
        }




        function change_user()
        {
		/*
		* Función que dado un parámetro pasado por POST, devuelve una vista 
		* con todos los calendarios asociados a dicho usuario.
		* En caso de ser llamada por un usuario no administrador, solo devuelve
		* la lista de calendarios del usuario.
		*/
		$this->controlacceso->control();
		$user_uid = $this->input->post('uvus');

                if(!$user_uid || !($this->controlacceso->permisoAdministracion())) 
		{
                         $user_uid = $this->session->userdata('uid');
                }
		//Get user's calendars from DataBase
                $this->db->where('owner',$user_uid);
                $calendars = $this->db->get('calendars');
                $data = array(
        	        'calendars' => $calendars,
                	'uid' => $user_uid,
                );
		$this->load->view('calendars_list.php',$data);
        }




        function restore_mailbox()
        {
                $this->controlacceso->control();
                $data = array(
                                'subtitulo' => 'Recuperación de correo electrónico',
                                'controlador' => 'asistente',
                        );
                $this->load->view('cabecera', $data);

                $user_uid = $this->input->post('uvus',TRUE);
                $dom = $this->input->post('dom',TRUE);

                if(!$this->controlacceso->permisoAdministracion())
                {
			//Si no es administrador, solo puede recuperar su correo
                        list($user_uid,$dom) =  split('@',$this->session->userdata('mail'));
                }

                $folder_option = $this->input->post('folder',TRUE);
                $folder_name = $this->input->post('folder_name',TRUE);
                $select_date = $this->input->post('fecha',TRUE);
	
                $message = "";
		$error = FALSE;
		$job = NULL;

		$folder = $folder_option;
		$path = "";

		if($folder_option == "Otra"){
			$folder = $folder_name;
		}

		if($folder_option != "INBOX" && $folder_option != "Trash" && $folder_option != "Sent" && $folder_option != "Otra"){
			$error = 1;
			$message = "Se ha especificado una carpeta no válida.";
		}
		elseif($folder_option == "Otra" && $folder_name == "")
		{
			$error = 1;
			$message = "Debe especificar un valor de carpeta a restaurar.";
		}
		elseif( $dom != "us.es" && $dom != "alum.us.es")
		{
			$error = 1;
			$message = "El dominio especificado no es válido.";
		}
		//elseif(false)
		elseif(!is_valid_date($select_date))
                {
                        $error = 1;
                        $message = "Debe especificarse una fecha válida de recuperación.";
                }elseif($user_uid."@".$dom != $this->session->userdata('mail')
	                    &&    !$this->controlacceso->permisoAdministracion() ){
                        //La dirección debe coincidir con el valor de SSO del mail
                        //si el usuario no es adminstrador
                        $error = 1;
                        $message = "Usted no tiene permiso para ordenar esta recuperación.";
 		}else {
                        //Comprobamos si el usuario tiene buzón definido
                        $this->db->where('user_uid',$user_uid);
                        $this->db->where('domain',$dom);
                        $mailbox = $this->db->get('mail_storage');
                        $mrow =  $mailbox->row();

                        if ($mailbox->num_rows != 1)
                        {
                                $error = 1;
                                $message = "La cuenta de correo especificada ($user_uid@$dom) no está activa.";
                        }else
                        {
                                $path = $mrow->path . "##" . $folder;
                        }
		}

		if(!$error)
                {
                        //Tratamiento de fecha
                        $select_date = str_replace('/', '-', $select_date);
                        //Aumentamos la fecha en un día dado que la copia de un día
                        //se realiza la madrugada del día siguiente
                        $date_stamp = strtotime($select_date) + 86400;
                        $date = date("d/m/Y",$date_stamp);

                        $ip = $_SERVER['REMOTE_ADDR'];
                        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                        }

                        //Registramos el trabajo en la base de datos local de recuper@
                        $data = array(
                                'date' => time(),
                                'backup_date' => strtotime($select_date),
                                'type' => 'mail' ,
                                'status' => 0,
                                'orderby' => $this->session->userdata('uid'),
                                'owner' => $user_uid,
                                'domain' => $dom,
                                'source' => $folder,
                                'name' => $folder,
                                'ip' => $ip,
                                'info' => "Trabajo registrado",
                        );
			
			$this->db->insert('jobs', $data);
                        //Obtenemos el id del trabajo guardado
                        $job_id = $this->db->insert_id();

                        //Get job info
                        $this->db->where('job_cod',$job_id);
                        $jobs = $this->db->get('jobs');
                        $job = $jobs->row();

                        //Obtenemos la fecha del ultimo backup completo
			//y las copias incrementales hasta la fecha dada
			$format_date = date("Y-m-d",$date_stamp);
                        
			//Encolamos la petición en beanstalkd
                        $this->load->model('cola');
                        $this->cola->encola($job->job_cod,'mail',$format_date,$user_uid."@".$dom,$path);
                }

		$data = array(
                        "error" => $error,
                        "message" => $message,
                        "job" => $job,
                 
                );

                if( (backupAvailable() && workerAvailable()) || $error == 1){
        	        $this->load->view('progress',$data);
		}else{
        	        $this->load->view('maintenance',$data);
		}
                $this->load->view('pie');
	}





	function restore_calendar()
	{
		$this->controlacceso->control();
                $data = array(
                                'subtitulo' => 'Recuperación de calendarios',
                                'controlador' => 'asistente',
                	);
                $this->load->view('cabecera', $data);

		$user_uid = $this->input->post('uvus',TRUE);

		if(!$this->controlacceso->permisoAdministracion())
                {
			//Si no es administrador, solo puede recuperar su calendario
                        list($user_uid,$dom) =  split('@',$this->session->userdata('mail'));
                }else {
			//En el caso de admin, comprobamos que exista el uvus
			//y obtenemos su dominio de correo para la posterior notificación
                        $this->db->where('user_uid',$user_uid);
                        $mailbox = $this->db->get('mail_storage');
                        $mrow =  $mailbox->row();

                        if ($mailbox->num_rows != 1)
                        {
                                $error = 1;
                                $message = "La cuenta de correo especificada ($user_uid) no existe.";
                        }else
                        {
				$dom = $mrow->domain;
                        }
		}

		$select_date = $this->input->post('fecha',TRUE);
		$cal_cod = $this->input->post('restore',TRUE);
		
		$error = FALSE;
		$message = "";

		//Get calendar info
		$this->db->where('cal_cod',$cal_cod);
                $calendars = $this->db->get('calendars');
		$calendar = $calendars->row();
				

		if ($calendars->num_rows() < 1)
		{
			$error = 1;
			$message = "El calendario especificado no es válido.";	
		}
		elseif(!is_valid_date($select_date))
		{
			$error = 1;
			$message = "Debe especificarse una fecha válida de recuperación.";
		}		
		elseif($user_uid != $calendar->owner)
		{
			$error = 1;
			$message = "El nombre del usuario especificado y el dueño del calendario no coinciden.";
		}
		elseif($user_uid != $this->session->userdata('uid')){
                        //El uid debe coincidir con el valor de SSO
                        //o bien ser usuario adminstrador
                        if(!$this->controlacceso->permisoAdministracion())
                        {
                                $error = 1;
                                $message = "Usted no tiene permiso para ordenar esta recuperación.";
                        }
                }
	

		$job = NULL;

		if(!$error)
		{
			//Tratamiento de fecha
	                $select_date = str_replace('/', '-', $select_date);
        	        //Aumentamos la fecha en un día dado que la copia de un día
                	//se realiza la madrugada del día siguiente
	                $date_stamp = strtotime($select_date) + 86400;
        	        $date = date("d/m/Y",$date_stamp);

			$ip = $_SERVER['REMOTE_ADDR'];
			if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
				$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
			}

			//Registramos el trabajo en la base de datos local de recuper@
			$data = array(
				'date' => time(),
				'backup_date' => strtotime($select_date),
				'type' => 'cal' ,
				'status' => 0,
				'orderby' => $this->session->userdata('uid'),
				'owner' => $user_uid,
				'source' => $calendar->private_name,
				'name' => $calendar->public_name,
				'ip' => $ip,
                                'domain' => $dom,
				'info' => "Trabajo registrado",
			);

			$this->db->insert('jobs', $data);
			//Obtenemos el id del trabajo guardado
			$job_id = $this->db->insert_id();
			
			//Get job info
	                $this->db->where('job_cod',$job_id);
        	        $jobs = $this->db->get('jobs');
                	$job = $jobs->row();
			
			//Encolamos la petición en beanstalkd
			$format_date = date("Ymd",$date_stamp);
			$this->load->model('cola');
			$this->cola->encola($job->job_cod,'cal',$format_date,$user_uid,$calendar->private_name);
		}

		$data = array(
			"error" => $error,
			"message" => $message,
			"job" => $job,
		);

                if( workerAvailable() || $error == 1){
                        $this->load->view('progress',$data);
                }else{
                        $this->load->view('maintenance',$data);
		}
		$this->load->view('pie.php');
	}

}
