    <div id="templatemo_sidebar">
        <div class="sidebar_title">Recuperación</div>
        <div class="sidebar_box">
	<div class="templatemo_list">
		<ul>
                	<li <?php echo ($actual=='todos')?'class="active"':'';?>>
			<a href="<?php echo site_url('asistente/'); ?>">Inicio</a>
			</li>
        	        <li <?php echo ($actual=='correo')?'class="active"':'';?>>
			<a href="<?php echo site_url('asistente/index/correo'); ?>">Recuperar correo</a>
			</li>
        	        <li <?php echo ($actual=='agenda')?'class="active"':'';?>>
			<a href="<?php echo site_url('asistente/index/agenda'); ?>">Recuperar agenda</a>
			</li>
                </ul>
        </div>
        </div>

	<div class="sidebar_title">Ayuda</div>
        <div class="sidebar_box">
	<p>Si tiene cualquier duda acerca del uso de este asistente, consulte la <a href="<?php echo site_url('ayuda#3'); ?>">sección de ayuda</a> donde se detalla el proceso de restauración paso a paso.</p>
        </div>
        <div class="cleaner_h20"></div>
</div>
