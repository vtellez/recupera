<div id="templatemo_main">
	<div id="templatemo_content">
        <img src="<?php echo site_url('img/32x32/database_go.png'); ?>" style="margin-right: 5px; margin-top: -2px; float: left;"/> <h2>Recuperando copia de seguridad</h2>
	<div class="content-separator"></div>



<script type="text/javascript">
$(document).ready(function() {
        $("#progressbar").progressbar({
                value: 0
                }).width(783);

        <?php
		$jobId = -1;
                if(!$error) {
			$jobId = $job->job_cod; 
                        echo "getJobValue();";
                } else {
                      echo "finish_button(true);";
        } ?>
});
</script>



<script type="text/javascript">
function getJobValue(jobId)
{
	/*
	* Función que se encarga de realizar una consulta AJAX para 
	* ir actualizando la barra de progreso en función del estado del trabajo
	*/

	$.ajax(
	{
		type: 'POST',
		url: '<?php echo base_url(); ?>ws/getJobValue',
		data: 'job_id='+<?php echo $jobId;?>,
		beforeSend : function (resp) {
		},

		success: function(resp) 
		{

			var mySplit = resp.split("#");
			var value = mySplit[0]; 
			var infostatus = mySplit[1]; 
			$("#progressbar div").animate( { width: value+"%" } );
			$('#info_progress').html(''+value+'% completado');
			$('#info_status').html( '- '+infostatus);
			if(value != '100' && value != 'error'){
				setTimeout('getJobValue()',1000);

				if(value == 'encolado'){
					window.location = "<?php echo site_url('asistente/espera/'.$jobId); ?>";
				}				

		        }else{
				if(value == '100')
				{
					setTimeout("$('#info').removeClass('notice').addClass('success')",1500);
					setTimeout("$('#info_message').html('Proceso finalizado.')",1500);
					setTimeout("$('#info_image').attr('src','<?php echo site_url('img/16x16/accept.png');?>')",1500);
				}
				else{
					$('#info_progress').html('Recuperación cancelada');
					setTimeout("$('#info').removeClass('notice').addClass('error')",1500);
					setTimeout("$('#info_message').html('Ocurrió un error durante la restauración.')",1500);
					setTimeout("$('#info_image').attr('src','<?php echo site_url('img/16x16/cancel.png');?>')",1500);
				}

				if(value == 'error') {
					setTimeout("finish_button(true)",1500);
				}else{
					setTimeout("finish_button(false)",1500);
				}
			}
		},

		error: function(resp)
		{	
			setTimeout("$('#info').removeClass('notice').addClass('error')",1500);
                        setTimeout("$('#info_message').html(resp)",1500);
                        setTimeout("$('#info_image').attr('src','<?php echo site_url('img/16x16/cancel.png');?>')",1500);
			setTimeout("finish_button()",1500);
		}
	});
}

function finish_button(error)
{
	if(!error){
        $( "#details" ).append('<a id="details" href="<?php echo site_url("historial/job/$jobId");?>" style="color: #555;">Ver resumen detallado</a>');
        $( "#details" ).button({
            icons: {
                primary: "ui-icon-search"
            },
        });
	}else{
	  $( "#details" ).append('<a id="details" href="javascript:history.go(-1);" style="color: #555;">Volver al asistente</a>');
        $( "#details" ).button({
            icons: {
                primary: "ui-icon-arrowthick-1-w"
            },
        });
		
	}
	$( "#ending" ).append('<a id="ending" href="<?php echo site_url('asistente');?>" style="color: #555;">Finalizar proceso de restauración</a>');
	
	$( "#ending" ).button({
            icons: {
                primary: "ui-icon-flag"
            },
        });
}
</script>

<br/>
<!-- Progress Bar -->
<div id="progressbar" style="margin:auto"></div>
<br/><br/>

<?php if ($error){ ?>

<div id="info" class="error" style="width:700px; margin:auto;"> 
 <h4 id="info_progress">Restaurando copia:</h4>
        <br/>
        <img src="<?php echo site_url('img/16x16/cancel.png'); ?>"/>
	Ocurrió un error previo a la restauración:
	<div style="margin:20px; margin-left: 40px;">- <?php echo $message; ?></div>
</div>

<?php } else { ?>
<center><h2 id="info_progress" style="margin-top:-20px;">0% completado</h2></center><br/>
<div id="info" class="notice" style="width:700px; margin:auto;"> 
 <h4 id="info_progress">Detalles del proceso</h4>
	<br/>
	<img id="info_image" src="<?php echo site_url('img/loading.gif');?>" style="float:left;margin-right:5px;"/>
	<div id="info_message">	Recuperando copia de seguridad </div>
	<div id="info_status" style="margin:20px; margin-left: 40px;">&nbsp;</div>
</div>
<?php } ?>

<br/><br/>
<div style="margin-left: 210px;">
	<a href="#" id="details"></a>
	<a href="#" id="ending"></a>
</div>
<br/>
</div>
