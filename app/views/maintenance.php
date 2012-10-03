<div id="templatemo_main">
	<div id="templatemo_content">
        <img src="<?php echo site_url('img/32x32/database_go.png'); ?>" style="margin-right: 5px; margin-top: -2px; float: left;"/> <h2>Restaurando copia de seguridad</h2>
	<div class="content-separator"></div>

<div class="notice" style="width:740px; margin:auto; margin-top:50px;"> 
	<img src="<?php echo site_url('img/under-maintenance.png'); ?>" 
	style="float:left; margin-top: -50px; margin-left: -90px; padding:10px;"/>

	<h4>Oops, esto puede tardar un poco...</h4>
	<br/>
	Su copia de seguridad no puede ser restaurada en este momento debido a que Recuper@ está atendiendo otras peticiones pendientes. 
	<br/><br/>
	No obstante, su petición ha sido registrada y será atendida lo antes posible. Recibirá un correo electrónico cuando se complete la restauración solicitada.
	<br/><br/>
</div>

<script>
	$(function() {
		 $( "#moreinfo" ).button({
                    icons: {
                    primary: "ui-icon-help"
                        },
                });

                 $( "#details" ).button({
                    icons: {
                    primary: "ui-icon-search"
                        },
                });
	});
	</script>

<div class="abuttons"  style="margin-left: 525px; margin-top:20px;">
        <a href="<?php echo site_url('ayuda#3.5');?>" id="moreinfo" style="color:#555;">Ayuda</a>
        <a href="<?php echo site_url("historial/job/$job->job_cod");?>" id="details" style="color:#555;">Ver resumen detallado</a>
</div>
<br/>
</div>
