<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<meta name="description" content="Recupera. Universidad de Sevilla."/>
<meta name="keywords" content="Recupera, Recuper@, Buzones,  Universidad, Sevilla" />
<meta name="author" content="Víctor Téllez - vtellez@us.es Servicio de Informática y Comunicaciones" />
<link href='https://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>
<link rel="shortcut icon" type="image/x-icon" href="<?php echo site_url('img/favicon.ico'); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo site_url('css/estilo.css'); ?>" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php echo site_url('js/css/Aristo/jquery-ui-1.8.7.custom.css'); ?>" media="screen" />

<?php
if (isset($css_adicionales)) {
	foreach ($css_adicionales as $css) {
?>
			<link rel="stylesheet" href="<?php echo site_url($css) ?>"
			type="text/css" media="screen" />
<?php
	}
}
?>

<script src="<?php echo site_url('js/jquery.js');?>"></script>
<script src="<?php echo site_url('js/jquery-ui-1.8.13.custom.min.js');?>"></script>

<?php
if (isset($js_adicionales)) {
	foreach ($js_adicionales as $js) {
		?>
			<script type="text/javascript"
			src="<?php echo site_url($js) ?>"></script>
			<?php
	}
}
?>

<title>Recuper@ | <?php echo $subtitulo; ?></title>
</head>
<body>


<?php if(false){ ?>
<!-- Barra de servicios de la Universidad de Sevilla -->
<iframe 
	src="http://choquito.us.es/propuesta/" 
	id="panelUS"
	name="panelUS" 
	style="
		width:100%; 
		height:40px;
		position: fixed;
		top: 0;
		left: 0;
		right: 0;
		z-index: 1000;
		" 
	scrolling="no"
	frameborder="0"
	allowtransparency="allowtransparency">
</iframe>
<div style="height: 50px;">&nbsp;</div>
<!-- /Barra de servicios de la Universidad de Sevilla -->
<?php } ?>

<div id="toTop"> ^ </div>
<div style="height: 5px;">&nbsp;</div>
<div id="templatemo_header">
	<div id="logo"> &nbsp;</div>
	<div id="descripcion"></div>
</div>

<div id="templatemo_menu">      
<ul>
<li><a href="<?php echo site_url('');?>" <?php echo ($controlador == "inicio")?'class="current"':''; ?>><img src="<?php echo site_url('img/16x16/house.png'); ?>"/> Inicio</a></li>

<li><a href="<?php echo site_url('asistente');?>"  <?php echo ($controlador == "asistente")?'class="current"':''; ?>><img src="<?php echo site_url('img/16x16/database_go.png'); ?>"/> Recuperar</a></li>
<li><a href="<?php echo site_url('historial');?>" <?php echo ($controlador == "historial")?'class="current"':''; ?>><img src="<?php echo site_url('img/16x16/calendar.png'); ?>"/> Historial</a></li>
<?php  if ($this->controlacceso->permisoAdministracion()) { ?>
<li><a href="<?php echo site_url('buscador');?>" <?php echo ($controlador == "buscador")?'class="current"':''; ?>><img src="<?php echo site_url('img/16x16/find.png'); ?>"/> &nbsp;Buscador</a></li>
<?php }//control de aceso ?>
<li><a href="<?php echo site_url('ayuda');?>"  <?php echo ($controlador == "ayuda")?'class="current"':''; ?> ><img src="<?php echo site_url('img/16x16/help.png'); ?>"/> Ayuda</a></li>
<li><a href="<?php echo site_url('indicadores');?>" <?php echo ($controlador == "indicadores")?'class="current"':''; ?>><img src="<?php echo site_url('img/16x16/chart_bar.png'); ?>"/> Indicadores</a></li>
<?php  if ($this->controlacceso->permisoAdministracion()) { ?>
<li><a href="<?php echo site_url('admin');?>" <?php echo ($controlador == "admin")?'class="current"':''; ?>><img src="<?php echo site_url('img/16x16/key.png'); ?>"/> Admin</a></li>
<?php }//control de aceso ?>
<li><a href="#" id="dialog_link" <?php echo ($controlador == "logout")?'class="current"':''; ?>><img src="<?php echo site_url('img/16x16/lock_go.png'); ?>"/> Salir</a></li>
</ul>
</div>

<!-- ui-dialog -->
		<div id="dialog" title="Confirmar cierre de sesión para <?php echo $this->session->userdata('uid'); ?>">
		<p><br/><img src="<?php echo site_url("img/32x32/lock_go.png");?>" style="float:left; margin:5px 10px 0 0;">
		¿Está seguro de que desea cerrar su sesión de usuario abierta en la <a href="http://www.us.es/campus/univirtual/gestioniden/opensso.html" target="_blank">plataforma Single Sign-On</a> de la Universidad de Sevilla para la cuenta <b><?php echo $this->session->userdata('uid'); ?></b>?<br/><br/><br/></p>
</div>
