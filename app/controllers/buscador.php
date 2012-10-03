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
class Buscador extends Controller {

	function Buscador()
	{
		parent::Controller();	
		$this->controlacceso->control();
                if (!$this->controlacceso->permisoAdministracion()) {
                        show_error(403, 'Acceso denegado');
                }
	}
	
	function index()
	{
		 $data = array(
                                'subtitulo' => 'Búsquedor de recuperaciones',
                                'controlador' => 'buscador',
                );
                $this->load->view('cabecera', $data);

                $data = array (
                );

                $this->load->view('buscador_recuperaciones',$data);
                $this->load->view('pie');

	}

	
	function resultados($type = 'all', $user_uid = FALSE)
	{
                $data = array(
                                'subtitulo' => 'Resultados de la búsqueda',
				'controlador' => 'buscador',
                );
                $this->load->view('cabecera', $data);

		$owner = $this->input->post('owner',TRUE);
		$orderby = $this->input->post('orderby',TRUE);
		$fecha_min = $this->input->post('fecha_min',TRUE);
		$fecha_max = $this->input->post('fecha_max',TRUE);
		$fecha_backup_min = $this->input->post('fecha_backup_min',TRUE);
		$fecha_backup_max = $this->input->post('fecha_backup_max',TRUE);
		$type = $this->input->post('tipo',TRUE);
		$status = $this->input->post('estado',TRUE);
		$hidden = $this->input->post('oculto',TRUE);


		//Formamos la cláusula where:
		if ($this->session->userdata('where_consulta') != "" && !$hidden) {
                                $where = $this->session->userdata('where_consulta');
                                $cond = $this->session->userdata('$cond_consulta');
                        }else{
				$where = "job_cod IS NOT NULL";
				$cond = "";
                        }

		if($fecha_min != "Elija fecha" && $fecha_min){
			$where .= " AND date > ".strtotime(str_replace('/', '-', $fecha_min));
			$cond .= "<li><b>Fecha de orden</b> es mayor que $fecha_min.</li>";
		}

		 if($fecha_max != "Elija fecha" && $fecha_max){
                        $where .= " AND date < ".strtotime(str_replace('/', '-', $fecha_max));
			$cond .= "<li><b>Fecha de orden</b> es menor que $fecha_max.</li>";
                }

		 if($fecha_backup_min != "Elija fecha" && $fecha_backup_min){
                        $where .= " AND backup_date > ".strtotime(str_replace('/', '-', $fecha_backup_min));
			$cond .= "<li><b>Fecha de backup</b> es mayor que $fecha_backup_min.</li>";
                }

		 if($fecha_backup_max != "Elija fecha" && $fecha_backup_max){
                        $where .= " AND backup_date < ".strtotime(str_replace('/', '-', $fecha_backup_max));
			$cond .= "<li><b>Fecha de backup</b> es menor que $fecha_backup_max.</li>";
                }

		
		if($orderby) {
			$where .= " AND orderby = '$orderby'";
			$cond .= "<li><b>Solicitante</b> es $orderby.</li>";
		}
		
                if($owner) {
                        $where .= " AND owner = '$owner'";
			$cond .= "<li><b>Propietario</b> es $owner.</li>";
                }
	
		if($type == "cal") {
			$where .= " AND type = 'cal'";
			$cond .= "<li><b>Tipo</b> es calendario.</li>";
		}elseif ($type == "mail") {
			$where .= " AND type = 'mail'";
			$cond .= "<li><b>Tipo</b> es correo.</li>";
		}

		if($status == "success") {
			$where .= " AND status = '100'";
			$cond .= "<li><b>Estado</b> es finalizado con éxito.</li>";
		}elseif ($status == "delay") {
			$where .= " AND status <> 'error' AND status <> '100'";
			$cond .= "<li><b>Estado</b> es encolado, pendiente de ejecución.</li>";
		}elseif ($status == "error") {
			$where .= " AND status = 'error'";
			$cond .= "<li><b>Estado</b> es fallido.</li>";
		}

		if($cond == "") {
			$cond = "<li>Ninguna restricción definida. Mostrando la tabla completa de recuperaciones.</li>";
		}

		 //Guardamos la consulta en la sesion del usuario:
                $this->session->set_userdata('where_consulta', $where);
                $this->session->set_userdata('cond_consulta', $cond);
		$this->db->where($where);
		$this->db->order_by('job_cod','desc');
                $jobs = $this->db->get('jobs',$this->config->item('num_item_pagina')*2,(int)$this->uri->segment(3));

		$this->db->where($where);
		$totales = $this->db->get('jobs');
		$num_rows = $totales->num_rows();

		//Cargamos los enlaces a la paginacion
                $this->load->library('pagination');
                $config['per_page'] = $this->config->item('num_item_pagina')*2;
                $config['first_link'] = '<<';
                $config['last_link'] = '>>';
                $config['uri_segment'] = 3;
                $config['total_rows'] = $num_rows;
                $config['num_links'] = 2;
                $config['full_tag_open'] = '<div id="paginacion">';
                $config['full_tag_close'] = '</div>';
                $config['cur_tag_open'] = '<div id="paginacion_actual">';
                $config['cur_tag_close'] = '</div>';
		$config['base_url'] = site_url("buscador/resultados/");
		$this->pagination->initialize($config);


		$data = array(	
			'jobs' => $jobs,
			'user_uid' => $user_uid,
			'pagination' => $this->pagination,
			'totales' => $num_rows,
			'condiciones' => "<ul>".$cond."</ul>",
		);
		
		$this->load->view('buscador_resultados',$data);

		$this->load->view('pie');
	}


}
