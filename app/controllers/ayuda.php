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
class Ayuda extends Controller {

	function Ayuda()
	{
		parent::Controller();	
	}
	
	function index()
	{

		//Obtenemos la tabla de estados
		$this->db->order_by("codigo", "asc"); 
		$estados = $this->db->get('estados');
		
                $data = array(
                                'subtitulo' => 'Ayuda',
				'controlador' => 'ayuda',
				'estados' => $estados,
				'parent' => '',
                );
                $this->load->view('cabecera', $data);

		$this->load->view('ayuda.php');
		$this->load->view('pie.php');
	}

}
