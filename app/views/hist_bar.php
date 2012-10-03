<?php if($this->controlacceso->permisoAdministracion()) { ?>
    <div id="templatemo_sidebar">
        <div class="sidebar_title">Administración</div>
        <div class="sidebar_box">
        <div class="templatemo_list">
                <p>Consultar historial de usuario</p>
                <form method="POST" action="<?php echo site_url('historial'); ?>">
                        <input type="text" style="width:170px; margin-bottom:10px;" name="hist_user">
                        <input type="submit" value="Realizar consulta">
                </form>
		 <ul>
                        <li <?php echo ($actual=='alaal')?'class="active"':'';?>>
                        <a href="<?php echo site_url("buscador/"); ?>">Busqueda avanzada</a>
                        </li>
                </ul>
        </div>
        </div>
<br/>
        <div class="cleaner_h20"></div>
</div>
<?php } ?>

<div id="templatemo_sidebar">
        <div class="sidebar_title">Historial</div>
        <div class="sidebar_box">
	<div class="templatemo_list">
		<ul>
                	<li <?php echo ($actual=='all')?'class="active"':'';?>>
			<a href="<?php echo site_url("historial/index/all/$user_uid"); ?>">Historial completo</a>
			</li>
        	        <li <?php echo ($actual=='mail')?'class="active"':'';?>>
			<a href="<?php echo site_url("historial/index/mail/$user_uid"); ?>">Historial de buzones</a>
			</li>
        	        <li <?php echo ($actual=='calendar')?'class="active"':'';?>>
			<a href="<?php echo site_url("historial/index/calendar/$user_uid"); ?>">Historial de calendarios</a>
			</li>
                </ul>
        </div>
        </div>
        <div class="cleaner_h20"></div>
</div>
