<?php
/*
 *    Copyright 2011 Víctor Téllez Lozano <vtellez@us.es>
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
class Historial extends Controller {

	function Historial()
	{
		parent::Controller();	
                $this->controlacceso->control();
	}
	
	function index($type = 'all', $user_uid = FALSE)
	{
                $data = array(
                                'subtitulo' => 'Historial',
				'controlador' => 'historial',
                );
                $this->load->view('cabecera', $data);

		$uid = $this->session->userdata('uid');

		if(!$user_uid)
		{
			$user_uid = $this->input->post('hist_user',TRUE);
		}

                if(!$user_uid || !($this->controlacceso->permisoAdministracion()))
                {
                         $user_uid = $this->session->userdata('uid');
                }


		//Formamos la cláusula where:
		//Obtenemos todos los trabajos registrados por y para el usuario actual
		$where = "(orderby = '$user_uid' OR owner = '$user_uid')";
	
		if($type == "calendar") 
		{
			$where = $where . " AND type = 'cal'";
		}elseif ($type == "mail")
		{
			$where = $where . " AND type = 'mail'";
		}
		$this->db->where($where);
		$this->db->order_by('job_cod','desc');
                $jobs = $this->db->get('jobs',$this->config->item('num_item_pagina'),(int)$this->uri->segment(5));

		$this->db->where($where);
		$totales = $this->db->get('jobs');
		$num_rows = $totales->num_rows();


		//Cargamos los enlaces a la paginacion
                $this->load->library('pagination');
                $config['per_page'] = $this->config->item('num_item_pagina');
                $config['first_link'] = '<<';
                $config['last_link'] = '>>';
                $config['uri_segment'] = 5;
                $config['total_rows'] = $num_rows;
                $config['num_links'] = 2;
                $config['full_tag_open'] = '<div id="paginacion">';
                $config['full_tag_close'] = '</div>';
                $config['cur_tag_open'] = '<div id="paginacion_actual">';
                $config['cur_tag_close'] = '</div>';
		$config['base_url'] = site_url("historial/index/$type/$user_uid");
		$this->pagination->initialize($config);


		$data = array(	
			'jobs' => $jobs,
			'user_uid' => $user_uid,
			'pagination' => $this->pagination,
			'totales' => $num_rows,
		);
		
		$this->load->view('historial.php',$data);

		$this->load->view('hist_bar.php',array('actual' => $type));

		$this->load->view('pie.php');
	}


	function job($id = FALSE)
        {
		$error = true;
                $uid = $this->session->userdata('uid');

		#Obtenemos el trabajo en cuestión
                $this->db->where('job_cod',$id);
                $jobs = $this->db->get('jobs');
		$row = $jobs->row();

		#Sino se encontró el trabajo o no tiene permisos para verlo
		#error no cambiará de valor 
		if($jobs->num_rows())
                {
                        if($uid == $row->owner || $this->controlacceso->permisoAdministracion())
                        {
                                $error = false;
                        }
                }

		$data = array(
                                'subtitulo' => 'Consulta de recuperación',
                                'controlador' => 'historial',
                );
                $this->load->view('cabecera', $data);


                $data = array(
			'error' => $error,
			'job' => $row,
                );
                $this->load->view('view_job', $data);
                $this->load->view('pie');
	}
}
