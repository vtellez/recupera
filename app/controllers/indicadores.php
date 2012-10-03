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
class Indicadores extends Controller {

	function Indicadores()
	{
		parent::Controller();	
                $this->controlacceso->control();
	}
	
	function index()
	{
                $data = array(
                                'subtitulo' => 'Indicadores',
				'controlador' => 'indicadores',
                                'js_adicionales' => array(
                                        'js/jquery-ui-1.8.13.custom.min.js'
                                ),
                                'css_adicionales' => array(
                                        'js/css/Aristo/jquery-ui-1.8.7.custom.css',
                                ),
                );
                $this->load->view('cabecera', $data);


		//Obtenemos los datos para pasarlos a la vista de indicadores

                /*Volumen de recuperaciones*/
                /*---------------------------------------*/
                $etiquetas = array();
                $datos = array();
                $totales = 0;

                $query = $this->db->query('select type,count(*) as value from jobs group by type order by value desc');
                foreach ($query->result() as $row)
                {
			if($row->type == 'cal'){
				$etiqueta = 'Calendarios recuperados';
			}else{
				$etiqueta = 'Buzones recuperados';
			}
                        array_push($etiquetas, $etiqueta);
                        array_push($datos, $row->value);
                        $totales += $row->value;
                }

                $volumen = array(
				'titulo' => "Indicadores totales de recuperaciones",
                                'legend' => "Indicadores 'Tipos y volumen de recuperaciones'",
                                'datos' => $datos,
                                'color' => '6495ED,ADFF2F',
                                'etiquetas' => $etiquetas,
                                'totales' => $totales,
                );
                /*---------------------------------------*/



                /*Estado de recuperaciones*/
                /*---------------------------------------*/
                $etiquetas = array();
                $datos = array();
                $totales = 0;

                $query = $this->db->query("select status,count(*) as value from jobs where status = '100'");
                $buzon = $query->row();
                array_push($etiquetas, 'Completadas con éxito');
                array_push($datos, $buzon->value);
                $totales += $buzon->value;

                $query = $this->db->query("select status,count(*) as value from jobs where status = 'error'");
                $buzon = $query->row();
                array_push($etiquetas, 'Fallidas');
                array_push($datos, $buzon->value);
                $totales += $buzon->value;

                $query = $this->db->query("select status,count(*) as value from jobs where status <> '100' and status <> 'error'");
                $buzon = $query->row();
                array_push($etiquetas, 'Encoladas');
                array_push($datos, $buzon->value);
                $totales += $buzon->value;

                $estado = array(
				'legend' => "Indicadores 'Estado de recuperaciones'",
                                'titulo' => "Estados de las recuperaciones registradas",
                                'datos' => $datos,
                                'color' => '9ACD32,FF6347,FFA500',
                                'etiquetas' => $etiquetas,
                                'totales' => $totales,
                );
                /*---------------------------------------*/




		/*Recuperaciones de buzón por dominios*/
                /*---------------------------------------*/
                $etiquetas = array();
                $datos = array();
                $totales = 0;

		$query = $this->db->query("select domain,count(*) as value from jobs where domain = 'us.es'");
		$buzon = $query->row();
                array_push($etiquetas, 'Dominio @us.es');
                array_push($datos, $buzon->value);
                $totales += $buzon->value;

                $query = $this->db->query("select domain, count(*) as value from jobs where domain = 'alum.us.es'");
                $buzalum = $query->row();
                array_push($etiquetas, 'Dominio @alum.us.es');
                array_push($datos, $buzalum->value);
                $totales += $buzalum->value;
                
		$dominios = array(
 				'legend' => "Indicadores 'Recuperaciones de buzón por dominios'",
                                'titulo' => "Recuperaciones de buzón por dominios",
                                'datos' => $datos,
                                'color' => '6495ED,FF69B4',
                                'etiquetas' => $etiquetas,
                                'totales' => $totales,
                );
                /*---------------------------------------*/



		/*Usuarios más activos*/
		/*---------------------------------------*/
		$etiquetas = array();
		$datos = array();
		$totales = 0;

		$query = $this->db->query('select orderby,count(*) as value from jobs group by orderby order by value desc limit 0,10;');
		foreach ($query->result() as $row)
		{
			array_push($etiquetas, $row->orderby);
			array_push($datos, $row->value);
			$totales += $row->value;
		}

                $usuarios_activos = array(
                                'titulo' => "Usuarios que han realizado más recuperaciones",
                                'legend' => "Indicadores 'Usuarios más activos'",
                                'datos' => $datos,
                                'color' => '6495ED,FF69B4,9ACD32,FFA500,ADFF2F',
                                'etiquetas' => $etiquetas,
                                'totales' => $totales,
                );
		/*---------------------------------------*/

		/*Usuarios con más recursos recuperados*/
		/*---------------------------------------*/
                $etiquetas = array();
                $datos = array();
                $totales = 0;

                $query = $this->db->query('select owner,count(*) as value from jobs group by owner order by value desc limit 0,10;');
                foreach ($query->result() as $row)
                {
                        array_push($etiquetas, $row->owner);
                        array_push($datos, $row->value);
                        $totales += $row->value;
                }

                $usuarios_recuperados = array(
                                'titulo' => "Usuarios con más recursos recuperados",
                                'legend' => "Indicadores 'Usuarios con más recursos recuperados'",
                                'datos' => $datos,
                                'color' => '6495ED,FF69B4,9ACD32,FFA500,ADFF2F',
                                'etiquetas' => $etiquetas,
                                'totales' => $totales,
                );
		/*---------------------------------------*/




		$data = array(
				'volumen' => $volumen,
				'estado' => $estado,
				'dominios' => $dominios,
				'uactivos' => $usuarios_activos,
				'urecuperados' => $usuarios_recuperados,
			);


		$this->load->view('indicadores.php', $data);
		$this->load->view('pie.php');
	}
}
