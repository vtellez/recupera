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

function dateRange($diad) { 
	/*
	* Función que dada una fecha en formato yyyy-mm-dd,
	* devuelve una cadena formada por todas las fechas en rango,
	* desde el domingo anterior a la fecha dada
	*/
	$sunday = FALSE;
	$actualday = $diad;
	$result = "";

	while (!$sunday) {
		$weekday = date("w",strtotime($actualday));
		
		$result .= "$actualday#";
	
		if($weekday == 0) {	
			$sunday = TRUE;
		}else{
			$yesterday_stamp = strtotime($actualday) - 86400;
		        $actualday = date("Y-m-d", $yesterday_stamp);
		}
	}

	return $result;
}


function is_date( $str )
{
	/*
	* Comprueba que el argumento de entrada, 
	* de tipo DD-MM-AAA es una fecha válida
	*/
	$stamp = strtotime( $str );
 
	if (!is_numeric($stamp))
	{
		return FALSE;
	}
	
	$month = date( 'm', $stamp );
	$day   = date( 'd', $stamp );
	$year  = date( 'Y', $stamp );
 
	if (checkdate($month, $day, $year))
	{
		return TRUE;
	}
 
	return FALSE;
}

function is_valid_date($str)
{
	/* 
	* Comprueba que el argumento de entrada,
	* de tipo DD/MM/AAAA, es una fecha valida,
	* y no anterior a 21 días ni posterior al día
	* de ayer
	*/
	$str = str_replace('/', '-', $str);
		
	if (!is_date( $str )) {
		return FALSE;
	}

	$segundos=strtotime($str) - strtotime('now');
	$diferencia_dias=intval($segundos/60/60/24);
	
	if ($diferencia_dias > -23 && $diferencia_dias < 0) {
		return TRUE;
	} else {
		return FALSE;
	}
} 
