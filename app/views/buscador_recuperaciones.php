<div id="templatemo_main">
<div id="templatemo_content">
<img src="<?php echo site_url('img/32x32/find.png');?>" style="margin-right: 5px; margin-top: -2px; float: left;"/> <h2>Buscador de recuperaciones</h2>
<div class="content-separator"></div>

<form method="POST" action="<?php echo site_url('buscador/resultados');?>">
<fieldset style="width:680px; margin:auto;">
        <legend><img src="<?php echo site_url('img/16x16/page_find.png'); ?>"  border="0" /> Formulario de búsqueda</legend>
	<input type="hidden" value ="1" name="oculto"/>
        <label>Solicitante</label>
	<input type="text" style="width:430px;" name="orderby"/>
	<br/><br/>
        <label>Propietario</label>
	<input type="text" style="width:430px;" name="owner"/>
	 <br/><br/>
        <label>Fecha de orden</label>
        <input type="text" name="fecha_min" id="fecha" size="10" value="Elija fecha" readonly="readonly"/>
	&nbsp;-&nbsp; 
        <input type="text" name="fecha_max" id="fechamax" size="10" value="Elija fecha" readonly="readonly"/>
	<br/><br/>
	<label>Fecha de backup</label>
        <input type="text" name="fecha_backup_min" id="fecha1" size="10" value="Elija fecha" readonly="readonly"/>
	&nbsp;-&nbsp; 
        <input type="text" name="fecha_backup_max" id="fecha1max" size="10" value="Elija fecha" readonly="readonly"/>
        <br/><br/>
	<label>Tipo</label>
        <script>
        $(function() {

			$( "#fecha" ).datepicker();
                        $( "#fechamax" ).datepicker();
                        $( "#fecha1" ).datepicker();
                        $( "#fecha1max" ).datepicker();

		$( "#radio-tipo" ).buttonset();
		$( "#radio-estado" ).buttonset();

		$( "#radio6" ).button({
                    icons: {
                        primary: "ui-icon-mail-closed"
                    },
                });

		$( "#radio7" ).button({
                    icons: {
                        primary: "ui-icon-calendar"
                    },
                });

		$( "#radio2" ).button({
                    icons: {
                        primary: "ui-icon-check"
                    },
                });

		$( "#radio3" ).button({
                    icons: {
                        primary: "ui-icon-clock"
                    },
                });

		  $( "#radio4" ).button({
                    icons: {
                        primary: "ui-icon-closethick"
                    },
                });
        });
        </script>

        <div id="radio-tipo">
                <input type="radio" id="radio5" name="tipo" checked="checked" value="all"/><label for="radio5">Todos</label>
                <input type="radio" id="radio6" name="tipo" value="mail"/><label for="radio6">Correo</label>
                <input type="radio" id="radio7" name="tipo" value="cal"/><label for="radio7">Calendario</label>
        </div>

        <br/><br/><br/>

        <label>Estado</label> 
        <div id="radio-estado">
		<input type="radio" id="radio1" name="estado" checked="checked" value="all"/><label for="radio1">Todos</label>
		<input type="radio" id="radio2" name="estado" value="success"/><label for="radio2">Terminados</label>
		<input type="radio" id="radio3" name="estado" value="delay"/><label for="radio3">Encolados</label>
		<input type="radio" id="radio4" name="estado" value="error"/><label for="radio4">Fallidos</label>
        </div>

        <br/><br/><br/>
	<label>&nbsp;</label>
	<input type="submit" value="Realizar búsqueda"/>
</fieldset>
</form>
<br/><br/>
</div>
