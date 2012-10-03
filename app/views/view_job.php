<div id="templatemo_main">
	<div id="templatemo_content">
	<img src="<?php echo site_url("img/32x32/database_go.png");?>" 
		style="margin-right: 5px; margin-top: -2px; float: left;"/> 
	<h2>Vista detallada de recuperación</h2>

	<div style="float:right; margin-top:-30px;">
        <a id="backtop" href="javascript:history.go(-1);" style="color: #555">Volver atrás</a>
	</div>  

	<div class="content-separator"></div>

	<?php

		if(!$error)
		{
		  $img = "accept.png";
		  $divstatus = "success";
		  $backupimg = "process_accept.png";
		  $messagestatus = $job->info;
                        if($job->status == "error")
                        {
                                $img = "cancel.png";
				$divstatus = "error";
		  		$backupimg = "process_warning.png";
                        }
			elseif($job->status != "100")
			{
				$img = "clock_select_remain.png";
				$divstatus = "notice";
		  		$backupimg = "process_clock.png";	
				if($job->info == "0") {
					$messagestatus = "Tarea de restauración encolada, a la espera de ser atendida.";
				}
			}

		  $type = "Restauración de buzón de correo.";
		  $typeimg = "cloudmail.png";
			if($job->type != 'mail')
                        {
		  		$typeimg = "cloudcal.png";
		  		$type = "Restauración de calendario de la agenda virtual.";
                        }

                ?>


 <table border="0" style="width:100px; margin:auto;">
                                                <tr>
                                                        <td><img align="right" src="<?php echo site_url("img/user.png"); ?>" /></td>
                                                        <td><img align="right" src="<?php echo site_url("img/next.png"); ?>" /></td>
                                                        <td><img align="right" src="<?php echo site_url("img/$typeimg"); ?>" /></td>
                                                        <td><img align="right" src="<?php echo site_url("img/next.png"); ?>" /></td>
                                                        <td><img align="right" src="<?php echo site_url("img/$backupimg"); ?>" /></td>
                                                </tr>
                                                <tr style="font-size:16px;">
                                                        <td colspan="1"><center><?php echo "$job->orderby@$job->ip"; ?></center></td>
                                                        <td>&nbsp;</td>
                                                        <td colspan="1"><br/><center><?php echo "$job->owner@$job->name"; ?></center></td>
                                                        <td>&nbsp;</td>
                                                        <td colspan="1"><center>Sistema de backup US</center></td>
                                                </tr>
                                        </table>
<br/>
	<div class="<?php echo $divstatus;?>">
		<img src="<?php echo site_url("img/16x16/$img"); ?>"/>
		<?php echo $messagestatus; ?>
	</div>

		<br/>
		<h2>Información</h2>
		<br/>

		<table class="data-table">
		<tr>
		<th>Parámetro</th>
		<th width="80%">Valor</th>
		</tr>

                <tr class="even">
		<td>Realizada por</td>
		<td><?php echo $job->orderby;?></td>
		</tr>

		<tr>	
                <td>Dirección IP</td>
		<td>
		<a href="http://www.geoiptool.com/es/?IP=<?php echo $job->ip;?>" target="_blank"><?php echo $job->ip;?></a>	
		</td>
                </tr>

                <tr class="even">
		<td>Fecha de realización</td>
		<td><?php echo date("d/m/Y - H:i",$job->date);?></td>
		</tr>

		<tr>
                <td>Tipo de recuperación</td>
                <td><?php echo $type;?></td>
                </tr>

		<tr class="even">
		<td>Recurso a restaurar</td>
		<td><?php echo $job->name;?></td>
		</tr>

		<tr>
		<td>Fecha del backup</td>
		<td><?php echo date("d/m/Y",$job->backup_date);?></td>
		</tr>

		<tr class="even">
		<td>Propietario del recurso</td>	
		<td><?php echo $job->owner;?></td>
		</tr>


		<tr>
		<td>Estado actual</td>
		<td>
		<img src="<?php echo site_url("img/16x16/$img"); ?>"/>                    
                <?php echo $job->info;?>
		</td>
		</tr>
		</table>

        <?php }//if (!$error)
                else {?>

	<div class="error">
		<img src="<?php echo site_url("img/16x16/cancel.png"); ?>"/>
		La recuperación que intenta consultar no existe en el sistema o bien no tiene permisos para visualizarla.
	</div><br/>

        <?php } //else error ?>


<div style="margin-left: 330px;">
	<a id="ending" href="javascript:history.go(-1);"style="color: #555">Volver a la página anterior</a>
</div>

<script>
        $( "#ending, #backtop" ).button({
            icons: {
                primary: "ui-icon-circle-triangle-w"
            },
        });
</script>
	<br/>

</div>
