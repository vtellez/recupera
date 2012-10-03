<div id="templatemo_main_2col">

	<div id="templatemo_content_2col">


<img src="<?php echo site_url('img/32x32/key.png');?>" style="margin-right: 5px; margin-top: -2px; float: left;"/> <h2>Administración</h2>
<div class="content-separator"></div>


<fieldset>
        <legend><img src="<?php echo site_url('img/16x16/help.png'); ?>"  border="0" /> Información del sistema</legend>
        <label>Nombre del sistema</label> recupera.us.es<br/><br/>
        <label>Bacula backup</label>
	<?php echo ($bacula) ? '<font color="green">Servicio activo</font>' : '<font color="red">Fuera de servicio</font>';?>
	<br/><br/>
        <label>Beanstalkd worker</label> 
 	<?php echo ($worker) ? '<font color="green">Servicio activo</font>' : '<font color="red">Fuera de servicio</font>';?>
        <br/><br/>
        <label>Uptime</label> <?php system('uptime'); ?><br/><br/>
        <label>Who</label> <?php system('who'); ?><br/><br/>
        <label>Uso de disco</label> <?php system("df -h | tail -n 3 | head -n 1"); ?><br/><br/>
        <label>Uso de memoria</label> <?php system("free -m"); ?><br/><br/>
</fieldset>


	</div> <!-- col izquierda -->

    <div id="templatemo_sidebar">

        <?php $this->load->view('admin_bar.php',array('actual' => '')); ?>
	<br/><br/><br/><br/><br/><br/>




    </div>
