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
class Admin extends Controller {

	function __construct()
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
                                'subtitulo' => 'Administración',
				'controlador' => 'admin',
                );
                $this->load->view('cabecera', $data);

 		$this->load->helper('backup_helper');

		$data = array (
				'bacula' => backupAvailable(),
				'worker' => workerAvailable(),
		);

		$this->load->view('admin',$data);
		$this->load->view('pie');
	}

}
