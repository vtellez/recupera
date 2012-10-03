<div id="templatemo_main_2col">
	<div id="templatemo_content_2col">
        <img src="<?php echo site_url('img/32x32/database_go.png'); ?>" style="margin-right: 5px; margin-top: -2px; float: left;"/> <h2>Recuperar copia de seguridad</h2>
	<div class="content-separator"></div>


<?php if($warning){ ?>

<div class="notice">        <a href="<?php echo site_url('ayuda#3.5'); ?>">
        <img src="<?php echo site_url('img/16x16/help.png'); ?>"/>
        Recuper@ tiene peticiones pendientes, es posible que esta recuperación <font color="blue">quede encolada</font>.
        </a>
</div><br/>

<?php } ?>


<script>
$(document).ready(function() {
	$("#browsable").scrollable({keyboard:false});

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

		<?php
                        if($this->controlacceso->permisoAdministracion())
                        {
                ?>

			if(cont == 2){
				change_user();
			}

		<?php } ?>
		
		$( "#progreso").replaceWith("<div id='progreso'>Progreso "+ porciento +"%</div>");
		$( "#arrow").hide('fade');

		//Generación de resumen
                $( "#resumen" ).replaceWith('<div id=\"resumen\" style=\"margin-left:70px;\">');
		<?php 
                        if($this->controlacceso->permisoAdministracion())
                        {
		?>
       	        $( "#resumen" ).append('<li>Usuario (UVUS): <b>' + document.getElementById("uvus").value + '</b></li>');
		<?php }else { ?>
       	        $( "#resumen" ).append('<li>Usuario (UVUS): <b><?php echo $this->session->userdata('uid');?></b></li>');
		<?php } ?>
               	$( "#resumen" ).append('<li>Fecha: <b>' + document.getElementById("fecha").value + '</b></li>');

		var indice = document.forms[0]["restore"]["selectedIndex"];
		var textoEscogido = document.forms[0]["restore"]["options"][indice]["text"];	

                $( "#resumen" ).append('<li>Calendario: <b>' + textoEscogido  +' </b></li>');
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


<?php if($this->controlacceso->permisoAdministracion()) { ?>
<script type="text/javascript">
function change_user()
{
	/*
	* Función que se encarga de realizar una consulta AJAX para obtener
	* el listado de calendarios del usuario especificado en el campo UVUS 
	*/
	var uvus = $('input#uvus').val();
	$.ajax(
	{
		type: 'POST',
		url: '<?php echo base_url(); ?>asistente/change_user',
		data: 'uvus='+uvus,

		beforeSend : function (resp) {
		},

		success: function(resp) 
		{
			$( "select#restore" ).html(resp);
			
		},

		error: function(resp)
		{	
			alert ( " Error ! " + resp );
		}
	});
}
</script>

<?php } //if permiso admin ?>
<div id="barra"></div>
<br/>

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
		<h4>Asitente de restauración de agenda</h4>
                <br/>
                <img src="<?php echo site_url('img/32x32/book_addresses.png'); ?>" class="left bordered"/>
                <h5>Instrucciones</h5>
                <p>Siga los pasos indicados a continuación en este asistente para recuperar una copia de seguridad de su agenda virtual corporativa.</p>
		<br/>
                <p style="margin-left: 72px;">Si tiene cualquier duda acerca del uso de este asistente, consulte nuestra <a href="<?php echo site_url('ayuda#3'); ?>">sección de ayuda</a> donde se detalla el proceso de restauración paso a baso.</p>

	</div>

	<div>

		<h4>Paso 1 de 4</h4>
                <br/>
                <img src="<?php echo site_url('img/32x32/user.png'); ?>" class="left bordered"/>
                <h5>Datos de usuario</h5>
                <p>Indique el nombre del usuario virtual (UVUS) para el que se debe realizar la restauración de la agenda virtual.</p><br/>
                <label>Usuario</label>
			<form method="POST" id="asistant" action="<?php echo site_url('asistente/restore_calendar'); ?>" autocomplete="off">
                <?php
                        $disabled = "";
                        $readonly = "";
                        if(!$this->controlacceso->permisoAdministracion()) {
                                $readonly = 'readonly="readonly"';
                                $disabled = 'disabled="disabled"';

                        }
                ?>
                        <input type="text" name="uvus" value="<?php echo "$uid"; ?>" id="uvus" size="50" style="width:40%" <?php echo $readonly;?>/>
                        <br/><br/>
	</div>

        <div>
                <h4>Paso 2 de 4</h4>
                <br/>
                <img src="<?php echo site_url('img/32x32/calendar_add.png'); ?>" class="left bordered"/>
                <h5>Calendario a restaurar</h5>
                <p>Indique que calendario de su agenda desea recuperar.</p><br/>

                <label>Seleccione</label>
                <select name="restore" id="restore" style="width:50%;">
                <?php
                        $data["calendars"] = $calendars;
                        $this->load->view('calendars_list',$data);
                ?>
                </select>
        </div>



        <div>
        <h4>Paso 3 de 4</h4>
                <br/>
                <img src="<?php echo site_url('img/32x32/calendar.png'); ?>" class="left bordered"/>
                <h5>Fecha de restauración</h5>
                <p>¿De qué día desea recuperar su calendario?<br/> Puede elegir una copia de seguridad de las últimas 3 semanas.</p><br/>
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
		<div style="margin-left:210px;">
	                <input value="Datos correctos, recuperar calendario" type="submit">
		</div>
	</div>
   </div>

</form>
</div>

<a class="next browse right" id="next"></a>

<br clear="all">

 	</div>
