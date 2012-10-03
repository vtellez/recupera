<div id="templatemo_main_2col">
	<div id="templatemo_content_2col">
        <img src="<?php echo site_url('img/32x32/database_go.png'); ?>" style="margin-right: 5px; margin-top: -2px; float: left;"/> <h2>Recuperar copia de seguridad</h2>
	<div class="content-separator"></div>


<?php if($warning){ ?>
<div class="notice">
	<a href="<?php echo site_url('ayuda#3.5'); ?>">
	<img src="<?php echo site_url('img/16x16/help.png'); ?>"/>
	Recuper@ tiene peticiones pendientes, es posible que esta recuperación <font color="blue">quede encolada</font>.
	</a>
</div><br/>
<?php } ?>

<script>
$(document).ready(function() {
	$("#browsable").scrollable({keyboard:false});
	$("#dominio").buttonset();

        $(document).keydown(function(objEvent) {
		if (objEvent.keyCode == 9 || objEvent.keyCode == 13) {  //tab or return pressed
                        objEvent.preventDefault(); // stops its action
                }
        })

	var cont = 0;
	var max = 4;
	var porciento = 0;
	var slider = $( "<div id='slider'><h6><div id='progreso'>Progreso 0%</div></h6></div>" ).insertAfter( "#barra" ).slider({
			min: 0,
			max: max,
			animate: false,
			range: "min",
			value: 0,
			slide: function( event, ui ) {
				select[ 0 ].selectedIndex = ui.value - 1;
			}
		});
	slider.slider( "value", 0 );
	$( "#next" ).click(function() {
		cont++;
		slider.slider( "value", cont );
		porciento = Math.ceil(cont/max*100);
		
		$( "#progreso").replaceWith("<div id='progreso'>Progreso "+ porciento +"%</div>");
		$( "#arrow").hide('fade');

		//Generación de resumen
                $( "#resumen" ).replaceWith('<div id=\"resumen\" style=\"margin-left:70px;\">');
		
		var dominio = 'us.es';
		if(document.getElementById("radio2").checked) {	
			dominio = document.getElementById("radio2").value;
		}
		
		<?php
                        if($this->controlacceso->permisoAdministracion())
                        {
                ?>
       	        $( "#resumen" ).append('<li>Cuenta de correo: <b>' + document.getElementById("uvus").value +"@"+ dominio  +  '</b></li>');
		<?php }else { ?>
       	        $( "#resumen" ).append('<li>Cuenta de correo: <b><?php echo $this->session->userdata('mail');?></b></li>');
		<?php }?>
		
		var carpeta = document.getElementById("folder_name").value;

		if(document.getElementById("inbox").checked) {
			carpeta = document.getElementById("inbox").value;
		}else if(document.getElementById("trash").checked) {
                        carpeta = document.getElementById("trash").value;
                }else if(document.getElementById("sent").checked) {
                        carpeta = document.getElementById("sent").value;
                }



               	$( "#resumen" ).append('<li>Carpeta a recuperar: <b>' + carpeta  + '</b></li>');


               	$( "#resumen" ).append('<li>Fecha de recuperación: <b>' + document.getElementById("fecha").value + '</b></li>');
	});

  $( "#back" ).click(function() {
                cont--;
                slider.slider( "value", cont );
                porciento = Math.ceil(cont/max*100);
                if(porciento == 0) 
                {
                        $( "#arrow").show('fade');
                }

                $( "#progreso").replaceWith("<div id='progreso'>Progreso "+ porciento +"%</div>");
        });     
});
</script>


<!-- ui-dialog -->
<div id="info_folder_dialog" title="Instrucciones para especificar el nombre de una carpeta">
	<p><img src="https://recupera-pre.us.es/img/32x32/folder_find.png" style="float:left; margin:5px 10px 0 0;">
	<br/>A continuación, se detalla como especificar el nombre de una carpeta de nuestro buzón de correo.
	<br/></p>
	<p>Para recuperar una carpeta cualquiera, tan solo debe especificarse su nombre en el campo titulado como "<i>Especifique carpeta</i>". En el caso de que se trate de una subcarpeta (carpeta contenida dentro de otra), deben separarse los nombres de la carpetas mediante una barra (<b>/</b>).</p>
	<p>Por ejemplo, supongamos que tenemos la siguiente estructura de carpetas en nuestro buzón de correo:</p>
	<img src="<?php echo site_url('img/ejemplo_carpetas.png'); ?>" />
	<br/>
	<br/>
	<p>Si queremos recuperar la subcarpeta 2012, perteneciente a la carpeta padre "Archivados", deberemos especificar como nombre de carpeta el valor: <i><b>Archivados/2012.</b></i>
</div>

<script type="text/javascript">
$(function() {
        //Dialog
        $('#info_folder_dialog').dialog({
                autoOpen: false,
                width: 700,
                buttons: [
                                {
                                        text:"Cerrar esta ventana",
                                        click: function() { 
                                                        $(this).dialog("close"); 
                                        }
                                } 
                        ],
                 modal: true
          });

         // Dialog Link
         $('#info_folder_dialog_link').click(function(){
                $('#info_folder_dialog').dialog('open');
                return false;
         });
});
</script>




<div id="barra"></div>
<br/>

<form id="form" action="<?php echo site_url('asistente/restore_mailbox'); ?>" method="POST" autocomplete="off">

<div class="navi">
	<a class="active" href="#0"></a>
	<a class="" href="#1"></a>
	<a class="" href="#2"></a>
	<a class="" href="#3"></a>
	<a class="" href="#4"></a>
	<a class="" href="#5"></a>
</div>

		<div id="arrow"/>&nbsp;</div>

<a class="prev browse left disabled" id="back"></a>
<div class="scrollable" id="browsable">   
   <div style="left: 0px;" class="items">
	<div>
		<h4>Asitente de restauración de buzón</h4>
		<br/>
		<img src="<?php echo site_url('img/32x32/email_go.png'); ?>" class="left bordered"/>
		<h5>Instrucciones</h5>
		<p>Siga los pasos indicados a continuación en este asistente para recuperar una copia de seguridad de su buzón.</p>
		<br/>
		<p style="margin-left: 72px;">Si tiene cualquier duda acerca del uso de este asistente, consulte nuestra <a href="<?php echo site_url('ayuda/#3');?>">sección de ayuda</a> donde se detalla el proceso de restauración paso a paso.</p>
	</div>

	<div>
		<h4>Paso 1 de 4</h4>
		<br/>
		<img src="<?php echo site_url('img/32x32/user.png'); ?>" class="left bordered"/>
		<h5>Datos de usuario</h5>
		<p>Indique para qué usuario (y dominio) se debe realizar la restauración del buzón.</p>
		<label>Usuario</label>
		<?php
			$disabled = "";
			$readonly = "";
                        if(!$this->controlacceso->permisoAdministracion()) {
				$readonly = 'readonly="readonly"';
				$disabled = 'disabled="disabled"';
				
			}
                ?>
		<input type="text" name="uvus" value="<?php echo $this->session->userdata('uid'); ?>" id="uvus" size="50" style="width:40%" <?php echo $readonly;?>/><br/><br/>
                <label>Dominio</label>
		<?php 
			$us = 'checked="checked"';
			$alum = '';

			list($uid,$dom) = split('@',$this->session->userdata('mail'));

			if($dom == "alum.us.es"){
				$us = '';
				$alum = 'checked="checked"';
			}
		?>
		<span id="dominio">
			<input type="radio" id="radio1" value="us.es" name="dom" <?php echo $disabled." ".$us;?>/>
			<label for="radio1">@us.es</label>
			<input type="radio" id="radio2" value="alum.us.es" name="dom" <?php echo $disabled." ".$alum;?>/>
			<label for="radio2">@alum.us.es</label>
		</span>
	</div>


	<div>
		<h4>Paso 2 de 4</h4>
		<br/>
		<img src="<?php echo site_url('img/32x32/folder_explore.png'); ?>" class="left bordered"/>
		<h5>Carpeta a restaurar</h5>
		<p>Indique que carpeta desea restaurar. Si la carpeta que desea recuperar no aparece en las opciones siguientes, especifique su nombre.</p>
	
	<div id="pix">
	<input type="radio" name="folder" checked="checked" id="inbox" value="INBOX"/>
	<img src="<?php echo site_url('img/32x32/email_back.png'); ?>" /> Recibidos

        <input type="radio" name="folder" id="sent" value="Sent"/>
        <img src="<?php echo site_url('img/32x32/email_go.png'); ?>" /> Enviados

	<input type="radio" name="folder" id="trash" value="Trash"/>
	<img src="<?php echo site_url('img/32x32/bin.png'); ?>" /> Papelera

	<input type="radio" name="folder" id="otraradio" value="Otra"/>
	<img src="<?php echo site_url('img/32x32/folder_find.png'); ?>" />
	</div>
<script type="text/javascript">
$(function() {
        $( "#otra" ).hide();

	$( "#otraradio" ).click(function() {	
        	$( "#otra" ).show('fade');
        });

	$( "#inbox, #trash, #sent" ).click(function() {    
                $( "#otra" ).hide('fade');
        });

});
</script>

	<div id="otra">
		<label>Especifique carpeta</label>
                <input type="text" name="folder_name" value="" id="folder_name" maxlength="150" size="50" style="width:40%"/>
		<div style="margin-top: -7px; margin-left: 12px;">
			<a href="#" id="info_folder_dialog_link"><img src="<?php echo site_url('img/16x16/help.png'); ?>" /> ¿Cómo especificar el nombre de una carpeta?</a>
		</div>
	</div>
</div>


        <div>
        <h4>Paso 3 de 4</h4>
                <br/>
                <img src="<?php echo site_url('img/32x32/calendar.png'); ?>" class="left bordered"/>
                <h5>Fecha de la copia</h5>
                <p>¿De qué día desea recuperar su buzón de correo?<br/> Puede elegir una copia de seguridad de las últimas 3 semanas.</p><br/>
                <label>Fecha</label>
                <input type="text" name="fecha" id="fecha" size="10" value="<?php echo date("d/m/Y",time()-86400); ?>" readonly="readonly"/>
                <script type="text/javascript">//<![CDATA[
                $(function() {
                         <?php if(!$this->controlacceso->permisoAdministracion()) { ?>
                        $( "#fecha" ).datepicker( { minDate: "-21D", maxDate: "-1D"});
                        <?php }else{ ?>
                                $( "#fecha" ).datepicker( { maxDate: "-1D"});
                        <?php } ?>
                });
                //]]></script>
        </div>


         <div>
                <h4>Paso 4 de 4</h4>
                <br/>
                <img src="<?php echo site_url('img/32x32/accept.png'); ?>" class="left bordered"/>
                <h5>Confirmación</h5>
                <p>Confirme que los siguientes datos son correctos.</p>
                <div id="resumen"> </div>
                <div style="margin-left:230px;">
                        <input value="Datos correctos, recuperar buzón" type="submit">
                </div>
        </div>
   </div>

</form>
</div>

<a class="next browse right" id="next"></a>

<br clear="all">

        </div>
