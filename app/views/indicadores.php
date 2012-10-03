<div id="templatemo_main">
	<div id="templatemo_content">
	<img src="<?php echo site_url("img/32x32/chart_bar.png"); ?>" 
		style="margin-right: 5px; margin-top: -2px; float: left;"/> 
	<h2>Indicadores de la aplicación</h2>
<div class="content-separator"></div>
<script>
	$(function() {
		$( "#tabs" ).tabs();
		$( "input submit" ).button();
	});
	</script>


<div id="tabs">
	<ul>
		<li><a href="#tabs-1">Indicadores generales</a></li>
	<!--	<li><a href="#tabs-2">Indicadores de actividad</a></li> -->
		<li><a href="#tabs-3">Indicadores de usuarios</a></li>
	</ul>

<div id="tabs-1">
        <?php
		//Gráfica de volumen de recuperaciones
                $this->load->view('graph', $volumen);

		//Gráfica de recuperaciones por estado
                $this->load->view('graph', $estado);

		//Gráficas de recuperaciones de correo por dominio
                $this->load->view('graph', $dominios);
        ?>
</div>


<!--

<div id="tabs-2">
    <fieldset>
                <legend>Indicadores de actividad de Recuper@</legend>
			<div id="label2">
				Mes: 
				<select id="">
					<option value="">Opción</option>
				</select>	
                               	/ Año: 
                                <select id="">
                                        <option value="">Opción</option>
                                </select>    
				<input type="submit" value="Consultar fecha" />
			</div>
                </ul>
        </fieldset>
	<ul>
		 <li>Gráfica de actividad mensual</li>
                <li>Gráfica de actividad anual</li>
                <li>Gráfica de actividad histórica</li>
	</ul>		
</div>
-->

<div id="tabs-3">

<?php
		//GRAFICA Usuarios con más recursos recuperados
                $this->load->view('graph', $urecuperados);
                
                //GRAFICA Usuarios más activos
                $this->load->view('graph', $uactivos);
?>

</div>


</div>


	</div> <!-- col izquierda -->

