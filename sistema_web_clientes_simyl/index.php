<?php session_start();
/**********************************************************************************************************************************/
/*                                           Se define la variable de seguridad                                                   */
/**********************************************************************************************************************************/
define('XMBCXRXSKGC', 1);
/**********************************************************************************************************************************/
/*                                                          Seguridad                                                             */
/**********************************************************************************************************************************/
require_once '../A2XRXS_gears/xrxs_seguridad/AntiXSS.php';
require_once '../A2XRXS_gears/xrxs_seguridad/Bootup.php';
require_once '../A2XRXS_gears/xrxs_seguridad/UTF8.php';
$security = new AntiXSS();
$_POST = $security->xss_clean($_POST);
$_GET  = $security->xss_clean($_GET);
/**********************************************************************************************************************************/
/*                                          Se llaman a los archivos necesarios                                                   */
/**********************************************************************************************************************************/
require_once 'A1XRXS_sys/xrxs_configuracion/config.php';                                  //Configuracion de la plataforma
require_once '../Legacy/gestion_modular/funciones/Helpers.Functions.Propias.php';         //carga librerias de la plataforma
require_once '../Legacy/gestion_modular/funciones/Components.UI.FormInputs.Extended.php'; //carga formularios de la plataforma
require_once '../Legacy/gestion_modular/funciones/Components.UI.Inputs.Extended.php';     //carga inputs de la plataforma
require_once '../Legacy/gestion_modular/funciones/Components.UI.Widgets.Extended.php';    //carga widgets de la plataforma

// obtengo puntero de conexion con la db
$dbConn = conectar();
//Se elimina la restriccion del sql 5.7
mysqli_query($dbConn, "SET SESSION sql_mode = ''");
/**********************************************************************************************************************************/
/*                                          Modulo de identificacion del documento                                                */
/**********************************************************************************************************************************/
//Cargamos la ubicacion 
$original = "index.php";
/**********************************************************************************************************************************/
/*                                               Se cargan los formularios                                                        */
/**********************************************************************************************************************************/
//formulario para iniciar sesion
if ( !empty($_POST['submit_login']) )  { 
	$form_trabajo= 'login';
	require_once 'A1XRXS_sys/xrxs_form/clientes_listado.php';
}
//formulario para recuperar la contraseña
if ( !empty($_POST['submit_pass']) )  { 
	$form_trabajo= 'getpass';
	require_once 'A1XRXS_sys/xrxs_form/clientes_listado.php';
}
/**********************************************************************************************************************************/
/*                                                     Armado del form                                                            */
/**********************************************************************************************************************************/
//Elimino los datos previos del form
unset($_SESSION['form_require']);
//se carga dato previo
$_SESSION['form_require'] = 'required';
?>
<!DOCTYPE html>
<html lang="es-ES">
	<head>
		<!-- Info-->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport"              content="width=device-width, initial-scale=1, user-scalable=no">
		<meta http-equiv="Content-Type"    content="text/html; charset=UTF-8">
		
		<!-- Informacion del sitio-->
		<title>Login</title>
		<meta name="description"           content="">
		<meta name="author"                content="">
		<meta name="keywords"              content="">
		
		<!-- WEB FONT -->
		<link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
		
		<!-- CSS Base -->
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIB_assets/lib/bootstrap3/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIB_assets/lib/font-awesome-animation/font-awesome-animation.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/Legacy/gestion_modular/css/main.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/Legacy/gestion_modular/css/theme_color_<?php if(isset($_SESSION['usuario']['basic_data']['Config_idTheme'])&&$_SESSION['usuario']['basic_data']['Config_idTheme']!=''){echo $_SESSION['usuario']['basic_data']['Config_idTheme'];}else{echo '1';} ?>.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/Legacy/gestion_modular/lib/fullcalendar/fullcalendar.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/Legacy/gestion_modular/css/my_style.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIB_assets/css/my_colors.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/Legacy/gestion_modular/css/my_corrections.css">
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
		if (file_exists($nombre_fichero)) { ?>
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
			.register-heading {margin-top: 0;}
			.login {background-color: #191d1e;background-image: none;background-size: 100%;}
			.login .form-signin {-webkit-box-shadow: none !important;-moz-box-shadow: none !important;box-shadow: none !important;position: relative;}
			html, body{
				width:100%; 
				height:100%; 
				padding:0px; 
				margin:0px;
				/*overflow: hidden;*/
				background: #191d1e; /* Old browsers */
				background: -moz-linear-gradient(0deg,  #191d1e 50%, #283139 100%); /* FF3.6+ */
				background: -webkit-gradient(linear, left top, right bottom, color-stop(50%,#191d1e), color-stop(100%,#283139)); /* Chrome,Safari4+ */
				background: -webkit-linear-gradient(0deg,  #191d1e 50%,#283139 100%); /* Chrome10+,Safari5.1+ */
				background: -o-linear-gradient(0deg,  #191d1e 50%,#283139 100%); /* Opera 11.10+ */
				background: -ms-linear-gradient(0deg,  #191d1e 50%,#283139 100%); /* IE10+ */
				background: linear-gradient(0deg,  #191d1e 50%,#283139 100%); /* W3C */
				filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#191d1e', endColorstr='#283139',GradientType=1 ); /* IE6-9 fallback on horizontal gradient */
				background-attachment: fixed
			}
			#projector {position: absolute; top: 0px;left: 0px;width:100%;height:100%;} 
			.center-div {width:580px;height:374px;position:absolute;left:50%;top:50%;margin-left: -290px;margin-top:  -187px;}
			#preloaderDiv{position:absolute;left:50%;top:50%;margin-left: -27px;margin-top:  -27px;}
			#logo{opacity:0;filter: alpha(opacity=0);}
			#date2014{position:absolute;padding-left: 210px;padding-top:15px;opacity:0;top:303px;left:0;filter: alpha(opacity=0);}			
		</style>
	</head>
	<body class="login">
		<!-- partial:index.partial.html -->
		<canvas id="projector">Your browser does not support the Canvas element.</canvas>
		<!-- partial -->
		<script src="<?php echo DB_SITE_REPO ?>/LIBS_js/ambient-background/js/easeljs-0.7.1.min.js"></script>
		<script src="<?php echo DB_SITE_REPO ?>/LIBS_js/ambient-background/js/TweenMax.min.js"></script>
		<script src="<?php echo DB_SITE_REPO ?>/LIBS_js/ambient-background/js/script.js"></script>

<?php
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])) {$error['usuario'] 	  = 'sucess/Usuario Creado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);};

/**********************************************************************************************************************************/
/*                                                   Verificacion bloqueos                                                        */
/**********************************************************************************************************************************/
//calculos
$bloqueo=0;
//reviso si se conecta desde chile
$INT_IP   = obtenerIpCliente();
$INT_Pais = obtenerInfoIp($INT_IP, "countryName");

//Se consultan los datos
$Mantenciones = db_select_data (false, 'Fecha, Hora_ini, Hora_fin', 'core_mantenciones', '', "idMantencion!=0 ORDER BY idMantencion DESC", $dbConn, 'login', basename($_SERVER["REQUEST_URI"], ".php"), 'Mantenciones');
$ip_bloqueada = db_select_nrows (false, 'idBloqueo', 'sistema_seguridad_bloqueo_ip', '', "IP_Client='".$INT_IP."'", $dbConn, 'login', basename($_SERVER["REQUEST_URI"], ".php"), 'ip_bloqueada');

//Se crean los bloqueos
if(strtotime($Mantenciones['Fecha'])>=strtotime(fecha_actual())&&strtotime($Mantenciones['Hora_ini'])<=strtotime(hora_actual())&&strtotime($Mantenciones['Hora_fin'])>=strtotime(hora_actual())&&$bloqueo==0){ $bloqueo=1;}
if(isset($INT_Pais)&&$INT_Pais!=''&&$INT_Pais!='Chile'&&$INT_IP!='::1'&&$bloqueo==0){  $bloqueo = 2;}
if(isset($ip_bloqueada)&&$ip_bloqueada!=0&&$bloqueo==0){ $bloqueo = 3;}
	
/**********************************************************************************************************************************/
/*                                                        Despliegue                                                              */
/**********************************************************************************************************************************/
//se selecciona la pantalla a mostrar
switch ($bloqueo) {
    //pantalla normal
    case 0:
        require_once '1include_login_form.php';
        break;
	//pantalla de mantenimiento
    case 1:
        require_once '1include_login_ani.php';
        break;
    //pantalla de bloqueo pais
    case 2:
        require_once '1include_login_block.php';
        //se entregan datos
        $sesion_archivo  = 'index.php';
		$sesion_tarea    = 'login-form';
        //se valida hackeo
		require_once 'A1XRXS_sys/xrxs_form/0_hacking_1.php';
        break;
    //pantalla de baneo
    case 3:
        require_once '1include_login_banned.php';
        break;
}
//validador
widget_validator(); ?>

  </body>
</html>
