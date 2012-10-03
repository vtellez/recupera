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

function backupAvailable(){
	/*
	 * Devuelve true si bacula esta disponible o
	 * false si se encuentra corriendo algún trabajo
	 */
	$CI =& get_instance();

	$cmd = "ssh ".$CI->config->item('backup_server')
		." '/usr/bin/sudo /usr/sbin/bconsole -c /etc/bacula/bconsole.conf < /var/www/dirstatus | "
		."grep \"No Jobs running.\" | wc -l'";
	$output = shell_exec($cmd);
	$out = trim($output);

	if($out == "1"){
		return TRUE;
	}else{
		return FALSE;
	}
}


function workerAvailable(){
        /*
         * Devuelve true si bacula esta disponible o
         * false si se encuentra corriendo algún trabajo
         */
        $CI =& get_instance();

        $cmd ="ps -ef | grep recupera-worker | wc -l";
        $output = shell_exec($cmd);
        $out = trim($output);
	if($out == "2"){
                return TRUE;
        }else{
                return FALSE;
        }
}

