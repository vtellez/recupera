<div id="templatemo_main">
	<div id="templatemo_content">
<img src="<?php echo site_url('img/32x32/find.png'); ?>" style="margin-right: 5px; margin-top: -2px; float: left;"/> 
<h2>Resultados de la búsqueda (<?php echo $totales; ?>)</h2>

	<div style="float:right; margin-top:-30px;">
        <a id="backtop" href="<?php echo site_url('buscador');?>" style="color: #555">Nueva búsqueda</a>
	</div>  
<script>
        $( "#ending, #backtop" ).button({
            icons: {
                primary: "ui-icon-search"
            },
        });
</script>

<div class="content-separator"></div>


<fieldset style="width:700px; margin:auto;">	
	<legend><img src="<?php echo site_url('img/16x16/page_find.png'); ?>"/> Condiciones de búsqueda aplicadas</legend>
	<?php echo $condiciones; ?>
</fieldset>

<br/>


<p>Puede ver información más detallada de cada recuperación, pinchando en la imagen de estado.</p>

<table class="data-table">
<thead>
<tr>
	<th width="40px">Est.</th>
	<th width="110px">Fecha</th>
	<th width="100px">Solicitante</th>
	<th width="100px">Propietario</th>
	<th width="60px">Tipo</th>
	<th width="80px">Backup día</th>
	<th width="240px">Recurso</th>
	
</tr>
</thead>

<?php
	if($jobs->num_rows() == 0)
	{	
		echo '<tr class="even"><td colspan="7">No se ha encontrado ningún registro para las condiciones de filtrado definidas.</td></tr>';
		
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
		        	<td><?php echo "$job->orderby"; ?></td>
		        	<td><?php echo "$job->owner"; ?></td>
			        <td><center><img src="<?php echo site_url("img/16x16/$type"); ?>"/></center></td>
			        <td><?php echo date("d/m/Y",$job->backup_date); ?></td>
		        	<td><?php echo utf8_decode($job->name); ?></td>
			</tr>
		<?php
			$cont++;
		} //foreach
	} //else

?>

</table>
	
<?php echo $pagination->create_links(); ?>
<br/>
<br/>
</div>
