<div id="templatemo_main_2col">

	<div id="templatemo_content_2col">

<img src="<?php echo site_url('img/32x32/calendar.png'); ?>" style="margin-right: 5px; margin-top: -2px; float: left;"/> 
<h2>Historial del usuario <?php echo $user_uid;?> (<?php echo $totales; ?>)</h2>
<div class="content-separator"></div>

<p>Puede ver información más detallada de cada recuperación, pinchando en la imagen de estado.</p>

<table class="data-table">
<thead>
<tr>
	<th width="40px">Est.</th>
	<th width="110px">Fecha</th>
	<th width="60px">Tipo</th>
	<th width="240px">Recurso</th>
	<th width="100px">Propietario</th>
	
</tr>
</thead>

<?php

	if($jobs->num_rows() == 0)
	{	
		echo '<tr class="even"><td colspan="5">No se ha encontrado ningún registro de actividad para su usuario</td></tr>';
		
	}else{

	$cont = 0;
	
		foreach ($jobs->result() as $job){
			$class = "";
			if ($cont%2 == 0)
			{
				$class = 'class="even"';
			}
		
			$img = "accept.png";
			if($job->status == "error")
			{
				$img = "cancel.png";
			}elseif($job->status != "100")
			{
				$img = "clock_select_remain.png";
			}

			$type = "email.png";
			if($job->type == "cal")
			{
				$type = "calendar.png";
			}
	?>
			<tr <?php echo $class; ?>>
			        <td><a href="<?php echo site_url("historial/job/$job->job_cod"); ?>">
				<img src="<?php echo site_url("img/16x16/$img"); ?>" style="margin-left:7px;"/></a>
				</td>
			        <td><?php echo date("d/m/Y, H:i",$job->date); ?></td>
			        <td><center><img src="<?php echo site_url("img/16x16/$type"); ?>"/></center></td>
		        	<td><?php echo $job->name; ?></td>
		        	<td><?php echo "$job->owner"; ?></td>
			</tr>
		<?php
			$cont++;
		} //foreach
	} //else

?>

</table>
	
<?php echo $pagination->create_links(); 

        if($jobs->num_rows() < 3)
        {?>
<br/>
<br/>
<br/>
	<?php } ?>
	</div> <!-- col izquierda -->
