<!DOCTYPE html>
<html lang="es-ES">
	<head>
		<!-- Info-->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport"              content="width=device-width, initial-scale=1, user-scalable=no">
		<meta http-equiv="Content-Type"    content="text/html; charset=UTF-8">

		<!-- Información del sitio-->
		<?php
		//Se verifican las variables para mostrar el titulo e la pagina
		if (isset($_SESSION['usuario']['basic_data']['RazonSocial'])&&$_SESSION['usuario']['basic_data']['RazonSocial']!=''){
			if (isset($_SESSION['usuario']['Permisos'][$original]['TransaccionNombre'])&&$_SESSION['usuario']['Permisos'][$original]['TransaccionNombre']!=''){
				echo '<title>'.TituloMenu($_SESSION['usuario']['Permisos'][$original]['TransaccionNombre']).' - '.$_SESSION['usuario']['basic_data']['RazonSocial'].'</title>';
			}else{
				echo '<title>'.$_SESSION['usuario']['basic_data']['RazonSocial'].'</title>';
			}
		}else{
			echo '<title>'.DB_SOFT_NAME.'</title>';
		} ?>
		<meta name="description"           content="">
		<meta name="author"                content="">
		<meta name="keywords"              content="">

		<!-- WEB FONT -->
		<?php
		//verifica la capa de desarrollo
		$whitelist = array( 'localhost', '127.0.0.1', '::1' );
		////////////////////////////////////////////////////////////////////////////////
		//si estoy en ambiente de desarrollo
		if( in_array( $_SERVER['REMOTE_ADDR'], $whitelist) ){
			echo '<link rel="stylesheet" href="'.DB_SITE_REPO.'/LIB_assets/lib/font-awesome/css/font-awesome.min.css">';
			//echo '<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">';

		////////////////////////////////////////////////////////////////////////////////
		//si estoy en ambiente de produccion
		}else{
			echo '<link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">';
			echo '<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">';
		}
		?>

		<!-- CSS Base -->
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIB_assets/lib/bootstrap3/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIB_assets/lib/font-awesome-animation/font-awesome-animation.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/Legacy/gestion_modular/css/main.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/Legacy/gestion_modular/css/theme_color_<?php if(isset($_SESSION['usuario']['basic_data']['Config_idTheme'])&&$_SESSION['usuario']['basic_data']['Config_idTheme']!=''){echo $_SESSION['usuario']['basic_data']['Config_idTheme'];}else{echo '1';} ?>.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/Legacy/gestion_modular/lib/fullcalendar/fullcalendar.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/Legacy/gestion_modular/css/my_style.css?<?php echo time(); ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIB_assets/css/my_colors.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIB_assets/css/directionalButtons/dist/bootstrap-directional-buttons.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIB_assets/css/bttn/dist/bttn.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/Legacy/gestion_modular/css/my_corrections.css?<?php echo time(); ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIBS_js/prism/prism.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIBS_js/elegant_font/css/style.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIBS_js/bootstrap_touchspin/src/jquery.bootstrap-touchspin.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIBS_js/material_datetimepicker/css/bootstrap-material-datetimepicker.min.css" >
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIBS_js/clock_timepicker/dist/bootstrap-clockpicker.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIBS_js/bootstrap_colorpicker/dist/css/bootstrap-colorpicker.min.css" >
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIBS_js/bootstrap_colorpicker/dist/css/bootstrap-colorpicker-plus.min.css" >
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIBS_js/bootstrap_fileinput/css/fileinput.min.css" media="all" >
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIBS_js/bootstrap_fileinput/themes/explorer/theme.min.css" media="all" >
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIBS_js/country_picker/css/bootstrap-select.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIBS_js/chosen/chosen.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIBS_js/modal/colorbox.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIBS_js/tooltipster/css/tooltipster.bundle.min.css">

		<!-- Javascript -->
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/Legacy/gestion_modular/js/main.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIB_assets/js/form_functions.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIB_assets/js/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIB_assets/js/jquery-1.11.0.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/rut_validate/jquery.rut.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/bootstrap_touchspin/src/jquery.bootstrap-touchspin.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/material_datetimepicker/js/moment-with-locales.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/material_datetimepicker/js/bootstrap-material-datetimepicker.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/clock_timepicker/dist/bootstrap-clockpicker.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/autosize/dist/autosize.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/ckeditor/ckeditor.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/bootstrap_fileinput/js/plugins/sortable.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/bootstrap_fileinput/js/fileinput.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/bootstrap_fileinput/js/locales/es.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/bootstrap_fileinput/themes/explorer/theme.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/country_picker/js/bootstrap-select.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/plotly_js/dist/plotly.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/plotly_js/dist/plotly-locale-es-ar.js"></script>

		<!-- Favicons-->
		<?php
		//Favicon Personalizado
		$nombre_fichero = 'img/mifavicon.png';
		if (file_exists($nombre_fichero)){ ?>
			<link rel="icon"             type="image/png"                    href="img/mifavicon.png" >
			<link rel="shortcut icon"    type="image/x-icon"                 href="img/mifavicon.png" >
			<link rel="apple-touch-icon" type="image/x-icon"                 href="img/mifavicon-57x57.png">
			<link rel="apple-touch-icon" type="image/x-icon" sizes="72x72"   href="img/mifavicon-72x72.png">
			<link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="img/mifavicon-114x114.png">
			<link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="img/mifavicon-144x144.png">
		<?php
		//Favicon predefinido
		}else{ ?>
			<link rel="icon"             type="image/png"                    href="<?php echo DB_SITE_REPO ?>/LIB_assets/img/favicons/favicon.png" >
			<link rel="shortcut icon"    type="image/x-icon"                 href="<?php echo DB_SITE_REPO ?>/LIB_assets/img/favicons/favicon.png" >
			<link rel="apple-touch-icon" type="image/x-icon"                 href="<?php echo DB_SITE_REPO ?>/LIB_assets/img/favicons/apple-touch-icon-57x57-precomposed.png">
			<link rel="apple-touch-icon" type="image/x-icon" sizes="72x72"   href="<?php echo DB_SITE_REPO ?>/LIB_assets/img/favicons/apple-touch-icon-72x72-precomposed.png">
			<link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="<?php echo DB_SITE_REPO ?>/LIB_assets/img/favicons/apple-touch-icon-114x114-precomposed.png">
			<link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="<?php echo DB_SITE_REPO ?>/LIB_assets/img/favicons/apple-touch-icon-144x144-precomposed.png">
		<?php } ?>

		<!-- Correcciones CSS -->
		<style>
			body {background-color: #FFF !important;}
			.outer {padding: 0px;}
			.inner {padding-right: 0px;padding-left: 0px;}
		</style>

	</head>
	<body class="sidebar-left-hidden">
		<div id="loader-wrapper">
			<div id="loader"></div>
			<div class="loader-section section-left"></div>
			<div class="loader-section section-right"></div>
		</div>
	<?php
	//verifica la capa de desarrollo
	$whitelist = array( 'localhost', '127.0.0.1', '::1' );
	//si estoy en ambiente de desarrollo
	if( in_array( $_SERVER['REMOTE_ADDR'], $whitelist) ){

	//si estoy en ambiente de produccion
	}else{	
		/*    Global Variables    */
		//Tiempo Maximo de la consulta, 40 minutos por defecto
		if(isset($_SESSION['usuario']['basic_data']['ConfigTime'])&&$_SESSION['usuario']['basic_data']['ConfigTime']!=0){$n_lim = $_SESSION['usuario']['basic_data']['ConfigTime']*60;set_time_limit($n_lim);}else{set_time_limit(2400);}
		//Memora RAM Maxima del servidor, 4GB por defecto
		if(isset($_SESSION['usuario']['basic_data']['ConfigRam'])&&$_SESSION['usuario']['basic_data']['ConfigRam']!=0){$n_ram = $_SESSION['usuario']['basic_data']['ConfigRam']; ini_set('memory_limit', $n_ram.'M');}else{ini_set('memory_limit', '4096M');}
	}
	/***********************************************/
	//Elimino los datos previos del form
	unset($_SESSION['form_require']);
	//se carga dato previo
	$_SESSION['form_require'] = 'required'; ?>
		<div id="wrap">
			<div id="top">
				<nav class="navbar navbar-inverse navbar-static-top">
					<div class="container-fluid">
						<header class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
							<a href="principal.php" class="navbar-brand">
								<?php require_once 'Web.Body.Nav.Logo.php'; ?>
							</a>
						</header>
						<?php require_once 'Web.Body.Nav.Actions.php'; ?>
						<div class="collapse navbar-collapse navbar-ex1-collapse">
							<?php require_once 'Web.Body.Nav.Menu_top.php'; ?>
						</div>
					</div>
				</nav>
				<header class="head">
					<div class="main-bar">
						<h3>
							<?php echo $t_dashboard; ?>
						</h3>
					</div>
				</header>
			</div>
			<div id="left">
			</div>
			<div id="content">
				<div class="outer">
					<div class="inner">
